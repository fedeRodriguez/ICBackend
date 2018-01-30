<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', function (Request $request, Response $response, array $args) {

    $this->logger->info("Visita nueva");

    return $this->renderer->render($response, 'index.phtml', $args);

});

// Register routes
require __DIR__ . '/inmueblesRoutes.php';

