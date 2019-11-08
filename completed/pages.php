<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$companies = App\Generator::generate(100);

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $response->write('go to the /companies');
});



$app->get('/companies', function ($request, $response) use ($companies) {
    $page = $request->getQueryParam('page', 1);
    $per = $request->getQueryParam('per', 5);
    $offset = ($page - 1) * $per;
    return $response->write(json_encode(array_slice($companies, $page, $per)));
});

$app->run();
