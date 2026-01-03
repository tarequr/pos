<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        if ($request->ajax()) {
            $query = Product::inStock()->with(['category:id,name', 'branch:id,name']);

            // Filtering
            if ($request->category_id) {
                $query->where('products.category_id', $request->category_id);
            }
            if ($request->branch_id) {
                $query->where('products.branch_id', $request->branch_id);
            }

            // Searching
            if ($request->search['value']) {
                $searchValue = $request->search['value'];
                $query->where(function($q) use ($searchValue) {
                    $q->where('serial_no', 'like', "%{$searchValue}%")
                      ->orWhereHas('category', function($cq) use ($searchValue) {
                          $cq->where('name', 'like', "%{$searchValue}%");
                      })
                      ->orWhereHas('branch', function($bq) use ($searchValue) {
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

            $totalRecords = Product::inStock()->count();
            $filteredRecords = $query->count();

            // Pagination
            $start  = $request->get('start');
            $length = $request->get('length');
            $products = $query->skip($start)->take($length)->get();

            $data = $products->map(function($product, $index) use ($start) {
                return [
                    'checkbox' => '<input type="checkbox" name="product_ids[]" value="' . $product->id . '" class="product-checkbox">',
                    'DT_RowIndex' => $start + $index + 1,
                    'category' => ['name' => $product->category->name ?? 'N/A'],
                    'branch' => ['name' => $product->branch->name ?? 'N/A'],
                    'serial_no' => $product->serial_no,
                    'status' => '<span class="badge bg-success">Stock In</span>',
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
        }

        $categories = Category::where('status', true)->get();
        $branches   = Branch::where('status', true)->get();
        return view('admin.pages.products.index', compact('categories', 'branches'));
    }

    public function bulkStockOut(\Illuminate\Http\Request $request)
    {
        try {
            $ids = $request->product_ids;
            if (empty($ids)) {
                notify()->error('No products selected.', 'Error');
                return back();
            }

            Product::whereIn('id', $ids)->update(['status' => 'stock_out']);

            notify()->success('Selected products marked as Stock Out successfully.', 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            notify()->error('Something went wrong during bulk stock out.', 'Error');
            return back();
        }
    }

    public function stockOutList(\Illuminate\Http\Request $request)
    {
        if ($request->ajax()) {
            $query = Product::stockOut()->with(['category:id,name', 'branch:id,name']);

            // Filtering
            if ($request->category_id) {
                $query->where('products.category_id', $request->category_id);
            }
            if ($request->branch_id) {
                $query->where('products.branch_id', $request->branch_id);
            }

            // Searching
            if ($request->search['value']) {
                $searchValue = $request->search['value'];
                $query->where(function($q) use ($searchValue) {
                    $q->where('serial_no', 'like', "%{$searchValue}%")
                      ->orWhereHas('category', function($cq) use ($searchValue) {
                          $cq->where('name', 'like', "%{$searchValue}%");
                      })
                      ->orWhereHas('branch', function($bq) use ($searchValue) {
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
                } elseif (in_array($columnName, ['serial_no', 'updated_at'])) {
                    $query->orderBy('products.' . $columnName, $columnDirection);
                }
            } else {
                $query->orderBy('products.updated_at', 'desc');
            }

            $totalRecords = Product::stockOut()->count();
            $filteredRecords = $query->count();

            // Pagination
            $start  = $request->get('start');
            $length = $request->get('length');
            $products = $query->skip($start)->take($length)->get();

            $data = $products->map(function($product, $index) use ($start) {
                return [
                    'DT_RowIndex' => $start + $index + 1,
                    'category' => ['name' => $product->category->name ?? 'N/A'],
                    'branch' => ['name' => $product->branch->name ?? 'N/A'],
                    'serial_no' => $product->serial_no,
                    'status' => '<span class="badge bg-danger">Stock Out</span>',
                    'updated_at' => $product->updated_at->format('d/m/Y h:i A'),
                ];
            });

            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
            ]);
        }

        $categories = Category::where('status', true)->get();
        $branches   = Branch::where('status', true)->get();
        return view('admin.pages.products.stock_out', compact('categories', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', true)->get();
        $branches   = Branch::where('status', true)->get();
        return view('admin.pages.products.create', compact('categories', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();

            $commonData = [
                'category_id' => $request->category_id,
                'branch_id'   => $request->branch_id,
                'stock_in_by' => auth()->user()->id,
                'stock_in_date' => now(),
                'status'      => 'stock_in',
            ];

            if ($request->serial_type === 'single') {
                Product::create(array_merge($commonData, [
                    'serial_no' => $request->serial_no,
                ]));
            } elseif ($request->serial_type === 'range') {
                // Range
                $start = (int) $request->serial_start;
                $end   = (int) $request->serial_end;

                for ($i = $start; $i <= $end; $i++) {
                    Product::create(array_merge($commonData, [
                        'serial_no' => (string) $i,
                    ]));
                }
            } elseif ($request->serial_type === 'bulk') {
                // Bulk
                $serials = array_filter($request->bulk_serials);
                foreach ($serials as $serial) {
                    Product::create(array_merge($commonData, [
                        'serial_no' => $serial,
                    ]));
                }
            }

            DB::commit();
            notify()->success('Products entry created successfully.', 'Success');

            return redirect()->route('products.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
                                                                                    // Check for duplicate entry error specifically?
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) { // Duplicate entry
                notify()->error('One or more serial numbers in the range already exist.', 'Error');
                return back()->withInput();
            }
            notify()->error('Something went wrong: ' . $e->getMessage(), 'Error');
            return back()->withInput();
        }
    }

    public function stockOut(Product $product)
    {
        try {
            $product->update([
                'status' => 'stock_out',
                'stock_out_by' => auth()->user()->id,
                'stock_out_date' => now(),
            ]);
            
            notify()->success('Product marked as Stock Out.', 'Success');
            return redirect()->back();

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            notify()->error('Product Stock Out Failed', 'Error');
            return back();
        }
    }
}
