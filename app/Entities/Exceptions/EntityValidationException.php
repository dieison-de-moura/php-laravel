<?php

namespace App\Entities\Exceptions;

use Exception;

class EntityValidationException extends Exception
{
    /**
     * EntityValidationException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct($message = 'Entity validation failed', $code = 422)
    {
        parent::__construct($message, $code);
    }
}
