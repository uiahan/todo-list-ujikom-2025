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
                <div class="card text-second p-3 border-0 shadow-lg mt-4">
                    <div class="d-flex justify-content-between">
                        <h4>My Job</h4>
                        <button data-bs-toggle="modal" data-bs-target="#addJobModal" data-bs-title="Add Job"
                            class="btn bg-brown text-white"><i class="fa-regular fa-plus"></i></button>
                    </div>
                    <hr>
                    <table class="table table-bordered text-second" id="jobTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Job Name</th>
                                <th>Deadline</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($task as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset('storage/' . $item->image) }}" width="40" height="40"
                                            style="object-fit: cover" alt=""></td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('Y-m-d') : 'Tidak ada deadline' }}
                                    </td>
                                    <td>
                                        <button class="btn bg-brown text-white open-quest-modal" data-bs-toggle="modal"
                                            data-bs-target="#questModal" data-task-id="{{ $item->id }}"
                                            data-task-title="{{ $item->title }}">
                                            <i class="fa-regular fa-note"></i>
                                        </button>
                                        <button class="btn bg-brown text-white" data-bs-toggle="modal"
                                            data-bs-target="#workerModal" data-bs-title="Worker"><i
                                                class="fa-regular fa-users"></i></button>
                                        <button class="btn bg-brown text-white btn-edit-tasker" data-bs-toggle="modal"
                                            data-bs-target="#editJobModal" data-id="{{ $item->id }}"
                                            data-title="{{ $item->title }}" data-description="{{ $item->description }}"
                                            data-image="{{ $item->image }}" data-video="{{ $item->video }}"
                                            data-deadline="{{ $item->deadline }}"
                                            data-repetition="{{ $item->repetition }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>

                                        <button class="btn bg-brown text-white btn-delete-tasker"
                                            data-id="{{ $item->id }}" data-title="{{ $item->title }}">
                                            <i class="fa-regular fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="questModalLabel">Add New Job</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store.job') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title">Title</label>
                            <input required type="text" class="form-control" name="title">
                        </div>
                        <div class="mt-3">
                            <label for="description">Description</label>
                            <textarea type="text" class="form-control" name="description"></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="image">Image</label>
                            <input type="file" accept="image/*" name="image" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="video">Video</label>
                            <input type="text" class="form-control" name="video">
                        </div>
                        <div class="mt-3">
                            <label for="deadline">Deadline</label>
                            <input type="date" class="form-control" name="deadline">
                        </div>
                        <div class="mt-3">
                            <label for="repetition">Repetition</label>
                            <select name="repetition" id="" class="form-control">
                                <option value="" selected>None</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="moonthly">Moonthly</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-brown text-white">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="workerModal" tabindex="-1" aria-labelledby="workerModalLabel" aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="workerModalLabel">Ujikom</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="mb-1">Add Worker</label>
                        <div class="input-group">
                            <select id="worker-select" name="worker" class="form-control">
                                <option value="farhan">Farhan</option>
                                <option value="nadip">Nadip</option>
                                <option value="riffa">Riffa</option>
                                <option value="hilal">Hilal</option>
                            </select>
                            <button type="submit" class="btn bg-brown text-white">
                                <i class="fa-regular fa-plus"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="pt-2 px-3 pb-3">
                    <h1 class="modal-title fs-5 mb-1">Worker List</h1>
                    <table class="table table-bordered text-second" id="workerTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="text-center"><img src="{{ asset('images/profile.jpg') }}" width="40"
                                        alt=""></td>
                                <td>Farhan Dika</td>
                                <td>
                                    <a href="{{ route('view.job') }}" class="btn bg-brown text-white"
                                        data-bs-title="View"><i class="fa-regular fa-eye"></i></a>
                                    <button class="btn bg-brown text-white" data-bs-toggle="tooltip"
                                        data-bs-title="Delete"><i class="fa-regular fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Job -->
    <div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editJobModalLabel">Edit Ujikom Job</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.job', ':id') }}" method="POST" enctype="multipart/form-data"
                        id="editJobForm">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="title">Title</label>
                            <input required type="text" class="form-control" name="title" id="edit-title">
                        </div>
                        <div class="mt-3">
                            <label for="description">Description</label>
                            <textarea required class="form-control" name="description" id="edit-description"></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="image">Image</label>
                            <input type="file" accept="image/*" class="form-control" name="image" id="edit-image">
                        </div>
                        <div class="mt-3">
                            <label for="video">Video</label>
                            <input type="text" class="form-control" name="video" id="edit-video">
                        </div>
                        <div class="mt-3">
                            <label for="deadline">Deadline</label>
                            <input type="date" class="form-control" name="deadline" id="edit-deadline" required>
                        </div>
                        <div class="mt-3">
                            <label for="repetition">Repetition</label>
                            <select name="repetition" id="edit-repetition" class="form-control">
                                <option value="none">None</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-brown text-white" id="saveChangesBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="questModal" tabindex="-1" aria-labelledby="questModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered text-second">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="questModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="questForm" method="POST" action="{{ route('store.quest') }}">
                        @csrf
                        <input type="hidden" name="task_id" id="task_id_field">
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
                    <div id="quest-list">
                        <div id="quest-list">
                            <p class="text-muted">Klik tombol quest untuk melihat daftarnya...</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    @endsection

    @push('js')
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
            const questModal = document.getElementById('questModal');

            questModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const title = button.getAttribute('data-task-title');
                const taskId = button.getAttribute('data-task-id');

                questModal.querySelector('#questModalLabel').textContent = title;

                questModal.querySelector('#task_id_field').value = taskId;
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const questModal = document.getElementById('questModal');
                const questList = document.getElementById('quest-list');
                const titleLabel = document.getElementById('questModalLabel');
                const taskIdField = document.getElementById('task_id_field');
                const form = document.getElementById('questForm');
                const inputTitle = form.querySelector('input[name="title"]');

                document.querySelectorAll('.open-quest-modal').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        const taskId = this.dataset.taskId;
                        const taskTitle = this.dataset.taskTitle;

                        titleLabel.innerText = taskTitle + ' Quest';
                        taskIdField.value = taskId;
                        questList.innerHTML = '<p>Loading...</p>';

                        fetchQuests(taskId);
                    });
                });

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const taskId = taskIdField.value;

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => response.json())
                        .then(result => {
                            inputTitle.value = '';
                            fetchQuests(taskId);
                        });
                });

                questList.addEventListener('click', function(e) {
                    if (e.target.closest('.btn-delete-quest')) {
                        const button = e.target.closest('.btn-delete-quest');
                        const id = button.dataset.id;
                        deleteQuest(id);
                    }
                });

                function fetchQuests(taskId) {
                    fetch(`/tasker/manage-quest/quest/${taskId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                questList.innerHTML = '<p class="text-muted">Belum ada quest.</p>';
                                return;
                            }

                            questList.innerHTML = '';
                            data.forEach((quest, index) => {
                                questList.innerHTML += `
                            <div class="card ps-3 pe-2 pt-2 pb-2 mt-2" data-quest-id="${quest.id}">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mt-1">${index + 1}. ${quest.title}</h6>
                                    <div>
                                        <button class="btn bg-brown text-white btn-delete-quest" data-id="${quest.id}">
                                            <i class="fa-regular fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                            });
                        });
                }

                function deleteQuest(id) {
                    Swal.fire({
                        title: 'Yakin mau hapus quest ini?',
                        text: "Quest yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3D0A05',
                        cancelButtonColor: '#3D0A05',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/tasker/manage-quest/delete-quest/' + id,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    $(`[data-quest-id="${id}"]`).fadeOut(300, function() {
                                        $(this).remove();
                                    });

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Terhapus!',
                                        text: response.message,
                                        confirmButtonText: 'OK',
                                        customClass: {
                                            confirmButton: 'btn'
                                        },
                                        buttonsStyling: false,
                                        didOpen: () => {
                                            const swal = Swal.getPopup();
                                            swal.style.color = '#3D0A05';

                                            const confirmBtn = swal.querySelector(
                                                '.btn');
                                            confirmBtn.style.backgroundColor =
                                                '#3D0A05';
                                            confirmBtn.style.borderColor = '#3D0A05';
                                            confirmBtn.style.color = 'white';
                                        }
                                    });
                                },
                                error: function(xhr) {
                                    console.error(xhr.responseText);
                                    Swal.fire('Oops!', 'Gagal menghapus quest.', 'error');
                                }
                            });
                        }
                    });
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const taskTable = document.querySelector('table');
                const dataTable = $('#taskerTable').DataTable();

                taskTable.addEventListener('click', function(e) {
                    const deleteBtn = e.target.closest('.btn-delete-tasker');
                    if (!deleteBtn) return;

                    const taskId = deleteBtn.dataset.id;
                    const taskTitle = deleteBtn.dataset.title;

                    Swal.fire({
                        title: `Hapus "${taskTitle}"?`,
                        text: "Data ini akan hilang permanen.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3D0A05',
                        cancelButtonColor: '#3D0A05',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/tasker/manage-job/delete-job/' + taskId,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Terhapus!',
                                        text: response.success ||
                                            'Tasker berhasil dihapus.',
                                        confirmButtonText: 'OK',
                                        customClass: {
                                            confirmButton: 'btn'
                                        },
                                        buttonsStyling: false,
                                        didOpen: () => {
                                            const swal = Swal.getPopup();
                                            swal.style.color = '#3D0A05';
                                            const confirmBtn = swal
                                                .querySelector('.btn');
                                            confirmBtn.style.backgroundColor =
                                                '#3D0A05';
                                            confirmBtn.style.borderColor =
                                                '#3D0A05';
                                            confirmBtn.style.color = 'white';
                                        }
                                    }).then(() => {
                                        location.reload();
                                    });
                                },
                                error: function(xhr) {
                                    console.error(xhr.responseText);
                                    Swal.fire('Oops!', 'Gagal menghapus job.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editButtons = document.querySelectorAll('.btn-edit-tasker');

                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const taskId = this.dataset.id;
                        const taskTitle = this.dataset.title;
                        const taskDescription = this.dataset.description;
                        const taskImage = this.dataset.image;
                        const taskVideo = this.dataset.video;
                        let taskDeadline = this.dataset.deadline;
                        const taskRepetition = this.dataset.repetition;

                        // Memastikan format tanggal sesuai dengan input tipe 'date'
                        if (taskDeadline) {
                            // Mengambil hanya bagian tanggal (YYYY-MM-DD) dari datetime string
                            taskDeadline = taskDeadline.split(' ')[
                            0]; // Ambil hanya bagian tanggal (YYYY-MM-DD)
                        }

                        // Mengisi data ke dalam modal
                        document.getElementById('edit-title').value = taskTitle;
                        document.getElementById('edit-description').value = taskDescription;
                        document.getElementById('edit-video').value = taskVideo;
                        document.getElementById('edit-deadline').value = taskDeadline;
                        document.getElementById('edit-repetition').value = taskRepetition;

                        const formAction = '{{ route('update.job', ':id') }}'.replace(':id', taskId);
                        document.getElementById('editJobForm').action = formAction;

                        if (taskImage) {
                            document.getElementById('edit-image').setAttribute('data-current-image',
                                taskImage);
                        }
                    });
                });

                document.getElementById('saveChangesBtn').addEventListener('click', function() {
                    document.getElementById('editJobForm').submit();
                });
            });
        </script>
    @endpush
