@extends('admin.layouts.master')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Products</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary float-end">Add Product</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filters</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <select id="filter-category" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Branch</label>
                            <select id="filter-branch" class="form-control">
                                <option value="">All Branches</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button id="reset-filters" class="btn btn-secondary">Reset Filters</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Product List</h5>
                        <button type="button" id="bulk-stock-out-btn" class="btn btn-warning" style="display:none;">Bulk Stock Out</button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="bulk-stock-out-form" action="{{ route('products.bulk-stock-out') }}" method="POST">
                        @csrf
                        <table id="products-table" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="check-all"></th>
                                    <th>SL</th>
                                    <th>Category</th>
                                    <th>Branch</th>
                                    <th>Serial</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = $("#products-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('products.index') }}",
                    data: function (d) {
                        d.category_id = $('#filter-category').val();
                        d.branch_id = $('#filter-branch').val();
                    }
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'category.name', name: 'category.name' },
                    { data: 'branch.name', name: 'branch.name' },
                    { data: 'serial_no', name: 'serial_no' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[2, 'asc']]
            });

            $('#filter-category, #filter-branch').on('change', function() {
                table.draw();
            });

            $('#reset-filters').on('click', function() {
                $('#filter-category').val('');
                $('#filter-branch').val('');
                table.draw();
            });

            // Handle Check All
            $('#check-all').on('click', function() {
                $('.product-checkbox').prop('checked', this.checked);
                toggleBulkButton();
            });

            // Handle Row Checkbox
            $('#products-table').on('click', '.product-checkbox', function() {
                if (!this.checked) {
                    $('#check-all').prop('checked', false);
                }
                toggleBulkButton();
            });

            function toggleBulkButton() {
                const checkedCount = $('.product-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#bulk-stock-out-btn').show().text(`Bulk Stock Out (${checkedCount})`);
                } else {
                    $('#bulk-stock-out-btn').hide();
                }
            }

            $('#bulk-stock-out-btn').on('click', function() {
                if (confirm('Are you sure you want to mark the selected items as sold?')) {
                    $('#bulk-stock-out-form').submit();
                }
            });

            // Reset checkboxes on table draw
            table.on('draw', function() {
                $('#check-all').prop('checked', false);
                toggleBulkButton();
            });
        });
    </script>
@endpush
