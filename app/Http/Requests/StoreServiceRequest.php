<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Store Service Request — طلب إضافة خدمة */
class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('create', \App\Models\Service::class); }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:services,slug'],
            'summary' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
