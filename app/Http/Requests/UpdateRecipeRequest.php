<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'ingredients'  => ['required', 'string'],
            'instructions' => ['required', 'string'],
            'prep_time'    => ['required', 'integer', 'min:0'],
            'cook_time'    => ['required', 'integer', 'min:0'],
            'servings'     => ['required', 'integer', 'min:1'],
            'image'        => ['nullable', 'image', 'max:2048'],
            'categories'   => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ];
    }
}
