<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Update Category Request — طلب تعديل تصنيف */
class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('update', $this->route('category')); }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('categories', 'slug')->ignore($categoryId)],
            'description' => ['nullable', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];
    }
}
