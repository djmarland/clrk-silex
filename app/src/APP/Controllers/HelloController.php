<?php
/**
 * Hello controller implementation
 *
 * PHP version 5.4
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Elisabeth Anderson <beth.anderson@bbc.co.uk>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/bbc-rmp/deploy-pipeline
 */

namespace APP\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Hello controller implementation
 *
 * PHP version 5.4
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Elisabeth Anderson <beth.anderson@bbc.co.uk>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/bbc-rmp/deploy-pipeline
 */
class HelloController
{

    /**
     * Controller 'index' action
     *
     * @param Request     $request the request
     * @param Application $app     the Silex application
     *
     * @return a twig template
     */
    public function indexAction(Request $request, Application $app)
    {
        $app['log']->debug("HelloController::indexAction called");

        $message = "Hello, World!";

        if ($app['hello_breaker']->isClosed()) {
            try {
                $message = "Hello, real World!";
                $app['hello_breaker']->success();

            } catch (Exception $e) {
                // log a failure
                $app['hello_breaker']->failure();
            }
        }

        return $app['twig']->render('hello/index.html.twig', array('message' => $message));
    }

    /**
     * Controller 'show' action
     *
     * @param Request     $request the request
     * @param Application $app     the Silex application
     *
     * @return a twig template
     */
    public function showAction(Request $request, Application $app)
    {
        $app['log']->debug("HelloController::showAction called");

        $name = $request->attributes->get('name');

        return $app['twig']->render('hello/hello.html.twig', array('name' => $name));
    }

    /**
     * Controller 'destroy' action
     *
     * @param Request     $request the request
     * @param Application $app     the Silex application
     *
     * @return a twig template
     */
    public function destroyAction(Request $request, Application $app)
    {
        $app['log']->debug("HelloController::destroyAction called");

        $name = $request->attributes->get('name');

        return $app['twig']->render('hello/destroy.html.twig', array('name' => $name));
    }
}
