<?php

declare(strict_types=1);

namespace App\Register\Actions;

use App\Auth\Domain\AuthRepository;
use App\Register\Application\Email\Confirmation\SendConfirmationEmailCommandHandler;
use App\Register\Application\Email\EmailConfirmationParams;
use App\Shared\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

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
