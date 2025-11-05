<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Update Service Request — طلب تعديل خدمة */
class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()->can('update', $this->route('service')); }

    public function rules(): array
    {
        $serviceId = $this->route('service')?->id;
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('services', 'slug')->ignore($serviceId)],
            'summary' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
