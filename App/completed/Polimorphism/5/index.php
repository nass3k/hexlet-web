<?php

use App\HTML;

require __DIR__ . '/vendor/autoload.php';

$loader = new DatabaseConfigLoader(__DIR__ . '/fixtures');
$config = $loader->load('production'); // loading database.production.json
// [
//     'host' => 'google.com',
//     'username' => 'postgres'
// ];
