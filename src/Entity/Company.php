<?php

declare(strict_types=1);

namespace App\Entity;

use A2lix\AutoFormBundle\Form\Attribute\AutoTypeCustom;
use App\Entity\Common\IdTrait;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    use IdTrait;

    #[ORM\Column]
    private string $code;

    /** @var Category[]|Collection<int, Category> */
    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'company', cascade: ['all'], orphanRemoval: true)]
    #[AutoTypeCustom(['label' => 'cccaat'])]
    private Collection $categories;

    /** @var CompanyMediaLocalize[]|Collection<int, CompanyMediaLocalize> */
    #[ORM\OneToMany(targetEntity: CompanyMediaLocalize::class, mappedBy: 'company', indexBy: 'locale', cascade: ['all'], orphanRemoval: true)]
    private Collection $medias;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->medias = new ArrayCollection();
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
}
