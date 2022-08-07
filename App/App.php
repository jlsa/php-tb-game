<?php

namespace App;

use App\World\World;
use App\World\WorldBuilder;

class App
{
    private World $world;

    public function __construct()
    {
//        $this->world = WorldBuilder::buildFromXml(filename: './data/world.xml');
        $this->world = WorldBuilder::buildFromJson(filename: './data/world.json');
    }

    public function start(): void
    {
        $rooms = $this->world->getRooms();

        foreach ($rooms as $room) {
            echo '--------------------';
            echo PHP_EOL;
            echo $room->describe();
            echo PHP_EOL;
        }
    }
}