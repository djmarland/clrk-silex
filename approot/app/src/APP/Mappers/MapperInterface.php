<?php

namespace APP\Mappers;


/**
 * Interface MapperInterface
 */
interface MapperInterface
{
    public function getDomainModel(array $dbArray);
}
