@extends('layouts.page')
@section('title', 'My Job')
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
                    <h4>My Job</h4>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="card mb-3 mt-3 border-0 shadow" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="ratio ratio-4x3 h-100 rounded-start overflow-hidden">
                                        <iframe width="560" height="315"
                                            src="https://www.youtube.com/embed/LY6LDB2VWGc?si=mLOCITliNukCjRcR"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Ujikom</h5>
                                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                            additional content. This content is a little bit longer.</p>
                                        <p class="card-text"><small class="text-body-secondary">Deadline : 12 september 2025</small></p>
                                        <a href="{{ route('quest') }}" class="btn bg-brown text-white d-block btn-sm">Start Job</a>
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
        // js
    </script>
@endpush
