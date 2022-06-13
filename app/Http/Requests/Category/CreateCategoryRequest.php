<?php

namespace App\Http\Requests\Category;

use App\Base\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateCategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ['required', Rule::unique('categories')],
            "enable" => 'required|boolean'
        ];
    }
}
