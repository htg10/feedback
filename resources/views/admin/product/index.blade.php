@extends('layouts.backend.app')

@section('meta')
    <title>Businesses | Admin Panel</title>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Header with title and Add button -->
            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">All Businesses</h4>
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add New Business
                    </a>
                </div>
            </div>

            <!-- Businesses Table Card -->
            <div class="card shadow-sm border">
                <div class="card-body p-3 p-md-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped align-middle mb-0 nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">Sr. No.</th>
                                    <th>Business Name</th>
                                    <th>Review URL</th>
                                    <th>Business URL</th>
                                    <th style="width: 110px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $key => $product)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="text-wrap">{{ $product->name }}</td>
                                        <td class="text-wrap">
                                            <a href="{{ env('APP_URL') . '/review/' . $product->slug }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                {{ env('APP_URL') }}/review/{{ $product->slug }}
                                            </a>
                                        </td>
                                        <td class="text-wrap">
                                            <a href="{{ $product->url }}" target="_blank" rel="noopener noreferrer">
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                {{ $product->url }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/product/' . $product->id . '/edit') }}"
                                                class="btn btn-info btn-sm me-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit Business">
                                                <i class="bx bx-pencil"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm sa-delete"
                                                data-id="{{ $product->id }}" data-link="/admin/product/delete/"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Business">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No businesses found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination (if applicable) --}}
                    <div class="mt-3">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
