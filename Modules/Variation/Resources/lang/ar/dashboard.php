<?php

return [
    'options'   => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'code'      => 'رمز للمجموعة',
            'status'    => 'الحالة',
            'tabs'      => [
                'general'       => 'بيانات عامة',
                'option_values' => 'القيم',
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
    'optionss'  => [
        'form'  => [
            'vendors'   => 'المتجر',
        ],
    ],
];
