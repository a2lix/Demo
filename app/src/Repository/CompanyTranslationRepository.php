<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CompanyTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompanyTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyTranslation[]    findAll()
 * @method CompanyTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyTranslationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompanyTranslation::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
