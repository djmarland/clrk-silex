<?php

namespace APP\Services;

use APP\Mappers\CustomerMapper;

class CustomersService extends BaseService
{



    public function getAll()
    {
        $results = $this->data;
        $customers = array();
        $mapper = new CustomerMapper;
        foreach ($results as $result) {
            $customers[] = $mapper->getDomainModel($result);
        }
        return $customers;
    }

    public function getById($id)
    {
        $result = $this->data[$id];
        $mapper = new CustomerMapper;
        return $mapper->getDomainModel($result);
    }

    private $data = array(
        array(
            'name' => 'Jon Smith',
            'address' => 'home
            wesminster
            london',
            'postcode' => 'HA9 0HL'
        ),
        array(
            'name' => 'Bob Bobertson',
            'address' => null,
            'postcode' => null
        )


    );

}