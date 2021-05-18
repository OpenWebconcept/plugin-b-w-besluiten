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
                    'title'       => __('Published', 'public-decisions'),
                    'post_field'  => 'post_date',
                    'date_format' => get_option('date_format') . ', ' . get_option('time_format'),
                ],
                'orderby' => [],
            ],
            'labels' => [
                'singular_name'      => __('Public decision', 'public-decisions'),
                'menu_name'          => __('Public decisions', 'public-decisions'),
                'name_admin_bar'     => __('New public decision', 'public-decisions'),
                'add_new'            => __('Add new public decision', 'public-decisions'),
                'add_new_item'       => __('Add public decision', 'public-decisions'),
                'new_item'           => __('New public decision', 'public-decisions'),
                'edit_item'          => __('Edit public decision', 'public-decisions'),
                'view_item'          => __('View public decision', 'public-decisions'),
                'all_items'          => __('All public decisions', 'public-decisions'),
                'search_items'       => __('Search public decision', 'public-decisions'),
                'parent_item_colon'  => __('Parent public decision:', 'public-decisions'),
                'not_found'          => __('No public decisions found.', 'public-decisions'),
                'not_found_in_trash' => __('No public decisions found in trash.', 'public-decisions'),
            ],
        ],
        // Override the base names used for labels:
        'names' => [
            'slug'     => 'public-decisions',
            'singular' => __('Public decision', 'public-decisions'),
            'plural'   => __('Public decisions', 'public-decisions'),
            'name'     => __('Public decisions', 'public-decisions'),
        ],
    ],
];
