<?php

namespace App\Infrastructure\Http\Requests\Onboarding;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProfileRequest extends FormRequest
{
    public function authorize(): bool { return Auth::check(); }
    public function rules(): array
    {
        return [
            'category_id' => ['required','integer','exists:categories,id'],
            'display_name' => ['required','string','max:120'],
            'city' => ['required','string','max:120'],
            'bio' => ['nullable','string','max:1200'],
            'website' => ['nullable','url'],
            'skills' => ['nullable','array','max:20'],
            'skills.*' => ['string','max:40'],
            'cities' => ['nullable','array','max:20'],
            'cities.*' => ['string','max:60'],
            'social' => ['nullable','array'],
        ];
    }
}
