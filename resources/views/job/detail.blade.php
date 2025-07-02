@extends('layouts.main')

@section('content')

    <div class="card shadow-sm">
        <div class="card-body">
            <h4>{{ $job->title }}</h4>
            @if ($isNew)
                <span class="badge bg-primary float-end">Baru</span>
            @endif

            <p class="text-muted mb-1 mt-3">
                <i class="ti ti-calendar"></i> Dibuka dari
                {{ \Carbon\Carbon::parse($job->date_posted)->locale('id')->translatedFormat('d F Y') }}
                sampai {{ \Carbon\Carbon::parse($job->deadline)->locale('id')->translatedFormat('d F Y') }}
            </p>
            <hr>
            <div class="text-secondary">
                {!! $job->content !!}
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('apps.job-vacancies') }}" class="btn btn-secondary">Kembali</a>

                @if (getInfoLogin()->roles[0]->name === 'Applicant')
                    @if ($isExpired)
                        <span class="text-danger fw-bold">Lowongan ini sudah kedaluwarsa</span>
                    @else
                        @if ($isApply)
                            <button class="btn btn-primary disabled">
                                <i class="ti ti-check"></i> Sudah Dilamar
                            </button>
                        @else
                            <button id="applyJob" class="btn btn-primary" data-bs-toggle="modal" data-apply-url="{{ route('apps.job-vacancies.apply', $job->hashid) }}" data-bs-target="#uploadModal">
                                <i class="ti ti-send"></i> Lamar Sekarang
                            </button>
                        @endif
                    @endif
                @endif
            </div>

        </div>
    </div>
    @include('job.partials.modal')

@endsection
