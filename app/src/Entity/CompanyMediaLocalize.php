<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyMediaLocalizeRepository")
 */
class CompanyMediaLocalize implements Common\OneLocaleInterface
{
    use Common\IdTrait;
    use Common\OneLocaleTrait;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $url;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="medias")
     */
    protected $company;

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
