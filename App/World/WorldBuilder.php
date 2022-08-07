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
    /**
     * @throws \Exception
     */
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

        return new World(rooms: (new WorldBuilder())->buildRooms(worldData: $data));
    }

    /**
     * @param array<mixed, mixed> $worldData
     * @return Room[]
     * @throws \Exception
     */
    public function buildRooms(array $worldData): array
    {
        $rooms = [];
        foreach ((array) $worldData['rooms'] as $row) {
            $rooms[] = new Room(
                id: (int)$row['id'],
                name: (string)$row['name'],
                description: (string)$row['description'],
                detailedDescription: (string)$row['detailed_description']
            );
        }

        return $this->addExitsToRooms($rooms, $worldData);
    }

    /**
     * @param Room[] $rooms
     * @param array<mixed, mixed> $worldData
     * @return Room[]
     * @throws \Exception
     */
    public function addExitsToRooms(array $rooms, array $worldData): array
    {
        foreach ($worldData['rooms'] as $row) {
            $room = $rooms[$row['id']];
            foreach ($row['exits'] as $exit) {
                $direction = DirectionEnum::tryFrom($exit['direction'] ?? '');
                if (!$direction) {
                    throw new \Exception(\sprintf('There is no direction for %s', $exit['direction']));
                }

                $room->addExit(
                    to: $rooms[$exit['room_id']],
                    direction: $direction,
                    exitType: RoomExitType::tryFrom($exit['exitType'] ?? '')
                );
            }
        }

        return $rooms;
    }
}