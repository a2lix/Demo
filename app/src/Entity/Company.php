<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company implements TranslatableInterface
{
    use Common\IdTrait;
    use TranslatableTrait;

    /**
     * @ORM\Column
     * @Assert\NotBlank
     */
    protected $code;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="company", cascade={"all"}, orphanRemoval=true)
     */
    protected $categories;

    /**
     * @ORM\OneToMany(targetEntity="CompanyMediaLocalize", mappedBy="company", indexBy="locale", cascade={"all"}, orphanRemoval=true)
     */
    protected $medias;

    /**
     * @Assert\Valid
     */
    protected $translations;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->medias = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function getCode(): ?string
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
        $mediaLocalized = $this->medias->filter(function (CompanyMediaLocalize $media) use ($currLocale) : bool {
            return $media->getLocale() === $currLocale;
        });

        return $mediaLocalized->count() ? $mediaLocalized->first() : null;
    }

    public function __toString()
    {
        return '?';
    }
}
