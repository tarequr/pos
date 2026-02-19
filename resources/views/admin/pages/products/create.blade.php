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
                                    <label for="category_id" class="form-label">Category <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Branch -->
                                <div class="col-md-6 mb-3">
                                    <label for="branch_id" class="form-label">Branch <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="branch_id" name="branch_id" required>
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Serial Type Selection -->
                            <div class="mb-3">
                                <label class="form-label d-block">Serial Input Type <span
                                        class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="serial_type" id="serial_single"
                                        value="single" {{ old('serial_type', 'single') === 'single' ? 'checked' : '' }}
                                        onclick="toggleSerialInput('single')">
                                    <label class="form-check-label" for="serial_single">Single Entry</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="serial_type" id="serial_range"
                                        value="range" {{ old('serial_type') === 'range' ? 'checked' : '' }}
                                        onclick="toggleSerialInput('range')">
                                    <label class="form-check-label" for="serial_range">Range Entry (e.g. 1-10)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="serial_type" id="serial_bulk"
                                        value="bulk" {{ old('serial_type') === 'bulk' ? 'checked' : '' }}
                                        onclick="toggleSerialInput('bulk')">
                                    <label class="form-check-label" for="serial_bulk">Bulk Entry (50)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="serial_type" id="serial_custom"
                                        value="custom" {{ old('serial_type') === 'custom' ? 'checked' : '' }}
                                        onclick="toggleSerialInput('custom')">
                                    <label class="form-check-label" for="serial_custom">Custom Bulk Entry</label>
                                </div>
                            </div>

                            <!-- Single Serial Input -->
                            <div id="single-input" class="mb-3"
                                style="{{ old('serial_type', 'single') === 'single' ? '' : 'display:none;' }}">
                                <label for="serial_no" class="form-label">Serial Number <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="serial_no" name="serial_no"
                                    value="{{ old('serial_no') }}" placeholder="Enter Serial Number" {{ old('serial_type', 'single') === 'single' ? 'required' : '' }}>
                            </div>

                            <!-- Range Serial Input -->
                            <div id="range-input" class="row mb-3"
                                style="{{ old('serial_type') === 'range' ? '' : 'display:none;' }}">
                                <div class="col-md-6">
                                    <label for="serial_start" class="form-label">Start Serial (Number) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="serial_start" name="serial_start"
                                        value="{{ old('serial_start') }}" placeholder="Start Number" {{ old('serial_type') === 'range' ? 'required' : '' }}>
                                </div>
                                <div class="col-md-6">
                                    <label for="serial_end" class="form-label">End Serial (Number) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="serial_end" name="serial_end"
                                        value="{{ old('serial_end') }}" placeholder="End Number" {{ old('serial_type') === 'range' ? 'required' : '' }}>
                                </div>
                            </div>

                            <!-- Bulk Serial Input -->
                            <div id="bulk-input" class="mb-3"
                                style="{{ old('serial_type') === 'bulk' ? '' : 'display:none;' }}">
                                <div class="row">
                                    @for ($i = 1; $i <= 50; $i++)
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Serial Number {{ $i }}</label>
                                            <input type="number" class="form-control" name="bulk_serials[]"
                                                value="{{ old('bulk_serials.' . ($i - 1)) }}"
                                                placeholder="Enter Serial Number" {{ old('serial_type') === 'bulk' ? 'required' : '' }}>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <!-- Custom Bulk Serial Input -->
                            <div id="custom-bulk-input" class="mb-3"
                                style="{{ old('serial_type') === 'custom' ? '' : 'display:none;' }}">
                                <div class="mb-3 col-md-4">
                                    <label for="custom_serial_count" class="form-label">Number of Serials <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="custom_serial_count"
                                        placeholder="Enter count" min="1" max="200"
                                        onkeyup="generateCustomFields()" onchange="generateCustomFields()">
                                    <div id="custom-count-error" class="text-danger small mt-1" style="display: none;">Maximum 200 serials allowed.</div>
                                </div>
                                <div id="custom-serial-fields" class="row">
                                    <!-- Dynamic fields will be injected here -->
                                    @if(old('serial_type') === 'custom' && old('custom_serials'))
                                        @foreach(old('custom_serials') as $index => $val)
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Serial Number {{ $index + 1 }}</label>
                                                <input type="number" class="form-control" name="custom_serials[]"
                                                    value="{{ $val }}" placeholder="Enter Serial Number" required>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                {{-- <button type="submit" class="btn btn-primary"
                                    onclick="return confirm('Are you sure you want to save this product?')">Save
                                    Product</button> --}}
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
            const bulkInput = document.getElementById('bulk-input');
            const customInput = document.getElementById('custom-bulk-input');

            const serialNo = document.getElementById('serial_no');
            const serialStart = document.getElementById('serial_start');
            const serialEnd = document.getElementById('serial_end');
            const bulkSerials = document.getElementsByName('bulk_serials[]');

            // Hide all
            singleInput.style.display = 'none';
            rangeInput.style.display = 'none';
            bulkInput.style.display = 'none';
            customInput.style.display = 'none';

            // Remove required attribute from all inputs
            serialNo.removeAttribute('required');
            serialStart.removeAttribute('required');
            serialEnd.removeAttribute('required');
            for (let i = 0; i < bulkSerials.length; i++) {
                bulkSerials[i].removeAttribute('required');
            }

            // Clear all inputs when type changes
            serialNo.value = '';
            serialStart.value = '';
            serialEnd.value = '';
            for (let i = 0; i < bulkSerials.length; i++) {
                bulkSerials[i].value = '';
            }

            if (type === 'single') {
                singleInput.style.display = 'block';
                serialNo.setAttribute('required', 'required');
            } else if (type === 'range') {
                rangeInput.style.display = 'flex';
                serialStart.setAttribute('required', 'required');
                serialEnd.setAttribute('required', 'required');
            } else if (type === 'bulk') {
                bulkInput.style.display = 'block';
                for (let i = 0; i < bulkSerials.length; i++) {
                    bulkSerials[i].setAttribute('required', 'required');
                }
            } else if (type === 'custom') {
                customInput.style.display = 'block';
                // Trigger field generation if count exists
                generateCustomFields();
            }
        }

        function generateCustomFields() {
            const count = parseInt(document.getElementById('custom_serial_count').value);
            const container = document.getElementById('custom-serial-fields');

            // If we are showing old data, dont clear if count matches
            const currentFields = container.getElementsByTagName('input').length;

            const errorDiv = document.getElementById('custom-count-error');
            
            if (isNaN(count) || count < 1) {
                container.innerHTML = '';
                errorDiv.style.display = 'none';
                return;
            }

            if (count > 200) {
                errorDiv.style.display = 'block';
                container.innerHTML = '';
                return;
            } else {
                errorDiv.style.display = 'none';
            }

            // If count is same, do nothing to preserve values
            if (count === currentFields) return;

            let html = '';
            for (let i = 1; i <= count; i++) {
                html += `
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Serial Number ${i}</label>
                        <input type="number" class="form-control" name="custom_serials[]"
                            placeholder="Enter Serial Number" required>
                    </div>
                `;
            }
            container.innerHTML = html;
        }
    </script>
@endsection
