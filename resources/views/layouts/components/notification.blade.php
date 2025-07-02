@php
    $notifications = getNotification();
    $unreadCount = $notifications->where('is_read', false)->count();
@endphp

@if (getInfoLogin()->roles[0]->name == 'Admin')
<li class="dropdown pc-h-item">
    <a class="notif-head dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <span class="notif-icon">
            <i class="ti ti-bell"></i>
        </span>
        @if ($unreadCount > 0)
            <span class="notif-badge">{{ $unreadCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-end p-3 shadow rounded-4 notification-dropdown" style="width: 340px;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Notifikasi</strong>
            <a href="#" class="small text-primary text-decoration-none mark-all" data-hashids='@json($notifications->pluck("hashid"))'>Tandai semua telah dibaca</a>
        </div>
        <div style="max-height: 400px; overflow-y: auto;">
            @forelse ($notifications as $notification)
                <a href="{{ $notification->url_path }}" class="text-decoration-none text-dark">
                    <div class="border rounded p-3 mb-2 d-block @if(!$notification->is_read) bg-light @endif">
                        <div class="d-flex justify-content-between">
                            <strong><i class="ti ti-mail me-1"></i>{{ $notification->title }}</strong>
                            <small class="text-muted">{{ diffForHumansId($notification->created_at) }}</small>
                        </div>
                        <div class="text-muted small mt-1">
                            {{ $notification->description }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center text-muted small">Tidak ada notifikasi</div>
            @endforelse
        </div>
        @if ($notifications->isNotEmpty())
            <div class="text-center mt-2">
                <a href="#" class="text-danger small delete-all" data-hashids='@json($notifications->pluck("hashid"))'>Hapus semua notifikasi</a>
            </div>
        @endif
    </div>
</li>
@else
<div class="dropdown">
    <a class="nav-link position-relative text-white" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ti ti-bell fs-5"></i>
        @if ($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $unreadCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-end p-3 shadow rounded-4 notification-dropdown" style="width: 340px;" aria-labelledby="notifDropdown">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Notifikasi</strong>
            <a href="#" class="small text-primary text-decoration-none mark-all" data-hashids='@json($notifications->pluck("hashid"))'>Tandai semua telah dibaca</a>
        </div>
        <div style="max-height: 400px; overflow-y: auto;">
            @forelse ($notifications as $notification)
                <a href="{{ $notification->url_path }}" class="text-decoration-none text-dark">
                    <div class="border rounded p-3 mb-2 d-block @if(!$notification->is_read) bg-light @endif">
                        <div class="d-flex justify-content-between">
                            <strong><i class="ti ti-mail me-1"></i>{{ $notification->title }}</strong>
                            <small class="text-muted">{{ diffForHumansId($notification->created_at) }}</small>
                        </div>
                        <div class="text-muted small mt-1">
                            {{ $notification->description }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center text-muted small">Tidak ada notifikasi</div>
            @endforelse
        </div>
        @if ($notifications->isNotEmpty())
            <div class="text-center mt-2">
                <a href="#" class="text-danger small delete-all" data-hashids='@json($notifications->pluck("hashid"))'>Hapus semua notifikasi</a>
            </div>
        @endif
    </div>
</div>
@endif

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnMarkReadEls = document.querySelectorAll('.mark-all');
        const btnDeleteAllEls = document.querySelectorAll('.delete-all');

        async function postToHelper(action, hashids) {
            try {
                const response = await fetch(`${BASE_URL}/apps/notifications`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    body: JSON.stringify({
                        action: action,
                        hashids: hashids,
                    }),
                });

                const result = await response.json();
                if (result.success) {
                    location.reload();
                } else {
                    alert('Gagal memproses data');
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan saat memproses.');
            }
        }

        // Loop semua tombol mark-all
        btnMarkReadEls.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const hashids = JSON.parse(this.dataset.hashids || '[]');
                postToHelper('mark_read', hashids);
            });
        });

        // Loop semua tombol delete-all
        btnDeleteAllEls.forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (confirm('Yakin ingin menghapus semua notifikasi?')) {
                    const hashids = JSON.parse(this.dataset.hashids || '[]');
                    postToHelper('delete', hashids);
                }
            });
        });
    });
</script>

@endsection
