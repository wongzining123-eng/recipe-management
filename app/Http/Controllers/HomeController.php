<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;

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

    /**
     * Show the application dashboard based on user role.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // If user is admin, redirect to admin dashboard
        if (auth()->user()->is_admin == 1) {
            return redirect()->route('admin.dashboard');
        }
        
        // For regular users, show normal home page
        $totalRecipes = Recipe::count();
        $recentRecipes = Recipe::with('user', 'categories')->latest()->take(6)->get();
        $popularCategories = Category::withCount('recipes')->orderBy('recipes_count', 'desc')->take(5)->get();
        
        return view('home', compact('totalRecipes', 'recentRecipes', 'popularCategories'));
    }
}