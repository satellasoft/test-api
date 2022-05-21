<?php

use App\Core\Router;

$router = new Router();

$router->post('reset', [\App\Classes\Reset::class, 'reset']);
$router->post('event', [\App\Controller\EventController::class, 'index']);
$router->get('balance', [\App\Controller\BalanceController::class, 'getBalanceAmount']);

$router->run();
