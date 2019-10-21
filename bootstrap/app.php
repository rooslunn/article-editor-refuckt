<?php

use Dreamscape\Foundation\Kernel;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Database\Capsule\Manager as Capsule;


$app = new Dreamscape\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
 * DotEnv
 */
$dotenv = Dotenv\Dotenv::create(base_path());
$dotenv->load();

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
 * Database
 */

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => env('DB_CONNECTION'),
    'host'      => env('DB_HOST'),
    'database'  => env('DB_DATABASE'),
    'username'  => env('DB_USERNAME'),
    'password'  => env('DB_PASSWORD'),
//    'charset'   => 'utf8',
//    'collation' => 'utf8_unicode_ci',
//    'prefix'    => '',
]);
$capsule->setAsGlobal();

/*
 * Ready for Romance!
 */
return $app;
