<?php

declare(strict_types=1);

namespace App\Entity;

use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryTranslationRepository")
 */
class CategoryTranslation implements Common\OneLocaleInterface
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $title;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
