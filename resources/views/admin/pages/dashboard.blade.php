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



        <div class="row">
            <div class="col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="card-actions float-end">
                            <div class="dropdown position-relative">
                                <a href="#" data-bs-toggle="dropdown" data-bs-display="static">
                                    <i class="align-middle" data-feather="more-horizontal"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Latest Products</h5>
                    </div>
                    <table class="table table-borderless my-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="d-none d-xxl-table-cell">Category</th>
                                <th class="d-none d-xl-table-cell">Branch</th>
                                <th>Status</th>
                                <th class="d-none d-xl-table-cell">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latest_products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light rounded-2">
                                                <div class="p-2">
                                                    <i class="align-middle" data-feather="package"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <strong>{{ $product->name }}</strong>
                                            <div class="text-muted">
                                                {{ $product->serial_no }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-xxl-table-cell">
                                    <strong>{{ $product->category->name ?? 'N/A' }}</strong>
                                </td>
                                <td class="d-none d-xl-table-cell">
                                    <strong>{{ $product->branch->name ?? 'N/A' }}</strong>
                                </td>
                                <td>
                                    @if($product->status === 'stock_in')
                                        <span class="badge bg-success">In Stock</span>
                                    @else
                                        <span class="badge bg-danger">Stock Out</span>
                                    @endif
                                </td>
                                <td class="d-none d-xl-table-cell">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-light">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
@endsection
