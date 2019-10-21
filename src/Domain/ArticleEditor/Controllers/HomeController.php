<?php


namespace Dreamscape\Domain\ArticleEditor\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function __invoke(Request $request)
    {
        $app_name = $request->get('name', 'Default');
        return new Response(
            view('home', compact('app_name'))
        );
    }
}