<?php
return [
    // Friendly validation messages - not scary, reassuring
    'required' => 'هذا الحقل مطلوب',
    'email' => 'الإيميل هذا مش صحيح',
    'min' => [
        'string' => 'لازم تكتب على الأقل :min حروف',
        'numeric' => 'لازم يكون :min على الأقل',
    ],
    'max' => [
        'string' => 'أكثر حد :max حرف',
        'file' => 'الملف كبير برشا، أكثر حد :max كيلوبايت',
        'numeric' => 'أكثر حد :max',
    ],
    'confirmed' => 'التأكيد ما يتطابقش',
    'unique' => 'هذا موجود بالفعل',
    'exists' => 'هذا ما موجودش',
    'numeric' => 'لازم يكون رقم',
    'date' => 'لازم يكون تاريخ صحيح',
    'image' => 'لازم يكون صورة',
    'mimes' => 'الملف لازم يكون: :values',
    'dimensions' => 'أبعاد الصورة غالطة',
    'phone' => 'رقم الهاتف غالط',
    'between' => [
        'string' => 'لازم يكون بين :min و :max حرف',
        'numeric' => 'لازم يكون بين :min و :max',
    ],
    'in' => 'القيمة المختارة غالطة',
    'not_in' => 'القيمة المختارة غالطة',
    'regex' => 'الصيغة غالطة',
    'url' => 'الرابط لازم يكون صحيح',
    'file' => 'لازم يكون ملف',
    'uploaded' => 'فشل الرفع، جرب ملف أصغر',
    
    // Custom attributes - friendly names
    'attributes' => [
        'email' => 'الإيميل',
        'password' => 'كلمة السر',
        'name' => 'الاسم',
        'phone' => 'رقم الهاتف',
        'city' => 'المدينة',
        'bio' => 'التعريف',
        'details' => 'التفاصيل',
        'photos' => 'الصور',
        'category_id' => 'الفئة',
        'service_id' => 'الخدمة',
        'avatar' => 'الصورة',
        'website' => 'الموقع',
        'price_min' => 'أقل سعر',
        'price_max' => 'أعلى سعر',
    ],
];
