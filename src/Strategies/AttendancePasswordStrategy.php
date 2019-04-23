<?php

namespace App\Strategies;


class AttendancePasswordStrategy
{

    public function addZerosToLeftStringSide($variable, int $limitSize = 4)
    {
        return str_pad($variable, $limitSize, '0', STR_PAD_LEFT);
    }
}
