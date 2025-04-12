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
                        <h4>My Job</h4>
                        <button data-bs-toggle="modal" data-bs-target="#addJobModal" data-bs-title="Add Job"
                            class="btn btn-primary"><i class="fa-regular fa-plus"></i></button>
                    </div>
                    <hr>
                    <table class="table table-bordered text-second" id="jobTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Job Name</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Ujikom</td>
                                <td>14 April 2025</td>
                                <td>Aktif</td>
                                <td>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#questModal"
                                        data-bs-title="Quest"><i class="fa-regular fa-note"></i></button>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#workerModal"
                                        data-bs-title="Worker"><i class="fa-regular fa-users"></i></button>
                                    <button class="btn btn-info text-white" data-bs-toggle="modal"
                                        data-bs-target="#editJobModal" data-bs-title="Edit"><i
                                            class="fa-regular fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-title="Delete"><i
                                            class="fa-regular fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- add job modal --}}
    <div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addJobModalLabel">Add My Job</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title">Title</label>
                            <input required type="text" class="form-control" name="title">
                        </div>
                        <div class="mt-3">
                            <label for="description">Description</label>
                            <textarea required type="text" class="form-control" name="description"></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="image">Image</label>
                            <input type="file" accept="image/*" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="video">Video</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="deadline">Deadline</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="repetition">Repetition</label>
                            <select name="repetition" id="" class="form-control">
                                <option value="none" selected>None</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="moonthly">Moonthly</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Submit</button>
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
                            <button type="submit" class="btn btn-primary">
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
                                <a href="" class="btn btn-danger"><i class="fa-regular fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card ps-3 pe-2 pt-2 pb-2 mt-2">
                        <div class="d-flex justify-content-between">
                            <h6 class="mt-1">2. Dokumentsi</h6>
                            <div>
                                <a href="" class="btn btn-danger"><i class="fa-regular fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card ps-3 pe-2 pt-2 pb-2 mt-2">
                        <div class="d-flex justify-content-between">
                            <h6 class="mt-1">3. Design web</h6>
                            <div>
                                <a href="" class="btn btn-danger"><i class="fa-regular fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card ps-3 pe-2 pt-2 pb-2 mt-2">
                        <div class="d-flex justify-content-between">
                            <h6 class="mt-1">4. Membuat web todo list</h6>
                            <div>
                                <a href="" class="btn btn-danger"><i class="fa-regular fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- worker modal --}}
    <div class="modal fade" id="workerModal" tabindex="-1" aria-labelledby="workerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg text-second modal-dialog-centered">
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
                            <button type="submit" class="btn btn-primary">
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
                                <td class="text-center"><img src="{{ asset('images/profile.jpg') }}" width="40" alt=""></td>
                                <td>Farhan Dika</td>
                                <td>
                                    <a href="{{ route('view.job') }}" class="btn btn-primary" data-bs-title="View"><i
                                            class="fa-regular fa-eye"></i></a>
                                    <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-title="Delete"><i
                                            class="fa-regular fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- edit job modal --}}
    <div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
        <div class="modal-dialog text-second modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editJobModalLabel">Edit Ujikom Job</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title">Title</label>
                            <input required type="text" class="form-control" name="title">
                        </div>
                        <div class="mt-3">
                            <label for="description">Description</label>
                            <textarea required type="text" class="form-control" name="description"></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="image">Image</label>
                            <input type="file" accept="image/*" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="video">Video</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="deadline">Deadline</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="repetition">Repetition</label>
                            <select name="repetition" id="" class="form-control">
                                <option value="none" selected>None</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="moonthly">Moonthly</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

    <!-- Tom Select JS -->
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
@endpush
