<?php

return [
    'providers' => [
        // EN: Auto approve newly created provider profiles. AR: قبول تلقائي لملفات المزود الجديدة.
        // According to plan: Users can upgrade to provider instantly (no admin approval required)
        'auto_approve' => env('PROVIDERS_AUTO_APPROVE', true),
        // Future: feature flags for badges, rating algorithms, etc.
    ],
];
