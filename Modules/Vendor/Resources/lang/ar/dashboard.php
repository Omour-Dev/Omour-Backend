<?php

return [
    'vendor_statuses'   => [
        'create'    => [
            'form'  => [
                'accepted_orders'   => 'حالة استقبال الطلبات',
                'info'              => 'البيانات',
                'label_color'       => 'لون العلامة',
                'title'             => 'العنوان',
            ],
            'title' => 'اضافة حالات المتجر',
        ],
        'datatable' => [
            'accepted_orders'   => 'حالة استقبال الطلبات',
            'created_at'        => 'تاريخ الآنشاء',
            'date_range'        => 'البحث بالتواريخ',
            'label_color'       => 'لون العلامة',
            'options'           => 'الخيارات',
            'title'             => 'العنوان',
        ],
        'index'     => [
            'title' => 'حالات المتجر',
        ],
        'update'    => [
            'form'  => [
                'accepted_orders'   => 'حالة استقبال الطلبات',
                'general'           => 'بيانات عامة',
                'label_color'       => 'لون العلامة',
                'title'             => 'العنوان',
            ],
            'title' => 'تعديل حالات المتجر',
        ],
        'validation'=> [
            'accepted_orders'   => [
                'unique'    => 'لا يمكن اكثر من حالة لستقبال الطلبات',
            ],
            'label_color'       => [
                'required'  => 'من فضلك اختر لون العلامة',
            ],
        ],
    ],
    'vendors'           => [
        'create'    => [
            'form'  => [
                'areas'                 => 'المناطق',
                'commission'            => 'نسبة الربح من المتجر',
                'delivery_time'         => 'وقت التوصيل',
                'description'           => 'الوصف',
                'fixed_commission'      => 'نسبة ربح ثابتة',
                'fixed_delivery'        => 'سعر التوصيل الثابت',
                'general'               => 'بيانات عامة',
                'image'                 => 'الصورة',
                'info'                  => 'البيانات',
                'is_trusted'            => 'صلاحيات الاضافة',
                'meta_description'      => 'Meta Description',
                'meta_keywords'         => 'Meta Keywords',
                'order_limit'           => 'الحد الادنى للطلب',
                'other'                 => 'بيانات اخرى',
                'payments'              => 'طرق الدفع المدعومة',
                'products'              => 'تصدير المنتجات',
                'receive_prescription'  => 'استقبال الوصفات الطبية',
                'receive_question'      => 'استقبال الاسالة',
                'sections'              => 'قسم المتجر',
                'sellers'               => 'مدراء المتاجر',
                'seo'                   => 'SEO',
                'status'                => 'الحالة',
                'title'                 => 'عنوان',
                'vendor_email'          => 'البريد الالكتروني للمتجر',
                'vendor_statuses'       => 'حالة المتجر',
                'workers'               => 'العاملين',
            ],
            'title' => 'اضافة المتاجر',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'الصورة',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'index'     => [
            'sorting'   => 'ترتيب المتاجر',
            'title'     => 'المتاجر',
        ],
        'sorting'   => [
            'title' => 'ترتيب المتاجر',
        ],
        'update'    => [
            'form'  => [
                'commission'            => 'نسبة الربح من المتجر',
                'description'           => 'الوصف',
                'general'               => 'بيانات عامة',
                'image'                 => 'الصورة',
                'info'                  => 'البيانات',
                'is_trusted'            => 'صلاحيات الاضافة',
                'meta_description'      => 'Meta Description',
                'meta_keywords'         => 'Meta Keywords',
                'order_limit'           => 'الحد الادنى للطلب',
                'other'                 => 'بيانات اخرى',
                'payments'              => 'طرق الدفع المدعومة',
                'products'              => 'تصدير المنتجات',
                'receive_prescription'  => 'استقبال الوصفات الطبية',
                'receive_question'      => 'استقبال الاسالة',
                'sections'              => 'قسم المتجر',
                'sellers'               => 'مدراء المتاجر',
                'seo'                   => 'SEO',
                'status'                => 'الحالة',
                'title'                 => 'عنوان',
                'vendor_email'          => 'البريد الالكتروني للمتجر',
                'workers'               => 'العاملين',
            ],
            'title' => 'تعديل المتجر',
        ],
        'validation'=> [
            'commission'        => [
                'numeric'   => 'من فضلك ادخل نسبه الربح ارقام انجليزية فقط',
                'required'  => 'من فضلك ادخل نسبه الربح',
            ],
            'description'       => [
                'required'  => 'من فضلك ادخل الوصف',
            ],
            'fixed_delivery'    => [
                'numeric'   => 'من فضلك ادخل سعر التوصيل الثابت ارقام انجليزية فقط',
                'required'  => 'من فضلك ادخل سعر التوصيل الثابت',
            ],
            'image'             => [
                'required'  => 'من فضلك اختر صورة المتجر',
            ],
            'months'            => [
                'numeric'   => 'من فضلك ادخل عدد شهور الباقة ارقام فقط',
                'required'  => 'من فضلك ادخل عدد شهور الباقة',
            ],
            'order_limit'       => [
                'numeric'   => 'من فضلك ادخل الاحد الادنى كا ارقام انجليزية فقط : 5.000',
                'required'  => 'من فضلك ادخل الحد الادنى للمتجر : 5.000',
            ],
            'payments'          => [
                'required'  => 'من فضلك اختر طرق الدفع المدعومة من قبل هذا المتجر',
            ],
            'price'             => [
                'numeric'   => 'من فضلك ادخل سعر الباقة ارقام فقط',
                'required'  => 'من فضلك ادخل سعر الباقة',
            ],
            'sections'          => [
                'required'  => 'من فضلك اختر قسم المتجر',
            ],
            'sellers'           => [
                'required'  => 'من فضلك اختر البائعين لهذا المتجر',
            ],
            'special_price'     => [
                'numeric'   => 'من فضلك ادخل السعر الخاص ارقام فقط',
            ],
            'title'             => [
                'required'  => 'من فضلك ادخل العنوان',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
