@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Information Card -->
            <div class="card mb-4 border-0 shadow-lg rounded-4">
                <div class="card-header bg-white border-0 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-person-circle text-primary me-2"></i>Profile Information
                        </h5>
                        @if(!request()->has('edit'))
                            <a href="?edit=profile" class="btn btn-primary btn-sm rounded-pill">
                                <i class="bi bi-pencil-square me-1"></i>Edit Profile
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(request()->get('edit') === 'profile')
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person-fill me-1 text-primary"></i>Name
                                </label>
                                <input type="text" class="form-control rounded-3" name="name" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-envelope-fill me-1 text-primary"></i>Email
                                </label>
                                <input type="email" class="form-control rounded-3" name="email" value="{{ auth()->user()->email }}" required>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary rounded-pill">
                                    <i class="bi bi-save-fill me-1"></i>Save Changes
                                </button>
                                <a href="{{ route('profile.edit') }}" class="btn btn-secondary rounded-pill">
                                    <i class="bi bi-x-circle me-1"></i>Cancel
                                </a>
                            </div>
                        </form>
                    @else
                        <div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">
                                    <i class="bi bi-person-fill me-1"></i>Name:
                                </label>
                                <p class="mt-1 fs-5">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">
                                    <i class="bi bi-envelope-fill me-1"></i>Email:
                                </label>
                                <p class="mt-1 fs-5">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">
                                    <i class="bi bi-shield-fill-check me-1"></i>Role:
                                </label>
                                <p class="mt-1">
                                    @if(auth()->user()->is_admin)
                                        <span class="badge bg-danger rounded-pill">
                                            <i class="bi bi-shield-lock-fill me-1"></i>Administrator
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">
                                            <i class="bi bi-person-fill me-1"></i>User
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">
                                    <i class="bi bi-calendar-fill me-1"></i>Member Since:
                                </label>
                                <p class="mt-1">{{ auth()->user()->created_at->format('F j, Y') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">
                                    <i class="bi bi-book-fill me-1"></i>Total Recipes:
                                </label>
                                <p class="mt-1">
                                    <span class="badge bg-primary rounded-pill">
                                        {{ auth()->user()->recipes()->count() }} recipes
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="card mb-4 border-0 shadow-lg rounded-4">
                <div class="card-header bg-white border-0 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-lock-fill text-warning me-2"></i>Change Password
                        </h5>
                        @if(!request()->has('edit'))
                            <a href="?edit=password" class="btn btn-warning btn-sm rounded-pill">
                                <i class="bi bi-key-fill me-1"></i>Change Password
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(request()->get('edit') === 'password')
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-lock-fill me-1 text-warning"></i>Current Password
                                </label>
                                <input type="password" class="form-control rounded-3" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-key-fill me-1 text-warning"></i>New Password
                                </label>
                                <input type="password" class="form-control rounded-3" name="password" required>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Minimum 8 characters
                                </small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1 text-warning"></i>Confirm New Password
                                </label>
                                <input type="password" class="form-control rounded-3" name="password_confirmation" required>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning rounded-pill">
                                    <i class="bi bi-save-fill me-1"></i>Update Password
                                </button>
                                <a href="{{ route('profile.edit') }}" class="btn btn-secondary rounded-pill">
                                    <i class="bi bi-x-circle me-1"></i>Cancel
                                </a>
                            </div>
                        </form>
                    @else
                        <p class="text-muted mb-0">
                            <i class="bi bi-shield-lock-fill me-1"></i>
                            Click the button above to change your password.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Danger Zone Card -->
            <div class="card border-danger shadow-lg rounded-4">
                <div class="card-header bg-danger text-white border-0 rounded-top-4">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        <i class="bi bi-info-circle-fill me-1 text-danger"></i>
                        Once you delete your account, all your recipes and data will be permanently removed. This action cannot be undone.
                    </p>
                    <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash-fill me-1"></i>Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-danger text-white border-0 rounded-top-4">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Delete Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-danger">
                        <i class="bi bi-exclamation-octagon-fill me-1"></i>
                        <strong>Warning:</strong> This action cannot be undone.
                    </p>
                    <p>All your recipes and associated data will be permanently deleted.</p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-lock-fill me-1"></i>Enter your password to confirm:
                        </label>
                        <input type="password" class="form-control rounded-3" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-danger rounded-pill">
                        <i class="bi bi-trash-fill me-1"></i>Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection