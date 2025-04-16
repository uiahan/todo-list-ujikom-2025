@extends('layouts.page')
@section('title', 'My Job')
@push('css')
    <style>
        @media(min-width: 1200px) {
            .wrap {
                padding-left: 270px;
            }
        }
    </style>
    @section('content')
        <div class="d-flex ps-4 py-4">
            @include('components.sidebar')
            <div class="w-100 wrap">
                <div class="pe-4">
                    @include('components.navbar')
                    <div class="text-second border-left-brown card px-3 pt-3 pb-2 border-0 shadow-lg mt-4">
                        <div class="d-flex justify-content-between">
                            <h4>My Job</h4>

                        </div>
                    </div>

                    <div class="row">
                        @foreach ($taskWorkers as $item)
                            <div class="col-xl-6 col-12">
                                <div class="card w-100 mb-3 mt-3 border-0 shadow text-white" style="background-color: #3D0A05;">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <div class="ratio ratio-4x3 h-100 rounded-start overflow-hidden">
                                                <img src="{{ asset('storage/' . $item->task->image) }}" alt=""
                                                    style="object-fit: cover">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="card-title mb-2">
                                                        {{ $item->task->title }}
                                                    </h5>
                                                </div>
                                                <p class="card-text small mb-2">
                                                    {{ Str::limit($item->task->description, 80, '...') }}</p>
                                                <p class="card-text mb-0">
                                                    <small>
                                                        @if ($item->done_subtasks === 0)
                                                            ❌ <span class="fw-bold">Progress:</span>
                                                            {{ $item->done_subtasks }}/{{ $item->total_subtasks }} pending
                                                        @elseif ($item->done_subtasks < $item->total_subtasks)
                                                            🔄 <span class="fw-bold">Progress:</span>
                                                            {{ $item->done_subtasks }}/{{ $item->total_subtasks }} in progress
                                                        @else
                                                            ✅<span class="fw-bold">Progress:</span>
                                                            {{ $item->done_subtasks }}/{{ $item->total_subtasks }} done
                                                        @endif
                                                    </small>
                                                </p>

                                                <p class="card-text mb-2"><small>📅 <span class="fw-bold">Deadline :</span>
                                                        {{ $item->task->deadline ? \Carbon\Carbon::parse($item->deadline)->format('Y-m-d') : 'Tidak ada deadline' }}</small>
                                                </p>
                                                @php
                                                    $isExpired =
                                                        $item->task->deadline &&
                                                        \Carbon\Carbon::parse($item->task->deadline)->isPast();
                                                @endphp

                                                @if ($isExpired)
                                                    <button class="btn btn-secondary d-block fw-bold btn-sm mt-3 w-100"
                                                        style="font-size: 11px" disabled>
                                                        ⛔ Deadline Expired
                                                    </button>
                                                @else
                                                    <a href="{{ route('quest', $item->task->id) }}"
                                                        class="btn btn-light text-second d-block fw-bold btn-sm mt-3"
                                                        style="font-size: 11px">Start Job</a>
                                                @endif

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


    @endsection
    @push('js')
        <script>
            // js
        </script>
    @endpush
