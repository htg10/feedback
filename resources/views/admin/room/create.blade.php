@extends('layouts.backend.app')

@section('meta')
    <title>Add New Room | Admin</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-building me-2"></i> Add New Room
                        </h4>
                        <a href="{{ route('admin.rooms') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <form action="{{ route('admin.room.store') }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">🧩 Room Information</h5>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="room" class="form-label fw-semibold">
                                                <i class="fas fa-tag me-1"></i> Room No. <sup
                                                    class="text-danger fs-6">*</sup>
                                            </label>
                                            <input type="text" id="room" name="name" class="form-control"
                                                placeholder="Enter Room Name" required>
                                            <div class="valid-feedback">Looks good!</div>
                                            <div class="invalid-feedback">Toilet name is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="toilet" class="form-label fw-semibold">
                                                <i class="fas fa-tag me-1"></i> Building <sup
                                                    class="text-danger fs-6">*</sup>
                                            </label>
                                            <select id="toilet" name="building_id" class="form-select" required>
                                                <option value="" selected disabled>-- Select Building --</option>
                                                @foreach ($buildings as $key => $building)
                                                    <option value="{{ $building->id }}">{{ $building->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                            <div class="invalid-feedback">Toilet name is required.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="toilet" class="form-label fw-semibold">
                                                <i class="fas fa-tag me-1"></i> Floor <sup class="text-danger fs-6">*</sup>
                                            </label>
                                            <select id="toilet" name="floor_id" class="form-select" required>
                                                <option value="" selected disabled>-- Select Floor --</option>
                                                @foreach ($floors as $key => $floor)
                                                    <option value="{{ $floor->id }}">{{ $floor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                            <div class="invalid-feedback">Toilet name is required.</div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="toilet" class="form-label fw-semibold">
                                                <i class="fas fa-tag me-1"></i> Category <sup
                                                    class="text-danger fs-6">*</sup>
                                            </label>
                                            <select id="toilet" name="category_id" class="form-select" required>
                                                <option value="" selected disabled>-- Select Category --</option>
                                                @foreach ($categories as $key => $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                            <div class="invalid-feedback">Toilet name is required.</div>
                                        </div>
                                    </div> --}}
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
