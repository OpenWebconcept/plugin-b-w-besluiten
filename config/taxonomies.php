<?php

return [
    /**
     * Examples of registering taxonomies: http://johnbillion.com/extended-cpts/
     */
    'public-decision-category' => [
        'object_types' => ['public-decision'],
        'args'         => [
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'capabilities'      => []
        ],
        'names'        => [
            'singular' => __('Category', 'bw-besluiten'),
            'plural'   => __('Categories', 'bw-besluiten'),
            'slug'     => 'categories'
        ]
    ],
];
