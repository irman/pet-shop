<?php

return [
    'currency' => [
        'default' => 'EUR',
        'supported' => [
            'EUR',
            'USD',
            'JPY',
            'BGN',
            'CZK',
            'DKK',
            'GBP',
            'HUF',
            'PLN',
            'RON',
            'SEK',
            'CHF',
            'ISK',
            'NOK',
            'TRY',
            'AUD',
            'BRL',
            'CAD',
            'CNY',
            'HKD',
            'IDR',
            'ILS',
            'INR',
            'KRW',
            'MXN',
            'MYR',
            'NZD',
            'PHP',
            'SGD',
            'THB',
            'ZAR',
        ]
    ],
    'route' => [
        'name' => 'exchange.convert',
        'group' => [
            'prefix' => 'exchange',
        ],
    ]
];
