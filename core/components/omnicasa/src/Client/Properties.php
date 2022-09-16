<?php

namespace modmore\Omnicasa\Client;

use modmore\Omnicasa\Client\Response\PropertyList;

final class Properties extends Base {

    /**
     * @param array $data
     * @return PropertyList
     */
    public function list(array $data = []): PropertyList
    {
        return $this->call('GetPropertyListJson', $data, PropertyList::class);
    }

    public function total(): int
    {
        /** @var PropertyList $result */
        $result = $this->call('GetPropertyListJson', [
            'Limit1' => 0,
            'Limit2' => 1,
        ], PropertyList::class);

        return $result->getTotalResults();
    }
}
