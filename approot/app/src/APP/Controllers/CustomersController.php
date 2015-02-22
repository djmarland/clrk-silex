<?php
namespace APP\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CustomersController extends BaseController
{
    public function listAction(Request $request, Application $app)
    {
        $this->data->customers = $this->getService('customers')->getAll();
        $this->data->hasCustomers = !empty($this->data->customers);

        return $app['twig']->render('customers/list.html.twig', array(
            'data' => $this->data
        ));
    }

    public function showAction(Request $request, Application $app)
    {
        $id = $request->attributes->get('id');

        $this->data->customer = $this->getService('customers')->getById($id);

        return $app['twig']->render('customers/show.html.twig', array(
            'data' => $this->data,
            'customer' => $this->data->customer
        ));
    }

    public function styleguideAction(Request $request, Application $app)
    {
        return $app['twig']->render('home/styleguide.html.twig', array());
    }
}
