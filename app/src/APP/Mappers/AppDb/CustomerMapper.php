<?php

namespace APP\Mappers\AppDb;

use APP\Models\Customer;
use APP\Mappers\MapperInterface;
use APP\Mappers\Hydrators\SimpleHydrator;
use stdClass;

/**
 * Class CustomerMapper
 */
class CustomerMapper implements MapperInterface
{
    /**
     * @var SimpleHydrator
     */
    private $simpleHydrator;

    public function __construct(
      //  HydratorFactory $hydratorFactory
    ) {
        $this->simpleHydrator               = new SimpleHydrator;
    }

    /**
     * @param array $resultItem
     * @return Customer
     */
    public function getDomainModel(array $resultItem)
    {
        // core construct data
        $name           = $this->simpleHydrator->get($resultItem, 'name');
        $address        = $this->simpleHydrator->get($resultItem, 'address');
        $postcode       = $this->simpleHydrator->get($resultItem, 'postcode');

        // create entity
        $customer = new Customer(
            $name,
            $address,
            $postcode
        );

        return $customer;
    }
}
