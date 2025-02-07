<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShoppingListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->request->get('id');

        return [
            'title' => [
                'required',
                Rule::unique('shopping_lists', 'title')->ignore($id),
                ],
            'items' => 'required|array',
            'items.*' => 'required'
        ];
    }

}
