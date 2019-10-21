<?php


use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../bootstrap/autoload.php';
require_once __DIR__.'/../bootstrap/app.php';

/*
 * Run the App
 */

$response = app('kernel')->handle($request = Request::createFromGlobals());
$response->send();
app('kernel')->terminate($request, $response);
