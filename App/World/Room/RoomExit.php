<?php

namespace App\World\Room;

use App\Enums\DirectionEnum;
use App\Interfaces\DescribeInterface;
use App\Interfaces\UsableInterface;
use App\Traits\DescribeTrait;
use App\Traits\UsableTrait;

class RoomExit implements UsableInterface, DescribeInterface
{
    use UsableTrait;
    use DescribeTrait;

    public function __construct(
        private readonly Room $from,
        private readonly Room $to,
        private readonly DirectionEnum $direction,
        private readonly RoomExitType $exitType = RoomExitType::Door
    ) {
    }

    function doUse(): string
    {
        return 'Using door exit ...';
    }

    function getDetailedDescription(): string
    {
        return \sprintf(
            ' %s %s %s %s',
            $this->exitType->value,
            $this->direction->value,
            $this->to->name,
            PHP_EOL
        );
    }

    function getDescription(): string
    {
        return ' ' . $this->direction->value . ' ' . $this->to->name . PHP_EOL;
    }
}