<?php

use App\Models\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

if (!function_exists('getInfoLogin')) {
    function getInfoLogin()
    {
        return Auth::user();
    }
}

if (!function_exists('getAuthPermissions')) {
    function getAuthPermissions()
    {
        if(Auth::check()) {
            $permissionsName = auth()->user()->getAllPermissions()->map(function ($perm) {
                return $perm->name;
            });
            return implode(',', $permissionsName->toArray());
        }

        return null;
    }
}

if (!function_exists('getNotification')) {
    function getNotification()
    {
        $user = Auth::user();
        $roleIds = $user->roles->pluck('id')->toArray();
        $query = Notification::with(['fromUser','fromRole','toUser', 'toRole'])->where(function ($q) use ($user, $roleIds) {
            $q->where('to_user_id', $user->id)->orWhere(function ($subQ) use ($roleIds) {
                $subQ->whereNull('to_user_id')->whereIn('to_role_id', $roleIds);
            });
        });

        return $query->orderByRaw('is_read ASC')->orderBy('created_at', 'desc')->get();

    }
}

if (!function_exists('diffForHumansId')) {
    function diffForHumansId($date)
    {
        $carbon = Carbon::parse($date)->locale('id');
        $diff = $carbon->diffForHumans();

        $replace = [
            'seconds' => 'detik',
            'second' => 'detik',
            'minutes' => 'menit',
            'minute' => 'menit',
            'hours' => 'jam',
            'hour' => 'jam',
            'days' => 'hari',
            'day' => 'hari',
            'weeks' => 'minggu',
            'week' => 'minggu',
            'months' => 'bulan',
            'month' => 'bulan',
            'years' => 'tahun',
            'year' => 'tahun',
            'after' => 'yang lalu',
            'before' => 'yang lalu',
            'from now' => 'dari sekarang',
        ];

        return strtr($diff, $replace);
    }
}

if (!function_exists('markAllNotificationsAsReadByHashids')) {
    function markAllNotificationsAsReadByHashids(array $hashids)
    {
        $ids = collect($hashids)
            ->map(fn ($hashid) => Hashids::decode($hashid)[0] ?? null)
            ->filter()
            ->all();

        return Notification::whereIn('id', $ids)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}

if (!function_exists('deleteAllNotificationsByHashids')) {
    function deleteAllNotificationsByHashids(array $hashids)
    {
        $ids = collect($hashids)
            ->map(fn ($hashid) => Hashids::decode($hashid)[0] ?? null)
            ->filter()
            ->all();

        return Notification::whereIn('id', $ids)->delete();
    }
}
