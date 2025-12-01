<?php

declare(strict_types=1);

namespace App\Repository;

use A2lix\TranslationFormBundle\LocaleProvider\LocaleProviderInterface;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(
        private ManagerRegistry $registry,
        private LocaleProviderInterface $localeProvider,
    ) {
        parent::__construct($registry, Product::class);
    }

    public function findOneWithTranslation(int $id): Product
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.translations', 'e_t')
            ->addSelect('e_t')
            ->where('e = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_FALLBACK, 0)
            ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $this->localeProvider->getDefaultLocale())
            ->getSingleResult()
        ;
    }
}
