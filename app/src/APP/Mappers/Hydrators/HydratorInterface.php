<?php

namespace APP\Mappers\Hydrators;

use stdClass;

/**
 * Interface HydratorInterface
 */
interface HydratorInterface
{
    /**
     * @param array $resultItem
     * @param $memberName
     * @return mixed
     */
    public function get(array $resultItem, $memberName = '');
}
