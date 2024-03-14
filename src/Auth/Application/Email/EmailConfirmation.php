<?php

declare(strict_types=1);

namespace App\Auth\Application\Email;

use App\Auth\Domain\AuthRepository;

class EmailConfirmation
{
    public function __construct(AuthRepository $repository)
    {

    }
}
