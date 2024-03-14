<?php

declare(strict_types=1);

namespace App\Register\Application\Email;

use App\Register\Domain\RegisteredUser;
use App\Register\Domain\RegisterEmail;
use App\Register\Domain\RegisterRepository;
use App\Register\Handler\Exception\InvalidEmailException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class EmailConfirmation
{
    /**
     * @param RegisterRepository $repository
     * @param MailerInterface $mailer
     */
    public function __construct(
        private RegisterRepository  $repository,
        private MailerInterface $mailer
    ) {
    }

    /**
     * @param RegisterEmail $email
     *
     * @return void
     * @throws InvalidEmailException
     * @throws TransportExceptionInterface
     */
    public function confirm(RegisterEmail $email): void
    {
        $user = $this->repository->searchByEmail($email);

        if ($user) {
            $this->ensureCredentialsAreValid($user, $email);
        }

        $this->send($email);
    }

    /**
     * @param RegisterEmail $email
     *
     * @return void
     * @throws TransportExceptionInterface
     */
    private function send(RegisterEmail $email): void
    {
        $email = (new Email())
            ->from('mevent@auth.com')
            ->to($email->value())
            ->subject('Confirm your email!')
            ->html('<p>Please confirm your email</p>');

        $this->mailer->send($email);
    }

    /**
     * @param RegisteredUser $user
     * @param RegisterEmail $email
     * @throws InvalidEmailException
     *
     * @return void
     */
    private function ensureCredentialsAreValid(RegisteredUser $user, RegisterEmail $email): void
    {
        if (!$user->matchEmail($email)) {
            throw new InvalidEmailException($user);
        }
    }
}
