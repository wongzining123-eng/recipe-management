<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
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
            'image'        => ['required', 'url', 'max:2048'],
            'categories'   => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ];
    }

     public function messages(): array
    {
        return [
            'image_url.required' => 'Please provide an image URL',
            'image_url.url' => 'Please enter a valid URL (e.g., https://example.com/image.jpg)',
        ];
    }
}
