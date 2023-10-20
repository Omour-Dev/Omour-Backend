<?php

return [
    'coupons'   => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'code'              => 'Coupon code',
            'description'       => 'Description',
            'end'               => 'End at',
            'fixed'             => 'Fixed discount',
            'image'             => 'Image',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'percentage'        => 'Percentage discount',
            'start'             => 'Start at',
            'status'            => 'Status',
            'tabs'              => [
                'general'   => 'General Info.',
                'seo'       => 'SEO',
            ],
            'title'             => 'Title',
        ],
        'routes'    => [
            'create'    => 'Create Coupons',
            'index'     => 'Coupons',
            'update'    => 'Update Coupon',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'Please enter the description of coupon',
            ],
            'title'         => [
                'required'  => 'Please enter the title of coupon',
                'unique'    => 'This title coupon is taken before',
            ],
        ],
    ],
];
