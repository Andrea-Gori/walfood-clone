<?php

namespace App\Http\Controllers;

use App\Dish;
use App\Restaurant;
use Illuminate\Http\Request;

class DishController extends Controller
{
    public function index(Request $request) {
        $data = $request->all();

        if (isset($data['slug'])) { //ricerca per nome contenuto in nome ristorante
          /*  $dishes = Dish::with('restaurant')
                ->where('slug', '=', $data['slug'])
                ->get();*/
            $dishes =Restaurant::with('dishes')->where('slug', '=', $data['slug'])
                ->get();

            return response()->json([
                'response' => $dishes,
                'results' => count($dishes),
                "success" => true
            ]);
        } else {
            return response()->json([
                'response' => 'Mancano parametri!',
                'success' => false
            ]);
        }

    }
}
