@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">
            <i class="bi bi-book-fill text-primary me-2"></i>Recipes
        </h1>
        <a href="{{ route('recipes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle-fill me-1"></i> New Recipe
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- SEARCH AND FILTER FORM --}}
    <div class="card mb-4 border-0 shadow-sm rounded-4">
        <div class="card-body">
            <form method="GET" action="{{ route('recipes.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label fw-semibold">
                        <i class="bi bi-search me-1"></i>Search by Title
                    </label>
                    <input type="text" 
                           name="search" 
                           id="search" 
                           class="form-control" 
                           placeholder="Search recipes..." 
                           value="{{ request('search') }}">
                </div>
                
                <div class="col-md-5">
                    <label for="category" class="form-label fw-semibold">
                        <i class="bi bi-funnel-fill me-1"></i>Filter by Category
                    </label>
                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel-fill me-1"></i>Apply Filters
                    </button>
                </div>
            </form>
            
            {{-- Clear filters link - shows only when filters are active --}}
            @if(request()->hasAny(['search', 'category']))
                <div class="mt-3">
                    <a href="{{ route('recipes.index') }}" class="text-decoration-none">
                        <i class="bi bi-x-circle me-1"></i> Clear all filters
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- DISPLAY RESULTS COUNT --}}
    @if(request()->hasAny(['search', 'category']))
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill me-2"></i>Found {{ $recipes->total() }} recipe(s) matching your criteria.
        </div>
    @endif

    {{-- MAIN CONTENT: RECIPES GRID OR EMPTY STATE --}}
    @if ($recipes->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-emoji-frown fs-1 mb-3 d-block"></i>
            <p class="fs-5">No recipes found.</p>
            @if(request()->hasAny(['search', 'category']))
                <a href="{{ route('recipes.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-repeat me-1"></i>Clear Filters
                </a>
            @else
                <a href="{{ route('recipes.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-plus-circle-fill me-1"></i>Create Your First Recipe
                </a>
            @endif
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($recipes as $recipe)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-4 hover-card">
                        @if ($recipe->image)
                            <img src="{{ $recipe->image }}" 
                                class="card-img-top rounded-top-4"
                                alt="{{ $recipe->title }}"
                                style="height: 300px; object-fit: cover;"
                                onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded-top-4"
                                style="height: 300px;">
                                <i class="bi bi-image fs-1 text-muted"></i>
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
                                    <i class="bi bi-hourglass-split me-1"></i>{{ $recipe->prep_time }} min
                                </span>
                                <span class="badge bg-secondary">
                                    <i class="bi bi-fire me-1"></i>{{ $recipe->cook_time }} min
                                </span>
                                <span class="badge bg-info text-dark">
                                    <i class="bi bi-people-fill me-1"></i>Serves {{ $recipe->servings }}
                                </span>
                            </div>

                            @if ($recipe->categories->isNotEmpty())
                                <div class="mb-3">
                                    @foreach ($recipe->categories as $category)
                                        <span class="badge bg-success me-1">
                                            <i class="bi bi-tag-fill me-1"></i>{{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <small class="text-muted">
                                    <i class="bi bi-person-circle me-1"></i>{{ $recipe->user->name }}
                                </small>
                                <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                    View Recipe <i class="bi bi-eye ms-1"></i>
                                </a>
                            </div>

                            @auth
                                @if (auth()->id() === $recipe->user_id || (auth()->user()->is_admin ?? false))
                                <a href="{{ route('recipes.edit', $recipe) }}" 
                                class="btn btn-outline-secondary btn-sm rounded-pill w-100 mt-2">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Recipe
                                </a>    
                                <form action="{{ route('recipes.destroy', $recipe) }}" 
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this recipe?')"
                                        class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill w-100">
                                            <i class="bi bi-trash me-1"></i> Delete Recipe
                                        </button>
                                    </form>
                                @endif
                            @endauth

                            @can('isAdmin')
                                <form action="{{ url('/api/admin/recipes/' . $recipe->id) }}" 
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this recipe?')">
                                    @csrf
                                    @method('DELETE')
                                    <br/>
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                        <i class="bi bi-trash me-1"></i> Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- PAGINATION LINKS --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $recipes->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<style>
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .rounded-top-4 {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection