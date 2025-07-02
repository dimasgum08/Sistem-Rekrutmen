<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'gender' => 'required',
            'telp' => 'required',
            'address' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
            'password_confirmation.required' => 'Konfirmasi password harus diisi',
            'password_confirmation.same' => 'Konfirmasi password tidak sesuai',
            'picture.image' => 'File harus berupa image',
            'picture.mimes' => 'Image harus berupa png, jpg atau jpeg',
            'picture.max' => 'Ukuran image maks 1MB',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'address.required' => 'Alamat wajib diisi.',
            'telp.required' => 'Nomor telepon wajib diisi.',
        ];
    }
}
