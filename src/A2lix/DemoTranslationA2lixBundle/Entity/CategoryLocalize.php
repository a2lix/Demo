<?php

namespace A2lix\DemoTranslationA2lixBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use A2lix\I18nDoctrineBundle\Doctrine as A2lixI18n;

/**
 * @ORM\Entity
 * @ORM\Table(name="categoryLocalize")
 */
class CategoryLocalize implements A2lixI18n\Interfaces\OneLocaleInterface
{
    use \A2lix\CommonBundle\Doctrine\Traits\Id;
    use A2lixI18n\ORM\Util\OneLocale;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $title;

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }
}