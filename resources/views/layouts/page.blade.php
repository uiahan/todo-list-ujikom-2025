<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo List | @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('bootstraps/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://naramizaru.github.io/fa-pro/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('css')
</head>
<body style="background-color: #f2f2f2">
    @yield('content')
    @include('components.notification')
</body>
<script src="{{ asset('bootstraps/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bootstraps/js/bootstrap.bundle.min.js') }}"></script>

@stack('js')
</html>
