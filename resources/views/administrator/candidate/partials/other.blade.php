 <div class="card-header bg-white border-bottom">
    <h5 class="mb-0">Pelamar Lainnya untuk Lowongan yang Sama</h5>
</div>
<div class="card-body p-0">
    <div class="list-group list-group-flush">
        @foreach ($otherCandidate as $item)
            <a href="{{ route('apps.candidates.detail', $item->hashid) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                            <img src="{{ $item->user->image ? asset('storage/images/users/' . $item->user->image) : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($item->user->name) }}" class="rounded-circle" width="40" alt="">
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $item->user->name }}</div>
                        <small class="text-muted">{{ $item->user->email }}</small>
                    </div>
                </div>
                <span class="badge
                    @if($item->status == 'Process') bg-warning
                    @elseif($item->status == 'Interview') bg-info text-dark
                    @elseif($item->status == 'Accept') bg-success
                    @else bg-danger @endif">
                    {{ $item->status === 'Process' ? 'Menunggu' : ($item->status === 'Interview' ? 'Interview' : ($item->status === 'Accept' ? 'Diterima' : 'Ditolak')) }}
                </span>
            </a>
        @endforeach
    </div>
    </div>
