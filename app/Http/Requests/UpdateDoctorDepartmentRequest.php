<?php

namespace App\Http\Requests;

use App\Models\DoctorDepartment;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorDepartmentRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $rules = DoctorDepartment::$rules;
        $rules['title'] = 'required|is_unique:doctor_departments,title,'.$this->route('doctorDepartment')->id;

        return $rules;
    }
}
