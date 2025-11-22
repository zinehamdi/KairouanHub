<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function switch($locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'ar', 'fr'])) {
            abort(404);
        }
        
        // Store locale in session
        Session::put('locale', $locale);
        
        // Set app locale
        app()->setLocale($locale);
        
        // Redirect back
        return redirect()->back();
    }
}
