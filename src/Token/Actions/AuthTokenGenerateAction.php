<?php

declare(strict_types=1);

namespace App\Token\Actions;

use App\Shared\Actions\Action;
use App\Shared\Settings\SettingsInterface;
use App\Token\Application\Generate\TokenGenerate;
use App\Token\Application\Generate\TokenGenerateArguments;
use App\Token\Application\Generate\TokenGenerator;
use App\Token\Domain\Token;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use App\RSA\Domain\RSAPrivate;
use App\RSA\Domain\RSAPublic;

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
     * @throws Exception
     */
    protected function action(): Response
    {
        $this->logger->info('Generate a new token for auth');

        $arguments = new TokenGenerateArguments(3600, 'test', $this->settings->get('app_name'), [
            'test'
        ]);

        $generate = new TokenGenerate(new TokenGenerator(new RSAPublic($this->settings)));

        $token = $generate->generate($arguments);

        return $this->respondWithData([
            'token' => $token->value(),
        ]);
    }
}
