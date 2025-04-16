@extends('layouts.page')
@section('title', 'My Job')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
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
                <div class="card text-second p-3 border-0 shadow-lg mt-4">
                    <div class="d-flex justify-content-between">
                        <h4>{{ $task->title }} : {{ $worker->name }}</h4>
                        <a href="javascript:void(0)" data-bs-title="Back" onclick="location.href = document.referrer"
                            class="btn bg-brown text-white">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered text-second" id="jobTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Quest title</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quest as $item)
                                    @php
                                        $statusData = $item->subtaskWorkers->where('worker_id', $worker->id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            @php
                                                if (!$statusData) {
                                                    $status = 'pending';
                                                } else {
                                                    $status = $statusData->status;
                                                }
    
                                                $badgeClass = match ($status) {
                                                    'pending' => 'danger',
                                                    'in_progres' => 'warning',
                                                    'review' => 'primary',
                                                    'done' => 'success',
                                                    default => 'secondary',
                                                };
                                            @endphp
    
                                            <span class="badge bg-{{ $badgeClass }} text-uppercase">{{ $status }}</span>
                                        </td>
                                        <td>
                                            @if ($statusData && $statusData->image)
                                                <button class="btn bg-brown text-white" data-bs-toggle="modal"
                                                    data-bs-target="#imageModal" data-bs-title="Image"
                                                    data-bs-image="{{ asset('storage/' . $statusData->image) }}">
                                                    <i class="fa-regular fa-image"></i>
                                                </button>
                                            @else
                                                <span class="text-muted">Not uploaded yet</span>
                                            @endif
                                        </td>
    
                                        <td>
                                            @if ($statusData && $statusData->status === 'review')
                                            <div class="d-flex">
                                                <button class="btn bg-brown text-white btn-accept" data-bs-toggle="modal"
                                                    data-bs-target="#acceptModal" data-subtask-id="{{ $item->id }}" data-bs-title="Accept"
                                                    data-worker-id="{{ $worker->id }}"><i class="fa-solid fa-check">
                                                    </i>
                                                </button>
    
                                                <button class="btn ms-1 bg-brown text-white btn-reject" data-bs-toggle="modal" data-bs-title="Reject"
                                                    data-bs-target="#rejectModal" data-subtask-id="{{ $item->id }}"
                                                    data-worker-id="{{ $worker->id }}">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                            @endif
                                        </td>
    
    
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- accept modal --}}
    <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="acceptModalLabel">Accept Quest?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('quest.approve') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subtask_id" id="accept-subtask-id">
                        <input type="hidden" name="worker_id" id="accept-worker-id">

                        <label for="">Insert comment</label>
                        <textarea name="description" required class="form-control"></textarea>
                        <button type="submit" class="btn bg-brown text-white mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk preview gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="previewImage" class="img-fluid rounded" alt="Preview" />
                </div>
            </div>
        </div>
    </div>


    {{-- reject modal --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="rejectModalLabel">Reject Quest?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('quest.reject') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subtask_id" id="reject-subtask-id">
                        <input type="hidden" name="worker_id" id="reject-worker-id">

                        <label for="">Insert comment</label>
                        <textarea name="description" required class="form-control"></textarea>

                        <button type="submit" class="btn bg-brown text-white mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        new DataTable('#jobTable');
        new DataTable('#workerTable');

        document.querySelectorAll('[data-bs-title]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    </script>

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    <script>
        new TomSelect("#worker-select", {
            placeholder: "Choose worker...",
            allowEmptyOption: true,
            create: false,
            maxOptions: 10,
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results">No worker found</div>';
                }
            }
        });
    </script>
    <script>
        $('#acceptModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const subtaskId = button.data('subtask-id');
            const workerId = button.data('worker-id');

            $('#accept-subtask-id').val(subtaskId);
            $('#accept-worker-id').val(workerId);
        });

        $('#rejectModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const subtaskId = button.data('subtask-id');
            const workerId = button.data('worker-id');

            $('#reject-subtask-id').val(subtaskId);
            $('#reject-worker-id').val(workerId);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const imageModal = document.getElementById('imageModal');
            imageModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const imageUrl = button.getAttribute('data-bs-image');
                const imgElement = imageModal.querySelector('#previewImage');

                imgElement.src = imageUrl;
            });
        });
    </script>
@endpush
