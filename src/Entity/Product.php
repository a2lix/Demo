<?php declare(strict_types=1);

namespace App\Entity;

use A2lix\AutoFormBundle\Form\Attribute\AutoTypeCustom;
use App\Entity\Common\IdTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Gedmo\TranslationEntity(class: ProductTranslation::class)]
class Product
{
    use IdTrait;

    #[ORM\Column]
    #[AutoTypeCustom(options: ['priority' => 1])]
    #[Assert\NotBlank]
    public ?string $code;

    #[ORM\Column]
    #[Gedmo\Translatable]
    #[Assert\NotBlank]
    public ?string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Gedmo\Translatable]
    public ?string $description;

    #[ORM\ManyToOne(targetEntity: Category::class, cascade: ['all'])]
    public ?Category $category;

    #[ORM\OneToOne(targetEntity: ProductMedia::class, cascade: ['all'], orphanRemoval: true)]
    #[Assert\Valid]
    public ?ProductMedia $media;

    /** @var Collection<array-key, ProductTranslation> */
    #[ORM\OneToMany(targetEntity: ProductTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[AutoTypeCustom(options: ['priority' => 1])]
    public Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /**
     * @return Collection<array-key, ProductTranslation>
     */
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

    public function removeTranslation(ProductTranslation $translation): self
    {
        $this->translations->removeElement($translation->setObject(null));

        return $this;
    }
}
