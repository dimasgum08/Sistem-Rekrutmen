@extends('layouts.main')

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-8 document">
            <ul class="nav nav-tabs mb-3" id="applicationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                        role="tab" aria-controls="all" aria-selected="true">Semua ({{ $all->count() }})</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="interview-tab" data-bs-toggle="tab" data-bs-target="#interview"
                        type="button" role="tab" aria-controls="interview" aria-selected="false">Interview ({{ $interview->count() }})</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected"
                        type="button" role="tab" aria-controls="rejected" aria-selected="false">Ditolak ({{ $rejected->count() }})</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="accepted-tab" data-bs-toggle="tab" data-bs-target="#accepted"
                        type="button" role="tab" aria-controls="accepted" aria-selected="false">Diterima ({{ $accepted->count() }})</button>
                </li>
            </ul>
            <div class="tab-content" id="applicationTabsContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                    @forelse ($all as $item)
                        @include('candidate.components.list', ['item' => $item])
                    @empty  
                        @include('candidate.components.empty-state', ['message' => 'Belum ada lamaran ditemukan.'])
                    @endforelse
                </div>

                <div class="tab-pane fade" id="interview" role="tabpanel" aria-labelledby="interview-tab">
                    @forelse ($interview as $item)
                        @include('candidate.components.list', ['item' => $item])
                    @empty
                        @include('candidate.components.empty-state', ['message' => 'Belum ada interview.'])
                    @endforelse
                </div>

                <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                    @forelse ($rejected as $item)
                        @include('candidate.components.list', ['item' => $item])
                    @empty
                        @include('candidate.components.empty-state', ['message' => 'Belum ada lamaran yang ditolak.'])
                    @endforelse
                </div>

                <div class="tab-pane fade" id="accepted" role="tabpanel" aria-labelledby="accepted-tab">
                    @forelse ($accepted as $item)
                        @include('candidate.components.list', ['item' => $item])
                    @empty
                        @include('candidate.components.empty-state', ['message' => 'Belum ada lamaran diterima.'])
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
