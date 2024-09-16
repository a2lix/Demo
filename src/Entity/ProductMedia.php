<?php

declare(strict_types=1);

namespace App\Entity;

use A2lix\TranslationFormBundle\Gedmo\TranslatableTrait;
use App\Entity\Common\IdTrait;
use App\Repository\ProductMediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductMediaRepository::class)]
#[Gedmo\TranslationEntity(class: ProductMediaTranslation::class)]
class ProductMedia
{
    use IdTrait;
    use TranslatableTrait;

    #[Gedmo\Translatable]
    #[ORM\Column()]
    private string $url;

    /** @var ProductMediaTranslation[]|Collection<int, ProductMediaTranslation> */
    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ProductMediaTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
