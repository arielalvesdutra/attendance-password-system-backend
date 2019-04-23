<?php

namespace App\Entities\Status;

use App\Entities\AttendanceStatus;

class CreatedStatus extends AttendanceStatus
{

    const CODE = "CREATED";

    protected $code = self::CODE;

    private function setStatus()
    {

    }
}