<?php

return [
    'offers'    => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'description'       => 'الوصف',
            'image'             => 'الصورة',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'restore'           => 'استرجاع من الحذف',
            'status'            => 'الحالة',
            'tabs'              => [
                'general'   => 'بيانات عامة',
                'seo'       => 'SEO',
            ],
            'title'             => 'عنوان الصفحة',
            'type'              => 'في تذيل الصفحة',
        ],
        'routes'    => [
            'create'    => 'اضافة الصفحات',
            'index'     => 'الصفحات',
            'update'    => 'تعديل الصفحة',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'من فضلك ادخل وصف الصفحة',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان الصفحة',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
