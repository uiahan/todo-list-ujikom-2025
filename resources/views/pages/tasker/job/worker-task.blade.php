@extends('layouts.page')
@section('title', 'Worker')

@push('css')
    <style>
        #workerTable td,
        #workerTable th {
            text-align: left !important;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex ps-4 py-4">
        @include('components.sidebar')
        <div style="padding-left: 270px" class="w-100">
            <div class="pe-4">
                @include('components.navbar')
                <div class="card text-second p-3 border-0 shadow-lg mt-4">
                    <div class="d-flex justify-content-between">
                        <h4>Add worker for {{ $task->title }}</h4>
                    </div>
                    <form action="{{ route('store.job.worker') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="hidden" name="task_id" value="{{ $task->id }}" id="worker-task-id">
                            <select id="worker-select" name="worker_id" class="form-control">
                                @foreach ($worker as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn bg-brown text-white" data-bs-title="Add Worker">
                                <i class="fa-regular fa-plus"></i>
                            </button>
                        </div>
                    </form>
                    <hr>
                    <table id="workerTable" class="table table-bordered text-second">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Photo</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taskWorker as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        @if ($item->worker->image)
                                        <img src="{{ asset('storage/' . ($item->worker->image ?? 'images/profile.jpg')) }}"
                                            width="40" alt="">
                                        @else
                                        <img src="{{ asset('images/profile-default.png') }}"
                                            width="40" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $item->worker->name }}</td>
                                    <td>{{ $item->worker->username }}</td>
                                    <td>{{ $item->worker->phone_number }}</td>
                                    <td>
                                        <form action="{{ route('delete.job.worker', $item->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')">
                                        <a href="{{ route('view.job', ['task' => $task->id, 'worker' => $item->worker->id]) }}" class="btn bg-brown text-white"
                                    data-bs-title="View"><i class="fa-regular fa-eye"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn bg-brown text-white" data-bs-title="Delete">
                                            <i class="fa-regular fa-trash"></i>
                                        </button>
                                    </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        new DataTable('#workerTable');

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

        document.querySelectorAll('[data-bs-title]').forEach(el => {
            new bootstrap.Tooltip(el);
        });
    </script>
@endpush
