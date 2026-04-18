@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="javascript:history.back()" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Go Back
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Left column: image + meta --}}
        <div class="col-lg-4">
           @if ($recipe->image)
                <img src="{{ $recipe->image }}" 
                    alt="{{ $recipe->title }}"
                    class="img-fluid rounded-4 shadow-sm w-100"
                    style="object-fit: cover; max-height: 350px;"
                    onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
            @else
                <div class="bg-light rounded-4 d-flex align-items-center justify-content-center"
                    style="height: 280px;">
                    <i class="bi bi-image fs-1 text-muted"></i>
                </div>
            @endif

            <div class="card mt-3 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="card-subtitle mb-3 text-muted text-uppercase fw-semibold" style="font-size: .75rem; letter-spacing: .05em;">
                        <i class="bi bi-info-circle-fill me-1"></i>Recipe Details
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted"><i class="bi bi-hourglass-split me-1"></i>Prep time</span>
                            <strong>{{ $recipe->prep_time }} min</strong>
                        </li>
                        <li class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted"><i class="bi bi-fire me-1"></i>Cook time</span>
                            <strong>{{ $recipe->cook_time }} min</strong>
                        </li>
                        <li class="d-flex justify-content-between py-1 border-bottom">
                            <span class="text-muted"><i class="bi bi-clock-fill me-1"></i>Total time</span>
                            <strong>{{ $recipe->total_time }} min</strong>
                        </li>
                        <li class="d-flex justify-content-between py-1">
                            <span class="text-muted"><i class="bi bi-people-fill me-1"></i>Servings</span>
                            <strong>{{ $recipe->servings }}</strong>
                        </li>
                    </ul>
                </div>
            </div>

            @if ($recipe->categories->isNotEmpty())
                <div class="mt-3">
                    <p class="text-muted mb-2 small fw-semibold text-uppercase">
                        <i class="bi bi-tags-fill me-1"></i>Categories
                    </p>
                    @foreach ($recipe->categories as $category)
                        <span class="badge bg-success me-1 mb-1">
                            <i class="bi bi-tag-fill me-1"></i>{{ $category->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            <p class="text-muted small mt-3">
                <i class="bi bi-person-circle me-1"></i>Added by <strong>{{ $recipe->user->name }}</strong>
                <i class="bi bi-calendar3 ms-2 me-1"></i>on {{ $recipe->created_at->format('d M Y') }}
            </p>
        </div>

        {{-- Right column: content --}}
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h1 class="h2 mb-0">
                    <i class="bi bi-book-fill text-primary me-2"></i>{{ $recipe->title }}
                </h1>

                @auth
                    @if (auth()->id() === $recipe->user_id)
                        <div class="d-flex gap-2">
                            <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </a>
                            <form action="{{ route('recipes.destroy', $recipe) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                    <i class="bi bi-trash-fill me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            @if ($recipe->description)
                <p class="lead text-muted mb-4">
                    <i class="bi bi-file-text-fill me-1"></i>{{ $recipe->description }}
                </p>
            @endif

            <hr>

            <div class="mb-4">
                <h4>
                    <i class="bi bi-cart-fill text-primary me-2"></i>Ingredients
                </h4>
                <div class="ps-2" style="white-space: pre-line;">{{ $recipe->ingredients }}</div>
            </div>

            <hr>

            <div>
                <h4>
                    <i class="bi bi-list-ol text-primary me-2"></i>Instructions
                </h4>
                <div class="ps-2" style="white-space: pre-line;">{{ $recipe->instructions }}</div>
            </div>
        </div>
    </div>
</div>
@endsection