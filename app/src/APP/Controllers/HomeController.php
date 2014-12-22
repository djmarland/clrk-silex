<?php
namespace APP\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class HomeController
{
    public function indexAction(Request $request, Application $app)
    {
        return $app['twig']->render('home/index.html.twig', array());
    }
}
