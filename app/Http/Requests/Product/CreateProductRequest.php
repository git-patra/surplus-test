<?php

namespace App\Http\Requests\Product;

use App\Base\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateProductRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ['required', Rule::unique('products')],
            "enable" => 'required|boolean'
        ];
    }
}
