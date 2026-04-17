@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">Recipes</h1>
        <a href="{{ route('recipes.create') }}" class="btn btn-primary">
            + New Recipe
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($recipes->isEmpty())
        <div class="text-center py-5 text-muted">
            <p class="fs-5">No recipes yet. Be the first to add one!</p>
            <a href="{{ route('recipes.create') }}" class="btn btn-outline-primary">Create a Recipe</a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($recipes as $recipe)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if ($recipe->image)
                            <img src="{{ Storage::url($recipe->image) }}"
                                 class="card-img-top"
                                 alt="{{ $recipe->title }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                 style="height: 200px;">
                                <span class="text-muted">No Image</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $recipe->title }}</h5>

                            @if ($recipe->description)
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($recipe->description, 100) }}
                                </p>
                            @endif

                            <div class="d-flex gap-2 mb-3 flex-wrap">
                                <span class="badge bg-secondary">
                                    Prep: {{ $recipe->prep_time }} min
                                </span>
                                <span class="badge bg-secondary">
                                    Cook: {{ $recipe->cook_time }} min
                                </span>
                                <span class="badge bg-info text-dark">
                                    Serves {{ $recipe->servings }}
                                </span>
                            </div>

                            @if ($recipe->categories->isNotEmpty())
                                <div class="mb-3">
                                    @foreach ($recipe->categories as $category)
                                        <span class="badge bg-success me-1">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <small class="text-muted">By {{ $recipe->user->name }}</small>
                                <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-primary btn-sm">
                                    View Recipe
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $recipes->links() }}
        </div>
    @endif
</div>
@endsection
