<?php

require_once(__DIR__ . '/_bootstrap.php');

use RingCentral\SDK\SDK;

// Create SDK instance

$credentials = require(__DIR__ . '/_credentials.php');

$rcsdk = new SDK($credentials['clientId'], $credentials['clientSecret'], $credentials['server'], 'SalesScript', '1.0.0');

$platform = $rcsdk->platform();

// Authorize

$platform->login($credentials['username'], $credentials['extension'], $credentials['password']);

// Load extensions

$extensions = $platform->get('/account/~/extension/~/call-log', array('page' => 1, 'perPage' => 2,'view'=>'Detailed'))->json()->records;
//$extensions = $platform->get('/account/~/recording/AakNqzez_0r-zUA')->json()->records;
//$extensions = $platform->get('/account/~/extension', array('perPage' => 10))->json()->records;
echo '<pre>'; print_r($extensions); echo '<pre>'; exit();