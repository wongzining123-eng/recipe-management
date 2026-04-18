<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

 public function index(Request $request): View  
    {
        $query = Recipe::with('user', 'categories'); 
        
        // Add search functionality
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        // Add category filter (using relationship since many-to-many)
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }
        
        $recipes = $query->latest()->paginate(12);
        
        // Get all categories for the filter dropdown
        $categories = Category::orderBy('name')->get();
        
        // Pass both to the view
        return view('recipes.index', compact('recipes', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('recipes.create', compact('categories'));
    }

    public function store(StoreRecipeRequest $request): RedirectResponse
    {
        $imagePath = $request->file('image')->store('recipes', 'public');

        $recipe = Recipe::create([
            'user_id'      => auth()->id(),
            'title'        => $request->title,
            'description'  => $request->description,
            'ingredients'  => $request->ingredients,
            'instructions' => $request->instructions,
            'prep_time'    => $request->prep_time,
            'cook_time'    => $request->cook_time,
            'servings'     => $request->servings,
            'image'        => $imagePath,
        ]);

        if ($request->filled('categories')) {
            $recipe->categories()->attach($request->categories);
        }

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recipe created successfully!');
    }

    public function show(Recipe $recipe): View
    {
        $recipe->load('user', 'categories');

        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe): View
    {
        $categories = Category::orderBy('name')->get();

        return view('recipes.edit', compact('recipe', 'categories'));
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe): RedirectResponse
    {
        $data = $request->only([
            'title', 'description', 'ingredients', 'instructions',
            'prep_time', 'cook_time', 'servings',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($recipe->image);
            $data['image'] = $request->file('image')->store('recipes', 'public');
        }

        $recipe->update($data);

        $recipe->categories()->sync($request->categories ?? []);

        return redirect()->route('recipes.show', $recipe)
            ->with('success', 'Recipe updated successfully!');
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        Storage::disk('public')->delete($recipe->image);

        $recipe->delete();

        return redirect()->route('recipes.index')
            ->with('success', 'Recipe deleted successfully!');
    }
}
