@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid p-0">

        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>Analytics</strong> Dashboard</h3>
            </div>

            <div class="col-auto ms-auto text-end mt-n1">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Total Products</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="package"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $total_products }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">In system</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Stock In</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="archive"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3 text-success">{{ $stock_in_products }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Stock Out</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="shopping-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3 text-danger">{{ $stock_out_products }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Sold items</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Categories</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="tag"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $total_categories }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Active classes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Branches</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="map-pin"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $total_branches }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Locations</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Admins</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="users"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $total_users }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Total users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>Today's</strong> Statistics</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Today's Stock In</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="plus-circle"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3 text-success">{{ $today_stock_in }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Products received</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Today's Stock Out</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="minus-circle"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3 text-danger">{{ $today_stock_out }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Products dispatched</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Today's Category In</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="layers"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $today_category_stock_in }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Categories involved</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Today's Category Out</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="layers"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $today_category_stock_out }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Categories involved</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Today's Branch In</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="map"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $today_branch_stock_in }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Branches involved</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Today's Branch Out</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="map"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $today_branch_stock_out }}</h1>
                                <div class="mb-0">
                                    <span class="text-muted">Branches involved</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Products List</h5>
                    </div>
                    <div class="card-body">
                        <table id="latest-products-table" class="table table-hover my-0" style="width:100%">
                            <thead>
                                <tr>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Category Stock Levels</h5>
                    </div>
                    <div class="card-body">
                        <table id="category-stats-table" class="table table-hover my-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Category Name</th>
                                    <th>Stock In</th>
                                    <th>Stock Out</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Branch Stock Levels</h5>
                    </div>
                    <div class="card-body">
                        <table id="branch-stats-table" class="table table-hover my-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Branch Name</th>
                                    <th>Stock In</th>
                                    <th>Stock Out</th>
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
            // Products Table
            $("#latest-products-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('dashboard') }}",
                    data: { table_type: 'products' }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'category.name', name: 'category.name' },
                    { data: 'branch.name', name: 'branch.name' },
                    { 
                        data: 'serial_no', 
                        name: 'serial_no',
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light rounded-2">
                                            <div class="p-2">
                                                <i class="align-middle" data-feather="package"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <strong>${data}</strong>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'desc']],
                drawCallback: function() {
                    feather.replace();
                }
            });

            // Category Stats Table
            $("#category-stats-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                searching: true,
                ajax: {
                    url: "{{ route('dashboard') }}",
                    data: { table_type: 'categories' }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'stock_in', name: 'stock_in', orderable: false, searchable: false },
                    { data: 'stock_out', name: 'stock_out', orderable: false, searchable: false },
                ]
            });

            // Branch Stats Table
            $("#branch-stats-table").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                searching: true,
                ajax: {
                    url: "{{ route('dashboard') }}",
                    data: { table_type: 'branches' }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'stock_in', name: 'stock_in', orderable: false, searchable: false },
                    { data: 'stock_out', name: 'stock_out', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush
