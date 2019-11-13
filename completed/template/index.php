<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;

$users = App\Generator::generate(100);

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $this->get('renderer')->render($response, 'users.phtml');
});

$app->get('/users', function ($request, $response) use ($users) {
    $params = [
        'users' => $users
    ];
    return $this->get('renderer')->render($response, 'users/users.phtml', $params);
});

$app->get('/users/{id}', function ($request, $response, $args) use ($users) {
    $user = collect($users)->firstWhere('id', $args['id']);
    $params = [
        'id' => $args['id'],
        'user' => $user
    ];
    return $this->get('renderer')->render($response, 'users/show.phtml', $params);
});
$app->run();