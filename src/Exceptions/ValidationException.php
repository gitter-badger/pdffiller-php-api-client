<?php

namespace PDFfiller\OAuth2\Client\Provider\Exceptions;

use PDFfiller\OAuth2\Client\Provider\Core\Exception;

class ValidationException extends Exception
{
    const EXCEPTION_KEY = 'validation';
    protected $errors = [];

    public function __construct($errors, $message = "", $code = 0, Exception $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function getDefaultMessage()
    {
        return parent::getDefaultMessage() . ':' . PHP_EOL . $this->errors;
    }
}