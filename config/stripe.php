<?php

return [
    'api_key' => env('STRIPE_API_KEY'),
    'currency' => env('CURRENCY_CODE', 'usd'),
];
