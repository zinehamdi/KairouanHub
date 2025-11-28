<?php

namespace App\Http\Controllers;

use App\Models\ProviderProfile;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $providers = ProviderProfile::where('status', 'approved')->get();

        $content = view('sitemap', compact('providers'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
