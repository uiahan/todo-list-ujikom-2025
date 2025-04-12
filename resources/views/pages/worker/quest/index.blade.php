@extends('layouts.page')
@section('title', 'Quest List')
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
                    <h4>Ujikom Quest List</h4>
                </div>

                <div class="row text-second mt-3">
                    <div class="col-3">
                        <div class="card p-3 border-0 shadow" style="min-height: 50vh">
                            <h4 class="text-center"><i class="fa-regular fa-clock"></i> Pending</h4>
                            <div style="background-color: #3D0A05; height: 2px;" class="mt-2"></div>
                            <div class="card border-brown p-2" style="margin-top: 1rem">
                                <div class="d-flex justify-content-between">
                                    <h6>Membuat rancangan web</h6>
                                    <div>
                                        <button data-bs-tooggle="tooltip" class="btn btn-sm bg-brown text-white"
                                            data-bs-title="Start"><i class="fa-solid fa-check"></i></button>
                                        <button data-bs-tooggle="tooltip" class="btn btn-sm bg-brown text-white"
                                            data-bs-title="Detail"><i class="fa-solid fa-bars"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card p-3 border-0 shadow" style="min-height: 50vh">
                            <h4 class="text-center"><i class="fa-regular fa-play"></i> In Progress</h4>
                            <div style="background-color: #3D0A05; height: 2px;" class="mt-2"></div>
                            <div class="card border-brown p-2" style="margin-top: 1rem">
                                <div class="d-flex justify-content-between">
                                    <h6>Membuat rancangan web</h6>
                                    <div>
                                        <button data-bs-tooggle="tooltip" class="btn btn-sm bg-brown text-white"
                                            data-bs-title="Cancel"><i class="fa-solid fa-xmark"></i></button>
                                        <button data-bs-tooggle="tooltip" class="btn btn-sm bg-brown text-white"
                                            data-bs-title="Done"><i class="fa-solid fa-check"></i></button>
                                        <button data-bs-tooggle="tooltip" class="btn btn-sm bg-brown text-white"
                                            data-bs-title="Detail"><i class="fa-solid fa-bars"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card p-3 border-0 shadow" style="min-height: 50vh">
                            <h4 class="text-center"><i class="fa-regular fa-eye"></i> In Review</h4>
                            <div style="background-color: #3D0A05; height: 2px;" class="mt-2"></div>
                            <div class="card border-brown p-2" style="margin-top: 1rem">
                                <div class="d-flex justify-content-between">
                                    <h6>Membuat rancangan web</h6>
                                    <div>
                                        <button data-bs-tooggle="tooltip" class="btn btn-sm bg-brown text-white"
                                            data-bs-title="Cancel"><i class="fa-solid fa-xmark"></i></button>
                                        <button data-bs-tooggle="tooltip" class="btn btn-sm bg-brown text-white"
                                            data-bs-title="Detail"><i class="fa-solid fa-bars"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card p-3 border-0 shadow" style="min-height: 50vh">
                            <h4 class="text-center"><i class="fa-solid fa-check"></i> Done</h4>
                            <div style="background-color: #3D0A05; height: 2px;" class="mt-2"></div>
                            <div class="card border-brown p-2" style="margin-top: 1rem">
                                <div class="d-flex justify-content-between">
                                    <h6>Membuat rancangan web</h6>
                                    <div>
                                        <button data-bs-tooggle="tooltip" class="btn btn-sm bg-brown text-white"
                                            data-bs-title="Detail"><i class="fa-solid fa-bars"></i></button>
                                    </div>
                                </div>
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
        document.querySelectorAll('[data-bs-title]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    </script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endpush
