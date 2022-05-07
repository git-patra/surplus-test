<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "code" => ['required', Rule::unique('models')->whereNull('deleted_at')],
            "name" => 'required'
        ];
    }

    /**
     * @return array
     */
    public function getFillable(): array
    {
        return [
            "code" => $this->code,
            "name" => $this->name,
        ];
    }
}
