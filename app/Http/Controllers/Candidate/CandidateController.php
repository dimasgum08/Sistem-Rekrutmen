<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CandidateController extends Controller
{
    public function index()
    {
        $isAdmin = getInfoLogin()->roles[0]->name === 'Admin' || getInfoLogin()->roles[0]->name === 'HRD';

        $candidates = Candidate::where('user_id', getInfoLogin()->id)->with(['jobVacancy', 'user'])->orderBy('created_at', 'desc')->get();
        $interview = $candidates->filter(fn($item) => $item->status === 'Interview');
        $rejected = $candidates->filter(fn($item) => $item->status === 'Reject');
        $accepted = $candidates->filter(fn($item) => $item->status === 'Accepted');
        $data = [
            'title' => 'Lamaran Saya',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => $isAdmin ? 'Pelamar' : 'Lamaran Saya',
                    'is_active' => true
                ]
            ],
            'all' => $candidates,
            'interview' => $interview,
            'rejected' => $rejected,
            'accepted' => $accepted,
            'mods' => 'candidates',
        ];
        $view = $isAdmin ? 'administrator.candidate.index' : 'candidate.index';
        return view($view, $data);
    }


    public function getData()
    {
        return DataTables::of(Candidate::query()->with(['jobVacancy', 'user']))->editColumn('user.image', function ($candidate) {
            return isset($candidate->user->image) ? asset('storage/images/users/' . $candidate->user->image) : null;
        })->make();
    }

    public function detail(Candidate $candidate)
    {
        $data = [
            'title' => 'Detail Pelamar' . ' - ' . $candidate->jobVacancy->title,
            'mods' => 'candidates',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Pelamar',
                    'url' => route('apps.candidates')
                ],
                [
                    'title' => 'Detail Pelamar',
                    'is_active' => true
                ]
            ],
            'candidate' => $candidate,
            'interview' => Interview::where('candidate_id', $candidate->id)->first(),
            'otherCandidate' => Candidate::where('job_vacancy_id', $candidate->job_vacancy_id)->where('id', '!=', $candidate->id)->with('user')->whereIn('status',['Process'])->get(),
        ];

        return view('administrator.candidate.detail', $data);
    }

    public function updateStatus(Candidate $candidate, Request $request)
    {
        $request->validate([
            'status' => 'required',
            'schedule' => 'required_if:status,Interview',
            'location' => 'required_if:status,Interview',
            'note' => 'nullable',
            'interviewer' => 'nullable',
        ], [
            'status.required' => 'Pilih status pelamar',
            'schedule.required_if' => 'Pilih jadwal interview',
            'location.required_if' => 'Masukkan lokasi interview',
        ]);

        try {
            $candidate->update([
                'status' => $request->status,
            ]);

            if ($request->status === 'Interview') {
                $interview = Interview::where('candidate_id', $candidate->id)->first();

                if ($interview) {
                    $interview->update([
                        'schedule' => Carbon::parse($request->schedule),
                        'location' => $request->location,
                        'note' => $request->note,
                        'interviewer' => $request->interviewer,
                    ]);
                    $this->sendNotification($candidate, 'Interview', true);
                } else {
                    Interview::create([
                        'candidate_id' => $candidate->id,
                        'schedule' => Carbon::parse($request->schedule),
                        'location' => $request->location,
                        'note' => $request->note,
                        'interviewer' => $request->interviewer,
                    ]);
                    $this->sendNotification($candidate, 'Interview', false);
                }
            } else {
                $this->sendNotification($candidate, $request->status);
            }

            return redirect()->back()->with(['message' => 'Status pelamar berhasil diperbarui','type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Error: ' . $e->getMessage(),'type' => 'error']);
        }
    }


    private function sendNotification(Candidate $candidate, $status, $isUpdated = false)
    {
        $title = '';
        $description = '';
        $url_path = route('apps.apply.jobs');
        if ($status === 'Reject') {
            $title = 'Lamaran Anda Ditolak';
            $description = 'Maaf, lamaran Anda untuk posisi ' . $candidate->jobVacancy->title . ' telah ditolak.';
            $url_path = null;
        } elseif ($status === 'Accept') {
            $title = 'Lamaran Anda Diterima';
            $description = 'Selamat! Lamaran Anda untuk posisi ' . $candidate->jobVacancy->title . ' telah diterima.';
        } elseif ($status === 'Interview') {
            $title = $isUpdated ? 'Perubahan Jadwal Interview' : 'Jadwal Interview Telah Ditentukan';
            $description = ($isUpdated ? 'Jadwal interview Anda diperbarui' : 'Anda dijadwalkan interview') . ' untuk posisi ' . $candidate->jobVacancy->title . '.';
            if ($candidate->interview) {
                $description .= ' Jadwal: ' . Carbon::parse($candidate->interview->schedule)->format('d M Y') . ', Lokasi: ' . $candidate->interview->location . '.';
            }
        } else {
            return;
        }

        Notification::create([
            'title' => $title,
            'description' => $description,
            'url_path' => $url_path,
            'to_user_id' => $candidate->user_id,
            'to_role_id' => $candidate->user->roles[0]->id ?? null,
            'from_user_id' => getInfoLogin()->id,
            'from_role_id' => getInfoLogin()->roles[0]->id,
            'is_read' => false,
        ]);
    }

}
