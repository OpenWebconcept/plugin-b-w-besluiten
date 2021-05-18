<?php

return [
    'public_decisions' => [
        'id'         => 'public_decisions_metadata',
        'title'      => __('Data', 'public-decisions'),
        'post_types' => ['public-decision'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            'general'   => [
                'expiration' => [
                    'name' => __('Expiration date', 'public-decisions'),
                    'desc' => __("The default value of this field is set to a date four weeks from now. The value of this field is only saved when the status of this post is set to 'publish'. If the post status, after saving, is not 'publish' the value will be cleared.", 'public-decisions'),
                    'id'   => 'public_decisions_expiration_date',
                    'type' => 'datetime',
                    'js_options' => [
                        'dateFormat'      => 'dd-mm-yy',
                        'showTimepicker'  => true,
                    ],
                    'std' => (new \DateTime('now', new DateTimeZone('Europe/Amsterdam')))->modify('+4 week')->format('d-m-Y H:i') // staat nu automatisch, als status niet publish is dan weer leeghalen
                ]
            ]
        ]
    ],
];
