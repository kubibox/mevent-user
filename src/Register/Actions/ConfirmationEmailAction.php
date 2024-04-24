<?php

declare(strict_types=1);

namespace App\Register\Actions;

use App\Register\Application\Email\Confirmation\SendConfirmationEmailCommand;
use App\Register\Application\Email\Confirmation\SendConfirmationEmailCommandHandler;
use App\Register\Application\Email\EmailConfirmation;
use App\Register\Application\Email\EmailConfirmationParams;
use App\Register\Application\JWTTokenService;
use App\Register\Domain\RegisterRepository;
use App\Register\Handler\Exception\EmailAlreadyExistedException;
use App\Register\Handler\Exception\InvalidEmailException;
use App\Shared\Actions\Action;
use App\TemporaryAccessToken\Infrastructure\Persistence\DoctrineTemporaryAccessTokensRepository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

final class ConfirmationEmailAction extends Action
{
    /**
     * @param LoggerInterface $logger
     * @param ContainerInterface $container
     * @param RegisterRepository $repository
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ContainerInterface $container,
        private readonly RegisterRepository $repository,
    ) {
    }

    /**
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function action(): Response
    {
        $this->logger->info('Run confirmation controller');

        try {
            if (!$this->getFormData()) {
                throw new \InvalidArgumentException('Got empty data');
            }

            $params = EmailConfirmationParams::createFromArray($this->getFormData());
        } catch (\Exception $exception) {
            return $this->error([
                $exception->getMessage()
            ], 401);
        }

        $handler = new SendConfirmationEmailCommandHandler(
            new EmailConfirmation(
                $this->repository,
                $this->container->get(MailerInterface::class),
                $this->container->get(JWTTokenService::class),
                $this->container->get(DoctrineTemporaryAccessTokensRepository::class)
            ),
        );

        try {
            $handler(new SendConfirmationEmailCommand($params->email()));
        } catch (EmailAlreadyExistedException $exception) {
            return $this->error([
                $exception->getMessage()
            ], 409);
        } catch (InvalidEmailException $exception) {
            return $this->error([
                'Sorry, some invalid data'
            ], 400);
        }

        return $this->success();
    }
}
