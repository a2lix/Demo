<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use A2lix\TranslationFormBundle\Helper\KnpTranslatableAccessorTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Gedmo\TranslationEntity(class: ProductMediaTranslation::class)]
class Product
{
    use IdTrait;

    #[ORM\Column]
    public string $code;

    #[ORM\Column]
    #[Gedmo\Translatable]
    public string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Gedmo\Translatable]
    public ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    public ?Category $category = null;

    #[ORM\OneToOne(targetEntity: ProductMedia::class, cascade: ['all'], orphanRemoval: true)]
    public ?ProductMedia $media = null;

    /** @var Collection<int, ProductTranslation> */
    #[ORM\OneToMany(targetEntity: ProductTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    public Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(ProductTranslation $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation->setObject($this);
        }

        return $this;
    }
}
