<?php

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require 'vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);

$app = AppFactory::create();

$errorMidddleware = new ErrorMiddleware(
	$app->getCallableResolver(),
	$app->getResponseFactory(),
	true,
	false,
	false
);

$app->add($errorMidddleware);

$twig = new Twig('./views', [
	'cache' => false
]);

$twigMiddleware = new TwigMiddleware($twig, $container, $app->getRouteCollector()->getRouteParser());

$app->add($twigMiddleware);


$app->get('/', function (Request $request, Response $response) {
	return $this->get('view')->render($response, 'home.twig');
})->setName('home');


$app->get('/about', function (Request $request, Response $response) {
	return $this->get('view')->render($response, 'about.twig');
})->setName('about');


$app->get('/contact', function (Request $request, Response $response) {
	return $this->get('view')->render($response, 'contact.twig');
})->setName('contact');



$app->run();






