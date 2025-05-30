@extends('layouts.page')
@section('title', 'Register')
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

        .col-4, .card {
            backdrop-filter: blur(16px);
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid px-0 d-none d-xl-block">
        <div class="login text-white">
            <div class="row">
                <div class="col-4 shadow-lg vh-100 p-5 d-flex flex-column justify-content-center">
                    <h2 class="text-center"><i class="fa-light fa-calendar-lines"></i> Todo List</h2>
                    <small class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus perspiciatis
                        quam ut unde laudantium officiis?</small>
                        <form action="{{ route('register') }}" method="POST" class="mt-5">
                            @csrf
                            <div>
                                <label for="name"><i class="fa-light fa-user"></i> Full Name</label>
                                <input type="text" class="form-control bg-transparent text-white" name="name" required>
                            </div>
                        
                            <div class="mt-3">
                                <label for="username"><i class="fa-light fa-at"></i> Username</label>
                                <input type="text" class="form-control bg-transparent text-white" name="username" required>
                            </div>
                        
                            <div class="mt-3">
                                <label for="phone_number"><i class="fa-light fa-phone"></i> Phone Number</label>
                                <input type="text" class="form-control bg-transparent text-white" name="phone_number" required>
                            </div>
                        
                            <div class="mt-3">
                                <label for="password"><i class="fa-light fa-lock"></i> Password</label>
                                <input type="password" class="form-control bg-transparent text-white" name="password" required>
                            </div>
                        
                            <div class="mt-3">
                                <label for="password_confirmation"><i class="fa-light fa-lock"></i> Confirm Password</label>
                                <input type="password" class="form-control bg-transparent text-white" name="password_confirmation" required>
                            </div>
                            <div class="mt-4">
                                <button class="btn text-white w-100 bg-brown" type="submit">Register</button>
                                <div class="mt-2">
                                    <small>Already have an account? <a href="{{ route('index') }}" class="text-white">Login now</a></small>
                                </div>
                            </div>
                        </form>
                        
                </div>
                <div class="col-8">

                </div>
            </div>
        </div>
    </div>

    <div class="login d-block d-xl-none d-flex justify-content-center px-4 align-items-center" style="height: 100vh;">
        <div class="card bg-transparent text-white px-3 py-5">
            <h2 class="text-center"><i class="fa-light fa-calendar-lines"></i> Todo List</h2>
            <small class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus perspiciatis
                quam ut unde laudantium officiis?</small>
                <form action="{{ route('register') }}" method="POST" class="mt-5">
                    @csrf
                    <div>
                        <label for="name"><i class="fa-light fa-user"></i> Full Name</label>
                        <input type="text" class="form-control bg-transparent text-white" name="name" required>
                    </div>
                
                    <div class="mt-3">
                        <label for="username"><i class="fa-light fa-at"></i> Username</label>
                        <input type="text" class="form-control bg-transparent text-white" name="username" required>
                    </div>
                
                    <div class="mt-3">
                        <label for="phone_number"><i class="fa-light fa-phone"></i> Phone Number</label>
                        <input type="text" class="form-control bg-transparent text-white" name="phone_number" required>
                    </div>
                
                    <div class="mt-3">
                        <label for="password"><i class="fa-light fa-lock"></i> Password</label>
                        <input type="password" class="form-control bg-transparent text-white" name="password" required>
                    </div>
                
                    <div class="mt-3">
                        <label for="password_confirmation"><i class="fa-light fa-lock"></i> Confirm Password</label>
                        <input type="password" class="form-control bg-transparent text-white" name="password_confirmation" required>
                    </div>
                    <div class="mt-4">
                        <button class="btn text-white w-100 bg-brown" type="submit">Register</button>
                        <div class="mt-2">
                            <small>Already have an account? <a href="{{ route('index') }}" class="text-white">Login now</a></small>
                        </div>
                    </div>
                </form>
        </div>
    </div>
    @include('components.notification')
@endsection
@push('js')
    <script>
        // js
    </script>
@endpush
