<?php

namespace App\World;

class WorldGenerator
{
//    /** @var array<int, string[]>  */
//    private array $grid = [];

    private int $width = 250;//120;
    private int $height = 250;//30;

    public function __construct()
    {
//        print_r($this->grid);
        $this->north = 1;
        $this->south = 2;
        $this->east = 4;
        $this->west = 8;

        $this->dx = [
            $this->east => 1,
            $this->west => -1,
            $this->north => 0,
            $this->south => 0,
        ];
        $this->dy = [
            $this->east => 0,
            $this->west => 0,
            $this->north => -1,
            $this->south => 1,
        ];

        $this->opposite = [
            $this->north => $this->south,
            $this->south => $this->north,
            $this->west => $this->east,
            $this->east => $this->west,
        ];

//        $this->generateMaze();
//        $this->generate();
    }

    private function generate(): void
    {
        $this->generateRooms(width: $this->width, height: $this->height);
    }

    private function generateRooms(int $width, int $height): void
    {
        $room = [
            ['▒', '▒', '▒', '▒', '▒', '▒', '▒', '▒', '▒'],
            ['▒', '=', '=', '▒', '=', '=', '=', '=', '▒'],
            ['▒', '=', '=', '▒', '=', '=', '=', '=', '▒'],
            ['▒', '=', '░', '▒', '=', '=', '=', '=', '▒'],
            ['▒', '=', '░', '=', '=', '=', '=', '=', '▒'],
            ['▒', '=', '.', '=', '=', '=', '=', '=', '▒'],
            ['▒', '=', '.', '▒', '=', '=', '=', '=', '▒'],
            ['▒', '=', '=', '▒', '=', '=', '=', '=', '▒'],
            ['▒', '▒', '▒', '▒', '▒', '▒', '▒', '▒', '▒'],
        ];
        $this->grid = $room;

//        for ($y = 0; $y < $height; $y++) {
//            for ($x = 0; $x < $width; $x++) {
//                $this->grid[$y][$x] = '▒';
//                if ($x + $height * $y % 4 === 24) {
//                    $this->grid[$y][$x] = '≡';
//                }
//            }
//        }
    }

    public function render(): void
    {
//        $pi = 3.14159265359;
//        $theta = mt_rand() * 2 * $pi;

        $sizex = 800;
        $sizey = 400;

        $img = imagecreatetruecolor($sizex, $sizey);
        $ink = imagecolorallocate($img, 255, 255, 255);

        for ($i = 0; $i < $sizex / 2; $i++) {
            for ($j = 0; $j < $sizey; $j++) {
                imagesetpixel($img, rand(1, $sizex / 2), rand(1, $sizey), $ink);
            }
        }

        for ($i = $sizex / 2; $i < $sizex; $i++) {
            for ($j = 0; $j < $sizey; $j++) {
                imagesetpixel($img, mt_rand($sizex / 2, $sizex), mt_rand(1, $sizey), $ink);
            }
        }

        imagepng($img, 'lala.png');
        imagedestroy($img);

        $this->renderMaze();


//        $R = 1;
//        $pi = 3.14159265359;
//        $r = $R * sqrt(mt_rand());
//        $theta = mt_rand() * 2 * $pi;
//
//        // cartesian coordinates
//        $x = $centerX + $r * cos($theta);
//        $y = $centerY + $r * sin($theta);

//        for ($y = 0; $y < \count($this->grid); $y++) {
//            for ($x = 0; $x < \count($this->grid[$y]); $x++) {
//                echo '';
//                echo $this->grid[$y][$x];
//                echo '';
//            }
//            echo PHP_EOL;
//        }
    }

    private function renderMaze(?array $grid = null): void
    {
        if (!$grid) {
            $grid = [];
            for ($y = 0; $y < $this->height; $y++) {
                for ($x = 0; $x < $this->width; $x++) {
                    $grid[$y][$x] = mt_rand(1, 255);
                }
            }
        }
        $image = imagecreatetruecolor($this->width, $this->height);

        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                $red = 255 - (int)(255 / $grid[$y][$x]);
                $green = 255 - (int)(255 / $grid[$y][$x]);
                $blue = 255 - (int)(255 / $grid[$y][$x]);
                $color = imagecolorallocate($image, $red, $green, $blue);
                imagesetpixel($image, $x, $y, $color);
            }
        }

        imagepng($image, 'maze.png');
        imagedestroy($image);
    }

    public function generateMaze(): void
    {
        $grid = [];
        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                $grid[$y][$x] = 0;
            }
        }
        $grid = $this->carvePassagesFrom(0, 0, $grid);
        $this->renderMaze($grid);
    }

    private function carvePassagesFrom(int $currentX, int $currentY, array $grid): array
    {
        $directions = [$this->north, $this->south, $this->east, $this->west];
        shuffle($directions);

        foreach ($directions as $direction) {
            $nextX = $currentX + $this->dx[$direction];
            $nextY = $currentY + $this->dy[$direction];

            if ($this->isOutOfBounds($nextX, $nextY, $grid)) {
                continue;
            }

            if ($this->hasAlreadySeen($nextX, $nextY, $grid)) {
                continue;
            }

            $grid[$currentY][$currentX] |= (int)$direction;
            $grid[$nextY][$nextX] |= (int)$this->opposite[$direction];

            $grid = $this->carvePassagesFrom($nextX, $nextY, $grid);
        }

        return $grid;
    }

    private function hasAlreadySeen(int $x, int $y, array $grid): bool
    {
        return $grid[$y][$x] !== 0;
    }

    private function isOutOfBounds(int $x, int $y, array $grid): bool
    {
        if ($x < 0 || $x > count($grid) - 1) {
            return true;
        }

        if ($y < 0 || $y > count($grid[$x]) - 1) {
            return true;
        }

        return false;
    }
}