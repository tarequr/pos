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
    public function index()
    {
        $products = Product::inStock()->with(['category:id,name', 'branch:id,name'])->orderBy('id', 'asc')->get();
        return view('admin.pages.products.index', compact('products'));
    }

    public function stockOutList()
    {
        $products = Product::stockOut()->with(['category:id,name', 'branch:id,name'])->orderBy('id', 'asc')->get();
        return view('admin.pages.products.stock_out', compact('products'));
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
            $product->update(['status' => 'stock_out']);
            notify()->success('Product marked as Stock Out.', 'Success');
            return redirect()->back();

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            notify()->error('Product Stock Out Failed', 'Error');
            return back();
        }
    }
}
