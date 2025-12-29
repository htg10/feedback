@extends('layouts.backend.app')

@section('meta')
    <title>Add New Department | Admin</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-building me-2"></i> Add New Department
                        </h4>
                        <a href="{{ route('admin.departments') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <form action="{{ route('admin.department.store') }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">🏢 Department Information</h5>
                            </div>
                            <div class="card-body">

                                <!-- Building -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Building <sup class="text-danger">*</sup></label>
                                    <select name="building_id" class="form-select" required>
                                        <option value="">-- Select Building --</option>
                                        @foreach ($buildings as $building)
                                            <option value="{{ $building->id }}">
                                                {{ $building->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Building is required.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="department" class="form-label fw-semibold">
                                        <i class="fas fa-tag me-1"></i> Department Name <sup
                                            class="text-danger fs-6">*</sup>
                                    </label>
                                    <input type="text" id="department" name="name" class="form-control"
                                        placeholder="Enter Department name" required>
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Department name is required.</div>
                                </div>

                            </div>
                        </div>

                        <!-- Form Buttons -->
                        <div class="card mt-3 shadow-sm">
                            <div class="card-body text-start">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check-circle me-1"></i> Submit
                                </button>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fas fa-undo me-1"></i> Clear
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('script')
    <script>
        // Bootstrap validation
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endsection
