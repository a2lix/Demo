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

    #[ORM\Column(nullable: true)]
    private ?string $url = null;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'medias')]
    private ?Company $company = null;

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function setCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
