<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::has('restaurants')->get();
        return response()->json([
            'response' => $categories,
            'results' => count($categories),
            'success' => true
        ]);
    }

}
