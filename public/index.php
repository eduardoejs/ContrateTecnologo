<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/../bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Code\Sistema\Config\Routes;

$app->get('/', function () use ($app) {
    return $app['twig']->render('home/index.twig', []);
})->bind('home');

$routes = new Routes();
$routes->init($app, $em);

//Enable HTTP Methods to functions in Controllers [GET|POST]
Request::enableHttpMethodParameterOverride();

$app->run();