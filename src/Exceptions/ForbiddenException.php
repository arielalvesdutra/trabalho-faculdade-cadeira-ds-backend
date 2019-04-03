<?php

namespace App\Exceptions;

use Exception;

/**
 * Class ForbiddenException
 * @package App\Exceptions
 */
class ForbiddenException extends Exception
{
    protected $code = 403;
}