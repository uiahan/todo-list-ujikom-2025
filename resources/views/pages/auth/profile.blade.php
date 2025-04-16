@extends('layouts.page')
@section('title', 'Profile')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        @media(min-width: 1200px) {
            .wrap {
                padding-left: 270px;
            }

            .image {
                width: 350px;
                height: 350px;
            }
        }

        @media(max-width: 1200px) {
            .card {
                width: 100% !important;
            }
        }
    </style>
@endpush
@section('content')
    <div class="d-flex ps-4 py-4">
        @include('components.sidebar')
        <div class="w-100 wrap">
            <div class="pe-4">
                @include('components.navbar')
                <div class="text-second border-left-brown card px-3 pt-3 pb-2 border-0 shadow-lg mt-4">
                    <h4>Settings</h4>
                </div>

                <div class="d-xl-flex">
                    <div class="card me-4 border-0 shadow p-4 mt-4" style="width: 40%">
                        <h4 class="text-second">😎Photo</h4>
                        <div class="mt-3" style="height: 2px; background-color: #3D0A05;"></div>
                        <div class="d-flex mt-4 justify-content-center align-items-center" style="height: 100%">
                            @if ($user->profile)
                                <img src="{{ asset('storage/' . $user->profile) }}" 
                                     alt="Profile Picture"
                                     class="rounded-3 shadow mb-3 image"
                                     style="object-fit: cover;">
                            @else
                                <img src="{{ asset('images/profile-default.png') }}" 
                                     alt="Default Profile"
                                     class="rounded-3 shadow mb-3 image"
                                     style="object-fit: cover;">
                            @endif
                        </div>
                    </div>
                    <div class="card me-4 border-0 shadow p-4 mt-4" style="width: 30%">
                        <h4 class="text-second">🧸Profile</h4>
                        <div class="mt-3" style="height: 2px; background-color: #3D0A05;"></div>
                        <div class="d-flex flex-column mt-4 align-items-center">
                            {{-- Profile Picture --}}
                            
                            {{-- Profile Form --}}
                            <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data" class="w-100" style="max-width: 600px;">
                                @csrf
                                
                            
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control rounded-3 shadow-sm">
                                </div>
                            
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Username</label>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control rounded-3 shadow-sm">
                                </div>
                            
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="form-control rounded-3 shadow-sm">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Profile Picture</label>
                                    <input type="file" name="profile" class="form-control rounded-3 shadow-sm">
                                </div>
                               
                            
                                <div class="text-center">
                                    <button class="btn bg-brown text-white px-4 py-2 rounded-3 shadow-sm"
                                    style="transition: all 0.3s ease-in-out;"
                                            onmouseover="this.style.opacity='0.85'"
                                            onmouseout="this.style.opacity='1'">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                    <div class="card border-0 shadow p-4 mt-4" style="width: 30%">
                        <h4 class="text-second">🔒Password</h4>
                        <div class="mt-3" style="height: 2px; background-color: #3D0A05;"></div>
                        <form action="{{ route('update.password') }}" class="mt-4" method="POST">
                            @csrf
                    
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Current Password</label>
                                <input type="password" name="current_password" class="form-control rounded-3 shadow-sm">
                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                    
                            <div class="mb-3">
                                <label class="form-label fw-semibold">New Password</label>
                                <input type="password" name="new_password" class="form-control rounded-3 shadow-sm">
                                @error('new_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                    
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control rounded-3 shadow-sm">
                            </div>
                    
                            <div class="text-center">
                                <button type="submit" class="btn bg-brown text-white px-4 py-2 rounded-3 shadow-sm">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        // js
    </script>
@endpush
