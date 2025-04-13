@extends('layouts.page')
@section('title', 'Manage Worker')

@push('css')
    <style>
        #workerTable td, #workerTable th {
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
                        <h4>Manage Worker</h4>
                        <button data-bs-toggle="modal" data-bs-target="#addWorkerModal" class="btn bg-brown text-white"><i class="fa-regular fa-plus me-1"></i> Add Worker</button>
                    </div>
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
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Worker Modal --}}
    <div class="modal fade" id="addWorkerModal" tabindex="-1" aria-labelledby="addWorkerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-second">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addWorkerModalLabel">Add Worker</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('store.worker') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Profile Picture (optional)</label>
                            <input type="file" name="profile" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-brown text-white">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tasker -->
    <div class="modal fade" id="editTaskerModal" tabindex="-1" aria-labelledby="editTaskerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-second">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTaskerModalLabel">Edit Tasker</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTaskerForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editTaskerId" name="id">
                        <div class="mb-2">
                            <label class="form-label">Name</label>
                            <input type="text" id="editName" name="name" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Username</label>
                            <input type="text" id="editUsername" name="username" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Phone Number</label>
                            <input type="text" id="editPhoneNumber" name="phone_number" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Password (kosongkan jika tidak ingin diubah)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" name="profile" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-brown text-white">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $('#workerTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('worker.data') }}",
        order: [
            [1, 'desc']
        ],
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'profile',
                name: 'profile',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'username',
                name: 'username'
            },
            {
                data: 'phone_number',
                name: 'phone_number'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
</script>
@endpush
