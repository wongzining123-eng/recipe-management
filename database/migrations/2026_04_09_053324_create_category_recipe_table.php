<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('category_recipe', function (Blueprint $table) {
            $table->id();                           // Primary key
            $table->foreignId('category_id')        // Links to categories table
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('recipe_id')          // Links to recipes table
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamps();                   // When relationship was created
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_recipe');
    }
}
