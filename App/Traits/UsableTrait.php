<?php

namespace App\Traits;

trait UsableTrait
{
    public function use(): string
    {
        return $this->doUse();
    }
}