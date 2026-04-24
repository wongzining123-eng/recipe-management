<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:isAdmin');
    }

    // Dashboard
    public function index()
    {
        $totalRecipes    = Recipe::count();
        $totalUsers      = User::count();
        $totalCategories = Category::count();
        $recentRecipes   = Recipe::with(['user', 'categories'])->latest()->take(5)->get();
        $recentUsers     = User::latest()->take(5)->get();
        
        return response()->json([
            'totalRecipes' => $totalRecipes,
            'totalUsers' => $totalUsers,
            'totalCategories' => $totalCategories,
            'recentRecipes' => $recentRecipes,
            'recentUsers' => $recentUsers,
        ]);
    }
    // Recipes - now returns JSON
    public function recipes(Request $request)
    {
        $query = Recipe::with(['user', 'categories']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $recipes = $query->latest()->paginate(15)->withQueryString();

        return response()->json($recipes);
    }

    // Delete recipe
    public function deleteRecipe(Recipe $recipe)
    {
        $title = $recipe->title;
        $recipe->delete();
        
         return redirect()->back()->with('success', 'Recipe deleted successfully.');
    }

    // Users
    public function users(Request $request)
    {
        $users = User::withCount('recipes')->latest()->paginate(15);
        
        return response()->json($users);
    }

    public function toggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            
            return response()->json(['error' => 'You cannot change your own role!'], 403);
        }

        $oldRole = $user->is_admin == 1 ? 'admin' : 'user';
        $user->is_admin = !$user->is_admin;
        $user->save();
        $newRole = $user->is_admin == 1 ? 'admin' : 'user';

        return response()->json([
            'message' => "User '{$user->name}' role changed from {$oldRole} to {$newRole}.",
            'user' => $user
        ]);
    }
}