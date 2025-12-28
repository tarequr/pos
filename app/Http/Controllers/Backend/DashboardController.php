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
        $data['latest_products']   = \App\Models\Product::with(['category', 'branch'])->latest()->limit(5)->get();

        return view('admin.pages.dashboard', $data);
    }
}
