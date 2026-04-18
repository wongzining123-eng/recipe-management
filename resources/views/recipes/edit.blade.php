@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('recipes.show', $recipe) }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Back to Recipe
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 rounded-top-4">
                    <h2 class="h4 mb-0">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Edit Recipe
                    </h2>
                </div>

                <div class="card-body">
                    <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">
                                <i class="bi bi-pencil-fill me-1 text-primary"></i>Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $recipe->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">
                                <i class="bi bi-file-text-fill me-1 text-primary"></i>Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $recipe->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Time + Servings row --}}
                        <div class="row g-3 mb-3">
                            <div class="col-sm-4">
                                <label for="prep_time" class="form-label fw-semibold">
                                    <i class="bi bi-hourglass-split me-1 text-primary"></i>Prep Time (min) <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="prep_time" id="prep_time" min="0"
                                       class="form-control @error('prep_time') is-invalid @enderror"
                                       value="{{ old('prep_time', $recipe->prep_time) }}" required>
                                @error('prep_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="cook_time" class="form-label fw-semibold">
                                    <i class="bi bi-fire me-1 text-primary"></i>Cook Time (min) <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="cook_time" id="cook_time" min="0"
                                       class="form-control @error('cook_time') is-invalid @enderror"
                                       value="{{ old('cook_time', $recipe->cook_time) }}" required>
                                @error('cook_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="servings" class="form-label fw-semibold">
                                    <i class="bi bi-people-fill me-1 text-primary"></i>Servings <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="servings" id="servings" min="1"
                                       class="form-control @error('servings') is-invalid @enderror"
                                       value="{{ old('servings', $recipe->servings) }}" required>
                                @error('servings')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Ingredients --}}
                        <div class="mb-3">
                            <label for="ingredients" class="form-label fw-semibold">
                                <i class="bi bi-cart-fill me-1 text-primary"></i>Ingredients <span class="text-danger">*</span>
                            </label>
                            <small class="text-muted d-block mb-1">List each ingredient on a new line.</small>
                            <textarea name="ingredients" id="ingredients" rows="6"
                                      class="form-control @error('ingredients') is-invalid @enderror"
                                      required>{{ old('ingredients', $recipe->ingredients) }}</textarea>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Instructions --}}
                        <div class="mb-3">
                            <label for="instructions" class="form-label fw-semibold">
                                <i class="bi bi-list-ol me-1 text-primary"></i>Instructions <span class="text-danger">*</span>
                            </label>
                            <small class="text-muted d-block mb-1">Describe each step on a new line.</small>
                            <textarea name="instructions" id="instructions" rows="8"
                                      class="form-control @error('instructions') is-invalid @enderror"
                                      required>{{ old('instructions', $recipe->instructions) }}</textarea>
                            @error('instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Categories --}}
                        <div class="mb-3">
                            <label for="categories" class="form-label fw-semibold">
                                <i class="bi bi-tags-fill me-1 text-primary"></i>Categories
                            </label>
                            <small class="text-muted d-block mb-1">Hold Ctrl / Cmd to select multiple.</small>
                            <select name="categories[]" id="categories" multiple
                                    class="form-select @error('categories') is-invalid @enderror"
                                    size="5">
                                @php
                                    $selectedCategories = old('categories', $recipe->categories->pluck('id')->toArray());
                                @endphp
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="mb-4">
                            <label for="image_url" class="form-label fw-semibold">
                                <i class="bi bi-image-fill me-1 text-primary"></i>Image URL
                            </label>
                            
                            @if ($recipe->image)
                                <div class="mb-2">
                                    <p class="text-muted small mb-1">Current image:</p>
                                    <img src="{{ $recipe->image }}" 
                                        alt="{{ $recipe->title }}"
                                        class="rounded"
                                        style="max-height: 150px; object-fit: cover;"
                                        onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                </div>
                            @endif
                            
                            <input type="url" 
                                name="image_url" 
                                id="image_url" 
                                class="form-control @error('image_url') is-invalid @enderror" 
                                value="{{ old('image_url', $recipe->image) }}"
                                placeholder="https://example.com/new-image.jpg">
                            <small class="text-muted">
                                Leave blank to keep current image. Paste a new URL to change the image.
                            </small>
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save-fill me-1"></i>Update Recipe
                            </button>
                            <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection