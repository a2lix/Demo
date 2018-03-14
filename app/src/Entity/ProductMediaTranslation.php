<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductMediaTranslationRepository")
 */
class ProductMediaTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $url;

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
