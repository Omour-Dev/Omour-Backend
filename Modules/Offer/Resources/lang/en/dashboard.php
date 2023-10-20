<?php

return [
    'offers'    => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'description'       => 'Description',
            'image'             => 'Image',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'restore'           => 'Restore from trash',
            'status'            => 'Status',
            'tabs'              => [
                'general'   => 'General Info.',
                'seo'       => 'SEO',
            ],
            'title'             => 'Title',
            'type'              => 'In footer',
        ],
        'routes'    => [
            'create'    => 'Create Offers',
            'index'     => 'Offers',
            'update'    => 'Update Offer',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'Please enter the description of offer',
            ],
            'title'         => [
                'required'  => 'Please enter the title of offer',
                'unique'    => 'This title offer is taken before',
            ],
        ],
    ],
];
