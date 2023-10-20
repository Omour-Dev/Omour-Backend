<?php

return [
    'attributes'    => [
        'datatable' => [
            'attributes'    => 'الخيارات',
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'code'      => 'رمز للمجموعة',
            'price'     => 'السعر',
            'status'    => 'الحالة',
            'tabs'      => [
                'attribute_values'  => 'القيم',
                'general'           => 'بيانات عامة',
            ],
            'title'     => 'عنوان خصائص المنتجات',
        ],
        'routes'    => [
            'create'    => 'اضافة خصائص المنتجات',
            'index'     => 'خصائص المنتجات',
            'update'    => 'تعديل خصائص المنتجات',
        ],
        'validation'=> [
            'title' => [
                'required'  => 'من فضلك ادخل عنوان خصائص المنتجات',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'attributess'   => [
        'form'  => [
            'vendors'   => 'المتجر',
        ],
    ],
];
