<?php

namespace App\Infrastructure\Http\Requests\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/** EN: Validation for creating/updating offers. AR: التحقق لإنشاء/تحديث العرض */
class StoreOfferRequest extends FormRequest
{
    public function authorize(): bool { return Auth::check(); }
    public function rules(): array
    {
        return [
            'note' => ['nullable','string','max:1000'],
            'eta_days' => ['nullable','integer','min:1'],
            'price' => ['nullable','integer','min:0'],
        ];
    }
}
