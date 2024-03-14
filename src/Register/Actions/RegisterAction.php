<?php

declare(strict_types=1);

namespace App\Register\Actions;

use App\Auth\Application\AuthParams;
use App\Register\Application\Register\RegisterUserCommand;
use App\Register\Application\Register\RegisterUserCommandHandler;
use App\Register\Application\Register\UserRegister;
use App\Register\Domain\RegisterRepository;
use App\Shared\Actions\Action;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class RegisterAction extends Action
{
    /**
     * @param LoggerInterface $logger
     * @param RegisterRepository $registerRepository
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly RegisterRepository $registerRepository
    ){
    }

    /**
     * @return Response
     */
    protected function action(): Response
    {
        $this->logger->info('Register a new user');
        //todo add verification for data

        $params = AuthParams::createFromArray($this->getFormData());

        $command = new RegisterUserCommand(
            $params->email(),
            $params->password(),
        );

        $handler = new RegisterUserCommandHandler(new UserRegister($this->registerRepository));

        try {
            $handler($command);
        } catch (Exception $exception) {
            return $this->respondException($exception);
        }
    }
}
