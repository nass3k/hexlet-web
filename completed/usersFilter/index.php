<?php

require __DIR__ . '/../vendor/autoload.php';
// Контейнеры в этом курсе не рассматриваются (это тема связанная с самим ООП), но если вам интересно, то посмотрите DI Container
use Slim\Factory\AppFactory;
use DI\Container;


$users = ['mike', 'mishel', 'adel', 'keks', 'kamila'];

$container = new Container();
$container->set('renderer', function () {
    // Параметром передается базовая директория в которой будут храниться шаблоны
    return new \Slim\Views\PhpRenderer(__DIR__ . '/../templates');
});
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/courses', function ($request, $response) use ($users){
    $term = $request->getQueryParam('term');
    if ($term !== null) {
        $users = array_filter($users, function ($user) use ($term) {
            return (strpos($user, $term) !== false);
        });
    }
    $params = [
        'term' => $term,
        'courses' => $users
        ];

    return $this->get('renderer')->render($response, '/courses.phtml', $params);
});

$app->run();