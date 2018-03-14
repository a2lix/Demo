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

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany(Company $company)
    {
        $this->company = $company;

        return $this;
    }
}
