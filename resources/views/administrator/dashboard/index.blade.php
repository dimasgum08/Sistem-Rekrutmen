@extends('layouts.main')

@section('content')
    @if (getInfoLogin()->roles[0]->name == 'Applicant')
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card hover-effect">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-primary"><i class="ti ti-users f-24"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">Total Lowongan Kerja</p>
                                <h4 class="mb-0">{{ $jobs }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-border bg-primary"></div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card hover-effect">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-primary"><i class="ti ti-users f-24"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">Total Lamaran Saya</p>
                                <h4 class="mb-0">{{ $apply }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-border bg-warning"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card hover-effect shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Lowongan yang Sudah Dilamar</h5>
                    </div>
                    <div class="card-body">
                        @if ($applyJob->isEmpty())
                            <div class="text-center py-4">
                                <img src="{{ asset('assets/images/empty.svg') }}" alt="Empty" style="width: 120px;">
                                <p class="text-muted mt-2 mb-0">Anda belum melamar lowongan kerja</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless">
                                    <tbody>
                                        @foreach ($applyJob as $item)
                                            <tr style="cursor: pointer;" onclick="window.location='{{ route('apps.job-vacancies.edit', $item->hashid) }}'">
                                                <td>
                                                    <h6 class="mb-0">{{ $item->jobVacancy->title }}</h6>
                                                    <small class="text-muted">Penempatan : {{ $item->jobVacancy->placement }}</small>
                                                </td>
                                                <td class="text-end">
                                                    <i class="ti ti-arrow-right"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Jadwal Interview</h5>
                    </div>
                    @if ($scheduleInterview->isEmpty())
                        <div class="card-body">
                            <div class="text-center py-4">
                                <img src="{{ asset('assets/images/empty.svg') }}" alt="Empty" style="width: 120px;">
                                <p class="text-muted mt-2 mb-0">Tidak ada jadwal interview hari ini</p>
                            </div>
                        </div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($scheduleInterview as $item)
                                <li class="list-group-item list-group-item-action" data-toggle="schedule" data-url="{{ route('apps.apply.jobs') }}" style="cursor:pointer">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1 me-2">
                                            <h6 class="mb-1">{{ $item->user->name }}</h6>
                                            <p class="mb-1 text-muted">
                                                <i class="ti ti-briefcase"></i> Posisi: {{ $item->jobVacancy->title ?? '-' }}<br>
                                                <i class="ti ti-building"></i> Lokasi: {{ $item->jobVacancy->placement ?? '-' }}
                                            </p>
                                            <span class="badge bg-info rounded-pill">
                                                <i class="ti ti-calendar-event"></i>
                                                {{ $item->interview->schedule ? \Carbon\Carbon::parse($item->interview->schedule)->locale('id')->translatedFormat('d F Y H:i') : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @if (getInfoLogin()->roles[0]->name == 'Admin')
                <div class="col-lg-3 col-md-6">
                    <div class="card hover-effect" data-toggle="card-redirect" data-url="{{ route('apps.candidates') }}">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avtar bg-light-primary"><i class="ti ti-users f-24"></i></div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="mb-1">Total Pelamar</p>
                                    <h4 class="mb-0">{{ $applicants }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-border bg-primary"></div>
                    </div>
                </div>
            @endif

            <div class="{{ getInfoLogin()->roles[0]->name == 'Admin' ? 'col-lg-3' : 'col-lg-4' }} col-md-6">
                <div class="card hover-effect" data-toggle="card-redirect" data-url="{{ route('apps.job-vacancies') }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-warning"><i class="ti ti-briefcase f-24"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">Total Lowongan</p>
                                <h4 class="mb-0">{{ $jobs }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-border bg-warning"></div>
                </div>
            </div>

            <div class="{{ getInfoLogin()->roles[0]->name == 'Admin' ? 'col-lg-3' : 'col-lg-4' }} col-md-6">
                <div class="card hover-effect" data-toggle="card-redirect" data-url="{{ route('apps.job-vacancies') }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-success"><i class="ti ti-send f-24"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">Lowongan Diposting</p>
                                <h4 class="mb-0">{{ $jobsPosted }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-border bg-success"></div>
                </div>
            </div>

            <div class="{{ getInfoLogin()->roles[0]->name == 'Admin' ? 'col-lg-3' : 'col-lg-4' }} col-md-6">
                <div class="card hover-effect" data-toggle="card-redirect" data-url="{{ route('apps.schedules') }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-info"><i class="ti ti-calendar-event f-24"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="mb-1">Jadwal Interview</p>
                                <h4 class="mb-0">{{ $interviews }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-border bg-info"></div>
                </div>
            </div>
        </div>
    @endif

    @if (getInfoLogin()->roles[0]->name !== 'Applicant')
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card table-card hover-effect">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Lowongan Terbaru</h5>
                        <button class="btn btn-sm btn-link-primary">Lihat Semua</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Posisi</th>
                                    <th>Tanggal Lowongan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jobsTable as $item)
                                    <tr style="cursor: pointer;"
                                        onclick="window.location='{{ route('apps.job-vacancies.edit', $item->hashid) }}'">
                                        <td>
                                            <h6 class="mb-0">{{ $item->title }}</h6>
                                            <small class="text-muted">Penempatan : {{ $item->placement }}</small>
                                        </td>
                                        <td>
                                            <i class="ti ti-calendar me-2"></i>
                                            {{ $item->date_posted ? \Carbon\Carbon::parse($item->date_posted)->locale('id')->translatedFormat('d F Y') : '-' }}
                                            -
                                            {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->locale('id')->translatedFormat('d F Y') : '-' }}
                                        </td>
                                        <td class="text-end">
                                            <i class="ti ti-arrow-right"></i>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <img src="{{ asset('assets/images/empty.svg') }}" alt="Empty" style="width: 120px;">
                                            <p class="text-muted mt-2 mb-0">Tidak ada data</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card table-card hover-effect">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Kandidat</h5>
                        <button class="btn btn-sm btn-link-primary">Lihat Semua</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Posisi</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($candidatesInterview as $item)
                                    <tr style="cursor: pointer;"
                                        onclick="window.location='{{ route('apps.candidates.detail', $item->hashid) }}'">
                                        <td>
                                            <h6 class="mb-0">{{ $item->user->name }}</h6>
                                            <small class="text-muted">{{ $item->user->email }}</small>
                                        </td>
                                        <td>
                                            {{ $item->jobVacancy->title }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $item->status == 'Process' ? 'bg-warning' : ($item->status == 'Interview' ? 'bg-info' : ($item->status == 'Accept' ? 'bg-success' : ($item->status == 'Reject' ? 'bg-danger' : ($item->status == 'Consider' ? 'bg-warning' : 'bg-secondary')))) }}">
                                                {{ $item->status == 'Process' ? 'Menunggu' : ($item->status == 'Interview' ? 'Interview' : ($item->status == 'Accept' ? 'Diterima' : ($item->status == 'Reject' ? 'Ditolak' : ($item->status == 'Consider' ? 'Dipertimbangkan' : $item->status)))) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <i class="ti ti-arrow-right"></i>
                                        </td>
                                    </tr>
                               @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <img src="{{ asset('assets/images/empty.svg') }}" alt="Empty" style="width: 120px;">
                                            <p class="text-muted mt-2 mb-0">Tidak ada data</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm hover-effect">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Lowongan</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div id="total-income-graph"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Jadwal Interview Hari Ini</h6>
                </div>
                <div class="card-body p-0">
                    @if ($scheduleInterview->isEmpty())
                        <div class="text-center py-4">
                            <img src="{{ asset('assets/images/empty.svg') }}" alt="Empty" style="width: 120px;">
                            <p class="text-muted mt-2 mb-0">Tidak ada jadwal interview hari ini</p>
                        </div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($scheduleInterview as $item)
                                <li class="list-group-item list-group-item-action" data-toggle="schedule" data-url="{{ route('apps.schedules.evaluation', $item->hashid) }}" style="cursor:pointer">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1 me-2">
                                            <h6 class="mb-1">{{ $item->user->name }}</h6>
                                            <p class="mb-1 text-muted">
                                                <i class="ti ti-briefcase"></i> Posisi: {{ $item->jobVacancy->title ?? '-' }}<br>
                                                <i class="ti ti-building"></i> Lokasi: {{ $item->jobVacancy->placement ?? '-' }}
                                            </p>
                                            <span class="badge bg-info rounded-pill">
                                                <i class="ti ti-calendar-event"></i>
                                                {{ $item->interview->schedule ? \Carbon\Carbon::parse($item->interview->schedule)->locale('id')->translatedFormat('d F Y H:i') : '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
    @endif
@endsection
