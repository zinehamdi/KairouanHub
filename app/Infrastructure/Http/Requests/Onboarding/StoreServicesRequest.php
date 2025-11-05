<?php

namespace App\Infrastructure\Http\Requests\Onboarding;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreServicesRequest extends FormRequest
{
    public function authorize(): bool { return Auth::check(); }
    public function rules(): array
    {
        return [
            'services' => ['required','array','min:1'],
            'services.*.id' => ['required','integer','exists:services,id'],
            'services.*.price_min' => ['nullable','integer','min:0'],
            'services.*.price_max' => ['nullable','integer','min:0','gte:services.*.price_min'],
        ];
    }
}
