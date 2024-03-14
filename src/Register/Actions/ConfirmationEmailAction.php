<?php

declare(strict_types=1);

namespace App\Register\Actions;

use App\Auth\Domain\AuthRepository;
use App\Register\Application\Email\Confirmation\SendConfirmationEmailCommand;
use App\Register\Application\Email\Confirmation\SendConfirmationEmailCommandHandler;
use App\Register\Application\Email\EmailConfirmation;
use App\Register\Application\Email\EmailConfirmationParams;
use App\Register\Domain\RegisterRepository;
use App\Shared\Actions\Action;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Symfony\Component\Mailer\MailerInterface;

class ConfirmationEmailAction extends Action
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
    ){
    }

    /**
     * @return Response
     * @throws \App\Auth\Domain\InvalidPasswordException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
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
                $this->container->get(MailerInterface::class)
            ),
        );

        $handler(new SendConfirmationEmailCommand($params->email()));

        return $this->success();
    }
}
