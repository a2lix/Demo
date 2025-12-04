<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Repository\ProductMediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ProductMediaRepository::class)]
#[Gedmo\TranslationEntity(class: ProductMediaTranslation::class)]
class ProductMedia implements \Stringable
{
    use IdTrait;

    #[ORM\Column]
    #[Gedmo\Translatable]
    public ?string $url;

    #[ORM\Column(nullable: true)]
    #[Gedmo\Translatable]
    public ?string $label = null;

    /** @var Collection<int, ProductMediaTranslation> */
    #[ORM\OneToMany(targetEntity: ProductMediaTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], orphanRemoval: true)]
    public Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /**
     * @return Collection<int, ProductMediaTranslation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(ProductMediaTranslation $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(ProductMediaTranslation $translation): self
    {
        $this->translations->removeElement($translation->setObject(null));

        return $this;
    }

    public function __toString(): string
    {
        return \sprintf(
            '%s (%s)',
            $this->url,
            $this->label,
        );
    }
}
