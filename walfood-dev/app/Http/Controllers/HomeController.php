<?php

namespace App\Http\Controllers;

use App\Restaurant;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class HomeController extends Controller

{
    public function index()
         {
             //Rotta homepage utente non registrato
             //Ritorna view ricerca e visualizzazione ristoranti
            return view('index');
         }
    public function buy(string $slug) {
        $restaurant = Restaurant::with('dishes', 'categories')->where('slug', '=', $slug)->first();

        //joinare con dishes per visualizzare i piatti
        return view('buy', compact('restaurant'));
    }
}
