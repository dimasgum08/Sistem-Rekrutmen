<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
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
            'ethics'         => 'required|numeric|min:1|max:100',
            'discipline'  => 'required|numeric|min:1|max:100',
            'accuracy'      => 'required|numeric|min:1|max:100',
            'cv'            => 'required',
            'status'        => 'required',
        ];
    }

     public function messages(): array
    {
        return [
            'etika.required'         => 'Nilai etika wajib diisi.',
            'etika.numeric'          => 'Nilai etika harus berupa angka.',
            'etika.min'              => 'Nilai etika minimal 1.',
            'etika.max'              => 'Nilai etika maksimal 100.',

            'kedisiplinan.required'  => 'Nilai kedisiplinan wajib diisi.',
            'kedisiplinan.numeric'   => 'Nilai kedisiplinan harus berupa angka.',
            'kedisiplinan.min'       => 'Nilai kedisiplinan minimal 1.',
            'kedisiplinan.max'       => 'Nilai kedisiplinan maksimal 100.',

            'menjawab.required'      => 'Nilai ketepatan menjawab wajib diisi.',
            'menjawab.numeric'       => 'Nilai ketepatan menjawab harus berupa angka.',
            'menjawab.min'           => 'Nilai ketepatan menjawab minimal 1.',
            'menjawab.max'           => 'Nilai ketepatan menjawab maksimal 100.',

            'cv.required'            => 'Nilai CV wajib diisi.',
            'cv.numeric'             => 'Nilai CV harus berupa angka.',
            'cv.min'                 => 'Nilai CV minimal 1.',
            'cv.max'                 => 'Nilai CV maksimal 100.',

            'status.required'        => 'Status pelamar wajib dipilih.',
        ];
    }
}
