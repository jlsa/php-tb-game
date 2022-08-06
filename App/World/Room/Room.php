<?php

namespace App\World\Room;

use App\Enums\DirectionEnum;
use App\Interfaces\DescribeInterface;
use App\Traits\DescribeTrait;
use App\World\Item\Item;

class Room implements DescribeInterface
{
    use DescribeTrait;

    /** @var RoomExit[] */
    private array $exits = [];

    /** @var Item[] */
    private array $items = [];

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        private readonly string $description = '',
        private readonly string $detailedDescription = '',
    ) {
    }

    public function getDescription(): string
    {
//        $output = $this->name . PHP_EOL;
        $output = wordwrap($this->description) . PHP_EOL;
        $output .= PHP_EOL;

        if ($this->exits) {
            // exits
            $output .= 'Exits: ' . PHP_EOL;
            foreach ($this->exits as $exit) {
                $output .= $exit->describe();
            }
        }
        if ($this->items) {
            // items
            $output .= PHP_EOL;
            $output .= 'Items: ' . PHP_EOL;
            foreach ($this->items as $item) {
                $output .= $item->describe();
            }
        }

        return $output;
    }

    public function getDetailedDescription(): string
    {
        $output = wordwrap($this->detailedDescription) . PHP_EOL;
        if ($this->exits) {
            // exits
            $output .= 'Exits: ' . PHP_EOL;
            foreach ($this->exits as $exit) {
                $output .= $exit->describe(detailed: true);
            }
        }
        if ($this->items) {
            // items
            $output .= PHP_EOL;
            $output .= 'Items: ' . PHP_EOL;
            foreach ($this->items as $item) {
                $output .= $item->describe(detailed: true);
            }
        }

        return $output;
    }

    /**
     * @param Item[] $items
     */
    public function setItems(array $items): static
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param array<DirectionEnum, Room> $rooms
     */
    public function addExits(array $rooms): static
    {
        foreach ($rooms as $direction => $room) {
            $this->addExit($room, DirectionEnum::from($direction));
        }

        return $this;
    }

    public function addExit(Room $to, DirectionEnum $direction, ?RoomExitType $exitType = null): static
    {
        $this->exits[] = new RoomExit($this, $to, $direction, $exitType);
//        $to->addExit($this, $direction->getOpposite());

        return $this;
    }

    public function addItem(Item $item): static
    {
        $this->items[] = $item;

        return $this;
    }
}