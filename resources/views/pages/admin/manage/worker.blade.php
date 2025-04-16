@extends('layouts.page')
@section('title', 'Manage Worker')

@push('css')
    <style>
        #workerTable td,
        #workerTable th {
            text-align: left !important;
        }

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
                        <h4>Manage Worker</h4>
                        <button data-bs-toggle="modal" data-bs-target="#addWorkerModal" class="btn bg-brown text-white"><i
                                class="fa-regular fa-plus me-1"></i> Add Worker</button>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table id="workerTable" class="table table-bordered text-second">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Phone Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
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

    <div class="modal fade" id="editWorkerModal" tabindex="-1" aria-labelledby="editWorkerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-second">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editWorkerModalLabel">Edit Worker</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editWorkerForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editWorkerId" name="id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" id="editName" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" id="editUsername" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" id="editPhoneNumber" name="phone_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password (optional)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" name="profile" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-brown text-white">Save</button>
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

        function editWorker(id) {
            let url = '{{ route('worker.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#editWorkerId').val(response.id);
                    $('#editName').val(response.name);
                    $('#editUsername').val(response.username);
                    $('#editPhoneNumber').val(response.phone_number);

                    let updateUrl = '{{ route('update.worker', ':id') }}'.replace(':id', response.id);
                    $('#editWorkerForm').attr('action', updateUrl);

                    $('#editWorkerModal').modal('show');
                },
                error: function(xhr) {
                    alert('Gagal ambil data. Cek console.');
                    console.error(xhr.responseText);
                }
            });
        }

        $('#editWorkerForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: $('#editWorkerForm').attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editWorkerModal').modal('hide');
                    $('#workerTable').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.success,
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn'
                        },
                        buttonsStyling: false,
                        didOpen: () => {
                            const swal = Swal.getPopup();
                            swal.style.color = '#3D0A05';

                            const confirmBtn = swal.querySelector('.btn');
                            confirmBtn.style.backgroundColor = '#3D0A05';
                            confirmBtn.style.borderColor = '#3D0A05';
                            confirmBtn.style.color = 'white';
                        }
                    });
                }
            });
        });

        function deleteWorker(id) {
            Swal.fire({
                title: 'Sure want to delete?',
                text: "Data cannot be restored!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3D0A05',
                cancelButtonColor: '#3D0A05',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/manage-worker/delete-worker/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#workerTable').DataTable().ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: response.success,
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn'
                                },
                                buttonsStyling: false,
                                didOpen: () => {
                                    const swal = Swal.getPopup();
                                    swal.style.color = '#3D0A05';

                                    const confirmBtn = swal.querySelector('.btn');
                                    confirmBtn.style.backgroundColor = '#3D0A05';
                                    confirmBtn.style.borderColor = '#3D0A05';
                                    confirmBtn.style.color = 'white';
                                }
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Oops!', 'Gagal menghapus worker.', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endpush
