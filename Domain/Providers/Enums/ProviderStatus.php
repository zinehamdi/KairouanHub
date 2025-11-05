<?php

namespace Domain\Providers\Enums;

/**
 * ProviderStatus Enum
 * EN: Moderation status for a provider profile.
 * AR: حالة المراجعة لملف المزود.
 */
enum ProviderStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
