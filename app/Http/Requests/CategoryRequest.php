<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');
        return [
            'name' => 'required|string|min:3|max:255|unique:categories,id, '. $id,
            'parent_id' => 'required|integer|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'status' => 'in:Active,Draft'
        ];
    }
}
