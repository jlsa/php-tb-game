<?php

namespace App\Traits;

trait DescribeTrait
{
    public function describe(bool $detailed = false): string
    {
        return $detailed ? $this->getDetailedDescription() : $this->getDescription();
    }
}