<?php

namespace Cart\Exceptions;

use Exception;
use Throwable;

class InvalidItemException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("invalid malformed item in the cart.", 401, $previous);
    }
}