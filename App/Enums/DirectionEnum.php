<?php

namespace App\Enums;

enum DirectionEnum: string
{
    case North = 'north';
    case East = 'east';
    case South = 'south';
    case West = 'west';
    case Up = 'up';
    case Down = 'down';

    /**
     * @throws \Exception
     */
    public function getOpposite(): DirectionEnum
    {
        return match($this->value) {
            DirectionEnum::Down->value => DirectionEnum::Up,
            DirectionEnum::Up->value => DirectionEnum::Down,
            DirectionEnum::North->value => DirectionEnum::South,
            DirectionEnum::East->value => DirectionEnum::West,
            DirectionEnum::South->value => DirectionEnum::North,
            DirectionEnum::West->value => DirectionEnum::East,
            default => throw new \Exception('Unexpected match value'),
        };
    }
}