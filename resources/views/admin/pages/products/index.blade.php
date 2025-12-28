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
                    <h5 class="card-title mb-0">Product List</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Branch</th>
                                <th>Serial</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    <td>{{ $product->branch->name ?? 'N/A' }}</td>
                                    <td>{{ $product->serial_no }}</td>
                                    <td>
                                        <span class="badge {{ $product->status === 'stock_in' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->status === 'stock_in' ? 'Stock In' : ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->status === 'stock_in')
                                            <form action="{{ route('products.stock-out', $product) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to mark this item as sold?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning">Stock Out</button>
                                            </form>
                                        @else
                                            <span class="text-muted">Stock Out</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
            // Datatables Responsive
            $("#datatables-reponsive").DataTable({
                responsive: true
            });
        });
    </script>
@endpush
