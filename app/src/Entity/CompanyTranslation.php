<?php

declare(strict_types=1);

namespace App\Entity;

use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyTranslationRepository")
 */
class CompanyTranslation implements Common\OneLocaleInterface
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
