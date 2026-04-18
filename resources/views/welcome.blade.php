<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABC Recipe - Discover Amazing Recipes</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .btn-custom {
            background: #ff6b6b;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            background: #ff5252;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container text-center text-white">
            <h1 class="display-1 fw-bold mb-4">🍽️ ABC Recipe</h1>
            <p class="lead fs-2 mb-4">Discover, Create, and Share Amazing Recipes</p>
            <p class="mb-5">Join our community of food lovers and explore thousands of delicious recipes!</p>
            
            @if (Route::has('login'))
                <div class="d-flex justify-content-center gap-3">
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-custom">Go to Dashboard →</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-custom">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</body>
</html>