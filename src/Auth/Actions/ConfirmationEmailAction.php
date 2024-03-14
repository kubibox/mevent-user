<?php

declare(strict_types=1);

namespace App\Auth\Actions;

use App\Auth\Domain\AuthRepository;
use Psr\Log\LoggerInterface;

class ConfirmationEmailAction
{
    public function __construct(LoggerInterface $logger, private readonly AuthRepository $authRepository)
    {
        parent::__construct($logger);
    }
}
