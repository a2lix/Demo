<?php

namespace A2lix\DemoTranslationBundle\Entity;

use A2lix\I18nDoctrineBundle\Doctrine as A2lixI18n;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Category
{
    use \A2lix\CommonBundle\Doctrine\Traits\Id;
    use A2lixI18n\ORM\Util\Translatable;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="categories")
     */
    protected $company;

    /**
     * @Assert\Valid
     */
    protected $translations;

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    public function displayWithCompany()
    {
        return $this->getTitle().' ('.$this->getCompany()->getTitle().')';
    }
}
