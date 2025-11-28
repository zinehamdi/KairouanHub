<?php

namespace App\Infrastructure\Http\Requests\Onboarding;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePhotosRequest extends FormRequest
{
    public function authorize(): bool { return Auth::check(); }
    public function rules(): array
    {
        $max = config('appsettings.providers.max_gallery', 6);
        return [
            'photos' => ['nullable','array','max:'.$max],
            'photos.*' => ['file','image','max:10240'],
        ];
    }
}
