<?php
$world = \simplexml_load_file("../data/world.xml");
$currentPos = 0;
$done = 0;
print "\n";
printplace();

function printplace() {
    GLOBAL $world, $currentPos;
    $room = $world->room[$currentPos];
    $name = $room->name;
    $desc = wordwrap((string)$room->desc);
    print "$name\n";
    print str_repeat('-', strlen($name));
    print "\n$desc\n\n";

    if ((string)$room->north != '-') {
        $index = (int)$room->north;
        print "North: {$world->room[$index]->name}\n";
    }

    if ((string)$room->south != '-') {
        $index = (int)$room->south;
        print "South: {$world->room[$index]->name}\n";
    }

    if ((string)$world->room[$currentPos]->west != '-') {
        $index = (int)$room->west;
        print "West: {$world->room[$index]->name}\n";
    }

    if ((string)$world->room[$currentPos]->east != '-') {
        $index = (int)$room->east;
        print "East: {$world->room[$index]->name}\n";
    }

    print "\n";
}
// IDEA: allow hidden when looking. Only show when specific events or flags are
// on the player or other things.
while (!$done) {
    $input = fgets(STDIN);
    print "\n"; // add another line break after the user input

    $input = explode(' ', $input);

    switch(trim($input[0])) {
        case 'north':
            if ((string)$world->room[$currentPos]->north != '-') {
                $currentPos = (int)$world->room[$currentPos]->north;
                printplace() ;
            } else {
                print "You cannot go north!\n";
            }
            break;
        case 'south':
            if ((string)$world->room[$currentPos]->south != '-') {
                $currentPos = (int)$world->room[$currentPos]->south;
                printplace() ;
            } else {
                print "You cannot go south!\n";
            }
            break;
        case 'west':
            if ((string)$world->room[$currentPos]->west != '-') {
                $currentPos = (int)$world->room[$currentPos]->west;
                printplace() ;
            } else {
                print "You cannot go west!\n";
            }
            break;
        case 'east':
            if ((string)$world->room[$currentPos]->east != '-') {
                $currentPos = (int)$world->room[$currentPos]->east;
                printplace() ;
            } else {
                print "You cannot go east!\n";
            }
            break;
        case 'look':
            printplace() ;
            break;
        case 'quit':
            $done = 1;
            break;
    }
}

print "\nThanks for playing!\n\n";

