<?php

return [
    'title' => 'اقتراحات المزودين',
    'subtitle' => 'مراجعة اقتراحات مزودي الخدمات',
    'back_to_dashboard' => 'رجوع للوحة التحكم',
    
    'filters' => [
        'all' => 'الكل',
        'pending' => 'قيد الانتظار',
        'approved' => 'مقبول',
        'rejected' => 'مرفوض',
    ],
    
    'table' => [
        'provider_name' => 'اسم المزود',
        'phone' => 'الهاتف',
        'category' => 'الفئة',
        'city' => 'المدينة',
        'submitted_by' => 'مقترح من',
        'status' => 'الحالة',
        'submitted_at' => 'تاريخ الاقتراح',
        'actions' => 'إجراءات',
    ],
    
    'actions' => [
        'approve' => 'اقبل',
        'reject' => 'ارفض',
        'approve_confirm' => 'متأكد تقبل هذا الاقتراح؟',
    ],
    
    'reject_modal' => [
        'title' => 'رفض اقتراح مزود',
        'reason' => 'سبب الرفض',
        'reason_placeholder' => 'حكينا ليش رفضت هذا الاقتراح...',
    ],
    
    'no_results' => [
        'title' => 'ما لقيناش اقتراحات',
        'pending' => 'ما فيش اقتراحات قيد الانتظار.',
        'other' => 'ما فيش اقتراحات :status.',
    ],
];

