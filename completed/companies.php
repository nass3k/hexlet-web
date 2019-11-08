<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;


$companies = App\Generator::generate(100);

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response, $args) {
    return $response->write('open something like (you can change id): /companies/5');
});



$app->get('/companies/{id}', function ($request, $response, $args) use ($companies) {

          return $response->write(json_encode(collect($companies)->firstWhere('id', $args['id'])));
  });

$app->run();
