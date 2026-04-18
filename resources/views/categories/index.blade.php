@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="bi bi-tags-fill text-primary me-2"></i>Categories
        </h1>
        @can('isAdmin')
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle-fill me-1"></i> Create New Category
        </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-folder-x fs-1 text-muted mb-3 d-block"></i>
            <p class="lead">No categories found.</p>
            @can('isAdmin')
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle-fill me-1"></i>Create your first category
            </a>
            @endcan
        </div>
    @else
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-lg border-0 rounded-4 hover-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-tag-fill text-primary me-2"></i>{{ $category->name }}
                        </h5>
                        <p class="card-text text-muted">
                            <i class="bi bi-link me-1"></i>Slug: {{ $category->slug }}<br>
                            <i class="bi bi-book-fill me-1"></i>Recipes: {{ $category->recipes->count() }}
                        </p>
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                            <i class="bi bi-eye me-1"></i>View Recipes
                        </a>
                        @can('isAdmin')
                        <div class="mt-2">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm rounded-pill">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill" 
                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="bi bi-trash-fill me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection