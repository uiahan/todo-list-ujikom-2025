@extends('layouts.page')
@section('title', 'Manage Tasker')

@push('css')
    <style>
        #taskerTable td,
        #taskerTable th {
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
                        <h4>Manage Tasker</h4>
                        <button data-bs-toggle="modal" data-bs-target="#addTaskerModal" class="btn bg-brown text-white"><i
                                class="fa-regular fa-plus me-1"></i> Add Tasker</button>
                    </div>
                    <hr>
                    <table id="taskerTable" class="table table-bordered text-second">
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

    <div class="modal fade" id="addTaskerModal" tabindex="-1" aria-labelledby="addTaskerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-second">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTaskerModalLabel">Add Tasker</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('store.tasker') }}" method="POST" enctype="multipart/form-data">
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
                        <button type="submit" class="btn bg-brown text-white">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#taskerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tasker.data') }}",
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

        function editTasker(id) {
            let url = '{{ route('tasker.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#editTaskerId').val(response.id);
                    $('#editName').val(response.name);
                    $('#editUsername').val(response.username);
                    $('#editPhoneNumber').val(response.phone_number);

                    let updateUrl = '{{ route('update.tasker', ':id') }}'.replace(':id', response.id);
                    $('#editTaskerForm').attr('action', updateUrl);

                    $('#editTaskerModal').modal('show');
                },
                error: function(xhr) {
                    alert('Gagal ambil data. Cek console.');
                    console.error(xhr.responseText);
                }
            });
        }

        $('#editTaskerForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: $('#editTaskerForm').attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editTaskerModal').modal('hide');
                    $('#taskerTable').DataTable().ajax.reload();

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

        function deleteTasker(id) {
            Swal.fire({
                title: 'Yakin mau hapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3D0A05',
                cancelButtonColor: '#3D0A05',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/manage-tasker/delete-tasker/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#taskerTable').DataTable().ajax.reload();

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
                            Swal.fire('Oops!', 'Gagal menghapus tasker.', 'error');
                        }
                    });
                }
            });
        }        
    </script>
@endpush
