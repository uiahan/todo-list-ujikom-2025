@extends('layouts.page')
@section('title', 'My Job')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <style>
        #myTable td, #myTable th {
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
                        <h4>My Job</h4>
                        <a href="" data-bs-toggle="tooltip" data-bs-title="Add Job" class="btn btn-primary"><i class="fa-regular fa-plus"></i></a>
                    </div>
                    <hr>
                    <table class="table table-bordered text-second" id="myTable">
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
                                    <button class="btn btn-info text-white" data-bs-toggle="tooltip" data-bs-title="Quest"><i class="fa-regular fa-note"></i></button>
                                    <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-title="Worker"><i class="fa-regular fa-users"></i></button>
                                    <button class="btn btn-primary" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="fa-regular fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger" data-bs-toggle="tooltip" data-bs-title="Delete"><i class="fa-regular fa-trash"></i></button>
                                </td>
                            </tr>
                            {{-- Tambahkan baris lainnya di sini --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- jQuery dan DataTables v1.10.25 --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    <script>
        new DataTable('#myTable');
    </script>
@endpush
