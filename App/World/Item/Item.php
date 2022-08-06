<?php

namespace App\World\Item;

use App\Interfaces\DescribeInterface;
use App\Interfaces\UsableInterface;
use App\Traits\DescribeTrait;
use App\Traits\UsableTrait;

class Item implements UsableInterface, DescribeInterface
{
    use UsableTrait;
    use DescribeTrait;

    private string $detailedDescription;
    private string $description;

    public function __construct(public readonly string $name)
    {
    }

    public function getDetailedDescription(): string
    {
        return $this->detailedDescription;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    function doUse(): string
    {
        return \sprintf('Using item %s', $this->name);
    }
}