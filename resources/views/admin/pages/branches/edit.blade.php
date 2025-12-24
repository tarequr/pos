@extends('admin.layouts.master')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">Edit Branch</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Branch Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('branches.update', $branch) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $branch->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $branch->slug) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" {{ $branch->status ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$branch->status ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('branches.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
