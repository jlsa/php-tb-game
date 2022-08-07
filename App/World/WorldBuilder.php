<?php

namespace App\World;

use App\Enums\DirectionEnum;
use App\World\Room\Room;
use App\World\Room\RoomExitType;

/**
 * @phpstan-type RoomExitArray array{direction: string, room_id: int, exit_type: string}
 * @phpstan-type RoomArray array{id: int, name: string, description: string, detailed: string, exits: RoomExitArray}
 */
class WorldBuilder
{
    public static function buildFromJson(string $filename): World
    {
        $json = \file_get_contents(filename: $filename);
        if (!$json) {
            throw new \Exception(message: \sprintf(
                format: 'Unable to properly load the world file: %s',
                values: $filename
            ));
        }
        $data = (array)json_decode(json: $json, associative: true, flags: JSON_OBJECT_AS_ARRAY);
        $rooms = (new WorldBuilder())->buildRooms(worldData: $data);

        return new World(rooms: []);
//        return new World(rooms: $rooms ?? []);
    }

    /**
     * @param array<string, mixed> $worldData
     * @return Room[]
     */
    public function buildRooms(array $worldData): array
    {
        $rooms = [];
        $it = (array) $worldData['rooms'];
        foreach ($it as $room) {
            var_dump($room);
        }

        return $rooms;
    }

//    /**
//     * @throws \Exception
//     */
//    public static function buildFromXml(string $filename): World
//    {
//        $xmlData = simplexml_load_file(filename: $filename);
//        $jsonEncoded = json_encode(value: $xmlData, flags: JSON_HEX_TAG);
//        if (!$jsonEncoded) {
//            throw new \Exception(message: \sprintf(
//                format: 'Unable to properly load the world file: %s',
//                values: $filename
//            ));
//        }
//
//        $worldData = (array)json_decode($jsonEncoded, associative: true);
//        if (!isset($worldData['room'])) {
//            throw new \Exception(\sprintf(
//                'Unable to properly load the world file: %s',
//                $filename
//            ));
//        }
//
//        return new World(rooms: (new WorldBuilder())->buildRooms((array)$worldData['room']));
//    }

//    /**
//     * @param array<string|int, mixed> $worldData
//     * @return Room[]
//     */
//    private function buildRooms(array $worldData): array
//    {
//        $rooms = [];
//
//        for($i = 0; $i < count($worldData); $i++) {
//            $roomData = $worldData[$i];
//            $description = \trim($roomData['description']['default']);
//            if (!$roomData['description']['detailed']) {
//                $detailedDescription = $description;
//            } else {
//                $detailedDescription = \trim($roomData['description']['detailed']);
//            }
//
//            $room = new Room($roomData['id'], $roomData['name'], $description, $detailedDescription);
//            $rooms[$room->id] = $room;
//        }
//
//        return $rooms; //$this->addExitsToRooms($rooms, $worldData);
//    }

//    /**
//     * @param Room[] $rooms
//     * @param array<string, mixed> $worldData
//     * @return Room[]
//     */
//    private function addExitsToRooms(array $rooms, mixed $worldData): array
//    {
//        for ($i = 0; $i < count($worldData['room']); $i++) {
//            $roomData = $worldData['room'][$i];
//            $room = $rooms[$roomData['id']];
//
//            if (is_array($roomData['exit'])) {
//                foreach ($roomData['exit'] as $exit) {
//                    $direction = DirectionEnum::tryFrom($exit['direction'] ?? '');
//                    if (!$direction) {
//                        continue;
//                    }
//                    $exitType = RoomExitType::tryFrom($exit['exitType'] ?? '');
//                    $room->addExit($rooms[$exit['roomId']], DirectionEnum::tryFrom($exit['direction']), $exitType);
//                }
//            } else {
//                $direction = DirectionEnum::tryFrom($exit['direction'] ?? '');
//                $exitType = RoomExitType::tryFrom($exit['exitType'] ?? '');
//                if ($direction) {
//                    $room->addExit($rooms[$roomData['exit']['roomId']], $direction, $exitType);
//                }
//            }
//        }
//
//        return $rooms;
//    }
}