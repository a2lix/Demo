<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Gedmo\Translatable\TranslatableListener;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(
        private readonly ManagerRegistry $registry,
        #[Autowire(service: 'stof_doctrine_extensions.listener.translatable')]
        private readonly TranslatableListener $translatableListener,
    ) {
        parent::__construct($registry, Product::class);
    }

    public function findAllWithTranslations(): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.translations', 'e_t', 'WITH', 'e_t.locale = :locale')
            ->addSelect('e_t')
            ->setParameter('locale', $this->translatableListener->getListenerLocale())
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneWithTranslations(int $id): Product
    {
        // $this->translatableListener->setSkipOnLoad(true);
        $this->translatableListener->setTranslatableLocale($this->translatableListener->getDefaultLocale());

        return $this->createQueryBuilder('e')
            ->leftJoin('e.translations', 'e_t')
            ->addSelect('e_t')
            ->where('e = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
