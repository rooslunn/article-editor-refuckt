<?php


use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$app = new Dreamscape\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
 * Routes
 */
$routes = require base_path('routes') . DIRECTORY_SEPARATOR . 'web.php';

/*
 * Kernel
 * todo: Simplify Http Kernel initializaion
 */
$matcher = new UrlMatcher($routes, new RequestContext());
$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));
$kernel = new HttpKernel(
    $dispatcher,
    new ControllerResolver(),
    new RequestStack(),
    new ArgumentResolver()
);

$app->instance('kernel', $kernel);

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
 * Monolog
 */
$log = new Logger(env('APP_NAME'));
$log_path = storage_path() . '/logs/' . env('APP_LOG_NAME', 'dreamscape.log');
$log->pushHandler(new StreamHandler($log_path, env('APP_LOG_LEVEL', Logger::WARNING)));

$app->instance('log', $log);


/*
 * Ready for Romance!
 */
return $app;
