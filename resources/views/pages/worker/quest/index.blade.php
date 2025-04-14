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

                <div class="text-second border-left-brown card px-3 pt-3 pb-3 border-0 shadow-lg mt-4">
                    <div class="d-flex justify-content-between">
                        <h4 class="mt-1">Job Title : {{ $task->title }}</h4>
                        <button class="btn bg-brown text-white" data-bs-toggle="modal" data-bs-target="#questModal"><i
                                class="fa-regular fa-plus me-1"></i> Add Quest</button>
                    </div>
                </div>

                <div class="row text-second mt-3">
                    <div class="col-7">
                        <div class="card text-white border-0 shadow p-3"
                            style="min-height: 408px; background-color: #3D0A05;">
                            <div class="d-flex justify-content-between">
                                <h4>Job Detail</h4>
                                <div class="mb-3">
                                    <span class="badge bg-primary text-white">On Progress</span>
                                </div>
                            </div>
                            <div style="background-color: #fff; height: 1px;" class="mt-2 mb-3"></div>
                            <div>
                                <label for="" class="fw-semibold"><i class="fa-regular fa-user me-1"></i> Assigned
                                    to</label>
                                <p class="mb-3">
                                    <small>
                                        {{ $user->name }}
                                    </small>
                                </p>
                            </div>
                            <div class="mt-2">
                                <label for="" class="fw-semibold"><i class="fa-regular fa-calendar me-1"></i>
                                    Deadline</label>
                                <p class="mb-3">
                                    <small>
                                        {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : 'Tidak ada deadline' }}
                                    </small>
                                </p>
                            </div>
                            <div class="mt-2">
                                <label for="" class="fw-semibold"><i class="fa-regular fa-file-lines me-1"></i>
                                    Description</label>
                                <p class="mb-3 text-sm">
                                    <small>
                                        {{ Str::limit($task->description, 80, '...') }}
                                    </small>
                                </p>
                            </div>
                            <div class="mb-3 mt-auto">
                                <label for="jobProgress" class="form-label"><i class="fa-regular fa-bars-progress me-1"></i>
                                    Progress</label>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%;"
                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="col-5">
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
                    <div class="col-3">
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
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>

                                                    <button data-bs-toggle="modal" data-bs-target="#detailQuestModal"
                                                        class="btn btn-sm bg-brown text-white" data-bs-title="Detail"><i
                                                            class="fa-solid fa-bars"></i></button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card p-3 border-0 shadow text-white"
                            style="min-height: 50vh; background-color: #3D0A05;">
                            <h4 class="text-center"><i class="fa-regular fa-play"></i> In Progress</h4>
                            <div style="background-color: #fff; height: 2px;" class="mt-2"></div>

                            @foreach ($inProgress as $item)
                                <div class="card border-brown p-2" style="margin-top: 1rem">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="text-second">{{ $item->title }}</h6>
                                        <div>
                                            <form action="{{ route('quest.cancel') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="subtask_id" value="{{ $item->id }}">
                                                <input type="hidden" name="worker_id" value="{{ auth()->id() }}">
                                                <button type="submit" class="btn btn-sm bg-brown text-white"
                                                    data-bs-toggle="tooltip" data-bs-title="Cancel">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </form>

                                            <button data-bs-toggle="modal" data-subtask-id="{{ $item->id }}"
                                                data-worker-id="{{ auth()->id() }}" data-bs-target="#uploadPhotoModal"
                                                class="btn btn-sm bg-brown text-white" data-bs-title="Done">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                            <button data-bs-toggle="modal" data-bs-target="#detailQuestModal"
                                                class="btn btn-sm bg-brown text-white" data-bs-title="Detail">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="col-3">
                        <div class="card p-3 border-0 shadow" style="min-height: 50vh">
                            <h4 class="text-center"><i class="fa-regular fa-eye"></i> In Review</h4>
                            <div style="background-color: #3D0A05; height: 2px;" class="mt-2"></div>
                            @foreach ($inReview as $item)
                                <div class="card border-brown p-2" style="margin-top: 1rem">
                                    <div class="d-flex justify-content-between">
                                        <h6>{{ $item->title }}</h6>
                                        <div>
                                            @if ($item->subtaskWorker && $item->subtaskWorker->image)
                                                <img src="{{ asset('storage/' . $item->subtaskWorker->image) }}"
                                                    alt="Photo" width="100" height="100">
                                            @endif
                                            <button data-bs-toggle="tooltip" class="btn btn-sm bg-brown text-white"
                                                data-bs-title="Cancel">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                            <button data-bs-toggle="modal" data-bs-target="#detailQuestModal"
                                                class="btn btn-sm bg-brown text-white" data-bs-title="Detail">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="card p-3 border-0 shadow text-white"
                            style="min-height: 50vh; background-color: #3D0A05;">
                            <h4 class="text-center"><i class="fa-solid fa-check"></i> Done</h4>
                            <div style="background-color: #fff; height: 2px;" class="mt-2"></div>

                            @forelse ($done as $item)
                                <div class="card border-brown p-2" style="margin-top: 1rem">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="text-second">{{ $item->title }}</h6>
                                        <div>
                                            <button data-bs-toggle="modal" data-bs-target="#detailQuestModal"
                                                class="btn btn-sm bg-brown text-white" data-bs-title="Detail">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-white mt-3">Belum ada tugas yang selesai 😴</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- detail quest modal --}}
    <div class="modal fade" id="detailQuestModal" tabindex="-1" aria-labelledby="detailQuestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailQuestModalLabel">Detail Quest</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <img src="{{ asset('images/ujikom.jpg') }}" class="img-fluid" alt="">
                    </div>
                    <div>
                        <h4 class="mt-3">Membuat rancangan web</h4>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequuntur ullam accusantium fuga
                            voluptas. Itaque, maiores! Unde excepturi architecto odit ea libero placeat, cumque, blanditiis,
                            quos laudantium iusto corrupti nam dolor?</p>
                    </div>
                </div>
                <div class="modal-footer">

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
                    <form action="{{ route('quest.updateToReview') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="subtask_id" id="modal-subtask-id">
                        <input type="hidden" name="worker_id" id="modal-worker-id">

                        <label for="description">Upload Foto Bukti</label>
                        <input type="file" class="form-control" name="photo" required>

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    {{-- quest modal --}}
    <div class="modal fade" id="questModal" tabindex="-1" aria-labelledby="questModalLabel" aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="questModalLabel">Ujikom</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="mb-1">Add Quest</label>
                        <div class="input-group">
                            <input type="text" name="title" class="form-control" required>
                            <button type="submit" class="btn bg-brown text-white">
                                <i class="fa-regular fa-plus"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="pt-2 px-3 pb-3">
                    <h1 class="modal-title fs-5 mb-1">Quest List</h1>
                    <div class="card ps-3 pe-2 pt-2 pb-2">
                        <div class="d-flex justify-content-between">
                            <h6 class="mt-1">1. Rancangan ERD</h6>
                            <div>
                                <a href="" class="btn bg-brown text-white"><i class="fa-regular fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card ps-3 pe-2 pt-2 pb-2 mt-2">
                        <div class="d-flex justify-content-between">
                            <h6 class="mt-1">2. Dokumentsi</h6>
                            <div>
                                <a href="" class="btn bg-brown text-white"><i class="fa-regular fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card ps-3 pe-2 pt-2 pb-2 mt-2">
                        <div class="d-flex justify-content-between">
                            <h6 class="mt-1">3. Design web</h6>
                            <div>
                                <a href="" class="btn bg-brown text-white"><i class="fa-regular fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card ps-3 pe-2 pt-2 pb-2 mt-2">
                        <div class="d-flex justify-content-between">
                            <h6 class="mt-1">4. Membuat web todo list</h6>
                            <div>
                                <a href="" class="btn bg-brown text-white"><i class="fa-regular fa-trash"></i></a>
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
@endpush
