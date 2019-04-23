<?php

namespace App\Entities\Status;

use App\Entities\AttendanceStatus;

class InProgressStatus extends AttendanceStatus
{

    const CODE = "IN_PROGRESS";

    protected $code = self::CODE;

    private function setStatus()
    {

    }
}