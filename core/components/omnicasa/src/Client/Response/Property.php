<?php

namespace modmore\Omnicasa\Client\Response;

use modmore\Omnicasa\Model\ocProperty;

final class Property {
    private array $data;

    private function __construct(array $item)
    {
        $this->data = $item;
    }

    public static function fromItem(array $item)
    {
        return new self($item);
    }

    public function __isset($key)
    {
        return array_key_exists($key, $this->data);
    }

    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function populate(ocProperty $dbProperty): void
    {
        foreach ($dbProperty->_fieldMeta as $key => $meta) {
            if (array_key_exists($key, $this->data) && !empty($this->data[$key])) {
                $dbProperty->set($key, $this->data[$key]);
            }
        }

        $dbProperty->set('type_of_property', ((int)$this->data['Goal'] === 1) ? ocProperty::TYPE_RENT : ocProperty::TYPE_SALE);
        $dbProperty->set('oc_ID', $this->data['ID']);
        $dbProperty->set('SynchronisedDate', date('Y-m-d H:i:s'));
        $dbProperty->set('all_data', $this->data);
    }
}