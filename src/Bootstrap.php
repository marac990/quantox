<?php

namespace Quantox;

require __DIR__ . '/../vendor/autoload.php';

/**
 * DEPENDENCY INJECTOR
 */
$injector = include('Dependencies.php');

$request = $injector->make('Http\Request');
$response = $injector->make('Http\Response');

/**
 * ROUTES
 */
$routeDefinitionCallback = function (\FastRoute\RouteCollector $r) {
    $routes = include('Routes.php');
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};

$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());
switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $response->setContent('404 - Page not found');
        $response->setStatusCode(404);
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response->setContent('405 - Method not allowed');
        $response->setStatusCode(405);
        break;
    case \FastRoute\Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];
        $parsedVars = [];
        //add ":" so that auryn DI will know that we are passing param, not a class name
        foreach ($vars as $key => $val)
            $parsedVars[":" . $key] = $val;
        $class = $injector->make($className);
        $injector->execute([$class, $method], $parsedVars);
        break;
}
/**
 * RESPONSE
 */
foreach ($response->getHeaders() as $header) {
    header($header);
}
echo $response->getContent();