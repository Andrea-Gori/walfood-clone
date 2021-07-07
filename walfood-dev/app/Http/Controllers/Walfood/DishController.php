<?php

namespace App\Http\Controllers\Walfood;

use App\Dish;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRestaurant(Request $request)
    {
        $restaurant = $request->all();
        return view('walfood.dish.create', compact('restaurant'));
    }
    public function index()
    {
        // return view('walfood.ristorante.show',compact('restaurant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'img' => 'image|max:2048|nullable',
            'description' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            $restaurant = $request->all();
            $messages = $validator->messages();
            return view('walfood.dish.create', compact('restaurant'))->withErrors($messages);

        }
        $data = $request->all();
        $img_path = 'img/dish_placeholder.png';
        if (array_key_exists('img', $data)) {
            $img_path = Storage::put('uploads', $data['img']);
        }
        $dish = new dish();
        $dish->fill($data);
        $dish->slug = $this->generaSlug($dish->name);
        $dish->img = '/storage/' . $img_path;
        $dish->visibility = 0;
        $dish->restaurant_id = $data['restaurant_id'];
        $dish->save();

        $restaurant = Dish::with('restaurant')->where('id', '=', $dish->id)->select('*')->first();
        return redirect()->route('walfood.restaurants.show', ['slug' => $restaurant->restaurant->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {

        $currentUser = Auth::user(); // prendo dati dell'utente autenticato
        $recordset = DB::table('users')->join("restaurants", "users.id", "=", "restaurants.user_id")
            ->join('dishes', "dishes.restaurant_id" ,"=", "restaurants.id")
            ->select('users.id as USERID', 'restaurants.id AS RESTID', 'dishes.id AS DISHESID')
            ->where("users.id", "=", $currentUser->id)
            ->where("dishes.id","=",$dish->id)->get();
       if (count($recordset) > 0) {

           return view('walfood.dish.edit', compact('dish'));
       } else {
           return view('errors.404');
       }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'img' => 'image|max:2048|nullable',
            'description' => 'required|string|max:255',
        ]);
        $data = $request->all();
        $img_path = NULL;
        if (array_key_exists('img', $data)) {
            $img_path = Storage::put('uploads', $data['img']);
            $data['img'] = '/storage/' . $img_path;
        }
        $data['slug'] = $this->generaSlug($data['name'], $dish->name != $data['name'], $dish->slug);

        $dish->visibility = 1;
        $dish->update($data);

        $restaurant = Dish::with('restaurant')->where('id', '=', $dish->id)->select('*')->first();
        return redirect()->route('walfood.restaurants.show', ['slug' => $restaurant->restaurant->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $restaurant = Dish::with('restaurant')->where('id', '=', $dish->id)->select('*')->first();
        $dish->delete();
        return redirect()->route('walfood.restaurants.show', ['slug' => $restaurant->restaurant->slug]);
    }

    private function generaSlug(string $title, bool $change = true, string $old_slug = '')
    {
        if (!$change) {
            return $old_slug;
        }

        $slug = Str::slug($title, '-');
        $slug_base = $slug;
        $contatore = 1;
        $post_with_slug = Dish::where('slug', '=', $slug)->first(); //Post {} || NULL
        while ($post_with_slug) {
            $slug = $slug_base . '-' . $contatore;
            $contatore++;

            $post_with_slug = Dish::where('slug', '=', $slug)->first(); //Post {} || NULL
        }

        return $slug;
    }
}
