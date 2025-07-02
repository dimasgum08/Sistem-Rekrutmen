<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    private $routeName;

    public function __construct()
    {
        $this->routeName = request()->route()->getName();
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                $this->routeName == 'apps.users.store' ? 'unique:users,email' : Rule::unique('users', 'email')->ignoreModel($this->user)
            ],
            'password' => $this->routeName == 'apps.users.store' ? 'required' : 'nullable',
            'confirm_password' => $this->routeName == 'apps.users.store' ? 'required|same:password' : 'nullable|same:password',
            'roles' => 'required',
            'patient_id' => 'nullable',
            'address' => 'nullable',
            'gender' => 'nullable',
            'telp' => 'nullable',
            'picture' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah ada',
            'password.required' => 'Password harus diisi',
            'confirm_password.required' => 'Konfirmasi password harus diisi',
            'confirm_password.same' => 'Konfirmasi password tidak sesuai',
            'roles.required' => 'Role harus dipilih',
            'picture.image' => 'File harus berupa image',
            'picture.mimes' => 'Image harus berupa png, jpg atau jpeg',
            'picture.max' => 'Ukuran image maks 1MB'
        ];
    }
}
