<?php
/**
 * Routes mappings
 *
 * PHP version 5.4
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Elisabeth Anderson <beth.anderson@bbc.co.uk>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/bbc-rmp/deploy-pipeline
 */

/* @var Silex\Application $app */

//
// ------------ Redirects --------------
// Forwarding the user through the app.
//
//$app->get('/', function (Silex\Application $app) {
    //return $app->redirect('/app');
//});

//
// ---------- Hello Routes -------------
// Setting up a controller through the DI container and then assigning
// routes to it.
//
$app['controllers.home'] = $app->share(function () use ($app) {
    return new APP\Controllers\HomeController();
});
$app['controllers.hello'] = $app->share(function () use ($app) {
    return new APP\Controllers\HelloController();
});
$app['controllers.customers'] = $app->share(function () use ($app) {
    return new APP\Controllers\CustomersController();
});

$app->get('/app', 'controllers.hello:indexAction')->bind('home');
$app->get('/app/hello', 'controllers.hello:indexAction')->bind('hellos');
$app->get('/app/hello/{name}', 'controllers.hello:showAction')->bind('hello');

//
// --------- Status Routes ------------
// Using an anonymous function to return the same response for two
// different routes.
//
$statusAction = function () {
    return 'Hello Status!';
};
$app->get('/status', $statusAction);
$app->get('/app/status', $statusAction);

//
// --------- Goodbye Routes -----------
// Using a feature switch to enable / disable certain routes.
//
if ($app['feature']->isActive('goodbye')) {
    $app->match('/app/goodbye/{name}', 'controllers.hello:showAction')->bind('goodbye');
}

//
// -------- Prefixed Routes -----------
// You can also set a group of routes to work with a shared prefix
//
$app['controllers.hello.prefixed'] = $app->share(function () use ($app) {
    return new APP\Hello\Controllers\HelloController();
});

// Create a new 'group' through the controllers_factory and bind routes as usual:
//$v2Routes = $app['controllers_factory'];
//$v2Routes->get('/hello', 'controllers.hello.prefixed:indexAction')->bind('hellos-v2');
//$v2Routes->get('/hello/{name}', 'controllers.hello.prefixed:showAction')->bind('hello-v2');

// and mount the v2 routes on their prefix:
//$app->mount('/app/v2/', $v2Routes);

$app->get('/customers/{id}', 'controllers.customers:showAction')->bind('customers_show');
$app->get('/customers', 'controllers.customers:listAction')->bind('customers_list');
$app->get('/styleguide', 'controllers.home:styleguideAction')->bind('styleguide');
$app->get('/', 'controllers.home:indexAction')->bind('home');
// the following routes are now mapped onto the controllers.hello.prefixed controller:
//  /app/v2/hello
//  /app/v2/hello/{name}
