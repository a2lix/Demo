<?php

namespace A2lix\DemoTranslationBundle\Entity;

use A2lix\I18nDoctrineBundle\Doctrine as A2lixI18n;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Company
{
    use \A2lix\CommonBundle\Doctrine\Traits\Id;
    use A2lixI18n\ORM\Util\Translatable;

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
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

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
        if ($this->medias->contains($media)) {
            $this->medias->removeElement($media);
        }

        return $this;
    }
}
