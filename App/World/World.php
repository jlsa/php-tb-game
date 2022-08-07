<?php

namespace App\World;

use App\Enums\DirectionEnum;
use App\World\Room\Room;
use App\World\Room\RoomExit;

class World
{
    /**
     * @param Room[] $rooms
     */
    public function __construct(private array $rooms = [])
    {
    }

    /**
     * @return Room[]
     */
    public function getRooms(): array
    {
        return $this->rooms;
    }
}