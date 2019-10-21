<?php


namespace Dreamscape\Domain\ArticleEditor\Controllers;


use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Database\Capsule\Manager as Capsule;

class IndexController
{
    public function __invoke()
    {
        $status = Capsule::table('generic_status')->get();
        return new JsonResponse($status);
    }
}