<?php

namespace App\Http\Controllers\Walfood;

use App\Category;
use App\Dish;
use App\Http\Controllers\Controller;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = Auth::user();
        /*$ristoranti = DB::table('restaurants')
            ->join('category_restaurant', 'restaurants.id', '=', 'category_restaurant.restaurant_id' )
            ->join('categories','category_restaurant.category_id','=','categories.id' )
            ->select('restaurants.*', 'categories.*')
            ->where('restaurants.user_id', '=', $currentUser->id)->get();*/
        $ristoranti = Restaurant::with('categories')->where('user_id', '=', $currentUser->id)->paginate(6);


        return view('walfood.index')->with('ristoranti', $ristoranti);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipologie = Category::all();
        return view('walfood.ristorante.create', compact('tipologie'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'business_name' => 'required|string|max:255',
            'vat' => 'required|numeric',
            'img' => 'image|max:2048|nullable',
            'address' => 'required|string|max:255',
            'user_id' => 'exists:users,id',
            'tipologia' => 'required|exists:categories,id|array|min:1'
        ]);

        $data = $request->all();
        $img_path = NULL;
        if (array_key_exists('img', $data)) {
            $img_path = Storage::put('uploads', $data['img']);
        }  else {
            $img_path = '../img/restaurant_placeholder.png';
        }
        $restaurant = new Restaurant();
        $restaurant->fill($data);
        $restaurant->slug = $this->generaSlug($restaurant->business_name);
        $restaurant->img = $img_path;
        $currentUser = Auth::user();
        $restaurant->user_id = $currentUser->id;
        $restaurant->save();
        $restaurant->categories()->attach($data['tipologia']);


        return redirect()->route('walfood.restaurants.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Walfood\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $currentUser = Auth::user();


        $restaurant = Restaurant::with('dishes', 'orders')->where('slug', '=', $slug)->with('dishes')->first();
        $dishes = Dish::where('restaurant_id', '=', $restaurant->id)->paginate(4);
        if ($restaurant->user_id == $currentUser->id) {
            return view('walfood.ristorante.show', compact('restaurant', 'dishes'));
        }
        return view('errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Walfood\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        $currentUser = Auth::user();
        if ($restaurant->user_id == $currentUser->id) {
            $tipologie = Category::all();
            return view('walfood.ristorante.edit', compact('restaurant', 'tipologie'));
        } else {
            return view('walfood.ristorante.error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Walfood\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'vat' => 'required|numeric',
            'img' => 'image|max:2048|nullable',
            'address' => 'required|string|max:255',
            'user_id' => 'exists:users,id'
        ]);
        $data = $request->all();
        $data['slug'] =
            $this->generaSlug($data['business_name'], $restaurant->business_name != $data['business_name'], $restaurant->slug);
        if (array_key_exists('img', $data)) {
            $img_path = Storage::put('uploads', $data['img']);
            $data['img'] = $img_path;
        }
        $restaurant->update($data);
        if (array_key_exists('tipologia', $data)) {
            $restaurant->categories()->sync($data['tipologia']);
        } else {
            $restaurant->categories()->detach();
        }
        return redirect()->route('walfood.restaurants.show', ['slug' => $restaurant->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Walfood\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('walfood.restaurants.index');
    }
    private function generaSlug(string $title, bool $change = true, string $old_slug = '')
    {
        if (!$change) {
            return $old_slug;
        }

        $slug = Str::slug($title, '-');
        $slug_base = $slug;
        $contatore = 1;

        $post_with_slug = Restaurant::where('slug', '=', $slug)->first(); //Post {} || NULL
        while ($post_with_slug) {
            $slug = $slug_base . '-' . $contatore;
            $contatore++;

            $post_with_slug = Restaurant::where('slug', '=', $slug)->first(); //Post {} || NULL
        }

        return $slug;
    }
}
