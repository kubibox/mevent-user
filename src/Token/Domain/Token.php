<?php

declare(strict_types=1);

namespace App\Token\Domain;

use DateInterval;
use Exception;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\UnencryptedToken;

final class Token
{
    public const DEFAULT_TTL = 3600;

    /**
     * @param RSAPublic $public
     * @param RSAPrivate $private
     * @param string $iss
     * @param string $aud
     */
    public function __construct(
        private readonly RSAPublic $public,
        private readonly RSAPrivate $private,
        private readonly string $iss,
        private readonly string $aud,
    ) {
    }

    /**
     * @param int $ttl
     * @param string $permissions
     *
     * @return UnencryptedToken
     * @throws Exception
     */
    public function generate(int $ttl, array $data): UnencryptedToken
    {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::file($this->public->fullPath()),
        );

        $now = new \DateTimeImmutable();
        return $config->builder()
            ->issuedBy($this->iss)
            ->permittedFor($this->aud)
            ->identifiedBy(uniqid('', true))
            ->issuedAt($now)
            ->expiresAt($now->add(new DateInterval('PT' . $ttl . 'S')))
            ->withClaim('data', $data)
            ->getToken($config->signer(), $config->signingKey());
    }

    /**
     * @param array $data
     * @param array $config
     *
     * @return bool
     */
    public function verify(array $data, array $config): bool
    {
        if ($data['username'] != $config['username'] || $data['password'] != $config['password']) {
            return $response->withStatus(400)->withHeader('Content-type', 'application/json')->write(json_encode(['response' => 'Invalid username or password!']));
        }

        if (!array_key_exists('permissions',$data) || count($data['permissions']) == 0) {
            return $response->withStatus(400)->withHeader('Content-type', 'application/json')->write(json_encode(['response' => 'Missing permissions for token!']));
        }

        foreach($data['permissions'] as $permission => $subjects) {
            foreach($data['permissions'][$permission] as $subject) {
                if (!isSubjectValid($subject)) {
                    return $response->withStatus(400)->withHeader('Content-type', 'application/json')->write(json_encode(['response' =>'Error, invalid subject format for subject: ' . $subject]));
                }
            }
        }

        return $response->withHeader('Content-type', 'application/json')->write(json_encode(['response' => generateToken($data['permissions'], $data['ttlSeconds'], $config['key'])]));
    }
}
