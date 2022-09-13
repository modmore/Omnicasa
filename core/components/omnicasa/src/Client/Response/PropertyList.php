<?php

namespace modmore\Omnicasa\Client\Response;

final class PropertyList
{

    private array $items;
    private int $totalResults;
    private int $from;
    private int $to;

    private function __construct(array $items, int $totalResults, int $from, int $to)
    {
        $this->items = $items;
        $this->totalResults = $totalResults;
        $this->from = $from;
        $this->to = $to;
    }


    /**
     * @param array $data
     * @return PropertyList
     */
    public static function fromResponse(array $data): PropertyList
    {
        $a = [];

        foreach ($data['Value']['Items'] as $item) {
            $a[] = Property::fromItem($item);
        }

        return new self($a,
            $data['Value']['RowsCount'],
            $data['Value']['From'],
            $data['Value']['To'],
        );
    }

    /**
     * @return Property[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getTotalResults(): int
    {
        return $this->totalResults;
    }

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function getTo(): int
    {
        return $this->to;
    }
}