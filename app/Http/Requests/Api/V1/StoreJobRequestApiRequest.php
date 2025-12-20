<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequestApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'provider_id' => ['nullable', 'exists:provider_profiles,id'],
            'details' => ['required', 'string', 'max:2000'],
            'city' => ['required', 'string', 'max:120'],
            'scheduled_date' => ['nullable', 'date', 'after:now'],
            'photos' => ['nullable', 'array', 'max:4'],
        ];
    }
}
