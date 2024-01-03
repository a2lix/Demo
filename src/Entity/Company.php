<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company implements TranslatableInterface, \Stringable
{
    use IdTrait;
    use TranslatableTrait;

    #[Assert\Valid]
    protected $translations;

    #[ORM\Column]
    private string $code;

    /** @var Category[]|Collection<int, Category> */
    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'company', cascade: ['all'], orphanRemoval: true)]
    private Collection $categories;

    /** @var CompanyMediaLocalize[]|Collection<int, CompanyMediaLocalize> */
    #[ORM\OneToMany(targetEntity: CompanyMediaLocalize::class, mappedBy: 'company', indexBy: 'locale', cascade: ['all'], orphanRemoval: true)]
    private Collection $medias;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->medias = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function __toString(): string
    {
        return '?';
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

    public function getMediaLocalized(): ?CompanyMediaLocalize
    {
        $currLocale = $this->getCurrentLocale();
        $mediaLocalized = $this->medias->filter(static fn (CompanyMediaLocalize $media): bool => $media->getLocale() === $currLocale);

        return $mediaLocalized->first() ?: null;
    }
}
