<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if(getInfoLogin()->roles[0]->name == 'Applicant') {
            $schedule = Candidate::with(['user','jobVacancy'])->where('status','Interview')->where('user_id', getInfoLogin()->id)->get();
        } else {
            $schedule = Candidate::with(['user','jobVacancy'])->where('status','Interview')->whereHas('interview', function($query) {
                $query->whereDate('schedule', now()->toDateString());
            })->get();
        }

        $data = [
            'title' => 'Beranda',
            'mods' => 'dashboard',
            'breadcrumbs' => [
                [
                    'title' => 'Beranda',
                    'is_active' => true
                ],
            ],
            'applicants' => Applicant::count(),
            'jobs' => JobVacancy::count(),
            'jobsPosted' => JobVacancy::where('is_posted', 1)->count(),
            'interviews' => Candidate::where('status','Interview')->count(),
            'jobsTable' => JobVacancy::where('is_posted', 1)->orderBy('date_posted', 'desc')->limit(5)->get(),
            'candidatesInterview' => Candidate::orderBy('created_at', 'desc')->limit(5)->get(),
            'scheduleInterview' => $schedule,
            'apply' => Candidate::where('user_id', getInfoLogin()->id)->count(),
            'applyJob' => Candidate::where('user_id', getInfoLogin()->id)->limit(5)->get(),
        ];
        // dd($data);
        return view('administrator.dashboard.index', $data);
    }

    public function getDataJob()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => [
                'posted' => JobVacancy::where('is_posted', true)->count(),
                'draft' => JobVacancy::where('is_posted', false)->count(),
            ],
        ]);
    }
}
