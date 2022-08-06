<?php

namespace App\World\Room;

enum RoomExitType: string
{
    case Door = 'door';
    case Gate = 'gate';
    case Window = 'window';
    case Portal = 'portal';
    case Stairs = 'stairs';
    case Ladder = 'ladder';
    case Hole = 'hole';
    case Other = 'other';
}