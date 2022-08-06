<?php

namespace App\World;

use App\Enums\DirectionEnum;
use App\World\Room\Room;
use App\World\Room\RoomExitType;

class WorldBuilder
{
    public static function buildFromXml(string $filename): World
    {
        $xmlData = simplexml_load_file($filename);
        $worldData = json_decode(json_encode($xmlData, true));

        return new World((new WorldBuilder())->buildRooms($worldData));
    }

    /**
     * @param mixed $worldData
     * @return Room[]
     */
    private function buildRooms(mixed $worldData): array
    {
        $rooms = [];

        for($i = 0; $i < count($worldData->room); $i++) {
            $roomData = $worldData->room[$i];
            $description = \trim($roomData->description->default);
            if ($roomData->description->detailed instanceof \stdClass) {
                $detailedDescription = $description;
            } else {
                $detailedDescription = \trim($roomData->description->detailed);
            }

            $room = new Room($roomData->id, $roomData->name, $description, $detailedDescription);
            $rooms[$room->id] = $room;
        }

        return $this->addExitsToRooms($rooms, $worldData);
    }

    /**
     * @param Room[] $rooms
     * @param mixed $worldData
     * @return Room[]
     */
    private function addExitsToRooms(array $rooms, mixed $worldData): array
    {
        for ($i = 0; $i < count($worldData->room); $i++) {
            $roomData = $worldData->room[$i];
            /** @var Room $room */
            $room = $rooms[$roomData->id];

            if (is_array($roomData->exit)) {
                foreach ($roomData->exit as $exit) {
                    $direction = DirectionEnum::tryFrom($exit->direction ?? '');
                    if (!$direction) {
                        continue;
                    }
                    $exitType = RoomExitType::tryFrom($exit->exitType ?? '');
                    $room->addExit($rooms[$exit->roomId], DirectionEnum::tryFrom($exit->direction), $exitType);
                }
            } else {
                $direction = DirectionEnum::tryFrom($exit->direction ?? '');
                $exitType = RoomExitType::tryFrom($exit->exitType ?? '');
                if ($direction) {
                    $room->addExit($rooms[$roomData->exit->roomId], $direction, $exitType);
                }
            }
        }

        return $rooms;
    }
}