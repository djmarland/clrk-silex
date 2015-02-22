<?php

namespace RMP\Hello\Tests\TestCase;

use Silex\WebTestCase as SilexWebTestCase;
use Silex\Application;

abstract class BaseWebTestCase extends SilexWebTestCase
{
    /**
     * Set-up function, called before each test function
     *
     * @return \Silex\Application
     */
    public function createApplication()
    {
        $app_env = 'unittests';
        $app_name = 'SilexReference';
        $app_release_number = '1.0';

        $app = new Application();

        include __DIR__ . '/../../../../bootstrap.php';
        include __DIR__ . '/../../../../config/routes.php';

        $app['exception_handler']->disable();

        return $app;
    }
}
