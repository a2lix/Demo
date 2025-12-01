<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Entity\Common\OneLocaleInterface;
use App\Entity\Common\OneLocaleTrait;
use App\Repository\CompanyMediaLocalizeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyMediaLocalizeRepository::class)]
class CompanyMediaLocalize implements OneLocaleInterface
{
    use IdTrait;
    use OneLocaleTrait;

    #[ORM\Column]
    public string $url;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'medias')]
    public ?Company $company = null;
}
