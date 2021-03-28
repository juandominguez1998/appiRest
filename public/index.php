<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require '../vendor/autoload.php';
require '../src/config/db.php';

$config=["settings" => [
    "displayErrorDetails" => true
]];

$app=new Slim\App($config);

//ruta clientes
require '../src/rutas/alumnos.php';
$app->run();