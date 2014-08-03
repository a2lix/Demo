<?php

namespace A2lix\DemoTranslationA2lixBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use A2lix\I18nDoctrineBundle\Doctrine as A2lixI18n;

/**
 * @ORM\Entity
 */
class Category
{
    use \A2lix\CommonBundle\Doctrine\Traits\Id;
    use A2lixI18n\ORM\Util\Translatable;

    /**
     * @Assert\Valid
     */
    protected $translations;

    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }
}