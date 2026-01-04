<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['total_products']    = \App\Models\Product::count();
        $data['stock_in_products']  = \App\Models\Product::inStock()->count();
        $data['stock_out_products'] = \App\Models\Product::stockOut()->count();
        $data['total_users']       = \App\Models\User::count();
        $data['total_categories']  = \App\Models\Category::count();
        $data['total_branches']    = \App\Models\Branch::count();

        // Today's counts
        $today = date('Y-m-d');
        $data['today_stock_in']           = \App\Models\Product::where('stock_in_date', $today)->count();
        $data['today_stock_out']          = \App\Models\Product::where('stock_out_date', $today)->count();
        $data['today_category_stock_in']  = \App\Models\Product::where('stock_in_date', $today)->distinct('category_id')->count('category_id');
        $data['today_category_stock_out'] = \App\Models\Product::where('stock_out_date', $today)->distinct('category_id')->count('category_id');
        $data['today_branch_stock_in']    = \App\Models\Product::where('stock_in_date', $today)->distinct('branch_id')->count('branch_id');
        $data['today_branch_stock_out']   = \App\Models\Product::where('stock_out_date', $today)->distinct('branch_id')->count('branch_id');

        $data['latest_products']   = \App\Models\Product::with(['category', 'branch'])->latest()->limit(5)->get();

        return view('admin.pages.dashboard', $data);
    }
}
