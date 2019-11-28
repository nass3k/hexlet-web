<?php

use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Middleware\MethodOverrideMiddleware;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$container = new Container();
$container->set('renderer', function () {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});
$container->set('flash', function () {
    return new \Slim\Flash\Messages();
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->add(MethodOverrideMiddleware::class);

$users = [
    ['name' => 'admin', 'passwordDigest' => hash('sha256', 'secret')],
    ['name' => 'mike', 'passwordDigest' => hash('sha256', 'superpass')],
    ['name' => 'kate', 'passwordDigest' => hash('sha256', 'strongpass')]
];



// BEGIN (write your solution here)
$app->get('/', function ($request, $response) {
    $flash = $this->get('flash')->getMessages();
    $params = [
        'flash' => $flash,
    ];
    return $this->get('renderer')->render($response, 'index.phtml', $params);
});

$app->post('/session', function ($request, $response) use ($users) {
    $data = $request->getParsedBodyParam('user');
    $userName = $data['name'];
    $userPass = hash('sha256', $data['pass']);

    foreach ($users as $user) {
        if (($user['name'] === $userName) && ($user['passwordDigest'] === $userPass)) {
            $_SESSION['user'] = $data;
            $this->get('flash')->addMessage('success', 'You signed in');
            return $response->withRedirect('/');
        }
    }

    $this->get('flash')->addMessage('failure', 'Wrong password or name');

    return $response->withRedirect('/');
});

$app->delete('/session', function ($request, $response) {
    $_SESSION = [];
    session_destroy();
    return $response->withRedirect('/');
});
// END

$app->run();