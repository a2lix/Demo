<?php

declare(strict_types=1);

namespace App\Entity;

use A2lix\TranslationFormBundle\Gedmo\TranslatableTrait;
use App\Entity\Common\IdTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    use IdTrait;
    use TranslatableTrait;

    #[Gedmo\Translatable]
    #[ORM\Column]
    private string $title;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private string $code;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    private ?Category $category = null;

    #[ORM\OneToOne(targetEntity: ProductMedia::class, cascade: ['all'], orphanRemoval: true)]
    private ?ProductMedia $media = null;

    /** @var ProductTranslation[]|Collection<int, ProductTranslation> */
    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ProductTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getMedia(): ?ProductMedia
    {
        return $this->media;
    }

    public function setMedia(ProductMedia $media): self
    {
        $this->media = $media;

        return $this;
    }
}
