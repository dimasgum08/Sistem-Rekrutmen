<div class="border rounded d-flex justify-content-between align-items-start p-3 mb-3 shadow-sm hovering">
    <div class="d-flex gap-3 align-items-start">
        <div class="rounded bg-light d-flex justify-content-center align-items-center" style="width: 48px; height: 48px;">
            <i class="ti ti-building fs-4 text-secondary"></i>
        </div>
        <div>
            <span
                class="badge mb-1 {{ $item->status == 'Process' ? 'bg-warning' : ($item->status == 'Interview' ? 'bg-info' : ($item->status == 'Accept' ? 'bg-success' : ($item->status == 'Reject' ? 'bg-danger' : ($item->status == 'Consider' ? 'bg-warning' : 'bg-secondary')))) }}">
                {{ $item->status == 'Process' ? 'Menunggu' : ($item->status == 'Interview' ? 'Interview' : ($item->status == 'Accept' ? 'Diterima' : ($item->status == 'Reject' ? 'Ditolak' : ($item->status == 'Consider' ? 'Dipertimbangkan' : $item->status)))) }}
            </span>
            <h6 class="mb-1">{{ $item->jobVacancy->title }}</h6>
            <div class="text-muted small">{{ $item->jobVacancy->placement }}</div>
            <div class="text-muted small">Applied on 18 Agustus 2022</div>
        </div>
    </div>
    <div class="text-end">
        @if ($item->status == 'Interview')
            <button
                class="btn btn-outline-primary btn-sm mb-2 btn-detail"
                data-position="{{ $item->jobVacancy->title }}"
                data-placement="{{ $item->jobVacancy->placement }}"
                data-schedule="{{ \Carbon\Carbon::parse($item->date)->locale('id')->translatedFormat('d F Y H:i') }}"
                data-location="{{ $item->location }}"
                data-interviewer="{{ $item->interviewer }}"
                data-note="{{ $item->note }}"
            >
                Lihat Jadwal
            </button>
        @endif

        <br>
        @php
            $now = \Carbon\Carbon::now();
        @endphp

        @if($item->jobVacancy->deadline < $now)
            <div class="small text-danger mt-2">Lowongan telah ditutup</div>
        @endif
    </div>
</div>

