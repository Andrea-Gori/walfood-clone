<?php

namespace App\Http\Controllers;

use App\Category;
use App\Dish;
use App\Http\Controllers\Controller;
use App\Restaurant;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    public function index(Request $request) //controller per api utente interessato (non reg) per visualizzazione in homepage
    {
        $data = $request->all();

        switch (isset($data['business_name']) && isset($data['categories'])) {
            case true:
                $nome = Restaurant::with('categories', 'dishes')
                    ->select('id')
                    ->where('restaurants.business_name', 'like', '%' . $data['business_name'] . '%')
                    ->distinct()->paginate(6);
//                $arrayCat = $data['categories'];
//                $restaurants=DB::table('category_restaurant')
//                    ->select('restaurant_id'/*,  DB::raw('count(restaurant_id)')*/)
//                    ->whereIn('restaurant_id', '=', $nome->id)
//                    ->whereIn('category_id', $arrayCat)
//                    ->groupBy('restaurant_id')
//                    ->paginate(6);
            $nomi = [];
            foreach ($nome as $name){
                array_push($nomi, $name->id);
            }

                $arrayCat = $data['categories'];
                $sub = DB::table('category_restaurant')
                    ->select('restaurant_id', DB::raw('count(category_id) as Cat'))
                    ->whereIn('restaurant_id', $nomi)
                    ->whereIn('category_id', $arrayCat)

                    ->groupBy('restaurant_id');

                $restaurants = DB::table(DB::raw("({$sub->toSql()}) as sub"))
                    ->select('restaurant_id')
                    ->mergeBindings($sub)
                    ->where('Cat', '=', count($arrayCat))
                    ->get();

                $idRisto = [];
                foreach ($restaurants as $risto) {
                    array_push($idRisto, $risto->restaurant_id);
                }

                $idRistoPieni = [];
                $risto = null;
                $restaurants = Restaurant::with('categories', 'dishes')->whereIn('id', $idRisto)->get();
                foreach ($restaurants as $ristorante) {
                    if (count($ristorante->dishes) > 0){
                        array_push($idRistoPieni, $ristorante->id);
                    }
                }
                $restaurants = Restaurant::with('categories', 'dishes')
                    ->whereIn('id', $idRistoPieni)->paginate(6);
                break;

            case false:
                if (isset($data['business_name'])) {
                    $restaurants = Restaurant::with('categories', 'dishes')
                        ->where('restaurants.business_name', 'like', '%' . $data['business_name'] . '%')
                        ->distinct()
                        ->get();
                    $idRistoPieni = [];

                    foreach ($restaurants as $ristorante) {
                        if (count($ristorante->dishes) > 0){
                            array_push($idRistoPieni, $ristorante->id);
                        }
                    }
                    $restaurants = Restaurant::with('categories', 'dishes')->whereIn('id', $idRistoPieni)->paginate(6);

                } elseif (isset($data['categories'])) {
                        /*SELECT * FROM

                        (SELECT restaurant_id, COUNT(category_id) as Cat
                        FROM category_restaurant
                        WHERE category_id = 1 or category_id = 2 OR category_id = 3
                        GROUP BY restaurant_id) result

                        where Cat = 1*/
                    $arrayCat = $data['categories'];
                    $sub = DB::table('category_restaurant')
                        ->select('restaurant_id', DB::raw('count(category_id) as Cat'))
                        ->whereIn('category_id', $arrayCat)
                        ->groupBy('restaurant_id');

                    $restaurants = DB::table(DB::raw("({$sub->toSql()}) as sub"))
                        ->select('restaurant_id')
                        ->mergeBindings($sub)
                        ->where('Cat', '=', count($arrayCat))
                        ->get();

                    $idRisto = [];
                    foreach ($restaurants as $risto) {
                        array_push($idRisto, $risto->restaurant_id);
                    }
                    $idRistoPieni = [];
                    $risto = null;
                    $restaurants = Restaurant::with('categories', 'dishes')->whereIn('id', $idRisto)->get();
                    foreach ($restaurants as $ristorante) {
                        if (count($ristorante->dishes) > 0){
                            array_push($idRistoPieni, $ristorante->id);
                        }
                    }
                    $restaurants = Restaurant::with('categories', 'dishes')->select('id as restaurant_id')
                        ->whereIn('id', $idRistoPieni)->paginate(6);

                } else {
                    if (isset($data['restaurant_id'])) {
                        $restaurants = Restaurant::with(['dishes', 'categories'])
                            ->whereIn('id', $data['restaurant_id'])
                            ->get();
                    } else {
                        $idRistoPieni = [];
                        $restaurants = Restaurant::with('categories', 'dishes')->get();
                        foreach ($restaurants as $ristorante) {
                            if (count($ristorante->dishes) > 0){
                                array_push($idRistoPieni, $ristorante->id);
                            }
                        }
                        $restaurants = Restaurant::with('categories', 'dishes')->whereIn('id', $idRistoPieni)->paginate(6);
                    }

                }

        }


        /*if (!isset($data['business_name']) && !isset($data['per_page'])){
        $restaurants = Restaurant::with('categories', 'dishes')->get();
    }


        if (isset($data['business_name']) && isset($data['per_page'])) { //ricerca per nome contenuto in nome ristorante
            $restaurants = Restaurant::with('categories', 'dishes')
                ->where('restaurants.business_name', 'like', '%' . $data['business_name'] . '%')
                ->distinct()
                ->paginate($data['per_page']);

        }

        if (isset($data['per_page']) && !isset($data['business_name']) && !isset($data['categories'])){
        $restaurants = Restaurant::with('categories', 'dishes')->paginate($data['per_page']);
    }

        if (isset($data['categories'])) {
            $arrayCat = $data['categories'];
            $restaurants=DB::table('category_restaurant')
                ->select('restaurant_id')
                ->whereIn('category_id', $arrayCat)
                ->groupBy('restaurant_id')
                ->paginate(6);

        }
        if (isset($data['restaurant_id'])) {

            $restaurants = Restaurant::with(['dishes' , 'categories'])
                ->whereIn('id', $data['restaurant_id'])
                ->get();
        }*/

        return response()->json([
            'response' => $restaurants,
            //'results' => count($restaurants),
            "success" => true
        ]);
    }
}
