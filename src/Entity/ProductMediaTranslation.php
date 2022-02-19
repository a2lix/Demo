<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Repository\ProductMediaTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

#[ORM\Entity(repositoryClass: ProductMediaTranslationRepository::class)]
class ProductMediaTranslation implements TranslationInterface
{
    use IdTrait;
    use TranslationTrait;

    #[ORM\Column(nullable: true)]
    private $url;

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
