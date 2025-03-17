<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use DI\Container;
use App\controllers\PokemonController;

// Crear contenedor de dependencias
$container = new Container();
$container->set(PokemonController::class, function () {
    return new PokemonController();
});

AppFactory::setContainer($container);
$app = AppFactory::create();

// Middleware para manejar CORS correctamente
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);

    $origin = $request->getHeader('Origin');
    $allowedOrigin = isset($origin[0]) ? $origin[0] : '*';

    return $response
        ->withHeader('Access-Control-Allow-Origin', $allowedOrigin)
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->withHeader('Access-Control-Allow-Credentials', 'true');
});

// **Solución al error de rutas duplicadas**
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response->withStatus(200);
});

// Cargar rutas
(require __DIR__ . '/../src/routes.php')($app);

$app->run();
