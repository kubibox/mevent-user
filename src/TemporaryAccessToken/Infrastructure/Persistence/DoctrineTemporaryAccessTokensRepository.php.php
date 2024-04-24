<?php

declare(strict_types=1);

namespace App\TemporaryAccessToken\Infrastructure\Persistence;

use App\Shared\Domain\ValueObject\StringValueObject;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\TemporaryAccessToken\Domain\TemporaryAccessToken;
use App\TemporaryAccessToken\Domain\TemporaryAccessTokensRepository;

class DoctrineTemporaryAccessTokensRepository extends DoctrineRepository implements TemporaryAccessTokensRepository
{
    /**
     * @param StringValueObject $email
     *
     * @return mixed
     */
    public function findByEmail(StringValueObject $email): TemporaryAccessToken
    {
        return $this->repository(TemporaryAccessToken::class)->findOneBy([
            'email.value' => $email->value(),
        ]);
    }

    /**
     * @param TemporaryAccessToken $temporaryAccessToken
     *
     * @return void
     * @throws \Doctrine\ORM\Exception\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(TemporaryAccessToken $temporaryAccessToken): void
    {
        $this->persist($temporaryAccessToken);
    }
}
