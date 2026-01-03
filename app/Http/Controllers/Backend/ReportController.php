<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->orderBy('name')->get();
        $branches = Branch::where('status', 1)->orderBy('name')->get();

        $query = Product::with(['category', 'branch']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('stock_in_date', [$startDate, $endDate])
                  ->orWhereBetween('stock_out_date', [$startDate, $endDate]);
            });
        } elseif ($request->filled('start_date')) {
            $startDate = $request->start_date;
            $query->where(function ($q) use ($startDate) {
                $q->where('stock_in_date', '>=', $startDate)
                  ->orWhere('stock_out_date', '>=', $startDate);
            });
        } elseif ($request->filled('end_date')) {
            $endDate = $request->end_date;
            $query->where(function ($q) use ($endDate) {
                $q->where('stock_in_date', '<=', $endDate)
                  ->orWhere('stock_out_date', '<=', $endDate);
            });
        }

        $products = $query->latest()->get();

        return view('admin.pages.reports.index', compact('categories', 'branches', 'products'));
    }
}
