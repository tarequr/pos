<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = \App\Models\Branch::latest()->paginate(10);
        return view('admin.pages.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\StoreBranchRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name);
        try {
        \App\Models\Branch::create($data);

        notify()->success('Branch created successfully.', 'Success');
        return redirect()->route('branches.index');

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            notify()->error('Branch Create Failed', 'Error');
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
    public function edit(\App\Models\Branch $branch)
    {
        return view('admin.pages.branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\UpdateBranchRequest $request, \App\Models\Branch $branch)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name);
        try {
        $branch->update($data);

        notify()->success('Branch updated successfully.', 'Success');
        return redirect()->route('branches.index');

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            notify()->error('Branch Update Failed', 'Error');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Branch $branch)
    {
        try {
        $branch->delete();

        notify()->success('Branch deleted successfully.', 'Success');
        return redirect()->route('branches.index');

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            notify()->error('Branch Delete Failed', 'Error');
            return back();
        }
    }
}
