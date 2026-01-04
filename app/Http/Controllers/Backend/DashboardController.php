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
    public function index(\Illuminate\Http\Request $request)
    {
        if ($request->ajax()) {
            $tableType = $request->get('table_type', 'products');

            if ($tableType === 'products') {
                $query = \App\Models\Product::inStock()->with(['category:id,name', 'branch:id,name']);

                // Searching
                if ($request->search['value']) {
                    $searchValue = $request->search['value'];
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('serial_no', 'like', "%{$searchValue}%")
                            ->orWhereHas('category', function ($cq) use ($searchValue) {
                                $cq->where('name', 'like', "%{$searchValue}%");
                            })
                            ->orWhereHas('branch', function ($bq) use ($searchValue) {
                                $bq->where('name', 'like', "%{$searchValue}%");
                            });
                    });
                }

                // Ordering
                if ($request->has('order')) {
                    $columnIndex = $request->order[0]['column'];
                    $columnName = $request->columns[$columnIndex]['data'];
                    $columnDirection = $request->order[0]['dir'];

                    if ($columnName === 'category.name') {
                        $query->join('categories', 'products.category_id', '=', 'categories.id')
                            ->orderBy('categories.name', $columnDirection)
                            ->select('products.*');
                    } elseif ($columnName === 'branch.name') {
                        $query->join('branches', 'products.branch_id', '=', 'branches.id')
                            ->orderBy('branches.name', $columnDirection)
                            ->select('products.*');
                    } elseif (in_array($columnName, ['serial_no', 'status'])) {
                        $query->orderBy('products.' . $columnName, $columnDirection);
                    }
                } else {
                    $query->orderBy('products.id', 'desc');
                }

                $totalRecords = \App\Models\Product::inStock()->count();
                $filteredRecords = $query->count();

                // Pagination
                $start  = $request->get('start');
                $length = $request->get('length');
                $products = $query->skip($start)->take($length)->get();

                $data = $products->map(function ($product, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'category' => ['name' => $product->category->name ?? 'N/A'],
                        'branch' => ['name' => $product->branch->name ?? 'N/A'],
                        'serial_no' => $product->serial_no,
                        'status' => $product->status === 'stock_in'
                            ? '<span class="badge bg-success">In Stock</span>'
                            : '<span class="badge bg-danger">Stock Out</span>',
                        'action' => '
                        <form action="' . route('products.stock-out', $product->id) . '" method="POST" class="d-inline-block" onsubmit="return confirm(\'Are you sure you want to mark this item as sold?\');">
                            ' . csrf_field() . '
                            <button type="submit" class="btn btn-sm btn-warning">Stock Out</button>
                        </form>
                    '
                    ];
                });

                return response()->json([
                    'draw' => intval($request->draw),
                    'recordsTotal' => $totalRecords,
                    'recordsFiltered' => $filteredRecords,
                    'data' => $data,
                ]);
            } elseif ($tableType === 'categories') {
                $query = \App\Models\Category::withCount([
                    'products as stock_in_count' => function ($q) {
                        $q->where('status', 'stock_in');
                    },
                    'products as stock_out_count' => function ($q) {
                        $q->where('status', 'stock_out');
                    }
                ]);

                if ($request->search['value']) {
                    $searchValue = $request->search['value'];
                    $query->where('name', 'like', "%{$searchValue}%");
                }

                $totalRecords = \App\Models\Category::count();
                $filteredRecords = $query->count();

                $start  = $request->get('start');
                $length = $request->get('length');
                $categories = $query->skip($start)->take($length)->get();

                $data = $categories->map(function ($category, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'name' => $category->name,
                        'stock_in' => '<span class="badge bg-success">' . $category->stock_in_count . '</span>',
                        'stock_out' => '<span class="badge bg-danger">' . $category->stock_out_count . '</span>',
                    ];
                });

                return response()->json([
                    'draw' => intval($request->draw),
                    'recordsTotal' => $totalRecords,
                    'recordsFiltered' => $filteredRecords,
                    'data' => $data,
                ]);
            } elseif ($tableType === 'branches') {
                $query = \App\Models\Branch::withCount([
                    'products as stock_in_count' => function ($q) {
                        $q->where('status', 'stock_in');
                    },
                    'products as stock_out_count' => function ($q) {
                        $q->where('status', 'stock_out');
                    }
                ]);

                if ($request->search['value']) {
                    $searchValue = $request->search['value'];
                    $query->where('name', 'like', "%{$searchValue}%");
                }

                $totalRecords = \App\Models\Branch::count();
                $filteredRecords = $query->count();

                $start  = $request->get('start');
                $length = $request->get('length');
                $branches = $query->skip($start)->take($length)->get();

                $data = $branches->map(function ($branch, $index) use ($start) {
                    return [
                        'DT_RowIndex' => $start + $index + 1,
                        'name' => $branch->name,
                        'stock_in' => '<span class="badge bg-success">' . $branch->stock_in_count . '</span>',
                        'stock_out' => '<span class="badge bg-danger">' . $branch->stock_out_count . '</span>',
                    ];
                });

                return response()->json([
                    'draw' => intval($request->draw),
                    'recordsTotal' => $totalRecords,
                    'recordsFiltered' => $filteredRecords,
                    'data' => $data,
                ]);
            }
        }

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

        return view('admin.pages.dashboard', $data);
    }
}
