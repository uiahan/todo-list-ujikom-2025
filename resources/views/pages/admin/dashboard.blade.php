@extends('layouts.page')
@section('title', 'Dashboard')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
    <div class="d-flex ps-4 py-4">
        @include('components.sidebar')
        <div style="padding-left: 270px" class="w-100">
            <div class="pe-4">
                @include('components.navbar')
                <div class="text-second border-left-brown card px-3 pt-3 pb-2 border-0 shadow-lg mt-4">
                    <h4>Dashboard</h4>
                </div>

                <div class="row mt-3">
                    <div class="col-3">
                        <a href="{{ route('manage.tasker') }}" class="text-decoration-none">
                            <div class="card card-badge p-3 border-0 shadow-lg text-white bk-brown">
                                <h3>Total Tasker : </h3>
                                <h1><i class="fa-light fa-user-tie me-2"></i> {{ $taskerCount }}</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="{{ route('manage.worker') }}" class="text-decoration-none">
                            <div class="card card-badge p-3 border-0 shadow-lg text-white bk-brown">
                                <h3>Total Worker : </h3>
                                <h1><i class="fa-light fa-user-helmet-safety me-2"></i> {{ $workerCount }}</h1>
                            </div>
                        </a>
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
