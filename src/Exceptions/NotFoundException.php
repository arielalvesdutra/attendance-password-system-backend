<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $code = 404;
}
