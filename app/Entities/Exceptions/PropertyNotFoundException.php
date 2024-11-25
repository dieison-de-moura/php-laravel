<?php

namespace App\Entities\Exceptions;

use Exception;

class PropertyNotFoundException extends Exception
{
    /**
     * PropertyNotFoundException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct($message = 'Property not found', $code = 422)
    {
        parent::__construct($message, $code);
    }
}
