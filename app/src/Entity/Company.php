<?php

declare(strict_types=1);

namespace App\Entity;

use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    use Common\IdTrait;
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Column()
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
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->medias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function addCategory(Category $category)
    {
        if (!$this->categories->contains($category)) {
            $category->setCompany($this);
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getMedias()
    {
        return $this->medias;
    }

    public function addMedia(CompanyMediaLocalize $media = null)
    {
        if (!$this->medias->contains($media)) {
            $media->setCompany($this);
            $this->medias->add($media);
        }

        return $this;
    }

    public function removeMedia(CompanyMediaLocalize $media)
    {
        $this->medias->removeElement($media);

        return $this;
    }

    public function __call($method, $arguments)
    {
        return \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
}
