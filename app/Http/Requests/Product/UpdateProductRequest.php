<?php

namespace App\Http\Requests\Product;

use App\Base\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ['required', Rule::unique('products')->ignore($this->id, 'id')],
            "enable" => 'required|boolean'
        ];
    }
}
