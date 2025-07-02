<?php

namespace App\Http\Controllers\JobVacancy;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobVacancy\JobVacancyRequest;
use App\Models\Candidate;
use App\Models\Document;
use App\Models\JobVacancy;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class JobVacancyController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Lowongan Pekerjaan',
            'mods' => 'job_vacancy',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Lowongan Pekerjaan',
                    'is_active' => true
                ]
            ],
        ];

        if(getInfoLogin()->roles[0]->name == 'Applicant') {
            if(getInfoLogin()->roles[0]->name == 'HRD') {
                $query = JobVacancy::orderBy('date_posted', 'desc')->paginate(5)->withQueryString();
            } else {
                $query = JobVacancy::where('is_posted', 1)->orderBy('date_posted', 'desc')->paginate(5)->withQueryString();
                $jobIds = $query->pluck('id')->toArray();
                $appliedIds = Candidate::where('user_id', getInfoLogin()->id)->whereIn('job_vacancy_id', $jobIds)->pluck('job_vacancy_id')->toArray();
                foreach ($query as $job) {
                    $job->isApply = in_array($job->id, $appliedIds);
                    $job->is_new = Carbon::parse($job->date_posted)->gt(now()->subDays(7));
                    $job->is_expired = isset($job->deadline) ? Carbon::parse($job->deadline)->lt(Carbon::now()) : null;
                }
            }
            $data = array_merge($data, [
                'jobVacancies' => $query
            ]);
            return view('job.index', $data);
        } else {
            return view('administrator.job.index', $data);
        }
    }

    public function getData()
    {
        return DataTables::of(JobVacancy::query()->with(['candidates']))->editColumn('deadline', function ($date ) {
            return  $date->deadline ? Carbon::parse($date->deadline)->locale('id')->translatedFormat('d F Y') : '-';
        })->editColumn('date_posted', function ($date) {
            return  Carbon::parse($date->date_posted)->locale('id')->translatedFormat('d F Y');
        })->make();
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Lowongan Pekerjaan',
            'mods' => 'job_vacancy',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Lowongan Pekerjaan',
                    'url' => route('apps.job-vacancies')
                ],
                [
                    'title' => 'Tambah Lowongan Pekerjaan',
                    'is_active' => true
                ]
            ],
            'action' => route('apps.job-vacancies.store'),
        ];

        return view('administrator.job.form', $data);
    }

    public function store(JobVacancyRequest $request)
    {
        try {
            $dateRange = explode(' to ', $request->date);
            $datePosted = \Carbon\Carbon::parse($dateRange[0])->format('Y-m-d');
            $deadline = isset($dateRange[1]) ? \Carbon\Carbon::parse($dateRange[1])->format('Y-m-d') : null;

            $slug = strtolower($request->title);
            $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
            $slug = trim($slug, '-');
            $count = JobVacancy::where('slug', 'LIKE', "$slug%")->count();
            $slug = $count ? "{$slug}-{$count}" : $slug;

            $request->merge([
                'slug' => $slug,
                'date_posted' => $datePosted,
                'deadline' => $deadline,
                'is_posted' => $request->is_posted ? 1 : 0
            ]);

            JobVacancy::create($request->only(['title', 'slug', 'content', 'date_posted', 'deadline', 'is_posted', 'placement']));

            return redirect()->route('apps.job-vacancies')->with(['message' => 'Lowongan pekerjaan berhasil ditambahkan', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Error:' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function posted(JobVacancy $jobVacancy)
    {
        try {
            $jobVacancy->update(['is_posted' => 1]);
            return $this->successResponse('Lowongan pekerjaan berhasil diposting');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function edit(JobVacancy $jobVacancy)
    {
        $dateRange = isset($jobVacancy->date_posted, $jobVacancy->deadline) ? $jobVacancy->date_posted . ' to ' . $jobVacancy->deadline : (isset($jobVacancy->date_posted) ? $jobVacancy->date_posted : null);
        $data = [
            'title' => 'Edit Lowongan Pekerjaan',
            'mods' => 'job_vacancy',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Lowongan Pekerjaan',
                    'url' => route('apps.job-vacancies')
                ],
                [
                    'title' => 'Edit Lowongan Pekerjaan',
                    'is_active' => true
                ]
            ],
            'date' => $dateRange,
            'jobVacancy' => $jobVacancy,
            'action' => route('apps.job-vacancies.update', $jobVacancy->hashid),
        ];

        return view('administrator.job.form', $data);
    }

    public function update(JobVacancyRequest $request, JobVacancy $jobVacancy)
    {
        try {
            $dateRange = explode(' to ', $request->date);
            $datePosted = \Carbon\Carbon::parse($dateRange[0])->format('Y-m-d');
            $deadline = isset($dateRange[1]) ? \Carbon\Carbon::parse($dateRange[1])->format('Y-m-d') : null;

            $slug = strtolower($request->title);
            $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
            $slug = trim($slug, '-');
            $count = JobVacancy::where('slug', 'LIKE', "$slug%")->count();
            $slug = $count ? "{$slug}-{$count}" : $slug;

            $request->merge([
                'slug' => $slug,
                'date_posted' => $datePosted,
                'deadline' => $deadline,
                'is_posted' => $request->is_posted ? 1 : 0
            ]);

            $jobVacancy->update($request->only(['title', 'slug', 'content', 'date_posted', 'deadline', 'is_posted', 'placement']));

            return redirect()->route('apps.job-vacancies')->with(['message' => 'Lowongan pekerjaan berhasil diperbarui', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Error:' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(JobVacancy $jobVacancy)
    {
        try {
            $jobVacancy->delete();
            return $this->successResponse('Lowongan pekerjaan berhasil dihapus');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function detail($slug)
    {
        $jobVacancy = JobVacancy::with('candidates')->where('slug', $slug)->firstOrFail();
        $jobVacancy->is_new = Carbon::parse($jobVacancy->date_posted)->gt(now()->subDays(7));
        $jobVacancy->is_expired = isset($jobVacancy->deadline) ? Carbon::parse($jobVacancy->deadline)->lt(now()) : false;
        $isApply = Candidate::where('user_id', getInfoLogin()->id)->where('job_vacancy_id', $jobVacancy->id)->exists();

        $data = [
            'title' => 'Detail Lowongan Pekerjaan',
            'mods' => 'job_vacancy',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Lowongan Pekerjaan',
                    'url' => route('apps.job-vacancies')
                ],
                [
                    'title' => 'Detail Lowongan Pekerjaan',
                    'is_active' => true
                ]
            ],
            'job' => $jobVacancy,
            'isNew' => $jobVacancy->is_new,
            'isExpired' => $jobVacancy->is_expired,
            'isApply' => $isApply,
        ];

        return view('job.detail', $data);
    }


    public function apply(JobVacancy $jobVacancy, Request $request)
    {
        $request->validate([
            'cv_document' => 'required|mimes:pdf|max:2048',
            'cover_letter_document' => 'required|mimes:pdf|max:2048',
        ],[
            'cv_document.required' => 'Upload CV anda',
            'cover_letter_document.required' => 'Upload Surat Lamaran anda',
            'cv_document.mimes' => 'File harus berupa pdf',
            'cover_letter_document.mimes' => 'File harus berupa pdf',
            'cv_document.max' => 'Ukuran file maks 2MB',
            'cover_letter_document.max' => 'Ukuran file maks 2MB',
        ]);

        try {
            DB::beginTransaction();
            $cvname = null;
            if($request->hasFile('cv_document')) {
                $file = $request->file('cv_document');
                $cvname = 'CV_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/documents'), $cvname);
            }

            $coverLetterName = null;
            if($request->hasFile('cover_letter_document')) {
                $file = $request->file('cover_letter_document');
                $coverLetterName = 'Cover_Letter'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/documents'), $coverLetterName);
            }

            $request->merge(['job_vacancy_id' => $jobVacancy->id,'user_id' => getInfoLogin()->id,'status' => 'Process',]);
            $candidate = Candidate::create($request->only(['user_id', 'job_vacancy_id', 'status']));
            Document::create(['candidate_id' => $candidate->id,'cv' => $cvname,'cover_letter' => $coverLetterName,]);

            if(getInfoLogin()->roles[0]->name == 'Applicant') {
                $roles = ['Admin', 'HRD'];
                $fromUser = getInfoLogin();
                $fromRole = $fromUser->roles[0]->id;
                foreach ($roles as $roleName) {
                    $role = Role::where('name', $roleName)->first();
                    if (!$role) continue;
                    Notification::create([
                        'title' => 'Pelamar Baru',
                        'description' => 'Ada kandidat baru yang ingin melamar pekerjaan sebagai ' . $jobVacancy->title . ' dengan nama ' . getInfoLogin()->name,
                        'url_path' => route('apps.candidates.detail', $candidate->hashid),
                        'to_user_id' => null,
                        'to_role_id' => $role->id,
                        'from_user_id' => $fromUser->id,
                        'from_role_id' => $fromRole,
                        'is_read' => false,
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with(['message' => 'Berhasil melamar pekerjaan, silahkan menunggu konfirmasi dari pihak perusahaan', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['message' => 'Error:' . $e->getMessage(), 'type' => 'error']);
        }
    }

}
