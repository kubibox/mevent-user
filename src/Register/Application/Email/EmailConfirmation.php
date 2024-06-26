<?php

declare(strict_types=1);

namespace App\Register\Application\Email;

use App\Register\Application\JWTTokenService;
use App\Register\Domain\RegisterEmail;
use App\Register\Domain\RegisterRepository;
use App\Register\Handler\Exception\EmailAlreadyExistedException;
use App\Register\Handler\Exception\InvalidEmailException;
use App\TemporaryAccessToken\Domain\TemporaryAccessTokensRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class EmailConfirmation
{
    /**
     * @param RegisterRepository $repository
     * @param MailerInterface $mailer
     * @param JWTTokenService $JWTTokenService
     * @param TemporaryAccessTokensRepository $accessTokensRepository
     */
    public function __construct(
        private RegisterRepository $repository,
        private MailerInterface $mailer,
        private JWTTokenService $JWTTokenService,
        private TemporaryAccessTokensRepository $accessTokensRepository,
    ) {
    }

    /**
     * @param RegisterEmail $email
     *
     * @return void
     * @throws TransportExceptionInterface|EmailAlreadyExistedException|InvalidEmailException
     */
    public function confirm(RegisterEmail $email): void
    {
        $this->ensureCredentialsAreValid($email);

        $user = $this->repository->searchByEmail($email);

        if ($user) {
            throw new EmailAlreadyExistedException($email->value());
        }

        $this->send($email, $this->token($email));
    }

    /**
     * @param RegisterEmail $email
     *
     * @return string
     * @throws \Exception
     */
    private function token(RegisterEmail $email): string
    {
        $token = $this->JWTTokenService
            ->getTokenForEmailConfirm($email->value())
            ->generate(36000, ['email' => $email->value()])
            ->toString();

        $this->accessTokensRepository->save(new TemporaryAccessToken());
        return $token;
    }

    /**
     * @param RegisterEmail $email
     * @param string $token
     *
     * @return void
     * @throws TransportExceptionInterface
     */
    private function send(RegisterEmail $email, string $token): void
    {
        $email = (new Email())
            ->from('mevent@auth.com')
            ->to($email->value())
            ->subject(sprintf('Confirm your email!, token [%s]', $token))
            ->html('<p>Please confirm your email</p>');

        $this->mailer->send($email);
    }

    /**
     * @param RegisterEmail $email
     *
     * @return void
     */
    private function ensureCredentialsAreValid(RegisterEmail $email): void
    {
        if (!\filter_var($email->value(), FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($email->value());
        }
    }
}
