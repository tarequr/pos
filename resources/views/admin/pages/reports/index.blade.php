@extends('admin.layouts.master')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Product Reports</h1>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filters</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Branch</label>
                                <select name="branch_id" class="form-control">
                                    <option value="">All Branches</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="stock_in" {{ request('status') == 'stock_in' ? 'selected' : '' }}>Stock In</option>
                                    <option value="stock_out" {{ request('status') == 'stock_out' ? 'selected' : '' }}>Stock Out</option>
                                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-3 mb-3 d-flex align-items-end">
                                <div class="btn-group w-100">
                                    <button type="submit" class="btn btn-primary">Generate Report</button>
                                    <a href="{{ route('reports.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Report Results</h5>
                    @if(count($products) > 0)
                        <button onclick="window.print()" class="btn btn-info btn-sm">
                            <i class="align-middle" data-feather="printer"></i> Print Report
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <table id="report-table" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Category</th>
                                <th>Branch</th>
                                <th>Serial No</th>
                                <th>Status</th>
                                <th>Stock In Date</th>
                                <th>Stock Out Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->branch->name }}</td>
                                    <td>{{ $product->serial_no }}</td>
                                    <td>
                                        @if($product->status == 'stock_in')
                                            <span class="badge bg-success">Stock In</span>
                                        @elseif($product->status == 'stock_out')
                                            <span class="badge bg-danger">Stock Out</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ ucfirst($product->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->stock_in_date ? \Carbon\Carbon::parse($product->stock_in_date)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $product->stock_out_date ? \Carbon\Carbon::parse($product->stock_out_date)->format('d-m-Y') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No products found for the selected criteria.</td>
                                </tr>
                            @endforelse
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
    $(document).ready(function() {
        $('#report-table').DataTable({
            responsive: true,
            pageLength: 50,
            order: [[0, 'asc']]
        });
    });
</script>
@endpush

@push('css')
<style>
    @media print {
        .sidebar, .navbar, .card-header .btn, .card-body form, .footer {
            display: none !important;
        }
        .main {
            padding: 0 !important;
            margin: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .content {
            padding: 0 !important;
        }
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        th, td {
            border: 1px solid #ddd !important;
            padding: 8px !important;
        }
    }
</style>
@endpush
