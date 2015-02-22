<?php
/**
 * Application entry point
 *
 * PHP version 5.4
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Elisabeth Anderson <beth.anderson@bbc.co.uk>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/bbc-rmp/deploy-pipeline
 */

use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Solution10\Config\Config;
use APP\Helpers\LogHandlerFactory;

/* Set default timezone */
date_default_timezone_set("Europe/London");

$app['env'] = 'live';
if (isset($app_env) && in_array($app_env, array('local','unittests','int','test','live'))) {
    $app['env'] = $app_env;
}

//
// Build config:
//
$app['config'] = new Config(__DIR__.'/config', ($app['env'] != 'live')? $app['env'] : null);

//
// Register Controller Service Provider
//
$app->register(new ServiceControllerServiceProvider());

//
// Set up Twig
//
$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__.'/views',
    'twig.options' => $app['config']->get('twig')
]);
$app['twig']->addExtension(new APP\Helpers\AssetHelper($app_name, $app_release_number));
$app['twig']->addFunction(
    new \Twig_SimpleFunction(
        'is_active',
        function ($key) use ($app) {
            return ($app['feature']->isActive($key)) ? true : false;
        }
    )
);

//
// Set up logging
//
$logHandlerFactory = new LogHandlerFactory($app['config']->get('logging'));
$app['log'] = new Logger('app', $logHandlerFactory->getHandlers());


//
// Misc Setup
//
$app['debug'] = $app['config']->get('app.debug', false);

/* DEBUG TO SHOW CURRENT CONFIG */
$app['log']->debug("The value of foo is: ".$app['config']->get('app.foo'));
$app['log']->debug("The value of bar is: ".$app['config']->get('app.bar'));
$app['log']->debug("The value of baz is: ".$app['config']->get('app.baz'));
/* END DEBUG TO SHOW CURRENT CONFIG */

/* UNCOMMENT THE FOLLOWING LINE TO ACTIVATE THE 'goodbye' FEATURE */
// $app['feature']->activate('goodbye');
