<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity(repositoryClass: ProductTranslationRepository::class)]
#[ORM\UniqueConstraint(columns: ['locale', 'object_id', 'field'])]
class ProductTranslation extends AbstractPersonalTranslation
{
    public function __construct(string $locale, string $field, string $value)
    {
        $this->setLocale($locale)->setField($field)->setContent($value);
    }

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'object_id', nullable: false, onDelete: 'CASCADE')]
    protected $object;
}
