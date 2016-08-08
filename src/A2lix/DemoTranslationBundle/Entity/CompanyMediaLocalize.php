<?php

namespace A2lix\DemoTranslationBundle\Entity;

use A2lix\I18nDoctrineBundle\Doctrine as A2lixI18n;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CompanyMediaLocalize implements A2lixI18n\Interfaces\OneLocaleInterface
{
    use \A2lix\CommonBundle\Doctrine\Traits\Id;
    use A2lixI18n\ORM\Util\OneLocale;

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
