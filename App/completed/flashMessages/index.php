<?php

use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
// Старт PHP сессии
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

$app->post('/courses', function ($req, $res) {
    $this->get('flash')->addMessage('success', 'Course Added');
    return $res->withStatus(302)->withHeader('Location', '/');
});

$app->get('/', function ($req, $res) {
    $messages = $this->get('flash')->getMessages();
    $params = [
      'messages' => $messages
    ];
    return $this->get('renderer')->render($res, 'index.phtml', $params);
});

$app->run();