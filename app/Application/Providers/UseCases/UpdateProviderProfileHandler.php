<?php

namespace Application\Providers\UseCases;

use App\Models\ProviderProfile;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * UpdateProviderProfileHandler
 * EN: Updates allowed fields for a provider profile (owner/admin checked elsewhere).
 * AR: يحدث الحقول المسموح بها لملف المزود (التحقق من الصلاحيات في الطبقة العليا).
 */
class UpdateProviderProfileHandler
{
    /**
     * @param ProviderProfile $profile
     * @param array{display_name?:string,city?:string,bio?:string,website?:string,skills_json?:array,cities_json?:array,social_json?:array} $data
     */
    public function handle(ProviderProfile $profile, array $data): ProviderProfile
    {
        if (!$profile->exists) {
            throw new InvalidArgumentException('Profile not persisted');
        }

        $allowed = collect($data)->only([
            'display_name','city','bio','website','skills_json','cities_json','social_json'
        ])->toArray();

        DB::transaction(fn() => $profile->update($allowed));
        return $profile->refresh();
    }
}
