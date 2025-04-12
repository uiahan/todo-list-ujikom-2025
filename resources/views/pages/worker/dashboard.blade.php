@extends('layouts.page')
@section('title', 'Dashboard')
@push('css')
    <style>
        /* css */
    </style>
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
                        <div class="card p-3 border-0 shadow-lg text-white bg-brown">
                            <h3>Total Job : </h3>
                            <h1><i class="fa-light fa-briefcase me-2"></i> 1</h1>
                        </div>
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
