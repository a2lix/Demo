<?php

namespace A2lix\DemoTranslationKnpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categoryLocalize")
 */
class CategoryLocalize
{
    use \A2lix\CommonBundle\Doctrine\Traits\Id;

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