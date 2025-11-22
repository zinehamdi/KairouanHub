<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends BaseApiController
{
	/**
	 * Upload media file.
	 */
	public function upload(Request $request)
	{
		$request->validate([
			'file' => 'required|file|max:10240', // 10MB max
			'type' => 'nullable|in:image,document,avatar',
		]);

		$type = $request->input('type', 'image');
		$file = $request->file('file');

		// Validate file type based on category
		if ($type === 'image') {
			$request->validate([
				'file' => 'mimes:jpeg,jpg,png,gif,webp',
			]);
		} elseif ($type === 'document') {
			$request->validate([
				'file' => 'mimes:pdf,doc,docx',
			]);
		}

		// Generate unique filename
		$filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

		// Store file
		$path = $file->storeAs(
			"uploads/{$type}s/" . auth()->id(),
			$filename,
			'public'
		);

		$url = Storage::url($path);

		return $this->successResponse([
			'path' => $path,
			'url' => $url,
			'filename' => $filename,
			'size' => $file->getSize(),
			'mime_type' => $file->getMimeType(),
		], 'File uploaded successfully', 201);
	}
}
