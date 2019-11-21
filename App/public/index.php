<?php

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

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

$app->get('/schools/{id}/edit', function ($request, $response, array $args) {
    $repo = new App\Repository();
    $id = $args['id'];
    $school = $repo->find($id);
    $params = [
        'school' => $school,
        'errors' => []
    ];
    return $this->get('renderer')->render($response, 'schools/edit.phtml', $params);
})->setName('editSchool');

$router = $app->getRouteCollector()->getRouteParser();

$app->patch('/schools/{id}', function ($request, $response, array $args)  {
    $repo = new App\Repository();
    $id = $args['id'];
    $school = $repo->find($id);
    $data = $request->getParsedBodyParam('school');

    $validator = new Validator();
    $errors = $validator->validate($data);

    if (count($errors) === 0) {
        // Ручное копирование данных из формы в нашу сущность
        $school['name'] = $data['name'];

        $this->get('flash')->addMessage('success', 'School has been updated');
        $repo->save($school);
        $url = $router->urlFor('editSchool', ['id' => $school['id']]);
        return $response->withRedirect($url);
    }

    $params = [
        'schoolData' => $data,
        'school' => $school,
        'errors' => $errors
    ];

    $response = $response->withStatus(422);
    return $this->get('renderer')->render($response, 'schools/edit.phtml', $params);
});

$app->run();