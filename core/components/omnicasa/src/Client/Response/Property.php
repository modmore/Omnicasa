<?php

namespace modmore\Omnicasa\Client\Response;

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
}