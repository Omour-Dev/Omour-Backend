<?php

return [
    'sections'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'description'       => 'Description',
            'image'             => 'Image',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'Status',
            'tabs'              => [
                'general'   => 'General Info.',
                'seo'       => 'SEO',
            ],
            'title'             => 'Title',
        ],
        'routes'    => [
            'create'    => 'Create Sections',
            'index'     => 'Sections',
            'update'    => 'Update Section',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'Please enter the description of section',
            ],
            'title'         => [
                'required'  => 'Please enter the title of section',
                'unique'    => 'This title section is taken before',
            ],
        ],
    ],
];
