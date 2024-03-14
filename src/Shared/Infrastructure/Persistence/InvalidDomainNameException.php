<?php

namespace App\Shared\Infrastructure\Persistence;

use Exception;
use Slim\Logger;
use Throwable;

class InvalidDomainNameException extends Exception
{
    private const MASSAGE = 'Undefined domain name';

    /**
     * @return Throwable
     */
    public static function create(): Throwable
    {
        return new static(self::MASSAGE);
    }
}
