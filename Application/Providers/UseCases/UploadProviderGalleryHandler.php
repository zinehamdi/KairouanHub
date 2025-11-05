<?php

namespace Application\Providers\UseCases;

use App\Models\ProviderProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * UploadProviderGalleryHandler
 * EN: Handles provider gallery image uploads (max 6).
 * AR: معالجة رفع صور معرض المزود (بحد أقصى 6).
 */
class UploadProviderGalleryHandler
{
    /**
     * @param ProviderProfile $profile
     * @param UploadedFile[] $files
     */
    public function handle(ProviderProfile $profile, array $files): ProviderProfile
    {
        if (count($files) === 0) {
            throw new InvalidArgumentException('No files provided');
        }
        $existing = $profile->photos_json ?? [];
        if (count($existing) >= 6) {
            throw new InvalidArgumentException('Gallery already full');
        }

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                throw new InvalidArgumentException('Invalid file instance');
            }
            if (!in_array($file->getMimeType(), ['image/jpeg','image/png','image/webp'])) {
                throw new InvalidArgumentException('Unsupported mime type');
            }
            if ($file->getSize() > 2 * 1024 * 1024) { // 2MB
                throw new InvalidArgumentException('File too large');
            }
        }

        $disk = 'public';
        foreach ($files as $file) {
            if (count($existing) >= 6) { break; }
            $path = $file->storeAs(
                'providers/'.$profile->user_id.'/gallery',
                Str::uuid().'.'.$file->getClientOriginalExtension(),
                $disk
            );
            if (!in_array($path, $existing)) {
                $existing[] = $path;
            }
        }

        $profile->update(['photos_json' => $existing]);
        return $profile->refresh();
    }
}
