<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductMediaTranslationRepository")
 */
class ProductMediaTranslation implements TranslationInterface
{
    use Common\IdTrait;
    use TranslationTrait;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $url;

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
