<?php

namespace App\Infrastructure\Http\Requests\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/** EN: Validation for creating job requests. AR: التحقق لإنشاء طلب خدمة */
class StoreJobRequestRequest extends FormRequest
{
    public function authorize(): bool { return Auth::check(); }
    public function rules(): array
    {
        return [
            'category_id' => ['required','exists:categories,id'],
            'service_id' => ['nullable','exists:services,id'],
            'details' => ['required','string','max:2000'],
            'city' => ['required','string','max:120'],
            'photos' => ['nullable','array','max:4'],
            'photos.*' => ['file','mimes:jpeg,png,webp','max:2048'],
        ];
    }
}
