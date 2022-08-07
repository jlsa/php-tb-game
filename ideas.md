# Ideas

### RoomExit
A room exit should be between two rooms. Not two different `RoomExit`s between two `Room`s

### Locked Rooms
A locked room doesn't exist. It's the exit that is locked. It can be locked from one side but also from both. This then needs to be defined on both sides of the exit. For how it's set up right now. See header `RoomExit` for another idea.

In the next code example I've demonstrated the idea that the user should have seen a room once, have a specific item (probably a key) and has been drinking 10 beers.

**Code example:**
```json
{
  "exits": [
    {
      "direction": "north",
      "room_id": 6,
      "exit_type": "gate",
      "lock": {
        "locked": true,
        "unlock_conditions": [
          {
            "type": "seen",
            "value": {
              "room": 7
            },
            "quantity": 1
          },
          {
            "type": "item",
            "value": {
              "key": 823472824
            },
            "quantity": 1
          },
          {
            "type": "consumed",
            "value": {
              "drink": "beer"
            },
            "quantity": 10
          }
        ]
      }
    }
  ]
}
```

### Hiding 
Allow hidden when looking/inspecting. Only show when specific events or flags are on the player or other things.


### Unable to go to a direction, yet it is there, just for the fun of it.
Like this example, there is a major city wall, it is way too high for the user to climb. So he would probably need something to go there. But for this first example lets say there isn't a way/method to go there.
```json
{
  "exits": [
    {
      "direction": "up",
      "room_id": 4,
      "exit_type": "other",
      "notifications": [
        {
          "variant": "error",
          "message": "Unable to climb up. It's way to high."
        }
      ]
    }
  ]
}
```

### Events
It would be awesome to have specific events occurring when conditions have been met, like falling rocks from a mountain side. An NPC only in a room at a specific time of day. Or the bartender is kicking you out of the pub when you've consumed too much. Or a bar fight when you annoy the other customers too much. Which also prevents you from entering the bar for a specific amount of time.

### Time
One action equals passing of time. How many would be one day? Does that depend on the action?

### NPCs
- Non-interactive NPCs
- Animal NPCs (you can pet the cat, but it might not like it if you do it too much)
- Vendor NPCs
- Monsters
- Other interactive NPCs

### Items
Some items could just be ornaments to a room, which can only be inspected, or not even. Some you need to have specific magic vision for to see. More from that kinds of stuff. 
Some can be looted, picked up, interacted with.
The player does need to have an inventory.

### Inventory
Do I limit the player theirs amount or can it be as big as they want?
Limiting requires throwing away.
So inventory management features, add, throw away, move, combine? (crafting!)

### Crafting
Magic? Blacksmithing and the likes, like WoW is awesome.

### Mining

### Movement
The player can move from one room to the other. Yet I would like it to be more in the nature of a specific room has tile based movement inside it.

```text
 ______  ______ 
|      ][______][Other rooms]      
|      |
|      |
|______| 
```
So the player can go in any `RoomExitDirection` only when they are on a tile that has that interaction.
Else they can move left, up, down, right. Or not? I'm not sure yet. Perhaps the same directions can be applied but the player then needs to do `leave north` or `leave up`
Or `move forward`, `move left`, `move right`, `move backward`

### Commands
Commands like: move, look, inspect, describe, use, interact, touch, feel and many more



