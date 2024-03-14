<?php

declare(strict_types=1);

namespace App\Auth\Actions;

use App\Auth\Application\Email\Confirmation\SendConfirmationEmailCommandHandler;
use App\Auth\Application\Email\EmailConfirmationParams;
use App\Auth\Application\Register\RegisterUserCommandHandler;
use App\Auth\Domain\AuthRepository;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use App\Shared\Actions\Action;

class ConfirmationEmailAction extends Action
{
    /**
     * @param LoggerInterface $logger
     * @param AuthRepository $authRepository
     */
    public function __construct(
        LoggerInterface $logger,
        private readonly AuthRepository $authRepository
    )
    {
        parent::__construct($logger);
    }

    /**
     * @return Response
     */
    protected function action(): Response
    {
        if (!$this->getFormData()) {
            throw new \InvalidArgumentException('Got empty data');
        }

        $params = EmailConfirmationParams::createFromArray($this->getFormData());

        $handler = new SendConfirmationEmailCommandHandler(

        );
    }
}
