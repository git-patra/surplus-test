<?php

namespace App\Http\Requests;

use app\Base\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "title" => ['required', Rule::unique('blogs')->ignore($this->id, 'id')],
            "text" => 'required'
        ];
    }
}
