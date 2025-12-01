<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Repository\ProductMediaTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity(repositoryClass: ProductMediaTranslationRepository::class)]
#[ORM\UniqueConstraint(columns: ['locale', 'object_id', 'field'])]
class ProductMediaTranslation extends AbstractPersonalTranslation
{
    public function __construct(string $locale, string $field, string $value)
    {
        $this->setLocale($locale)->setField($field)->setContent($value);
    }

    #[ORM\ManyToOne(targetEntity: ProductMedia::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'object_id', nullable: false, onDelete: 'CASCADE')]
    protected $object;
}
