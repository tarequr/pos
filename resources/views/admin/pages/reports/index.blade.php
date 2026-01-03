@extends('admin.layouts.master')

@section('content')
<div class="container-fluid p-0">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filters</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.index') }}" method="GET">
                        <input type="hidden" name="generate" value="1">
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

    @if($showReport)
    <div class="row">
        <div class="col-12 text-end mb-2 d-print-none">
            @if(count($products) > 0)
                <button onclick="window.print()" class="btn btn-info btn-sm">
                    <i class="align-middle" data-feather="printer"></i> Print Report
                </button>
            @endif
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div id="print-area">
                        <div class="report-header text-center mb-4">
                            <h1 class="fw-bold mb-1">Product Report</h1>
                            <p class="mb-1">
                                <strong>Category:</strong> {{ $filterSummary['category'] }} ||
                                <strong>Branch:</strong> {{ $filterSummary['branch'] }}
                            </p>
                            <p>
                                <strong>Status:</strong> {{ $filterSummary['status'] }} ||
                                <strong>Date Range:</strong> {{ $filterSummary['date_range'] }}
                            </p>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered report-table mb-0" style="width:100%">
                                <thead>
                                    <tr class="text-center">
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
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ $product->branch->name }}</td>
                                            <td>{{ $product->serial_no }}</td>
                                            <td class="text-center">
                                                @if($product->status == 'stock_in')
                                                    <span class="badge bg-success px-2">Stock In</span>
                                                @elseif($product->status == 'stock_out')
                                                    <span class="badge bg-danger px-2">Stock Out</span>
                                                @else
                                                    <span class="badge bg-warning text-dark px-2">{{ ucfirst($product->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $product->stock_in_date ? \Carbon\Carbon::parse($product->stock_in_date)->format('d-m-Y') : '-' }}</td>
                                            <td class="text-center">{{ $product->stock_out_date ? \Carbon\Carbon::parse($product->stock_out_date)->format('d-m-Y') : '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No products found for the selected criteria.</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                                @if(count($products) > 0)
                                    <tfoot class="table-light fw-bold">
                                        <tr>
                                            <td colspan="4" class="text-end">TOTAL PRODUCTS:</td>
                                            <td colspan="3" class="text-center">{{ count($products) }} Items</td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('js')
<script>
    // DataTable removed for 'simple table' requirement
</script>
@endpush

@push('css')
<style>
    .report-table th, .report-table td {
        vertical-align: middle;
    }
    .report-table thead th {
        background-color: #f8f9fa !important;
        color: #333 !important;
        font-weight: 600;
        text-transform: capitalize;
    }
    .report-table tfoot th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    @media print {
        @page {
            size: A4;
            margin: 1.5cm; /* Slightly larger margins for safety */
        }
        .sidebar, .navbar, .card-header, .card-body form, .footer, .btn-group, .d-print-none {
            display: none !important;
        }
        .main {
            padding: 0 !important;
            margin: 0 !important;
            background: white !important;
        }
        #print-area {
            padding-bottom: 50px !important; /* Forces a safe gap at the bottom */
        }
        .container-fluid {
            padding: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .card-body {
            padding: 0 !important;
        }
        .report-table {
            border: 1px solid #111 !important;
        }
        .report-table th, .report-table td {
            border: 1px solid #000 !important;
            padding: 8px 5px !important;
            font-size: 12px;
            color: #000 !important;
        }
        .report-table tfoot {
            display: table-row-group; /* Treats footer as body rows to prevent repeating and fix pagination */
        }
        .report-table tfoot tr td {
            background-color: #f2f2f2 !important;
            border: 2px solid #000 !important;
            border-bottom: 3px solid #000 !important;
            font-weight: 800 !important;
            font-size: 14px !important;
            color: #000 !important;
            padding: 10px 5px !important;
        }
        .report-table thead {
            display: table-row-group; /* Prevents header from repeating on every page */
        }
        .report-table thead th {
            border: 2px solid #000 !important;
            background-color: #eee !important;
            font-weight: bold !important;
        }
        .report-table {
            border-collapse: collapse !important;
            width: 100% !important;
        }
        /* Clean up badges for print */
        .badge {
            border: none !important;
            padding: 0 !important;
            color: #000 !important;
            background: transparent !important;
            font-weight: normal;
        }
        h1 {
            font-size: 24px;
        }
    }
</style>
@endpush
