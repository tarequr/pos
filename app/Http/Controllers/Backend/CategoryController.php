<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = \App\Models\Category::latest()->paginate(10);
        return view('admin.pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name);
        try {
            \App\Models\Category::create($data);

            notify()->success('Category created successfully.', 'Success');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            notify()->error('Category Create Failed', 'Error');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Category $category)
    {
        return view('admin.pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\UpdateCategoryRequest $request, \App\Models\Category $category)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name);
        try {
            $category->update($data);

            notify()->success('Category updated successfully.', 'Success');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            notify()->error('Category Update Failed', 'Error');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Category $category)
    {
        try {
            $category->delete();

            notify()->success('Category deleted successfully.', 'Success');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            notify()->error('Category Delete Failed', 'Error');
            return back();
        }
    }
}
