<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductMedia[]    findAll()
 * @method ProductMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductMediaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductMedia::class);
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
