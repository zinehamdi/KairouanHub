<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch the application locale and persist to session.
     */
    public function switch(Request $request)
    {
        $locale = $request->input('locale');
        if (in_array($locale, supported_locales())) {
            session(['locale' => $locale]);
        }
        return back();
    }
}
