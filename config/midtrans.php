<?php

// ...

$serverKey = env('MIDTRANS_SERVER_KEY', '');
$clientKey = env('MIDTRANS_CLIENT_KEY', '');

return [
    'serverKey' => $serverKey,
    'clientKey' => $clientKey,
];

