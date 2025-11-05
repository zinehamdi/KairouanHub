<?php

return [
    'providers' => [
        // EN: Auto approve newly created provider profiles (dev only). AR: قبول تلقائي لملفات المزود الجديدة (للتطوير فقط).
        'auto_approve' => env('PROVIDERS_AUTO_APPROVE', false),
        // Future: feature flags for badges, rating algorithms, etc.
    ],
];
