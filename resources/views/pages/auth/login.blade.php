@extends('layouts.page')
@section('title', 'Login')
@push('css')
    <style>
        .login {
            height: 100vh;
            background-image: url('{{ asset('images/login-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }

        .login .row {
            margin: 0;
            padding: 0;
        }

        .col-4 {
            backdrop-filter: blur(16px);
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid px-0">
        <div class="login text-white">
            <div class="row">
                <div class="col-4 shadow-lg vh-100 p-5 d-flex flex-column justify-content-center">
                    <h2 class="text-center"><i class="fa-light fa-calendar-lines"></i> Todo List</h2>
                    <small class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus perspiciatis
                        quam ut unde laudantium officiis?</small>
                    <form action="{{ route('login') }}" method="POST" class="mt-5">
                        @csrf
                        <div class="">
                            <label for="username"><i class="fa-light fa-user"></i> Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mt-3">
                            <label for="password"><i class="fa-light fa-lock"></i> Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mt-3">
                            <input type="checkbox" class="form-check-input" name="checkbox">
                            <small for="checkbox">Remember me</small>
                        </div>
                        <div class="mt-3">
                            <button class="btn text-white w-100 bg-brown" type="submit">Sign In</button>
                            <div class="mt-2">
                                <small>Belum punya akun? <a href="" class="text-white">daftar sekarang</a></small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-8">

                </div>
            </div>
        </div>
    </div>
    @include('components.notification')
@endsection
@push('js')
    <script>
        // js
    </script>
@endpush
