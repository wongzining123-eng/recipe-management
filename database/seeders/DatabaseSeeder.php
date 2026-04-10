<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,           // 1. Users 
            CategoriesTableSeeder::class,      // 2. Categories 
            RecipesTableSeeder::class,         // 3. Recipes (needs users)
            CategoryRecipeTableSeeder::class,  // 4. Pivot table 
        ]);
    }

}
