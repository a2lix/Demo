<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Repository\CompanyTranslationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

#[ORM\Entity(repositoryClass: CompanyTranslationRepository::class)]
class CompanyTranslation implements TranslationInterface
{
    use IdTrait;
    use TranslationTrait;

    #[ORM\Column(nullable: true)]
    private $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
