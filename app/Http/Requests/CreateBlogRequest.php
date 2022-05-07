<?php

namespace App\Http\Requests;

use App\Base\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateBlogRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "title" => ['required', Rule::unique('blogs')],
            "text" => 'required'
        ];
    }
}
