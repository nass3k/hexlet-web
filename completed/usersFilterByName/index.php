<?php

use Slim\Factory\AppFactory;
use DI\Container;

use function Stringy\create as s;

require __DIR__ . '/../vendor/autoload.php';

$users = App\Generator::generate(100);

$container = new Container();
$container->set('render', function () {
   return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $this->get('render')->render($response, 'index.phtml');
});

$app->get('/users', function ($request, $response) use ($users) {
    $term = $request->getQueryParam('term');
    if (!empty($term)) {
        $users = array_filter($users, function ($user) use ($term) {
            return s($user['firstName'])->startsWith($term, false);
        });
    }
    $params = ['users' => $users,
        'term' => $term
    ];
    return $this->get('render')->render($response, 'users/index.phtml', $params);
});

$app->run();