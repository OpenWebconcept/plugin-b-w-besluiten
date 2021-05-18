<?php

return [
    'public_decisions'  => [
        'id'             => 'public_decisions',
        'title'          => __('Public decisions', 'public-decisions'),
        'settings_pages' => '_owc_public_decisions_settings',
        'tab'            => 'public_decisions',
        'fields'         => [
            'settings' => [
                'settings_public_decisions_portal_url' => [
                    'name' => __('Portal URL', 'public-decisions'),
                    'desc' => __('URL including http(s)://', 'public-decisions'),
                    'id'   => 'setting_portal_url',
                    'type' => 'text',
                ],
                'settings_public_decisions_slug' => [
                    'name' => __('Portal public decisions item slug', 'public-decisions'),
                    'desc' => __('URL for public decisions items in the portal, eg "besluiten"', 'public-decisions'),
                    'id'   => 'setting_portal_public_decision_item_slug',
                    'type' => 'text',
                ]
            ],
        ]
    ]
];
