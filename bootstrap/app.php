<?php

use Dreamscape\Foundation\Kernel;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


$app = new Dreamscape\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
 * Monolog
 */
$log = new Logger(env('APP_NAME'));
$log_path = storage_path() . '/logs/' . env('APP_LOG_NAME', 'app.log');
$log->pushHandler(new StreamHandler($log_path, env('APP_LOG_LEVEL', Logger::WARNING)));
$app->instance('log', $log);

/*
 * Routes
 */
$routes = require base_path('routes') . DIRECTORY_SEPARATOR . 'web.php';
$log->debug($routes);

/*
 * Kernel
 */

$app->instance('kernel', Kernel::getInstance($routes));

/*
 * Twig Template Engine settings
 */
$loader = new Twig_Loader_Filesystem(config('view.path'));
$twig_options = [];
if (env('APP_ENV') === 'production') {
    $twig_options['cache'] = config('view.compiled');
}
$app->instance('view', new Twig_Environment($loader, $twig_options));

/*
 * Ready for Romance!
 */
return $app;
