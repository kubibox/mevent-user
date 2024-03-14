<?php

declare(strict_types=1);

namespace App\Auth\Application\Email;

use App\Auth\Domain\AuthEmail;
use App\Auth\Domain\AuthRepository;
use App\Auth\Domain\AuthUser;
use App\Auth\Domain\InvalidPasswordException;
use App\Auth\Handler\Exception\InvalidEmailException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class EmailConfirmation
{
    /**
     * @param AuthRepository $repository
     * @param MailerInterface $mailer
     */
    public function __construct(
        private AuthRepository  $repository,
        private MailerInterface $mailer
    ) {
    }

    /**
     * @param AuthEmail $email
     *
     * @return void
     * @throws InvalidPasswordException|TransportExceptionInterface
     */
    public function confirm(AuthEmail $email): void
    {
        $user = $this->repository->searchEmail($email);

        $this->ensureCredentialsAreValid($user, $email);

        $this->send($email);
    }

    /**
     * @param AuthEmail $email
     *
     * @return void
     * @throws TransportExceptionInterface
     */
    private function send(AuthEmail $email): void
    {
        $email = (new Email())
            ->from('mevent@auth.com')
            ->to($email->value())
            ->subject('Confirm your email!')
            ->html('<p>Please confirm your email</p>');

        $this->mailer->send($email);
    }

    /**
     * @param AuthUser $user
     * @param AuthEmail $email
     *
     * @return void
     * @throws InvalidPasswordException
     */
    private function ensureCredentialsAreValid(AuthUser $user, AuthEmail $email): void
    {
        if (!$user->matchEmail($email)) {
            throw new InvalidEmailException($user);
        }
    }
}
