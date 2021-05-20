<?php

return [
    'public_decisions'  => [
        'id'             => 'public_decisions',
        'title'          => __('Public decisions', 'bw-besluiten'),
        'settings_pages' => '_owc_public_decisions_settings',
        'tab'            => 'public_decisions',
        'fields'         => [
            'settings' => [
                'settings_public_decisions_portal_url' => [
                    'name' => __('Portal URL', 'bw-besluiten'),
                    'desc' => __('URL including http(s)://', 'bw-besluiten'),
                    'id'   => 'setting_portal_url',
                    'type' => 'text',
                ],
                'settings_public_decisions_slug' => [
                    'name' => __('Portal public decisions item slug', 'bw-besluiten'),
                    'desc' => __('URL for public decisions items in the portal, eg "besluiten"', 'bw-besluiten'),
                    'id'   => 'setting_portal_public_decision_item_slug',
                    'type' => 'text',
                ]
            ],
        ]
    ]
];
