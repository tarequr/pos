@extends('admin.layouts.master')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Create Product</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Product Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        
                         @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Product Name" required>
                            </div>

                            <!-- Category -->
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Branch -->
                             <div class="col-md-12 mb-3">
                                <label for="branch_id" class="form-label">Branch <span class="text-danger">*</span></label>
                                <select class="form-control" id="branch_id" name="branch_id" required>
                                    <option value="">Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Serial Type Selection -->
                        <div class="mb-3">
                            <label class="form-label d-block">Serial Input Type <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="serial_type" id="serial_single" value="single" {{ old('serial_type', 'single') === 'single' ? 'checked' : '' }} onclick="toggleSerialInput('single')">
                                <label class="form-check-label" for="serial_single">Single Entry</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="serial_type" id="serial_range" value="range" {{ old('serial_type') === 'range' ? 'checked' : '' }} onclick="toggleSerialInput('range')">
                                <label class="form-check-label" for="serial_range">Range Entry (e.g. 1-10)</label>
                            </div>
                        </div>

                        <!-- Single Serial Input -->
                        <div id="single-input" class="mb-3" style="{{ old('serial_type', 'single') === 'single' ? '' : 'display:none;' }}">
                            <label for="serial_no" class="form-label">Serial Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="serial_no" name="serial_no" value="{{ old('serial_no') }}" placeholder="Enter Serial Number">
                        </div>

                        <!-- Range Serial Input -->
                        <div id="range-input" class="row mb-3" style="{{ old('serial_type') === 'range' ? '' : 'display:none;' }}">
                            <div class="col-md-6">
                                <label for="serial_start" class="form-label">Start Serial (Number) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="serial_start" name="serial_start" value="{{ old('serial_start') }}" placeholder="Start Number">
                            </div>
                            <div class="col-md-6">
                                <label for="serial_end" class="form-label">End Serial (Number) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="serial_end" name="serial_end" value="{{ old('serial_end') }}" placeholder="End Number">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSerialInput(type) {
        const singleInput = document.getElementById('single-input');
        const rangeInput = document.getElementById('range-input');

        if (type === 'single') {
            singleInput.style.display = 'block';
            rangeInput.style.display = 'none';
        } else {
            singleInput.style.display = 'none';
            rangeInput.style.display = 'flex'; // Use flex for row behavior
        }
    }
</script>
@endsection
