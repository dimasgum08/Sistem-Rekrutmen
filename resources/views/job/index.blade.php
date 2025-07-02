@extends('layouts.main')

@section('content')

    {{-- @if(getInfoLogin()->roles[0]->name == 'HRD')
        <div class="col-12 text-end mb-2">
            <a href="{{ route('apps.job-vacancies.create') }}" class="btn btn-primary"><i class="ti ti-device-floppy me-2"></i> Tambah Lowongan</a>
        </div>
    @endif --}}
    <div class="row">
        <div class="col-lg-5">
            <div id="jobList">
                @foreach ($jobVacancies as $job)
                    <a href="#" class="list-group-item list-group-item-action"
                        data-id="{{ $job->hashid }}"
                        data-slug="{{ $job->slug }}"
                        data-title="{{ $job->title }}"
                        data-is-apply="{{ $job->isApply ? '1' : '0' }}"
                        data-content="{{ htmlspecialchars($job->content) }}"
                        data-apply-url="{{ route('apps.job-vacancies.apply', $job->hashid) }}"
                        data-expired="{{ $job->is_expired ? '1' : '0' }}"
                        onclick="showJobDetail(event, this)">

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0">{{ $job->title }}</h6>
                                    @if ($job->is_new)
                                        <span class="badge bg-primary ">Baru</span>
                                    @endif
                                </div>
                                <p class="text-muted mb-1">
                                    <i class="ti ti-building me-1"></i>
                                    {{ $job->placement }}
                                </p>
                                <p class="text-muted mb-1">
                                    {{ Str::limit(strip_tags($job->content), 100) }}
                                </p>
                                <small>
                                    @if ($job->is_expired)
                                        <span class="text-danger"><i>Lowongan Kedaluwarsa</i></span>
                                    @else
                                        Dibuka sampai {{ \Carbon\Carbon::parse($job->deadline)->locale('id')->translatedFormat('d F Y') }}
                                    @endif
                                </small>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-3">
                {{ $jobVacancies->links('vendor.pagination.default') }}
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="jobDetailCard" class="card">
                <div class="card-body">
                    <div id="jobPlaceholder"
                        class="d-flex flex-column justify-content-center align-items-center text-center">
                        <img src="{{ asset('assets/images/empty.svg') }}" alt="Job Illustration" style="max-width: 200px;"
                            class="mb-4">
                        <div class="text-muted">
                            <h5 class="mt-3">Pilih lowongan untuk melihat detail</h5>
                            <p>Silakan klik salah satu lowongan kerja di sebelah kiri untuk melihat informasi lengkapnya.
                            </p>
                        </div>
                    </div>

                    <div id="jobDetail" class="w-100 d-none">
                        <h5 id="jobTitle"></h5>
                        <div id="jobContent" class="mt-3 text-secondary"></div>
                        @if (getInfoLogin()->roles[0]->name == 'Applicant')
                            <div class="mt-4 text-end">
                                <button id="applyButton" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#uploadModal">
                                    <i class="ti ti-send"></i> Lamar Sekarang
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('job.partials.modal')
@endsection
