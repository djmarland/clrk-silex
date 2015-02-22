<?php
/**
 * Application index
 *
 * PHP version 5.4
 *
 * @category CategoryName
 * @package  PackageName
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 */

use Silex\Application;

ini_set('display_errors', true);

require_once __DIR__.'/../vendor/autoload.php';

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$app_name = getenv('APP_NAME') ?: '';
$app_release_number = getenv('APP_RELEASE_NUMBER') ?: '';
$app_env = getenv('APP_ENV') ?: 'production';

//
// Build the Application object here:
//
$app = new Application();

//
// Run the bootstrap:
//
include __DIR__ . '/../app/bootstrap.php';

//
// Build the routes
//
require __DIR__ . '/../app/config/routes.php';

//
// Run the application:
//
$app->run();
