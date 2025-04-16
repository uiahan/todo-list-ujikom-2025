@extends('layouts.page')
@section('title', 'Dashboard')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
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
                <div class="text-second border-left-brown card px-3 pt-3 pb-2 border-0 shadow-lg mt-4">
                    <h4>Notification History</h4>
                </div>

                <div class="card p-3 mt-3">
                    <div class="list-group">
                        @forelse ($notifications as $notification)
                            <div class="p-3 text-second">
                                <h5>{{ $notification->data['message'] }}</h5>
                                <p class="small text-muted">{{ $notification->created_at->diffForHumans() }}</p>
                                <hr>
                                <!-- Jika notifikasi belum dibaca, tampilkan tombol untuk menandai sebagai dibaca -->
                              
                            </div>
                        @empty
                            <div class="list-group-item">
                                <p class="text-muted">Tidak ada notifikasi</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        // js
    </script>
@endpush
