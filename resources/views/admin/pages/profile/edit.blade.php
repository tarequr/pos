@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid p-0">

        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Profile</h1>
        </div>
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Details</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ !empty($user->avatar) ? asset('storage/' . $user->avatar) : asset('admin/img/avatars/avatar.jpg') }}"
                            alt="{{ $user->name }}" class="img-fluid rounded-circle mb-2" width="128"
                            height="128">
                        <h5 class="card-title mb-0">{{ $user->name }}</h5>
                        <div class="text-muted mb-2">{{ $user->designation ?? 'N/A' }}</div>
                    </div>
                    @if ($user->address || $user->phone)
                        <hr class="my-0">
                        <div class="card-body">
                            <h5 class="h6 card-title">About</h5>
                            <ul class="list-unstyled mb-0">
                                @if ($user->address)
                                    <li class="mb-1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-home feather-sm me-1">
                                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                        </svg> Lives in {{ $user->address }}</li>
                                @endif
                                @if ($user->phone)
                                    <li class="mb-1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-phone feather-sm me-1">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-2.29a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                            </path>
                                        </svg> {{ $user->phone }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8 col-xl-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Profile</h5>
                    </div>
                    <div class="card-body h-100">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $user->name ?? '') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $user->email ?? '') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $user->phone ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address', $user->address ?? '') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="avatar">Avatar</label>
                                @if (!empty($user->avatar))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" width="80"
                                            height="80" class="rounded-circle">
                                    </div>
                                @endif
                                <input type="file" class="form-control dropify" id="avatar" name="avatar"
                                    data-height="120">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="designation">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation"
                                    value="{{ old('designation', $user->designation ?? '') }}">
                            </div>
                            <hr>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
@endpush
