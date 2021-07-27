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
                'expired'   => OWC\Besluiten\RestAPI\ItemFields\ExpiredField::class,
                'connected' => OWC\Besluiten\RestAPI\ItemFields\ConnectedField::class
            ],
        ]
    ],
];
