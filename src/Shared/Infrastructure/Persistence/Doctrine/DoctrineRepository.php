<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use App\Shared\Criteria\ConvertToDoctrineCriteria;
use App\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class DoctrineRepository
{
    use ConvertToDoctrineCriteria;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    /**
     * @return EntityManager
     */
    protected function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param AggregateRoot $entity
     *
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function persist(AggregateRoot $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush($entity);
    }

    /**
     * @param AggregateRoot $entity
     *
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function remove(AggregateRoot $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush($entity);
    }

    /**
     * @param string $entityClass
     *
     * @return EntityRepository
     */
    protected function repository(string $entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }
}
