@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('recipes.index') }}" class="text-decoration-none text-muted">
            &larr; Back to Recipes
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Left column: image + meta --}}
        <div class="col-lg-4">
            @if ($recipe->image)
                <img src="{{ Storage::url($recipe->image) }}"
                     alt="{{ $recipe->title }}"
                     class="img-fluid rounded shadow-sm w-100"
                     style="object-fit: cover; max-height: 350px;">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                     style="height: 280px;">
                    <span class="text-muted">No Image</span>
                </div>
            @endif

            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-subtitle mb-3 text-muted text-uppercase fw-semibold" style="font-size: .75rem; letter-spacing: .05em;">
                        Recipe Details
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">Prep time</span>
                            <strong>{{ $recipe->prep_time }} min</strong>
                        </li>
                        <li class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">Cook time</span>
                            <strong>{{ $recipe->cook_time }} min</strong>
                        </li>
                        <li class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted">Total time</span>
                            <strong>{{ $recipe->total_time }} min</strong>
                        </li>
                        <li class="d-flex justify-content-between py-1">
                            <span class="text-muted">Servings</span>
                            <strong>{{ $recipe->servings }}</strong>
                        </li>
                    </ul>
                </div>
            </div>

            @if ($recipe->categories->isNotEmpty())
                <div class="mt-3">
                    <p class="text-muted mb-2 small fw-semibold text-uppercase">Categories</p>
                    @foreach ($recipe->categories as $category)
                        <span class="badge bg-success me-1 mb-1">{{ $category->name }}</span>
                    @endforeach
                </div>
            @endif

            <p class="text-muted small mt-3">
                Added by <strong>{{ $recipe->user->name }}</strong>
                on {{ $recipe->created_at->format('d M Y') }}
            </p>
        </div>

        {{-- Right column: content --}}
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h1 class="h2 mb-0">{{ $recipe->title }}</h1>

                @auth
                    @if (auth()->id() === $recipe->user_id)
                        <div class="d-flex gap-2">
                            <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline-secondary btn-sm">
                                Edit
                            </a>
                            <form action="{{ route('recipes.destroy', $recipe) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            @if ($recipe->description)
                <p class="lead text-muted mb-4">{{ $recipe->description }}</p>
            @endif

            <hr>

            <div class="mb-4">
                <h4>Ingredients</h4>
                <div class="ps-2" style="white-space: pre-line;">{{ $recipe->ingredients }}</div>
            </div>

            <hr>

            <div>
                <h4>Instructions</h4>
                <div class="ps-2" style="white-space: pre-line;">{{ $recipe->instructions }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
