@extends('layouts.backend.app')

@section('meta')
    <title>Edit Business | Admin Panel</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- [ Breadcrumb and Page Title ] -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 text-primary fw-bold">
                            <i class="fas fa-edit me-2"></i> Edit Business
                        </h4>
                        <div>
                            <a href="{{ route('admin.product') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [ Form Start ] -->
            <div class="row mt-4">
                <div class="col-xl-10 mx-auto">
                    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" value="{{ $product['id'] }}">

                        <!-- Card: Business Info -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-light border-bottom">
                                <h5 class="mb-0 text-dark">
                                    <i class="fas fa-briefcase me-2 text-info"></i> Business Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">

                                    <!-- User Assign -->
                                    <div class="col-md-6">
                                        <label for="user_id" class="form-label fw-semibold">User Assign <span class="text-danger">*</span></label>
                                        <select class="form-select select2" name="user_id" id="user_id" required>
                                            <option value="">Select User</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $user->id == $product->user_id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">User assignment is required.</div>
                                    </div>

                                    <!-- Business Name -->
                                    <div class="col-md-12">
                                        <label for="name" class="form-label fw-semibold">Business Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" value="{{ $product->name }}" class="form-control" placeholder="Enter Business Name" onkeyup="slug_url(this.value, 'init_slug')" required>
                                        <div class="invalid-feedback">Business name is required.</div>
                                    </div>

                                    <!-- Slug -->
                                    <div class="col-md-12">
                                        <label for="init_slug" class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">{{ env('APP_URL') }}/</span>
                                            <input type="text" class="form-control" id="init_slug" name="slug" value="{{ $product->slug }}" placeholder="Unique Slug" required>
                                        </div>
                                        <div class="invalid-feedback">Slug is required.</div>
                                    </div>

                                    <!-- Review Link -->
                                    <div class="col-md-12">
                                        <label for="init_link" class="form-label fw-semibold">Review Link <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="init_link" name="url" value="{{ $product->url }}" placeholder="Enter Review Link" required>
                                        <div class="invalid-feedback">Review link is required.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card: Actions -->
                        <div class="card shadow-sm border-0 text-start">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                                <button type="reset" class="btn btn-warning ms-2">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
<script>
    // Bootstrap 5 Validation
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select a User",
                allowClear: true
            });
        });
</script>
@endsection
