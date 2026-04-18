@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="text-white rounded-4 p-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h1 class="display-4 fw-bold">
                    <i class="bi bi-emoji-wink-fill me-2"></i>
                    Welcome to ABC Recipe, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="lead">Discover, create, and share amazing recipes with food lovers around the world.</p>
                <a href="{{ route('recipes.index') }}" class="btn btn-light btn-lg mt-3 me-2 rounded-pill">
                    <i class="bi bi-search"></i> Explore Recipes
                </a>
                <a href="{{ route('recipes.create') }}" class="btn btn-outline-light btn-lg mt-3 rounded-pill">
                    <i class="bi bi-plus-circle"></i> Share Your Recipe
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center border-0 shadow-sm rounded-4">
                <div class="card-body py-4">
                    <i class="bi bi-book-fill fs-1 text-primary"></i>
                    <h3 class="text-primary mt-2 mb-0 fw-bold">{{ $totalRecipes }}</h3>
                    <p class="text-muted mb-0">Total Recipes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center border-0 shadow-sm rounded-4">
                <div class="card-body py-4">
                    <i class="bi bi-person-fill fs-1 text-success"></i>
                    <h3 class="text-success mt-2 mb-0 fw-bold">{{ Auth::user()->recipes->count() }}</h3>
                    <p class="text-muted mb-0">Your Recipes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center border-0 shadow-sm rounded-4">
                <div class="card-body py-4">
                    <i class="bi bi-tags-fill fs-1 text-info"></i>
                    <h3 class="text-info mt-2 mb-0 fw-bold">{{ App\Models\Category::count() }}</h3>
                    <p class="text-muted mb-0">Categories</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center border-0 shadow-sm rounded-4">
                <div class="card-body py-4">
                    <i class="bi bi-people-fill fs-1 text-warning"></i>
                    <h3 class="text-warning mt-2 mb-0 fw-bold">{{ App\Models\User::count() }}</h3>
                    <p class="text-muted mb-0">Food Lovers</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Categories Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="mb-0">
                        <i class="bi bi-fire me-2 text-danger"></i>
                        Popular Categories
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($popularCategories as $category)
                        <div class="col-md-2 col-6 mb-3">
                            <a href="{{ route('recipes.index', ['category' => $category->id]) }}" 
                               class="text-decoration-none">
                                <div class="text-center p-3 border rounded-4 hover-shadow">
                                    <i class="bi bi-tag fs-1 d-block text-primary"></i>
                                    <strong class="d-block mt-2">{{ $category->name }}</strong>
                                    <small class="text-muted">
                                        <i class="bi bi-bookmark-check"></i> {{ $category->recipes_count }} recipes
                                    </small>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Recipes Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-clock-history me-2 text-primary"></i>
                        Latest Recipes
                    </h4>
                    <a href="{{ route('recipes.index') }}" class="btn btn-primary btn-sm rounded-pill">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    @if($recentRecipes->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-emoji-smile fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No recipes yet. Be the first to share one!</p>
                            <a href="{{ route('recipes.create') }}" class="btn btn-primary rounded-pill mt-2">
                                <i class="bi bi-plus-circle"></i> Create Recipe
                            </a>
                        </div>
                    @else
                        <div class="row">
                            @foreach($recentRecipes as $recipe)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-card">
                                    @if($recipe->image)
                                        <img src="{{ Storage::url($recipe->image) }}" 
                                             class="card-img-top" 
                                             alt="{{ $recipe->title }}"
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bi bi-image fs-1 text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">{{ Str::limit($recipe->title, 50) }}</h5>
                                        <p class="card-text text-muted small">
                                            {{ Str::limit($recipe->description, 80) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <small class="text-muted">
                                                <i class="bi bi-person-circle me-1"></i>
                                                {{ $recipe->user->name }}
                                            </small>
                                            <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                                View <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section - FIXED with better contrast -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);">
                <div class="card-body text-center py-4">
                    <i class="bi bi-star-fill fs-1" style="color: #1a1a2e;"></i>
                    <h5 class="mt-2 fw-bold" style="color: #1a1a2e;">✨ Share Your Recipe</h5>
                    <p class="mb-3" style="color: #2d3436;">Have a delicious recipe? Share it with the community!</p>
                    <a href="{{ route('recipes.create') }}" class="btn btn-dark rounded-pill">
                        <i class="bi bi-plus-circle"></i> Create Recipe
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);">
                <div class="card-body text-center py-4">
                    <i class="bi bi-compass-fill fs-1 text-white"></i>
                    <h5 class="mt-2 fw-bold text-white">🔍 Explore Categories</h5>
                    <p class="mb-3 text-white">Browse recipes by category and find your next meal!</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-light rounded-pill" style="color: #6c5ce7; font-weight: 500;">
                        <i class="bi bi-grid-3x3-gap-fill"></i> Browse Categories
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection