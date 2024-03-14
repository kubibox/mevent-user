<?php

declare(strict_types=1);

namespace App\Auth\Actions;

use App\Auth\Application\Authenticate\AuthenticateUserCommand;
use App\Auth\Application\Authenticate\AuthenticateUserCommandHandler;
use App\Auth\Application\Authenticate\UserAuthenticator;
use App\Auth\Application\AuthParams;
use App\Auth\Domain\AuthRepository;
use App\Auth\Domain\InvalidPasswordException;
use App\Auth\Domain\InvalidUsernameException;
use App\Shared\Actions\Action;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

final class AuthAction extends Action
{
    /**
     * @param LoggerInterface $logger
     * @param ContainerInterface $container
     * @param AuthRepository $authRepository
     */
    public function __construct(
        protected readonly LoggerInterface $logger,
        protected readonly ContainerInterface $container,
        private readonly AuthRepository $authRepository
    )
    {
    }

    protected function action(): Response
    {
        $params = AuthParams::createFromArray($this->getFormData());

        $command = new AuthenticateUserCommand(
            $params->email(),
            $params->password()
        );

        $handler = new AuthenticateUserCommandHandler(new UserAuthenticator($this->authRepository));

        try {
            $handler($command);
        } catch (InvalidUsernameException | InvalidPasswordException $exception) {
            return $this->respondException($exception, 404);
        } catch (Exception $exception) {
            return $this->respondException($exception);
        }

        return $this->respondWithData([
            'success' => true,
            'token' => 'token' //generate temp token
        ]);
    }
}
