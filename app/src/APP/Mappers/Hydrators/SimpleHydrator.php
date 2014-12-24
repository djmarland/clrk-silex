<?php

namespace APP\Mappers\Hydrators;

use Exception;
use stdClass;

/**
 * Class SimpleHydrator
 *
 * Handle strings and booleans
 *
 */
class SimpleHydrator implements HydratorInterface
{
    /**
     * @param array $resultItem
     * @param string $memberName
     * @return string
     * @throws Exception
     */
    public function get(array $resultItem, $memberName = '')
    {
        $currentItem = null;
        if (isset($resultItem[$memberName])) {
            $currentItem = $resultItem[$memberName];
        }

        if ($currentItem == 'true') {
            return true;
        }
        if ($currentItem == 'false') {
            return false;
        }
        return $currentItem;
    }
}
