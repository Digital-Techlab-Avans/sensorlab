<!doctype html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- All stylesheets --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.4.4/css/tempus-dominus.min.css"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{asset('css/cart-badge.css')}}">
    <link rel="stylesheet" href="{{asset('css/alert-toast.css')}}">

    {{--    All scripts--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/datetimepicker-flatpickr.js') }}" defer></script>
    <script src="/dataTableConfig.js"></script>

    @yield('stylesheets')
    <title>Leensysteem</title>
    @laravelPWA

</head>

<body>
    <div class="page-wrapper">
        <header>
            @include('shared.navbar')
        </header>
        <div class="wrapper">
            @if (session('session_id'))
                @yield('content')
            @endif
        </div>
    </div>
    <footer>
        @include('shared.footer')
    </footer>
</body>
<script src="/app.js"></script>

</html>
