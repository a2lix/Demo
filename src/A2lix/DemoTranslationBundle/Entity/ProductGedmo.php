<?php

namespace A2lix\DemoTranslationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="A2lix\DemoTranslationBundle\Entity\ProductGedmoTranslation")
 */
class ProductGedmo
{
    use \A2lix\TranslationFormBundle\Util\GedmoTranslatable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(nullable=true)
     * @Gedmo\Translatable
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Translatable
     */
    protected $description;

    /**
     * @ORM\OneToMany(
     * 	targetEntity="ProductGedmoTranslation", mappedBy="object", cascade={"all"}
     * )
     * @Assert\Valid
     */
    protected $translations;

    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
}