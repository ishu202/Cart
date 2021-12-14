<?php

namespace Cart\Exceptions;

use Exception;
use Throwable;

class InvalidRentalException extends Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("the item is missing one of the following keys
        ['price' , 'from' , 'to' , 'pick' , 'drop' , 'duration' , 'delivery_method' ] please check the item post data.", $code, $previous);
    }
}