<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/*
 * todo: Helper class for comfort route management (Route: get('/', Controller::class)->name())
 */

$routes = new RouteCollection();
$routes->add('welcome', new Route('/welcome/{name}', [
        '_controller' => \Dreamscape\Domain\ArticleEditor\Controllers\HomeController::class
        ], [], [], '', [], ['GET']
));

return $routes;
