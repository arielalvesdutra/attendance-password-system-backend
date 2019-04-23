<?php

namespace App\Entities\Status;

use App\Entities\AttendanceStatus;

class CanceledStatus extends AttendanceStatus
{

    const CODE = "CANCELED";

    protected $code = self::CODE;

    private function setStatus()
    {

    }
}