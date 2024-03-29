<?php

namespace App\Http\Requests;

use App\Models\DiagnosisCategory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDiagnosisCategoryRequest extends FormRequest
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
        $rules = DiagnosisCategory::$rules;
        $rules['name'] = 'required|is_unique:diagnosis_categories,name,'.$this->route('diagnosisCategory')->id;

        return $rules;
    }
}
