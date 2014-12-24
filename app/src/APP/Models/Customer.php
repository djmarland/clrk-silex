<?php

namespace APP\Models;


class Customer extends BaseModel
{

    private $name;
    private $address;
    private $postcode;

    public function __construct(
        $name,
        $address = null,
        $postcode = null
    )
    {
        $this->name = $name;
        $this->address = $address;
        $this->postcode = $postcode;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getInlineAddress()
    {
        $address = nl2br($this->address);
        return str_replace('<br />',', ',$address);
    }

    public function getPostcode()
    {
        return $this->postcode;
    }
}