<?php

return [
    'models' => [
        /**
         * Custom field creators.
         *
         * [
         *      'creator'   => CreatesFields::class,
         *      'condition' => \Closure
         * ]
         */
        'besluit'   => [
            'fields' => [
                'connected' => OWC\Besluiten\RestAPI\ItemFields\ConnectedField::class
            ],
        ]
    ],
];
