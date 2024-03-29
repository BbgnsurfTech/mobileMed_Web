<?php

namespace App\Http\Requests;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
        $rules = Brand::$rules;
        $rules['email'] = 'nullable|email|is_unique:brands,email,'.$this->route('brand')->id;
        $rules['name'] = 'required|is_unique:brands,name,'.$this->route('brand')->id;

        return $rules;
    }
}
