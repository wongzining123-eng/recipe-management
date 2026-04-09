<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    /*
    A slug is a URL-friendly version of a name. 
    It's used to create clean, readable, and SEO-friendly URLs.
    */
    protected $fillable = ['name', 'slug'];

    // Relationship to Recipes (Many-to-many)
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class);
    }
}
