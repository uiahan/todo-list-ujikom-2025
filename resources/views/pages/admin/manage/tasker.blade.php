@extends('layouts.page')
@section('title', 'Manage Tasker')

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
                        <h4>Manage Tasker</h4>
                        <a href="" class="btn btn-primary"><i class="fa-regular fa-plus"></i></a>
                    </div>
                    <hr>
                    <table class="table table-bordered text-second" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Nomor Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Eneng Maryam</td>
                                <td>emaryam</td>
                                <td>08123456789</td>
                                <td>
                                    <button class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger"><i class="fa-regular fa-trash"></i></button>
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
        new DataTable('#myTable');
    </script>
@endpush
