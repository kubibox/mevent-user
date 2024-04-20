<?php

declare(strict_types=1);

namespace App\Register\Handler\Exception;

class EmailAlreadyExistedException extends \Exception
{
    private const PATTERN = 'The [%s] email already using, plead try another';

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        parent::__construct(sprintf(self::PATTERN, $email));
    }
}
