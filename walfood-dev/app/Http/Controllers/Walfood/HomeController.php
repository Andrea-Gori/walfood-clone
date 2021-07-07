<?php

namespace App\Http\Controllers\Walfood;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //Vista Dashboard utente registrato
        return redirect()->route('walfood.restaurants.index');
    }
}
