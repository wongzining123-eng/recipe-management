<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Italian', 'slug' => 'italian'],
            ['name' => 'Quick Meals', 'slug' => 'quick-meals'],
            ['name' => 'Vegetarian', 'slug' => 'vegetarian'],
            ['name' => 'Dessert', 'slug' => 'dessert'],
            ['name' => 'Healthy', 'slug' => 'healthy'],
            ['name' => 'Breakfast', 'slug' => 'breakfast'],
            ['name' => 'Asian', 'slug' => 'asian'],
            ['name' => 'Seafood', 'slug' => 'seafood'],
            ['name' => 'Soup', 'slug' => 'soup'],
            ['name' => 'BBQ & Grilling', 'slug' => 'bbq-grilling'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}