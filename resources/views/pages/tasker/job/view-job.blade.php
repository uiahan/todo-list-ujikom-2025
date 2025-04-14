@extends('layouts.page')
@section('title', 'My Job')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
@endpush

@section('content')
    <div class="d-flex ps-4 py-4">
        @include('components.sidebar')
        <div style="padding-left: 270px" class="w-100">
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
                                            <a href="{{ asset('storage/' . $statusData->image) }}" target="_blank"
                                                class="btn bg-brown text-white" data-bs-title="Image">
                                                <i class="fa-regular fa-image"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">Not uploaded yet</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($statusData && $statusData->status === 'review')
                                            <button class="btn bg-brown text-white" data-bs-toggle="modal"
                                                data-bs-target="#acceptModal" data-bs-title="Accept">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                            <button class="btn bg-brown text-white" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal" data-bs-title="Reject">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
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
                        <input type="text" name="subtask_id" value="{{ $item->id }}">
                        <input type="text" name="worker_id" value="{{ $worker->id }}">
                        <label for="">Insert comment</label>
                        <textarea name="description" required class="form-control"></textarea>
                        <button type="submit" class="btn bg-brown text-white mt-2">Submit</button>
                    </form>
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
                        <input type="hidden" name="subtask_id" value="{{ $item->id }}">
                        <input type="hidden" name="worker_id" value="{{ $worker->id }}">
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
        document.querySelectorAll('[data-bs-target="#acceptModal"]').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('approve_subtask_id').value = btn.dataset.subtaskId;
            });
        });
        document.querySelectorAll('[data-bs-target="#rejectModal"]').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('reject_subtask_id').value = btn.dataset.subtaskId;
            });
        });
    </script>
@endpush
