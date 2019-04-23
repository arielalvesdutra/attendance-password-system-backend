<?php

namespace App\Entities\Status;

use App\Entities\AttendanceStatus;

class CompletedStatus extends AttendanceStatus
{

    const CODE = "COMPLETED";

    protected $code = self::CODE;

    private function setStatus()
    {

    }
}