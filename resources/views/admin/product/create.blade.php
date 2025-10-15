@extends('layouts.backend.app')

@section('meta')
    <title>Add Business | Admin Panel</title>
@endsection

@section('content')
    <!--[ Page Content ] start -->
    <div class="page-content">
        <div class="container-fluid">

            <!-- [ Breadcrumb ] -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-20 fw-bold text-primary">
                            <i class="fas fa-building me-1"></i> Add Business
                        </h4>

                        <div class="page-title-right">
                            <a href="{{ route('admin.product') }}" class="btn btn-outline-primary">
                                <i class="fas fa-reply-all me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [ Main Form ] -->
            <div class="row mt-3">
                <div class="col-xl-10 mx-auto">
                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        @csrf

                        <div class="card shadow-sm">
                            <div class="card-header bg-light border-bottom">
                                <h5 class="card-title mb-0 text-dark">
                                    <i class="fas fa-info-circle me-1"></i> Business Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <!-- User Assign -->
                                    <div class="col-md-6">
                                        <label for="user_id" class="form-label fw-semibold">User Assign <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select select2" name="user_id" id="user_id" required>
                                            <option value="">Select User</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Please select a user.</div>
                                    </div>

                                    <!-- Business Name -->
                                    <div class="col-md-12">
                                        <label for="name" class="form-label fw-semibold">Business Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="Enter Business Name" onkeyup="slug_url(this.value,'init_slug')"
                                            required>
                                        <div class="invalid-feedback">Business name is required.</div>
                                    </div>

                                    <!-- Slug -->
                                    <div class="col-md-12">
                                        <label for="init_slug" class="form-label fw-semibold">Slug <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">{{ env('APP_URL') }}/</span>
                                            <input type="text" class="form-control" name="slug" id="init_slug"
                                                placeholder="Unique Slug" required>
                                        </div>
                                        <div class="invalid-feedback">Slug is required.</div>
                                    </div>

                                    <!-- Review Link -->
                                    <div class="col-md-12">
                                        <label for="init_link" class="form-label fw-semibold">Review Link <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="url" id="init_link"
                                            placeholder="Enter Review Link..." required>
                                        <div class="invalid-feedback">Review link is required.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Buttons -->
                            <div class="card-footer text-start">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Submit
                                </button>
                                <button type="reset" class="btn btn-outline-warning">
                                    <i class="fas fa-eraser me-1"></i> Clear
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
        // Bootstrap validation
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })();

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select a User",
                allowClear: true
            });
        });
    </script>
@endsection
