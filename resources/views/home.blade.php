@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    Welcome to the Recipe Management System!
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @can('isAdmin')
                        You are logged in as an administrator. You can manage all users, recipes, and categories.
                    @elsecan('isUser')
                        You are logged in as a regular user. You can create, edit, and delete your own recipes.
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
