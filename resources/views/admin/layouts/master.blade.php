<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="{{ route('dashboard') }}" />

    <title>{{ config('app.name', 'Dashboard') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">

    <link class="js-stylesheet" href="{{ asset('admin/css/light.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />

    <style>
        .dropify-message p {
            font-size: 16px;
        }
    </style>

    <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">

    @stack('css')
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">

        @include('admin.partials.sidebar')

        <div class="main">
            @include('admin.partials.navbar')

            <main class="content">
                @yield('content')
            </main>

            @include('admin.partials.footer')
        </div>
    </div>

    <script src="{{ asset('admin/js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
    <script src="{{ asset('js/iziToast.js') }}"></script>
    @include('vendor.lara-izitoast.toast')
    @stack('js')
</body>

</html>
