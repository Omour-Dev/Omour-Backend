<?php

return [
    'coupons'   => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'الصورة',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'code'              => 'كود الكوبون',
            'description'       => 'الوصف',
            'end'               => 'ينتهي في',
            'fixed'             => 'خصم ثابت',
            'image'             => 'الصورة',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'percentage'        => 'خصم بالنسبة المئوية',
            'start'             => 'يبدا في',
            'status'            => 'الحالة',
            'tabs'              => [
                'general'   => 'بيانات عامة',
                'seo'       => 'SEO',
            ],
            'title'             => 'عنوان',
        ],
        'routes'    => [
            'create'    => 'اضافة الاقسام',
            'index'     => 'الاقسام',
            'update'    => 'تعديل الاقسام',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'من فضلك ادخل وصف الاقسام',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان الاقسام',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
