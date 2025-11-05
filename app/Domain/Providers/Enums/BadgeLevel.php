<?php

namespace Domain\Providers\Enums;

/**
 * BadgeLevel Enum
 * EN: Provider recognition badge level.
 * AR: مستوى شارة التميز للمزود.
 */
enum BadgeLevel: string
{
    case None = 'none';
    case Bronze = 'bronze';
    case Silver = 'silver';
    case Gold = 'gold';
}
