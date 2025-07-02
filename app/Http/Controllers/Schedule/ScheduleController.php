<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\ScheduleRequest;
use App\Models\Candidate;
use App\Models\Criteria;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    public function index()
    {
        $isAdmin = getInfoLogin()->roles[0]->name === 'Admin' || getInfoLogin()->roles[0]->name === 'HRD';

        $data = [
            'title' => 'Jadwal Interview',
            'mods' => 'schedules',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Jadwal Interview',
                    'is_active' => true
                ],
            ],
        ];
        $view = $isAdmin ? 'administrator.schedule.index' : 'schedule.index';

        return view($view, $data);
    }


    public function getData()
    {
        return DataTables::of(Candidate::query()->with(['user','jobVacancy','interview'])->whereHas('interview', function($query){
            $query->where('schedule', '!=', null);
        }))->editColumn('interview.schedule', function ($candidate) {
            return isset($candidate->interview->schedule) ? Carbon::parse($candidate->interview->schedule)->locale('id')->translatedFormat('d F Y') : '-';
        })->editColumn('user.image', function ($candidate) {
            return isset($candidate->user->image) ? asset('storage/images/users/' . $candidate->user->image) : null;
        })->make();
    }

    public function evaluation(Candidate $candidate)
    {
        $data = [
            'title' => 'Evaluasi Kandidat',
            'mods' => 'schedules',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Jadwal Interview',
                    'url' => route('apps.schedules')
                ],
                [
                    'title' => 'Evaluasi Kandidat',
                    'is_active' => true
                ],
            ],
            'candidate' => $candidate,
            'criteria' => Criteria::where('candidate_id', $candidate->id)->first(),
        ];

        return view('administrator.schedule.evaluation', $data);
    }

    public function update(ScheduleRequest $request, Candidate $candidate)
    {
        try {
            $criteria = Criteria::where('candidate_id', $candidate->id)->first();
            if ($criteria) {
                $criteria->update($request->only(['ethics', 'discipline', 'accuracy', 'cv']));
            } else {
                $request->merge(['candidate_id' => $candidate->id]);
                $criteria = Criteria::create($request->only(['candidate_id', 'ethics', 'discipline', 'accuracy', 'cv']));
            }
            $candidate->update($request->only('status'));

            $this->sendNotification($candidate, $request->status);

            return redirect()->route('apps.schedules')->with(['message' => 'Evaluasi kandidat berhasil disimpan', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Error:' . $e->getMessage(), 'type' => 'error']);
        }
    }

    private function sendNotification($candidate, $status)
    {
        $title = '';
        $message = '';

        switch ($status) {
            case 'Accept':
                $title = 'Selamat!';
                $message = 'Kamu diterima sebagai kandidat yang lolos seleksi. Tim kami akan segera menghubungi kamu untuk proses selanjutnya.';
                break;
            case 'Reject':
                $title = 'Mohon Maaf';
                $message = 'Kami mengucapkan terima kasih atas partisipasi kamu. Namun, saat ini kamu belum lolos seleksi.';
                break;
            case 'Consider':
                $title = 'Pertimbangan Lebih Lanjut';
                $message = 'Terima kasih atas partisipasi. Kamu sedang dalam tahap pertimbangan. Kami akan segera menghubungi jika ada kabar selanjutnya.';
                break;
            default:
                $title = 'Status Tidak Dikenali';
                $message = 'Status kandidat tidak diketahui.';
                break;
        }

        Notification::create([
            'title' => $title,
            'description' => $message,
            'url_path' => route('apps.apply.jobs'),
            'to_user_id' => $candidate->user->id,
            'to_role_id' => $candidate->user->roles[0]->id,
            'from_user_id' => getInfoLogin()->id,
            'from_role_id' => getInfoLogin()->roles[0]->id,
            'is_read' => false,
        ]);
    }
}
