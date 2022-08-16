<?php

namespace App\World;

class WorldGenerator
{
    /** @var array<int, string[]>  */
    private array $grid = [];

    private int $width = 120;
    private int $height = 30;

    public function __construct()
    {
        print_r($this->grid);
        $this->generate();
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
        $pi = 3.14159265359;
        $theta = mt_rand() * 2 * $pi;


        header("Content-type: image/png");
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

        imagepng($img);
        imagedestroy($img);


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
}