<?php

return [
    'public_decisions' => [
        'id'            => '_owc_public_decisions_settings',
        'option_name'   => '_owc_public_decisions_settings',
        'menu_title'    => __('Public decisions', 'public-decisions'),
        'icon_url'      => 'dashicons-admin-settings',
        'position'      => 9,
        'parent'        => '_owc_openpub_base_settings',
        'submenu_title' => __('Public decisions', 'public-decisions'),
        'columns'       => 1,
        'submit_button' => __('Save', 'public-decisions'),
        'tabs'          => [
            'public_decisions' => __('Public decisions', 'public-decisions'),
        ]
    ]
];
