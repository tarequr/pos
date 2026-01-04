@extends('admin.layouts.master')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Create Product</h1>
        <a href="{{ route('products.index') }}" class="btn btn-danger float-end">Back</a>
    </div>

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

                            <!-- Branch -->
                             <div class="col-md-6 mb-3">
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
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="serial_type" id="serial_bulk" value="bulk" {{ old('serial_type') === 'bulk' ? 'checked' : '' }} onclick="toggleSerialInput('bulk')">
                                <label class="form-check-label" for="serial_bulk">Bulk Entry (50)</label>
                            </div>
                        </div>

                        <!-- Single Serial Input -->
                        <div id="single-input" class="mb-3" style="{{ old('serial_type', 'single') === 'single' ? '' : 'display:none;' }}">
                            <label for="serial_no" class="form-label">Serial Number <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="serial_no" name="serial_no" value="{{ old('serial_no') }}" placeholder="Enter Serial Number">
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

                        <!-- Bulk Serial Input -->
                        <div id="bulk-input" class="mb-3" style="{{ old('serial_type') === 'bulk' ? '' : 'display:none;' }}">
                            <div class="row">
                                @for($i = 1; $i <= 50; $i++)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Serial Number {{ $i }}</label>
                                        <input type="number" class="form-control" name="bulk_serials[]" 
                                               value="{{ old('bulk_serials.' . ($i-1)) }}" 
                                               placeholder="Enter Serial Number">
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <!-- <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to save this product?')">Save Product</button> -->
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
        const rangeInput  = document.getElementById('range-input');
        const bulkInput   = document.getElementById('bulk-input');

        // Hide all
        singleInput.style.display = 'none';
        rangeInput.style.display  = 'none';
        bulkInput.style.display   = 'none';

        // Clear all inputs when type changes
        document.getElementById('serial_no').value = '';
        document.getElementById('serial_start').value = '';
        document.getElementById('serial_end').value = '';
        const bulkSerials = document.getElementsByName('bulk_serials[]');
        for (let i = 0; i < bulkSerials.length; i++) {
            bulkSerials[i].value = '';
        }

        if (type === 'single') {
            singleInput.style.display = 'block';
        } else if (type === 'range') {
            rangeInput.style.display  = 'flex';
        } else if (type === 'bulk') {
            bulkInput.style.display   = 'block';
        }
    }
</script>
@endsection
