<?php

namespace modmore\Omnicasa\Client;

use modmore\Omnicasa\Client\Response\Property;
use modmore\Omnicasa\Client\Response\PropertyList;

final class Properties extends Base {

    /**
     * @param array $filter
     * @param string|null $sort
     * @return PropertyList
     */
    public function list(array $filter = [], string $sort = null): PropertyList
    {
        return $this->call('GetPropertyListJson', [

        ], PropertyList::class);
    }

    public function get($id): Property
    {

    }
}
