<?php

namespace App\Interfaces;

interface DescribeInterface
{
    function describe(bool $detailed = false): string;
    function getDetailedDescription(): string;
    function getDescription(): string;
}