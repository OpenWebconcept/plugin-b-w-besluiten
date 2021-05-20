<?php

return [
    /**
     * Examples of registering post types: https://johnbillion.com/extended-cpts/
     */
    'public-decision' => [
        'args' => [
            // Add the post type to the site's main RSS feed:
            'show_in_feed' => false,
            // Show all posts on the post type archive:
            'archive' => [
                'nopaging' => true,
            ],
            'public'        => true,
            'show_ui'       => true,
            'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'comments'],
            'menu_icon'     => 'dashicons-megaphone',
            'menu_position' => 6,
            'show_in_rest'  => true,
            'admin_cols'    => [
                'published' => [
                    'title'       => __('Published', 'bw-besluiten'),
                    'post_field'  => 'post_date',
                    'date_format' => get_option('date_format') . ', ' . get_option('time_format'),
                ],
                'orderby' => [],
            ],
            'labels' => [
                'singular_name'      => __('Public decision', 'bw-besluiten'),
                'menu_name'          => __('Public decisions', 'bw-besluiten'),
                'name_admin_bar'     => __('New public decision', 'bw-besluiten'),
                'add_new'            => __('Add new public decision', 'bw-besluiten'),
                'add_new_item'       => __('Add public decision', 'bw-besluiten'),
                'new_item'           => __('New public decision', 'bw-besluiten'),
                'edit_item'          => __('Edit public decision', 'bw-besluiten'),
                'view_item'          => __('View public decision', 'bw-besluiten'),
                'all_items'          => __('All public decisions', 'bw-besluiten'),
                'search_items'       => __('Search public decision', 'bw-besluiten'),
                'parent_item_colon'  => __('Parent public decision:', 'bw-besluiten'),
                'not_found'          => __('No public decisions found.', 'bw-besluiten'),
                'not_found_in_trash' => __('No public decisions found in trash.', 'bw-besluiten'),
            ],
        ],
        // Override the base names used for labels:
        'names' => [
            'slug'     => 'public-decisions',
            'singular' => __('Public decision', 'bw-besluiten'),
            'plural'   => __('Public decisions', 'bw-besluiten'),
            'name'     => __('Public decisions', 'bw-besluiten'),
        ],
    ],
];
