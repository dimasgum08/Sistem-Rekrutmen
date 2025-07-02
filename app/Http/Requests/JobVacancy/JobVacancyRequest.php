<?php

namespace App\Http\Requests\JobVacancy;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyRequest extends FormRequest
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
            'title' => 'required',
            'date' => 'required',
            'placement' => 'required',
            'content' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Posisi harus diisi',
            'placement.required' => 'Penempatan harus diisi',
            'date.required' => 'Tanggal harus diisi',
            'content.required' => 'Konten harus diisi',
        ];
    }
}
