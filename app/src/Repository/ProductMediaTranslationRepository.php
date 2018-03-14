<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductMediaTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductMediaTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductMediaTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductMediaTranslation[]    findAll()
 * @method ProductMediaTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductMediaTranslationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductMediaTranslation::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
