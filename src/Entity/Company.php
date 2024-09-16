<?php

declare(strict_types=1);

namespace App\Entity;

use A2lix\TranslationFormBundle\Gedmo\TranslatableTrait;
use App\Entity\Common\IdTrait;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[Gedmo\TranslationEntity(class: CompanyTranslation::class)]
class Company implements \Stringable
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

    /** @var Category[]|Collection<int, Category> */
    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'company', cascade: ['all'], orphanRemoval: true)]
    private Collection $categories;

    /** @var CompanyMediaLocalize[]|Collection<int, CompanyMediaLocalize> */
    #[ORM\OneToMany(targetEntity: CompanyMediaLocalize::class, mappedBy: 'company', indexBy: 'locale', cascade: ['all'], orphanRemoval: true)]
    private Collection $medias;

    /** @var CompanyTranslation[]|Collection<int, CompanyTranslation> */
    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: CompanyTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private Collection $translations;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->medias = new ArrayCollection();
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

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $category->setCompany($this);
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(CompanyMediaLocalize $media): self
    {
        if (!$this->medias->contains($media)) {
            $media->setCompany($this);
            $this->medias->add($media);
        }

        return $this;
    }

    public function removeMedia(CompanyMediaLocalize $media): self
    {
        $this->medias->removeElement($media);

        return $this;
    }

    public function getMediaLocalized(string $locale): ?CompanyMediaLocalize
    {
        $mediaLocalized = $this->medias->filter(static fn (CompanyMediaLocalize $media): bool => $media->getLocale() === $locale);

        return $mediaLocalized->first() ?: null;
    }

    public function __toString(): string
    {
        return '?';
    }
}
