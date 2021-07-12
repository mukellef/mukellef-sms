<?php

namespace Mukellef\MukellefSms\Exceptions;

use Exception;

class DriverConfigurationException extends Exception
{
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
