<?php

declare(strict_types=1);

namespace App\Token\Actions;

use App\Shared\Actions\Action;
use App\Shared\Settings\SettingsInterface;
use App\Token\Domain\RSAPrivate;
use App\Token\Domain\RSAPublic;
use App\Token\Domain\Token;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

final class AuthTokenGenerateAction extends Action
{
    /**
     * @param LoggerInterface $logger
     * @param SettingsInterface $settings
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly SettingsInterface $settings
    ) {
    }

    /**
     * @return Response
     * @throws \Exception
     */
    protected function action(): Response
    {
        $this->logger->info('Generate a new token for auth');

        $token = new Token(
            new RSAPublic($this->settings),
            new RSAPrivate($this->settings),
            $this->settings->get('app_name'),
            $this->settings->get('app_name'),
        );

        return $this->respondWithData([
            'toke' => $token->generate(36000, [
                'name' => 'test',
                'email' => 'test',
            ])->toString()
        ]);
    }
}
