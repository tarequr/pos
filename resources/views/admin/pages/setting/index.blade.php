@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Settings</h1>

        <div class="row">
            <div class="col-md-3 col-xl-2">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Settings</h5>
                    </div>

                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#general"
                            role="tab" aria-selected="true">
                            General
                        </a>
                        <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#email"
                            role="tab" aria-selected="false" tabindex="-1">
                            Email
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-xl-10">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="general" role="tabpanel">

                        <div class="card">
                            <div class="card-header">

                                <h5 class="card-title mb-0">Public info</h5>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                <form method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="form-label" for="site_title">Site Title</label>
                                                <input type="text" class="form-control" id="site_title" name="site_title"
                                                    value="{{ old('site_title', $setting->site_title ?? '') }}"
                                                    placeholder="Enter site title">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="site_description">Site Description</label>
                                                <textarea rows="2" class="form-control" id="site_description" name="site_description"
                                                    placeholder="Enter site description">{{ old('site_description', $setting->site_description ?? '') }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="site_phone">Site Phone</label>
                                                <input type="text" class="form-control" id="site_phone" name="site_phone"
                                                    value="{{ old('site_phone', $setting->site_phone ?? '') }}"
                                                    placeholder="Enter site phone">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="site_address">Site Address</label>
                                                <input type="text" class="form-control" id="site_address"
                                                    name="site_address"
                                                    value="{{ old('site_address', $setting->site_address ?? '') }}"
                                                    placeholder="Enter site address">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="site_logo">Site Logo</label>
                                                <input type="file" class="form-control dropifyLogo" id="site_logo"
                                                    data-height="120"
                                                    data-default-file="{{ asset('storage/' . $setting->site_logo) }}"
                                                    name="site_logo">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="site_favicon">Favicon</label>
                                                <input type="file" name="site_favicon" id="site_favicon"
                                                    class="form-control dropifyLogo" data-height="120"
                                                    data-default-file="{{ asset('storage/' . $setting->site_favicon) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"
                                        onclick="return confirm('Are you sure you want to save changes?')">Save
                                        changes</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="email" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Email Settings</h5>
                                <form method="POST" action="{{ route('setting.update') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="mail_mailer">Mailer</label>
                                        <input type="text" class="form-control" id="mail_mailer" name="mail_mailer"
                                            value="{{ old('mail_mailer', $setting->mail_mailer ?? '') }}"
                                            placeholder="smtp, sendmail, etc.">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="mail_host">Host</label>
                                        <input type="text" class="form-control" id="mail_host" name="mail_host"
                                            value="{{ old('mail_host', $setting->mail_host ?? '') }}"
                                            placeholder="smtp.example.com">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="mail_port">Port</label>
                                        <input type="text" class="form-control" id="mail_port" name="mail_port"
                                            value="{{ old('mail_port', $setting->mail_port ?? '') }}" placeholder="587">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="mail_username">Username</label>
                                        <input type="text" class="form-control" id="mail_username"
                                            name="mail_username"
                                            value="{{ old('mail_username', $setting->mail_username ?? '') }}"
                                            placeholder="mail username">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="mail_password">Password</label>
                                        <input type="password" class="form-control" id="mail_password"
                                            name="mail_password"
                                            value="{{ old('mail_password', $setting->mail_password ?? '') }}"
                                            placeholder="mail password">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="mail_encryption">Encryption</label>
                                        <input type="text" class="form-control" id="mail_encryption"
                                            name="mail_encryption"
                                            value="{{ old('mail_encryption', $setting->mail_encryption ?? '') }}"
                                            placeholder="tls, ssl, etc.">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="mail_from_address">From Address</label>
                                        <input type="email" class="form-control" id="mail_from_address"
                                            name="mail_from_address"
                                            value="{{ old('mail_from_address', $setting->mail_from_address ?? '') }}"
                                            placeholder="noreply@example.com">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="mail_from_name">From Name</label>
                                        <input type="text" class="form-control" id="mail_from_name"
                                            name="mail_from_name"
                                            value="{{ old('mail_from_name', $setting->mail_from_name ?? '') }}"
                                            placeholder="Mail sender name">
                                    </div>
                                    <button type="submit" class="btn btn-primary"
                                        onclick="return confirm('Are you sure you want to save changes?')">Save Email
                                        Settings</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.dropifyLogo').dropify();
        });
    </script>
@endpush
