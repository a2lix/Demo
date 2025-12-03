<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use A2lix\TranslationFormBundle\Helper\OneLocaleInterface;
use A2lix\TranslationFormBundle\Helper\OneLocaleTrait;
use App\Repository\CompanyMediaLocalizeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyMediaLocalizeRepository::class)]
class CompanyMediaLocalize implements OneLocaleInterface
{
    use IdTrait;
    use OneLocaleTrait;

    #[ORM\Column]
    public ?string $url;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'medias')]
    public ?Company $company = null;

    public function isEmpty(): bool
    {
        return null === $this->url;
    }

    public function render(): string
    {
        return sprintf(
            '%s',
            $this->url,
        );
    }
}
