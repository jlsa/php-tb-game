<?php

namespace App;

use App\World\World;
use App\World\WorldBuilder;

class App
{
    private World $world;

    public function __construct()
    {
        $this->world = WorldBuilder::buildFromXml('./data/world.xml');
    }

    public function start(): void
    {

    }
}