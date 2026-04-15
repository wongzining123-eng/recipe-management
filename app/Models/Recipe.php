<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'title', 
        'description', 
        'ingredients', 
        'instructions', 
        'prep_time', 
        'cook_time', 
        'servings', 
        'image'
    ];

    // Relationship to User (who created this recipe)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Categories (many-to-many)
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    // Accessor for total cooking time
    public function getTotalTimeAttribute(): int
    {
        return ($this->prep_time ?? 0) + ($this->cook_time ?? 0);
    }
}


