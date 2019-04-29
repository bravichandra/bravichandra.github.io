<?php

require_once(__DIR__ . '/_bootstrap.php');

use RingCentral\SDK\SDK;

// Create SDK instance
$credentials = require(__DIR__ . '/_credentials.php');

$rcsdk = new SDK($credentials['clientId'], $credentials['clientSecret'], $credentials['server'], 'SalesScript', '1.0.0');

$platform = $rcsdk->platform();

$platform->logout();

return true;