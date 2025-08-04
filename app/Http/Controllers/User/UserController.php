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
        if (getInfoLogin()->roles[0]->name == 'Admin') {
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
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = 'Users_' . rand(0, 999999999) . '_' . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/users'), $filename);
            }

            $applicant = null;
            if ($request->has('is_applicant') && $request->is_applicant === 'on') {
                $applicant = Applicant::create($request->only('name', 'email', 'telp', 'address', 'gender'));
            }

            $request->merge(['image' => $filename, 'password' => Hash::make($request->password), 'applicant_id' => $applicant ? $applicant->id : null]);
            $user = User::create($request->only('name', 'email', 'password', 'applicant_id', 'image'));
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
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = 'Users_' . rand(0, 999999999) . '_' . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/users'), $filename);
                if ($user->image) {
                    File::delete(public_path('storage/images/users/' . $user->image));
                }
            } else {
                $filename = $user->image;
            }
            if ($user->applicant_id) {
                $user->applicant->update($request->only('name', 'email', 'telp', 'address', 'gender'));
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
            if ($user->image) {
                File::delete(public_path('storage/images/users/' . $user->image));
            }
            $user->delete();
            return $this->successResponse('Berhasil menghapus data pengguna');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function editProfile()
    {
        $data = [
            'title' => 'Edit Profil',
            'mods' => 'user',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Edit Profil',
                    'is_active' => true
                ],
            ],
            'user' => getInfoLogin(),
        ];

        return view('administrator.profile.index', $data);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'telp' => 'required|string|max:20',
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',

            'old_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|required_with:old_password|same:confirm_password|min:6',
            'confirm_password' => 'nullable|required_with:new_password|same:new_password',
        ], [
            'old_password.current_password' => 'Password lama tidak sesuai.',
            'new_password.same' => 'Konfirmasi password tidak cocok.',
            'confirm_password.same' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $user = auth()->user();
            $applicant = Applicant::findOrFail($user->applicant_id);
            $applicant->update([
                'name' => $request->name,
                'telp' => $request->telp,
                'address' => $request->address,
            ]);

            $updateUserData = ['name' => $request->name];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = 'User_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/users'), $filename);

                if ($user->image && File::exists(public_path('storage/images/users/' . $user->image))) {
                    File::delete(public_path('storage/images/users/' . $user->image));
                }

                $updateUserData['image'] = $filename;
            }
            if ($request->filled('new_password')) {
                $updateUserData['password'] = Hash::make($request->new_password);
            }

            $user->update($updateUserData);

            return redirect()->back()->with(['message' => 'Profil berhasil diperbarui', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'type' => 'error']);
        }
    }
}
