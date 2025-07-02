<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\Applicant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengguna',
            'mods' => 'user',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Pengguna',
                    'is_active' => true
                ]
            ],
        ];

        return view('administrator.user.index', $data);
    }

    public function getData()
    {
        if(getInfoLogin()->roles[0]->name == 'Admin') {
            $query = User::with(['roles']);
        } else {
            $query = User::with(['roles'])->whereHas('roles', function ($q) {
                $q->where('name', 'Applicant');
            });
        }

        return DataTables::of($query)->editColumn('image', function ($user) {
            if ($user->image !== null) {
                return asset('storage/images/users/' . $user->image);
            }
        })->make();
    }
    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna',
            'mods' => 'user',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Pengguna',
                    'url' => route('apps.users')
                ],
                [
                    'title' => 'Tambah Pengguna',
                    'is_active' => true
                ],
            ],
            'roles' => Role::all(),
            'action' => route('apps.users.store'),
        ];

        return view('administrator.user.form', $data);
    }

    public function store(UserRequest $request)
    {
        try {
            $filename = null;
            if($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = 'Users_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/users'), $filename);
            }

            $applicant = null;
            if ($request->has('is_applicant') && $request->is_applicant === 'on') {
                $applicant = Applicant::create($request->only('name', 'email', 'telp', 'address', 'gender'));
            }

            $request->merge(['image' => $filename, 'password' => Hash::make($request->password), 'applicant_id' => $applicant ? $applicant->id : null]);
            $user = User::create($request->only('name', 'email', 'password', 'applicant_id','image'));
            $user->assignRole($request->roles);
            return redirect()->route('apps.users')->with(['message' => 'Pengguna berhasil ditambahkan', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Error:' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function edit(User $user)
    {
        $data = [
            'title' => 'Edit Pengguna',
            'mods' => 'user',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Pengguna',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Edit Pengguna',
                    'is_active' => true
                ],
            ],
            'user' => $user,
            'applicant' => Applicant::where('id', $user->applicant_id)->first(),
            'roles' => Role::all(),
            'action' => route('apps.users.update', $user->hashid),
        ];

        return view('administrator.user.form', $data);
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            if($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = 'Users_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/users'), $filename);
                if($user->image) {
                    File::delete(public_path('storage/images/users/'. $user->image));
                }
            } else {
                $filename = $user->image;
            }
            if ($user->applicant_id) {
                $user->applicant->update($request->only('name', 'email', 'telp','address', 'gender'));
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'applicant_id' => $user->applicant_id,
                'image' => $filename,
            ];

            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            $user->assignRole($request->roles);
            return redirect()->route('apps.users')->with(['message' => 'Pengguna berhasil diperbarui', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Error:' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(User $user)
    {
        try {
            if($user->image) {
                File::delete(public_path('storage/images/users/'. $user->image));
            }
            $user->delete();
            return $this->successResponse('Berhasil menghapus data pengguna');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
