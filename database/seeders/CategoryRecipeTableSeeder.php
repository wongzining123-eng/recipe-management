<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRecipeTableSeeder extends Seeder
{
    public function run(): void
    {
        // Using Eloquent
        $this->attachUsingEloquent();
    }
    
    private function attachUsingEloquent(): void
    {
        // Get all recipes
        $recipes = Recipe::all();
        
        // Assign categories to each recipe
        foreach ($recipes as $recipe) {
            // Assign random categories based on recipe ID
            if ($recipe->id == 1) {
                // Recipe 1 (Spaghetti) -> Italian (1) and Quick Meals (2)
                $recipe->categories()->attach([1, 2]);
            } elseif ($recipe->id == 2) {
                // Recipe 2 (Chicken Stir Fry) -> Asian (7) and Quick Meals (2)
                $recipe->categories()->attach([2, 7]);
            } elseif ($recipe->id == 3) {
                // Recipe 3 (Vegetable Curry) -> Vegetarian (3) and Healthy (5)
                $recipe->categories()->attach([3, 5]);
            } elseif ($recipe->id == 4) {
                // Recipe 4 (Chocolate Cake) -> Dessert (4)
                $recipe->categories()->attach([4]);
            } elseif ($recipe->id == 5) {
                // Recipe 5 (Greek Salad) -> Healthy (5) and Vegetarian (3)
                $recipe->categories()->attach([3, 5]);
            }
        }
    }
    
    private function attachUsingDB(): void
    {
        // Alternative: Using DB facade directly
        DB::table('category_recipe')->insert([
            // recipe_id, category_id
            ['recipe_id' => 1, 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['recipe_id' => 1, 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['recipe_id' => 2, 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['recipe_id' => 2, 'category_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['recipe_id' => 3, 'category_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['recipe_id' => 3, 'category_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['recipe_id' => 4, 'category_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['recipe_id' => 5, 'category_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['recipe_id' => 5, 'category_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}