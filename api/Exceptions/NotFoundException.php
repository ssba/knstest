<?php

namespace Exceptions;

class NotFoundException extends \Exception
{
    public function __construct() {
        parent::__construct("Not Found", 404, null);
    }

    // Переопределим строковое представление объекта.
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
