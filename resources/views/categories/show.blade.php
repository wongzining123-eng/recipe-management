@extends('layouts.app')

@section('content')

<div class="container">
    <div class="mb-3">
        <a href="{{ route('categories.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Back to Categories
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="bi bi-tag-fill text-primary me-2"></i>{{ $category->name }}
        </h1>
        <span class="badge bg-secondary rounded-pill">
            <i class="bi bi-bookmark-check me-1"></i>{{ $recipes->total() }} recipes found
        </span>
    </div>

    @if($recipes->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-folder-x fs-1 text-muted mb-3 d-block"></i>
            <p class="lead">No recipes found in this category yet.</p>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary rounded-pill">
                <i class="bi bi-plus-circle-fill me-1"></i>Create a Recipe
            </a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($recipes as $recipe)
            <div class="col">
                <div class="card h-100 shadow-lg border-0 rounded-4 hover-card">
                    @if($recipe->image)
                        <img src="{{ Storage::url($recipe->image) }}" 
                             class="card-img-top rounded-top-4" 
                             alt="{{ $recipe->title }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4" style="height: 200px;">
                            <i class="bi bi-image fs-1 text-muted"></i>
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $recipe->title }}</h5>
                        <p class="card-text text-muted small">
                            {{ Str::limit($recipe->description, 100) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-person-circle me-1"></i>{{ $recipe->user->name }}
                            </small>
                            <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                View Recipe <i class="bi bi-eye ms-1"></i>
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