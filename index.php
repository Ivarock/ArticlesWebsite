<?php
require 'vendor/autoload.php';

use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use FastRoute\RouteCollector;
use ArticlesWebsite\Database;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Utils;

try {
    Database::getConnection();
} catch (\Doctrine\DBAL\Exception $e) {
}

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/app/Container.php');
try {
    $container = $containerBuilder->build();
} catch (Exception $e) {
}

$routes = require __DIR__ . '/app/Routes.php';
$dispatcher = FastRoute\simpleDispatcher($routes);

$request = ServerRequest::fromGlobals();
$response = new Response();

$method = $request->getMethod();
if ($method === 'POST' && isset($request->getParsedBody()['_method'])) {
    $method = strtoupper($request->getParsedBody()['_method']);
    $request = $request->withMethod($method);
}

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $response = $response->withStatus(404)->withBody(Utils::streamFor('404 Not Found'));
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response = $response->withStatus(405)->withBody(Utils::streamFor('405 Method Not Allowed'));
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$class, $method] = $handler;
        try {
            $controller = $container->get($class);
            $response = $controller->$method($request, $response, $vars);
        } catch (DependencyException|NotFoundException $e) {
            $response = $response->withStatus(500)->withBody(Utils::streamFor('Internal Server Error'));
        }
        break;
}

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
echo $response->getBody();
