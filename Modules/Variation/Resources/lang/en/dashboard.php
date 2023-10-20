<?php

return [
    'options'   => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'code'      => 'Group code',
            'status'    => 'Status',
            'tabs'      => [
                'general'       => 'General Info.',
                'option_values' => 'Option Values',
            ],
            'title'     => 'Title',
        ],
        'routes'    => [
            'create'    => 'Create Options Products',
            'index'     => 'Options Products',
            'update'    => 'Update Option Products',
        ],
        'validation'=> [
            'title' => [
                'required'  => 'Please enter the title of option',
                'unique'    => 'This title option is taken before',
            ],
        ],
    ],
    'optionss'  => [
        'form'  => [
            'vendors'   => 'Vendor',
        ],
    ],
];
