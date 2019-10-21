<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/*
 * todo: Helper class for comfortable route management (Route: get('/', Controller::class, 'action')->name())
 */

$routes = new RouteCollection();
$routes->add('welcome', new Route('/test/{name}', [
        '_controller' => \Dreamscape\Domain\ArticleEditor\Controllers\TestController::class
        ], [], [], '', [], ['GET']
));
$routes->add('welcome', new Route('/api/index', [
    '_controller' => \Dreamscape\Domain\ArticleEditor\Controllers\IndexController::class
], [], [], '', [], ['GET']
));

return $routes;
