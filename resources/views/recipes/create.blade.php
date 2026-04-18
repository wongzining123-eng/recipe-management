@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('recipes.index') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Back to Recipes
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 rounded-top-4">
                    <h2 class="h4 mb-0">
                        <i class="bi bi-plus-circle-fill text-primary me-2"></i>Create New Recipe
                    </h2>
                </div>

                <div class="card-body">
                    {{-- Display validation errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <strong class="mb-2 d-block">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following errors:
                            </strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" id="recipeForm">
                        @csrf

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">
                                <i class="bi bi-pencil-fill me-1 text-primary"></i>Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" 
                                   required
                                   maxlength="255"
                                   placeholder="Enter recipe title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <small class="text-muted">Maximum 255 characters</small>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">
                                <i class="bi bi-file-text-fill me-1 text-primary"></i>Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Brief description of your recipe...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Time + Servings row --}}
                        <div class="row g-3 mb-3">
                            <div class="col-sm-4">
                                <label for="prep_time" class="form-label fw-semibold">
                                    <i class="bi bi-hourglass-split me-1 text-primary"></i>Prep Time (min) <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       name="prep_time" 
                                       id="prep_time" 
                                       min="0"
                                       max="1440"
                                       class="form-control @error('prep_time') is-invalid @enderror"
                                       value="{{ old('prep_time', 0) }}" 
                                       required>
                                @error('prep_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="cook_time" class="form-label fw-semibold">
                                    <i class="bi bi-fire me-1 text-primary"></i>Cook Time (min) <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       name="cook_time" 
                                       id="cook_time" 
                                       min="0"
                                       max="1440"
                                       class="form-control @error('cook_time') is-invalid @enderror"
                                       value="{{ old('cook_time', 0) }}" 
                                       required>
                                @error('cook_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="servings" class="form-label fw-semibold">
                                    <i class="bi bi-people-fill me-1 text-primary"></i>Servings <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       name="servings" 
                                       id="servings" 
                                       min="1"
                                       max="100"
                                       class="form-control @error('servings') is-invalid @enderror"
                                       value="{{ old('servings', 1) }}" 
                                       required>
                                @error('servings')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Ingredients --}}
                        <div class="mb-3">
                            <label for="ingredients" class="form-label fw-semibold">
                                <i class="bi bi-cart-fill me-1 text-primary"></i>Ingredients <span class="text-danger">*</span>
                            </label>
                            <small class="text-muted d-block mb-1">List each ingredient on a new line.</small>
                            <textarea name="ingredients" 
                                      id="ingredients" 
                                      rows="6"
                                      class="form-control @error('ingredients') is-invalid @enderror"
                                      required 
                                      placeholder="1 cup flour&#10;2 eggs&#10;1/2 cup sugar">{{ old('ingredients') }}</textarea>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Instructions --}}
                        <div class="mb-3">
                            <label for="instructions" class="form-label fw-semibold">
                                <i class="bi bi-list-ol me-1 text-primary"></i>Instructions <span class="text-danger">*</span>
                            </label>
                            <small class="text-muted d-block mb-1">Describe each step on a new line.</small>
                            <textarea name="instructions" 
                                      id="instructions" 
                                      rows="8"
                                      class="form-control @error('instructions') is-invalid @enderror"
                                      required 
                                      placeholder="1. Preheat oven to 350°F&#10;2. Mix dry ingredients&#10;3. Bake for 30 minutes">{{ old('instructions') }}</textarea>
                            @error('instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Categories --}}
                        <div class="mb-3">
                            <label for="categories" class="form-label fw-semibold">
                                <i class="bi bi-tags-fill me-1 text-primary"></i>Categories
                            </label>
                            <small class="text-muted d-block mb-1">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</small>
                            <select name="categories[]" 
                                    id="categories" 
                                    multiple
                                    class="form-select @error('categories') is-invalid @enderror"
                                    size="5">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if(!$categories->count())
                                <small class="text-warning d-block mt-1">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    No categories available. Please contact the administrator.
                                </small>
                            @endif
                        </div>

                        {{-- Image URL --}}
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">
                                <i class="bi bi-image-fill me-1 text-primary"></i>Image URL <span class="text-danger">*</span>
                            </label>
                            <input type="url" 
                                   name="image" 
                                   id="image" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   value="{{ old('image') }}"
                                   required
                                   placeholder="https://example.com/delicious-food.jpg">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Paste a direct image URL from Imgur, Google Photos, Flickr, or any image hosting service.
                                <br>
                                <strong>Tip:</strong> Right-click on any image online and select "Copy image address/URL"
                            </small>
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image Preview --}}
                        <div id="imagePreviewContainer" class="mt-2 mb-3" style="display: none;">
                            <p class="text-muted small mb-2">
                                <i class="bi bi-eye me-1"></i>Image Preview:
                            </p>
                            <div class="position-relative d-inline-block">
                                <img id="imagePreview" 
                                     src="" 
                                     alt="Preview" 
                                     style="max-height: 200px; max-width: 100%; border-radius: 8px; object-fit: cover;">
                                <button type="button" 
                                        id="clearPreview" 
                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle"
                                        style="width: 30px; height: 30px; padding: 0;"
                                        title="Clear preview">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="d-flex gap-2 mt-4 pt-2 border-top">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-save-fill me-1"></i>Create Recipe
                            </button>
                            <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </a>
                            <button type="reset" class="btn btn-outline-danger ms-auto">
                                <i class="bi bi-arrow-repeat me-1"></i>Reset Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .invalid-feedback {
        font-size: 0.875rem;
    }
    
    #imagePreview {
        transition: all 0.3s ease;
    }
    
    #imagePreview:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    (function() {
        'use strict';
        
        // DOM Elements
        const form = document.getElementById('recipeForm');
        const imageUrlInput = document.getElementById('image_url');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');
        const clearPreviewBtn = document.getElementById('clearPreview');
        const submitBtn = document.getElementById('submitBtn');
        
        // Image preview functionality
        function updateImagePreview() {
            const url = imageUrlInput.value.trim();
            
            if (url && (url.startsWith('http://') || url.startsWith('https://'))) {
                previewImage.src = url;
                previewContainer.style.display = 'block';
                
                // Handle image load error
                previewImage.onload = function() {
                    previewContainer.classList.remove('border-danger');
                    previewImage.style.display = 'block';
                };
                
                previewImage.onerror = function() {
                    previewContainer.style.display = 'none';
                    showTemporaryMessage('Invalid image URL. Please check the link.', 'danger');
                };
            } else {
                previewContainer.style.display = 'none';
                previewImage.src = '';
            }
        }
        
        // Clear preview
        function clearPreview() {
            imageUrlInput.value = '';
            previewContainer.style.display = 'none';
            previewImage.src = '';
            imageUrlInput.focus();
        }
        
        // Show temporary message
        function showTemporaryMessage(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                <i class="bi bi-${type === 'danger' ? 'exclamation-triangle' : 'info-circle'}-fill me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
        
        // Form validation
        function validateForm(event) {
            let isValid = true;
            const requiredFields = ['title', 'prep_time', 'cook_time', 'servings', 'ingredients', 'instructions', 'image_url'];
            
            // Clear previous validation styles
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            
            // Validate each required field
            for (const field of requiredFields) {
                const input = document.getElementById(field);
                if (input && !input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                    
                    // Create error message if not exists
                    let errorDiv = input.nextElementSibling;
                    if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = `${field.replace('_', ' ')} is required.`;
                        input.parentNode.insertBefore(errorDiv, input.nextSibling);
                    }
                }
            }
            
            // Validate image URL format
            const imageUrl = imageUrlInput.value.trim();
            if (imageUrl && !isValidUrl(imageUrl)) {
                imageUrlInput.classList.add('is-invalid');
                showTemporaryMessage('Please enter a valid URL (e.g., https://example.com/image.jpg)', 'danger');
                isValid = false;
            }
            
            // Validate numeric fields
            const prepTime = parseInt(document.getElementById('prep_time').value);
            const cookTime = parseInt(document.getElementById('cook_time').value);
            const servings = parseInt(document.getElementById('servings').value);
            
            if (isNaN(prepTime) || prepTime < 0 || prepTime > 1440) {
                document.getElementById('prep_time').classList.add('is-invalid');
                isValid = false;
            }
            
            if (isNaN(cookTime) || cookTime < 0 || cookTime > 1440) {
                document.getElementById('cook_time').classList.add('is-invalid');
                isValid = false;
            }
            
            if (isNaN(servings) || servings < 1 || servings > 100) {
                document.getElementById('servings').classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                event.preventDefault();
                showTemporaryMessage('Please fix the errors in the form.', 'danger');
                // Scroll to first error
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            } else {
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Creating Recipe...';
            }
            
            return isValid;
        }
        
        // URL validation helper
        function isValidUrl(string) {
            try {
                const url = new URL(string);
                return url.protocol === 'http:' || url.protocol === 'https:';
            } catch (_) {
                return false;
            }
        }
        
        // Auto-save draft to localStorage
        function autoSaveDraft() {
            const formData = {
                title: document.getElementById('title')?.value || '',
                description: document.getElementById('description')?.value || '',
                prep_time: document.getElementById('prep_time')?.value || '0',
                cook_time: document.getElementById('cook_time')?.value || '0',
                servings: document.getElementById('servings')?.value || '1',
                ingredients: document.getElementById('ingredients')?.value || '',
                instructions: document.getElementById('instructions')?.value || '',
                categories: Array.from(document.getElementById('categories')?.selectedOptions || []).map(opt => opt.value),
                image_url: document.getElementById('image_url')?.value || '',
                saved_at: new Date().toISOString()
            };
            
            localStorage.setItem('recipe_draft', JSON.stringify(formData));
        }
        
        // Load draft from localStorage
        function loadDraft() {
            const draft = localStorage.getItem('recipe_draft');
            if (draft) {
                const formData = JSON.parse(draft);
                const saveTime = new Date(formData.saved_at);
                const now = new Date();
                const hoursDiff = (now - saveTime) / (1000 * 60 * 60);
                
                // Only load draft if less than 24 hours old
                if (hoursDiff < 24) {
                    if (confirm(`You have a saved draft from ${saveTime.toLocaleString()}. Do you want to restore it?`)) {
                        document.getElementById('title').value = formData.title || '';
                        document.getElementById('description').value = formData.description || '';
                        document.getElementById('prep_time').value = formData.prep_time || '0';
                        document.getElementById('cook_time').value = formData.cook_time || '0';
                        document.getElementById('servings').value = formData.servings || '1';
                        document.getElementById('ingredients').value = formData.ingredients || '';
                        document.getElementById('instructions').value = formData.instructions || '';
                        document.getElementById('image_url').value = formData.image_url || '';
                        
                        // Restore categories
                        if (formData.categories && formData.categories.length) {
                            const select = document.getElementById('categories');
                            Array.from(select.options).forEach(option => {
                                if (formData.categories.includes(option.value)) {
                                    option.selected = true;
                                }
                            });
                        }
                        
                        updateImagePreview();
                        showTemporaryMessage('Draft restored successfully!', 'success');
                    }
                } else {
                    localStorage.removeItem('recipe_draft');
                }
            }
        }
        
        // Clear draft on successful submission
        function clearDraft() {
            localStorage.removeItem('recipe_draft');
        }
        
        // Event Listeners
        if (imageUrlInput) {
            imageUrlInput.addEventListener('input', updateImagePreview);
            imageUrlInput.addEventListener('blur', updateImagePreview);
        }
        
        if (clearPreviewBtn) {
            clearPreviewBtn.addEventListener('click', clearPreview);
        }
        
        if (form) {
            form.addEventListener('submit', validateForm);
            
            // Auto-save on input changes (debounced)
            let saveTimeout;
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(autoSaveDraft, 2000);
                });
            });
        }
        
        // Reset button handler
        const resetBtn = document.querySelector('button[type="reset"]');
        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                if (confirm('Are you sure you want to reset all form fields?')) {
                    setTimeout(() => {
                        clearPreview();
                        const errorElements = document.querySelectorAll('.is-invalid');
                        errorElements.forEach(el => el.classList.remove('is-invalid'));
                        showTemporaryMessage('Form has been reset.', 'info');
                    }, 100);
                } else {
                    e.preventDefault();
                }
            });
        }
        
        // Load draft on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadDraft);
        } else {
            loadDraft();
        }
        
        // Warn before leaving if form has unsaved changes
        let formChanged = false;
        const formInputs = form?.querySelectorAll('input, textarea, select');
        formInputs?.forEach(input => {
            input.addEventListener('change', () => {
                formChanged = true;
            });
        });
        
        window.addEventListener('beforeunload', (e) => {
            if (formChanged && !form?.hasAttribute('data-submitted')) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                return e.returnValue;
            }
        });
        
        form?.addEventListener('submit', () => {
            form.setAttribute('data-submitted', 'true');
            clearDraft();
        });
    })();
</script>
@endpush