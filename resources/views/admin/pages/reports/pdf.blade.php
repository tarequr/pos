<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 4px; }
        .mb-4 { margin-bottom: 16px; }
        
        .report-header {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        h1 { font-size: 20px; margin: 0; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px 5px;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
        }
        .bg-success { color: #008000; }
        .bg-danger { color: #ff0000; }
        
        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
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

    <table>
        <thead>
            <tr class="text-center">
                <th style="width: 40px;">SL</th>
                <th>Category</th>
                <th>Branch</th>
                <th>Serial No</th>
                <th style="width: 80px;">Status</th>
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
                            <span class="bg-success">Stock In</span>
                        @elseif($product->status == 'stock_out')
                            <span class="bg-danger">Stock Out</span>
                        @else
                            <span>{{ ucfirst($product->status) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $product->stock_in_date ? \Carbon\Carbon::parse($product->stock_in_date)->format('d-m-Y') : '-' }}
                    </td>
                    <td class="text-center">
                        {{ $product->stock_out_date ? \Carbon\Carbon::parse($product->stock_out_date)->format('d-m-Y') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No products found.</td>
                </tr>
            @endforelse
        </tbody>
        @if(count($products) > 0)
            <tfoot>
                <tr class="fw-bold text-center">
                    <td colspan="4" class="text-end">TOTAL PRODUCTS:</td>
                    <td colspan="3">{{ count($products) }} Items</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer text-end">
        Generated on: {{ now()->format('d-m-Y h:i A') }}
    </div>
</body>
</html>
