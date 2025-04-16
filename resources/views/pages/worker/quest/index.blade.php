@extends('layouts.page')
@section('title', 'Quest List')

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

                {{-- Info Job --}}
                <div class="text-second border-left-brown card px-3 pt-3 pb-3 border-0 shadow-lg mt-4">
                    <div class="d-flex justify-content-between">
                        <h4 class="mt-1">Job Title : {{ $task->title }}</h4>
                    </div>
                </div>

                {{-- Detail & Video --}}
                <div class="row text-second mt-3">
                    <div class="col-xl-7 col-12">
                        <div class="card text-white border-0 shadow p-3"
                            style="min-height: 408px; background-color: #3D0A05;">
                            <h4>Job Detail</h4>
                            <div style="background-color: #fff; height: 1px;" class="mt-2 mb-3"></div>

                            <label class="fw-semibold">😄 Assigned to</label>
                            <p><small>{{ $user->name }}</small></p>

                            <label class="fw-semibold">🗓️ Deadline</label>
                            <p><small>{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : 'Tidak ada deadline' }}</small>
                            </p>

                            <label class="fw-semibold">📝 Description</label>
                            <p class="text-sm"><small>{{ Str::limit($task->description, 200, '...') }}</small></p>

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
                    <div class="col-xl-5 col-12 mt-xl-0 mt-3">
                        <div class="card border-0 shadow p-3">
                            <h4>Video Tutorial</h4>
                            <div style="background-color: #3D0A05; height: 1px;" class="mt-2 mb-3"></div>
                            <iframe width="100%" height="315" src="{{ $task->video }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>

                <div class="row text-second mt-3">
                    {{-- Pending --}}
                    <div class="col-xl-3 col-12">
                        <div class="card p-3 border-0 shadow" style="min-height: 50vh">
                            <h4 class="text-center"><i class="fa-regular fa-clock"></i> Pending</h4>
                            <div style="background-color: #3D0A05; height: 2px;" class="mt-2"></div>
                            @foreach ($subtasks as $item)
                                <div class="card border-brown p-2 mt-3">
                                    <div class="d-flex justify-content-between">
                                        <h6>{{ Str::limit($item->title, 20) }}</h6>
                                        <div class="d-flex">
                                            <form action="{{ route('quest.progress') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="subtask_id" value="{{ $item->id }}">
                                                <input type="hidden" name="worker_id" value="{{ auth()->id() }}">
                                                <input type="hidden" name="status" value="in_progres">
                                                <button type="submit" class="btn btn-sm bg-brown text-white me-1"
                                                    data-bs-title="Start">
                                                    <i class="fa-regular fa-play"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm bg-brown text-white"
                                                data-bs-toggle="modal" data-bs-target="#detailQuestModal"
                                                data-bs-title="Detail" data-title="{{ $item->title }}"
                                                data-workerdescription="{{ $item->subtaskWorkers->first()?->description ?? 'Nothing' }}">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- In Progress --}}
                    <div class="col-xl-3 col-12 mt-3 mt-xl-0">
                        <div class="card p-3 border-0 shadow text-white"
                            style="min-height: 50vh; background-color: #3D0A05;">
                            <h4 class="text-center"><i class="fa-regular fa-play"></i> In Progress</h4>
                            <div style="background-color: #fff; height: 2px;" class="mt-2"></div>
                            @foreach ($inProgress as $item)
                                <div class="card border-brown p-2 mt-3">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="text-second">{{ Str::limit($item->title, 20) }}</h6>
                                        <div class="d-flex">
                                            <form action="{{ route('quest.cancel') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="subtask_id" value="{{ $item->id }}">
                                                <input type="hidden" name="worker_id" value="{{ auth()->id() }}">
                                                <button type="submit" class="btn btn-sm bg-brown text-white me-1">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </form>

                                            <button data-bs-toggle="modal" data-bs-target="#uploadPhotoModal"
                                                class="btn btn-sm bg-brown text-white me-1" data-bs-title="Done"
                                                data-subtask-id="{{ $item->id }}"
                                                data-worker-id="{{ auth()->id() }}">
                                                <i class="fa-solid fa-upload"></i>
                                            </button>

                                            <button type="button" class="btn btn-sm bg-brown text-white"
                                                data-bs-toggle="modal" data-bs-target="#detailQuestModal"
                                                data-title="{{ $item->title }}"
                                                data-workerdescription="{{ $item->subtaskWorkers->first()?->description ?? 'Nothing' }}">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- In Review --}}
                    <div class="col-xl-3 col-12 mt-3 mt-xl-0">
                        <div class="card p-3 border-0 shadow" style="min-height: 50vh;">
                            <h4 class="text-center"><i class="fa-regular fa-eye"></i> In Review</h4>
                            <div style="background-color: #3D0A05; height: 2px;" class="mt-2"></div>
                            @foreach ($inReview as $item)
                                <div class="card border-brown p-2 mt-3">
                                    <div class="d-flex justify-content-between">
                                        <h6>{{ Str::limit($item->title, 20) }}</h6>
                                        <div class="d-flex">
                                            @if ($item->subtaskWorker && $item->subtaskWorker->image)
                                                <img src="{{ asset('storage/' . $item->subtaskWorker->image) }}"
                                                    alt="Photo" width="100" height="100" class="me-2">
                                            @endif
                                            <button type="button" class="btn btn-sm bg-brown text-white"
                                                data-bs-toggle="modal" data-bs-target="#detailQuestModal"
                                                data-title="{{ $item->title }}"
                                                data-workerdescription="{{ $item->subtaskWorkers->first()?->description ?? 'Nothing' }}">
                                                <i class="fa-solid fa-bars"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Done --}}
                    <div class="col-xl-3 col-12 mt-3 mt-xl-0">
                        <div class="card p-3 border-0 shadow text-white"
                            style="min-height: 50vh; background-color: #3D0A05;">
                            <h4 class="text-center"><i class="fa-solid fa-check"></i> Done</h4>
                            <div style="background-color: #fff; height: 2px;" class="mt-2"></div>
                            @forelse ($done as $item)
                                <div class="card border-brown p-2 mt-3">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="text-second">{{ Str::limit($item->title, 20) }}</h6>
                                        <button type="button" class="btn btn-sm bg-brown text-white"
                                            data-bs-toggle="modal" data-bs-target="#detailQuestModal"
                                            data-title="{{ $item->title }}"
                                            data-workerdescription="{{ $item->subtaskWorkers->first()?->description ?? 'Nothing' }}">
                                            <i class="fa-solid fa-bars"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-white mt-3">No tasks completed yet 😴</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div class="modal fade" id="detailQuestModal" tabindex="-1" aria-labelledby="detailQuestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Detail Quest</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6><i class="fa-regular fa-notebook me-1"></i> Title :</h6>
                    <p id="questTitle"></p>
                    <h6><i class="fa-regular fa-comment me-1"></i> Comment :</h6>
                    <p id="workerDescription"></p>
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
                    <h1 class="modal-title fs-5">Upload Photo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('quest.updateToReview') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="subtask_id" id="modal-subtask-id">
                        <input type="hidden" name="worker_id" id="modal-worker-id">

                        <label>Upload Foto Bukti</label>
                        <input type="file" class="form-control" name="photo" required>

                        <button type="submit" class="btn bg-brown text-white mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Script --}}
    <script>
        const detailModal = document.getElementById('detailQuestModal');
        detailModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            document.getElementById('questTitle').innerText = button.getAttribute('data-title');
            document.getElementById('workerDescription').innerText = button.getAttribute('data-workerdescription');
        });

        const uploadModal = document.getElementById('uploadPhotoModal');
        uploadModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            document.getElementById('modal-subtask-id').value = button.getAttribute('data-subtask-id');
            document.getElementById('modal-worker-id').value = button.getAttribute('data-worker-id');
        });
    </script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
