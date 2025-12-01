<?php

declare(strict_types=1);

namespace App\Repository;

use A2lix\TranslationFormBundle\Locale\LocaleProviderInterface;
use App\Entity\ProductMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductMediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductMedia::class);
    }
}
