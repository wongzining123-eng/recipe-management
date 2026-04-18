<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ABC Recipe</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    

    <script src="/js/app.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-book-half me-2"></i>ABC Recipe
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar - Main Menu -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if(auth()->user()->is_admin)
                                <!-- ADMIN NAVIGATION -->
                                <li class="nav-item">
                                    <a class="nav-link text-danger fw-bold" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-shield-lock-fill me-1"></i>Admin Panel
                                    </a>
                                </li>
                                
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="recipesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-book-fill me-1"></i>Recipes
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="recipesDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('recipes.index') }}">
                                                <i class="bi bi-grid-3x3-gap-fill me-2"></i>All Recipes
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('my.recipes') }}">
                                                <i class="bi bi-person-fill me-2"></i>My Recipes
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('recipes.create') }}">
                                                <i class="bi bi-plus-circle-fill me-2"></i>Create New Recipe
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-tags-fill me-1"></i>Categories
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('categories.index') }}">
                                                <i class="bi bi-search me-2"></i>Browse Categories
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                            @else
                                <!-- REGULAR USER NAVIGATION -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">
                                        <i class="bi bi-house-fill me-1"></i>Home
                                    </a>
                                </li>
                                
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="recipesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-book-fill me-1"></i>Recipes
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="recipesDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('recipes.index') }}">
                                                <i class="bi bi-grid-3x3-gap-fill me-2"></i>All Recipes
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('my.recipes') }}">
                                                <i class="bi bi-person-fill me-2"></i>My Recipes
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('recipes.create') }}">
                                                <i class="bi bi-plus-circle-fill me-2"></i>Create New Recipe
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-tags-fill me-1"></i>Categories
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('categories.index') }}">
                                                <i class="bi bi-search me-2"></i>Browse Categories
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>{{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus-fill me-1"></i>{{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                                    @if(auth()->user()->is_admin)
                                        <span class="badge bg-danger ms-1">Admin</span>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(auth()->user()->is_admin)
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            <i class="bi bi-person-badge me-2"></i>Admin Profile
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="bi bi-person-gear me-2"></i>My Profile
                                        </a>
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>My Dashboard
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}
                                        </a>
                                    @endif
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>