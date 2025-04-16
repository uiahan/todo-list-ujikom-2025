@extends('layouts.page')
@section('title', 'Private Job')

@push('css')
    <style>
        .btn-light {
            padding-left: 10px;
            padding-right: 10px;
            min-width: 40px;
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
                <div class="text-second border-left-brown card px-3 p-3 border-0 shadow-lg mt-4">
                    <div class="d-flex justify-content-between">
                        <h4>Private Job</h4>
                        <button data-bs-toggle="modal" data-bs-target="#addJobModal" data-bs-title="Add Job"
                            class="btn bg-brown text-white"><i class="fa-regular fa-plus me-1"></i> Add New Job</button>
                    </div>
                </div>
                <div class="row">
                    @foreach ($task as $item)
                        <div class="col-xl-6 col-12">
                            <div class="card w-100 mb-3 mt-3 border-0 shadow text-white" style="background-color: #3D0A05;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <div class="ratio ratio-4x3 h-100 rounded-start overflow-hidden">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt=""
                                                style="object-fit: cover">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title mb-2">{{ $item->title }}
                                                </h5>
                                            </div>
                                            
                                            
                                            <p class="card-text small mb-2">
                                                {{ Str::limit($item->description, 80, '...') }}
                                            </p>
                                            <p class="card-text mb-0">
                                                <small>
                                                    @if ($item->done_subtasks === 0)
                                                        ❌<span class="fw-bold">Progress :</span> 
                                                        {{ $item->done_subtasks }}/{{ $item->total_subtasks }} pending
                                                    @elseif ($item->done_subtasks < $item->total_subtasks)
                                                        🔄 <span class="fw-bold">Progress :</span> 
                                                        {{ $item->done_subtasks }}/{{ $item->total_subtasks }} in progress
                                                    @else
                                                        ✅ <span class="fw-bold">Progress :</span> 
                                                        {{ $item->done_subtasks }}/{{ $item->total_subtasks }} done
                                                    @endif
                                                    
                                                </small>
                                            </p>
                                            <p class="card-text mb-2"><small>📅 <span class="fw-bold">Estimate Completed :</span>
                                                    {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('Y-m-d') : 'Tidak ada deadline' }}</small>
                                            </p>
                                            <div class="d-flex mt-3">
                                                <button class="btn btn-light btn-sm open-quest-modal me-1" data-bs-toggle="modal"
                                                    data-bs-target="#questModal" data-task-id="{{ $item->id }}"
                                                    data-task-title="{{ $item->title }}" data-bs-title="Quest">
                                                    <i class="fa-regular fa-note"></i>
                                                </button>
                                                <button class="btn btn-light btn-sm btn-edit-tasker me-1" data-bs-toggle="modal"
                                                    data-bs-target="#editJobModal" data-id="{{ $item->id }}"
                                                    data-title="{{ $item->title }}"
                                                    data-description="{{ $item->description }}"
                                                    data-image="{{ $item->image }}" data-video="{{ $item->video }}"
                                                    data-deadline="{{ $item->deadline }}"
                                                    data-repetition="{{ $item->repetition }}" data-bs-title="Edit">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>

                                                <button class="btn btn-light btn-sm btn-delete-tasker me-1" data-bs-title="Delete"
                                                    data-id="{{ $item->id }}" data-title="{{ $item->title }}">
                                                    <i class="fa-regular fa-trash"></i>
                                                </button>
                                                <a href="{{ route('private.quest', $item->id) }}" data-bs-title="Start job" class="btn btn-light btn-sm"><i class="fa-regular fa-play"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                    <form action="{{ route('store.job.private') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="deadline">Estimate Completed</label>
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

    <!-- Modal Edit Job -->
    <div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editJobModalLabel">Edit Ujikom Job</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.job.private', ':id') }}" method="POST" enctype="multipart/form-data"
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
                            <label for="deadline">Estimate Completed</label>
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
                    <form id="questForm" method="POST" action="{{ route('store.quest.private') }}">
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
                    fetch(`/worker/private-job/quest/${taskId}`)
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
                                url: '/worker/private-job/delete-quest/private/' + id,
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
                document.addEventListener('click', function(e) {
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
                                url: '/worker/private-job/delete-job/' + taskId,
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

                        if (taskDeadline) {
                            taskDeadline = taskDeadline.split(' ')[
                                0];
                        }

                        document.getElementById('edit-title').value = taskTitle;
                        document.getElementById('edit-description').value = taskDescription;
                        document.getElementById('edit-video').value = taskVideo;
                        document.getElementById('edit-deadline').value = taskDeadline;
                        document.getElementById('edit-repetition').value = taskRepetition;

                        const formAction = '{{ route('update.job.private', ':id') }}'.replace(':id', taskId);
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const workerButtons = document.querySelectorAll('.btn-open-worker-modal');

                workerButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const taskId = this.dataset.taskId;
                        document.getElementById('worker-task-id').value = taskId;
                    });
                });
            });
        </script>
    @endpush
