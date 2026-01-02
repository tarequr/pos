@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Stock Out Products</h1>
            <a href="{{ route('products.index') }}" class="btn btn-secondary float-end">Back to Product List</a>
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
                        <h5 class="card-title mb-0">Stock Out Product List</h5>
                    </div>
                    <div class="card-body">
                        <table id="stock-out-table" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Category</th>
                                    <th>Branch</th>
                                    <th>Serial</th>
                                    <th>Status</th>
                                    <th>Sold Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = $("#stock-out-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 100, // Default per page 100
                ajax: {
                    url: "{{ route('products.stock_out_list') }}",
                    data: function (d) {
                        d.category_id = $('#filter-category').val();
                        d.branch_id = $('#filter-branch').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'category.name', name: 'category.name' },
                    { data: 'branch.name', name: 'branch.name' },
                    { data: 'serial_no', name: 'serial_no' },
                    { data: 'status', name: 'status' },
                    { data: 'updated_at', name: 'updated_at' },
                ],
                order: [[5, 'desc']] // Order by Date Sold
            });

            $('#filter-category, #filter-branch').on('change', function() {
                table.draw();
            });

            $('#reset-filters').on('click', function() {
                $('#filter-category').val('');
                $('#filter-branch').val('');
                table.draw();
            });
        });
    </script>
@endpush
