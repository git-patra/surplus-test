<?php

namespace App\Http\Requests\Image;

use App\Base\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateImageRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ['required', Rule::unique('images')->ignore($this->id, 'id')],
            'file_image' => 'required|mimes:png,jpg,jpeg',
            "enable" => 'required|boolean'
        ];
    }
}
