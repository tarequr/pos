<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Branch;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'branch'])->latest()->paginate(10);
        return view('admin.pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', true)->get();
        $branches = Branch::where('status', true)->get();
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
                'branch_id' => $request->branch_id,
                'name' => $request->name,
                'status' => 'active',
            ];

            if ($request->serial_type === 'single') {
                Product::create(array_merge($commonData, [
                    'serial_no' => $request->serial_no,
                ]));
            } else {
                // Range
                $start = (int) $request->serial_start;
                $end = (int) $request->serial_end;

                for ($i = $start; $i <= $end; $i++) {
                    // Check if serial exists to prevent error inside loop? 
                    // Or catch exception. For now, rely on validation or unique constraint.
                    // Ideally we should bulk insert for performance if range is huge, 
                    // but for reasonable ranges loop is fine and safer for validaton.
                     Product::create(array_merge($commonData, [
                        'serial_no' => (string) $i,
                    ]));
                }
            }

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Products entry created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Check for duplicate entry error specifically?
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) { // Duplicate entry
                 return back()->withInput()->withErrors(['serial_no' => 'One or more serial numbers in the range already exist.']);
            }
            return back()->withInput()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    public function stockOut(Product $product)
    {
        $product->update(['status' => 'sold']);
        return redirect()->back()->with('success', 'Product marked as sold.');
    }
}
