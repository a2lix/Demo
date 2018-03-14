<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CompanyMediaLocalize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompanyMediaLocalize|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyMediaLocalize|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyMediaLocalize[]    findAll()
 * @method CompanyMediaLocalize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyMediaLocalizeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompanyMediaLocalize::class);
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
