<?php
namespace APP\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class BaseController
{
    public $data;

    private $services = array();

    public function __construct()
    {
        $this->data = new \StdClass;
    }

    protected function getService($name)
    {
        $className = '\APP\Services\\' . ucfirst($name) . 'Service';
        if (!isset($services[$className])) {
            $services[$className] = new $className;
        }
        return $services[$className];
    }
}
