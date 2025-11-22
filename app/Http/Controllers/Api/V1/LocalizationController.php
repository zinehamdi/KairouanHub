<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LocalizationController extends BaseApiController
{
	/**
	 * Get translations for a specific locale.
	 */
	public function index(Request $request, $locale = 'en')
	{
		// Validate locale
		$availableLocales = ['en', 'ar', 'fr'];

		if (!in_array($locale, $availableLocales)) {
			return $this->errorResponse('Invalid locale', 400);
		}

		$translations = [];
		$langPath = resource_path("lang/{$locale}");

		if (!File::exists($langPath)) {
			return $this->errorResponse('Locale not found', 404);
		}

		// Load all translation files for the locale
		$files = File::files($langPath);

		foreach ($files as $file) {
			$filename = pathinfo($file, PATHINFO_FILENAME);
			$translations[$filename] = include $file;
		}

		return $this->successResponse([
			'locale' => $locale,
			'translations' => $translations,
		]);
	}
}
