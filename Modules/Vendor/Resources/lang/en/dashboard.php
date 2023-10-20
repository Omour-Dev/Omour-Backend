<?php

return [
    'vendor_statuses'   => [
        'create'    => [
            'form'  => [
                'accepted_orders'   => 'Accpeting orders',
                'info'              => 'Info.',
                'label_color'       => 'Label Color',
                'title'             => 'Title',
            ],
            'title' => 'Create Vendor Status',
        ],
        'datatable' => [
            'accepted_orders'   => 'Accpeting orders',
            'created_at'        => 'Created At',
            'date_range'        => 'Search By Dates',
            'label_color'       => 'Label Color',
            'options'           => 'Options',
            'title'             => 'Title',
        ],
        'index'     => [
            'title' => 'Vendor Status',
        ],
        'update'    => [
            'form'  => [
                'accepted_orders'   => 'Accpeting orders',
                'general'           => 'General info.',
                'label_color'       => 'Label Color',
                'title'             => 'Title',
            ],
            'title' => 'Update Vendor Status',
        ],
        'validation' => [
            'accepted_orders'   => [
                'unique'    => 'only one status can be accepted orders',
            ],
            'label_color'       => [
                'required'  => 'Please select the label color',
            ],
        ],
    ],
    'vendors'           => [
        'create'    => [
            'form'  => [
                'areas'                 => 'Areas',
                'commission'            => 'Commission from vendor',
                'delivery_time'         => 'Delivery Time',
                'description'           => 'Description',
                'fixed_commission'      => 'Fixed Commission',
                'fixed_delivery'        => 'Fixed Delivery Fees',
                'general'               => 'General Info.',
                'image'                 => 'Image',
                'info'                  => 'Info.',
                'is_trusted'            => 'Is Trusted',
                'meta_description'      => 'Meta Description',
                'meta_keywords'         => 'Meta Keywords',
                'order_limit'           => 'Order Limit',
                'other'                 => 'Other Info.',
                'payments'              => 'Allowed Payments',
                'products'              => 'Exporting Products',
                'receive_prescription'  => 'Receiving Prescriptions',
                'receive_question'      => 'Receiving Questions',
                'sections'              => 'Vendor Section',
                'sellers'               => 'Vendor admins',
                'vendor_admins'               => 'vendor admins',
                'seo'                   => 'SEO',
                'status'                => 'Status',
                'title'                 => 'Title',
                'vendor_email'          => 'Vendor Email',
                'vendor_statuses'       => 'Vendor Status',
                'workers'               => 'Workers',
            ],
            'title' => 'Create Vendors',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'index'     => [
            'sorting'   => 'Sorting Vendors',
            'title'     => 'Vendors',
        ],
        'sorting'   => [
            'title' => 'Sorting Vendors',
        ],
        'update'    => [
            'form'  => [
                'commission'            => 'Commission from vendor',
                'description'           => 'Description',
                'general'               => 'General info.',
                'image'                 => 'Image',
                'info'                  => 'Info.',
                'is_trusted'            => 'Is Trusted',
                'meta_description'      => 'Meta Description',
                'meta_keywords'         => 'Meta Keywords',
                'order_limit'           => 'Order Limit',
                'other'                 => 'Other Info.',
                'payments'              => 'Allowed Payments',
                'products'              => 'Exporting Products',
                'receive_prescription'  => 'Receiving Prescriptions',
                'receive_question'      => 'Receiving Questions',
                'sections'              => 'Vendor Section',
                'sellers'               => 'Vendor admins',
                'seo'                   => 'SEO',
                'status'                => 'Status',
                'title'                 => 'Title',
                'vendor_email'          => 'Vendor Email',
                'workers'               => 'Workers',
            ],
            'title' => 'Update Vendor',
        ],
        'validation' => [
            'commission'        => [
                'numeric'   => 'Please add commission as numeric only',
                'required'  => 'Please add commission from vendor',
            ],
            'description'       => [
                'required'  => 'Please enter the description of vendor',
            ],
            'fixed_delivery'    => [
                'numeric'   => 'Please enter the fixed delivery fees as numbers only',
                'required'  => 'Please enter the fixed delivery fees.',
            ],
            'image'             => [
                'required'  => 'Please select vendor profile image',
            ],
            'months'            => [
                'numeric'   => 'Please enter the months as numbers only',
                'required'  => 'Please enter the months of the package',
            ],
            'order_limit'       => [
                'numeric'   => 'Please enter the order limit numeric only - ex : 5.000',
                'required'  => 'Please enter the order limit for this vendro ex : 5.000',
            ],
            'payments'          => [
                'required'  => 'Please select the allowed payments methods for this vendor',
            ],
            'price'             => [
                'numeric'   => 'Please enter the price numbers only',
                'required'  => 'Please enter the price of package',
            ],
            'sections'          => [
                'required'  => 'Please select the section of vendor',
            ],
            'sellers'           => [
                'required'  => 'Please select the sellers of this vendor',
            ],
            'special_price'     => [
                'numeric'   => 'Please enter the special price numbers only',
            ],
            'title'             => [
                'required'  => 'Please enter the title of vendor',
                'unique'    => 'This title vendor is taken before',
            ],
        ],
    ],
];
