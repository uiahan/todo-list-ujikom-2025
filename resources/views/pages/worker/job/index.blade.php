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
                    <div class="d-flex justify-content-between">
                        <h4>My Job</h4>
                        <button class="btn bg-brown text-white" data-bs-toggle="modal" data-bs-target="#addJobModal"><i
                            class="fa-regular fa-plus me-1"></i> Add New Job</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="card w-100 mb-3 mt-3 border-0 shadow text-white" style="background-color: #3D0A05;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="ratio ratio-4x3 h-100 rounded-start overflow-hidden">
                                        <img src="{{ asset('images/ujikom.jpg') }}" alt=""
                                            style="object-fit: cover">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title mb-1"><i class="fa-regular fa-clipboard me-1"></i> Ujikom
                                            </h5>
                                            <div class="mb-3">
                                                <span class="badge bg-primary text-white">On Progress</span>
                                            </div>
                                        </div>
                                        <p class="card-text small mb-2">This is a wider card with supporting text below as a
                                            natural lead-in to
                                            additional content. This content is a little bit longer.</p>

                                        <p class="card-text mb-2"><small>📅 <span class="fw-bold">Deadline :</span> 12
                                                September 2025</small></p>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: 45%;" aria-valuenow="45"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <a href="{{ route('quest') }}"
                                            class="btn btn-light text-second d-block fw-bold btn-sm mt-3"
                                            style="font-size: 11px">Start Job</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- add job modal --}}
    <div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addJobModalLabel">Add My Job</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title">Title</label>
                            <input required type="text" class="form-control" name="title">
                        </div>
                        <div class="mt-3">
                            <label for="description">Description</label>
                            <textarea required type="text" class="form-control" name="description"></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="image">Image</label>
                            <input type="file" accept="image/*" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="video">Video</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="deadline">Deadline</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="repetition">Repetition</label>
                            <select name="repetition" id="" class="form-control">
                                <option value="none" selected>None</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="moonthly">Moonthly</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Submit</button>
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
