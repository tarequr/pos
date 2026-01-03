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
        $showReport = false;

        $filterSummary = [
            'category' => 'All',
            'branch' => 'All',
            'status' => 'All',
            'date_range' => 'All'
        ];

        // Check if generate flag is present (only show report if button was clicked)
        if ($request->filled('generate')) {
            $showReport = true;

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
                $filterSummary['category'] = Category::find($request->category_id)->name ?? 'All';
            }

            if ($request->filled('branch_id')) {
                $query->where('branch_id', $request->branch_id);
                $filterSummary['branch'] = Branch::find($request->branch_id)->name ?? 'All';
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
                $filterSummary['status'] = ucfirst(str_replace('_', ' ', $request->status));
            }

            if ($request->filled('start_date') || $request->filled('end_date')) {
                $startDate = $request->start_date;
                $endDate = $request->end_date;

                if ($startDate && $endDate) {
                    $filterSummary['date_range'] = $startDate . ' to ' . $endDate;
                    $query->where(function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('stock_in_date', [$startDate, $endDate])
                          ->orWhereBetween('stock_out_date', [$startDate, $endDate]);
                    });
                } elseif ($startDate) {
                    $filterSummary['date_range'] = 'From ' . $startDate;
                    $query->where(function ($q) use ($startDate) {
                        $q->where('stock_in_date', '>=', $startDate)
                          ->orWhere('stock_out_date', '>=', $startDate);
                    });
                } elseif ($endDate) {
                    $filterSummary['date_range'] = 'Until ' . $endDate;
                    $query->where(function ($q) use ($endDate) {
                        $q->where('stock_in_date', '<=', $endDate)
                          ->orWhere('stock_out_date', '<=', $endDate);
                    });
                }
            }

            $products = $query->latest()->get();
        } else {
            $products = collect();
        }

        return view('admin.pages.reports.index', compact('categories', 'branches', 'products', 'filterSummary', 'showReport'));
    }
}
