<?php

namespace App\Http\Requests;

use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
        $rules = Account::$rules;
        $rules['name'] = 'required|is_unique:accounts,name,'.$this->route('account')->id;

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->sanitize();
    }

    public function sanitize()
    {
        $input = $this->all();
        $input['status'] = ! empty($input['status']) ? 1 : 0;
        $this->replace($input);
    }
}
