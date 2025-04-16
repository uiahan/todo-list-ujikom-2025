@extends('layouts.page')
@section('title', 'Private Quest List')
@push('css')
    <style>
        @media(min-width: 1200px) {
            .wrap {
                padding-left: 270px;
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

                <div class="text-second border-left-brown card px-3 pt-3 pb-3 border-0 shadow-lg mt-4">
                    <div class="d-flex justify-content-between">
                        <h4 class="mt-1">Job Title : {{ $task->title }}</h4>

                    </div>
                </div>

                <div class="row text-second mt-3">
                    <div class="col-xl-7 col-12">
                        <div class="card text-white border-0 shadow p-3"
                            style="min-height: 408px; background-color: #3D0A05;">
                            <div class="d-flex justify-content-between">
                                <h4>Job Detail</h4>
                            </div>
                            <div style="background-color: #fff; height: 1px;" class="mt-2 mb-3"></div>
                            <div>
                                <label for="" class="fw-semibold">😄 Created by
                                    </label>
                                <p class="mb-3">
                                    <small>
                                        {{ $user->name }}
                                    </small>
                                </p>
                            </div>
                            <div class="mt-2">
                                <label for="" class="fw-semibold">🗓️
                                    Estimate Completed</label>
                                <p class="mb-3">
                                    <small>
                                        {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : 'Tidak ada deadline' }}
                                    </small>
                                </p>
                            </div>
                            <div class="mt-2">
                                <label for="" class="fw-semibold">📝
                                    Description</label>
                                <p class="mb-3 text-sm">
                                    <small>
                                        {{ Str::limit($task->description, 80, '...') }}
                                    </small>
                                </p>
                            </div>
                            <div class="mb-3 mt-auto">
                                <label class="form-label mt-auto">✈️ Progress</label>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ round($progress) }}%;" aria-valuenow="{{ round($progress) }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    {{ round($progress) }}%
                                </div>
                            </div>
                            </div>


                        </div>

                    </div>
                    <div class="col-xl-5 col-12 mt-3 mt-xl-0">
                        <div class="card border-0 shadow p-3">
                            <h4>Video Tutorial</h4>
                            <div style="background-color: #3D0A05; height: 1px;" class="mt-2 mb-3"></div>
                            <iframe width="540" height="315" src="{{ $task->video }}" title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>

                <div class="row text-second mt-3">
                    <div class="col-xl-4 col-12">
                        <div class="card p-3 border-0 shadow" style="min-height: 50vh">
                            <h4 class="text-center"><i class="fa-regular fa-clock"></i> Pending</h4>
                            <div style="background-color: #3D0A05; height: 2px;" class="mt-2"></div>
                            @foreach ($subtasks as $item)
                                <div class="card border-brown p-2" style="margin-top: 1rem">
                                    <div class="d-flex justify-content-between">
                                        <h6>{{ $item->title }}</h6>
                                        <div>
                                            <form action="{{ route('quest.progress') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="subtask_id" value="{{ $item->id }}">
                                                <input type="hidden" name="worker_id" value="{{ auth()->id() }}">
                                                <input type="hidden" name="status" value="in_progres">
                                                <div class="d-flex">
                                                    <button type="submit" class="btn btn-sm bg-brown text-white me-1"
                                                        data-bs-title="Start">
                                                        <i class="fa-regular fa-play"></i>
                                                    </button>

                                            </form>
                                            @php
                                                $worker = $item->subtaskWorkers->first(); // ambil salah satu worker, kalau ada
                                            @endphp

                                            <button type="button" class="btn btn-sm bg-brown text-white" data-bs-title="Detail"
                                                data-bs-toggle="modal" data-bs-target="#detailQuestModal"
                                                data-title="{{ $item->title }}"
                                                data-workerdescription="{{ $worker?->description ?? 'Nothing' }}">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-xl-4 col-12 mt-3 mt-xl-0">
                    <div class="card p-3 border-0 shadow text-white" style="min-height: 50vh; background-color: #3D0A05;">
                        <h4 class="text-center"><i class="fa-regular fa-play"></i> In Progress</h4>
                        <div style="background-color: #fff; height: 2px;" class="mt-2"></div>

                        @foreach ($inProgress as $item)
                            <div class="card border-brown p-2" style="margin-top: 1rem">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-second">{{ $item->title }}</h6>
                                    <div class="d-flex">
                                        <form action="{{ route('quest.cancel') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="subtask_id" value="{{ $item->id }}">
                                            <input type="hidden" name="worker_id" value="{{ auth()->id() }}">
                                            <button type="submit" class="btn me-1 btn-sm bg-brown text-white"
                                                data-bs-toggle="tooltip" data-bs-title="Cancel">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('done.quest') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="subtask_id" value="{{ $item->id }}">
                                            <input type="hidden" name="worker_id" value="{{ auth()->id() }}">
                                            <button type="submit" data-bs-title="Done" class="btn me-1 bg-brown text-white btn-sm"><i
                                                    class="fa-solid fa-check"></i></button>
                                        </form>
                                        @php
                                            $worker = $item->subtaskWorkers->first();
                                        @endphp

                                        <button type="button" class="btn btn-sm bg-brown text-white"
                                            data-bs-toggle="modal" data-bs-target="#detailQuestModal" data-bs-title="Detail"
                                            data-title="{{ $item->title }}"
                                            data-workerdescription="{{ $worker?->description ?? 'Nothing' }}">
                                            <i class="fa-solid fa-bars"></i>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-xl-4 col-12 mt-3 mt-xl-0">
                    <div class="card p-3 border-0 shadow text-second" style="min-height: 50vh; background-color: #fff;">
                        <h4 class="text-center"><i class="fa-solid fa-check"></i> Done</h4>
                        <div style="background-color: #3D0A05; height: 2px;" class="mt-2"></div>

                        @forelse ($done as $item)
                            <div class="card border-brown p-2" style="margin-top: 1rem">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-second">{{ $item->title }}</h6>
                                    <div>
                                        @php
                                            $worker = $item->subtaskWorkers->first(); // ambil salah satu worker, kalau ada
                                        @endphp

                                        <button type="button" class="btn btn-sm bg-brown text-white"
                                            data-bs-toggle="modal" data-bs-target="#detailQuestModal"
                                            data-title="{{ $item->title }}" data-bs-title="Detail"
                                            data-workerdescription="{{ $worker?->description ?? 'Nothing' }}" data-bs-title="detail">
                                            <i class="fa-solid fa-bars"></i>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-second mt-3">No tasks completed yet 😴</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

    <!-- Modal Detail Quest -->
    <div class="modal fade" id="detailQuestModal" tabindex="-1" aria-labelledby="detailQuestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailQuestModalLabel">Detail Quest</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tampilkan Judul Quest -->
                    <div>
                        <h6 class="mt-3 text-second"><i class="fa-regular fa-notebook me-1"></i> Title :</h6>
                        <p id="questTitle"></p>
                        <!-- Deskripsi Quest -->
                    </div>
                    <!-- Deskripsi Worker -->
                    <div class="mt-3">
                        <h6 class="mt-3"><i class="fa-regular fa-comment me-1"></i> Comment :</h6>
                        <p id="workerDescription"></p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Upload Photo Modal --}}
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="uploadPhotoModalLabel">Upload Photo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reviewModal = document.getElementById('uploadPhotoModal');

            reviewModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const subtaskId = button.getAttribute('data-subtask-id');
                const workerId = button.getAttribute('data-worker-id');

                // Isi hidden input
                reviewModal.querySelector('#modal-subtask-id').value = subtaskId;
                reviewModal.querySelector('#modal-worker-id').value = workerId;
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const detailQuestModal = document.getElementById('detailQuestModal');

            detailQuestModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // tombol yang mengaktifkan modal
                const title = button.getAttribute('data-title');
                const workerDescription = button.getAttribute('data-workerdescription');

                // Update konten modal dengan data dari tombol
                detailQuestModal.querySelector('#questTitle').textContent = title;
                detailQuestModal.querySelector('#workerDescription').textContent = workerDescription;
            });
        });
    </script>
@endpush
