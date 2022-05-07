<?php

namespace App\Http\Requests;

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

    /**
     * @return array
     */
    public function getFillable(): array
    {
        return [
            "title" => $this->title,
            "text" => $this->text,
        ];
    }
}
