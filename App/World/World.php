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
//        $name = 'Test';
//        $description = 'A white test room';
//        $detailedDescription = 'A very clinical and clean white test room';
//
//        $room = new Room($name, $description, $detailedDescription);
//        $hallway = new Room('Hallway', 'Blood everywhere', 'A murder must have happened here. So, so much blood');
//        $room->addExit($hallway, DirectionEnum::North);
//        $hallway->addExit($room, DirectionEnum::South);

//        echo $room->describe();
//        echo $room->describe(detailed: true);
        foreach ($this->rooms as $room) {
//            echo '---------------' . PHP_EOL;
//            echo $room->describe();
            echo '---------------' . PHP_EOL;
            echo $room->describe(detailed: true);
        }

        echo "\n";
    }
}