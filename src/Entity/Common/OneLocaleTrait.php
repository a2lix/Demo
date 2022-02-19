<?php

declare(strict_types=1);

namespace App\Entity\Common;

use Doctrine\ORM\Mapping as ORM;

/**
 * One locale trait.
 *
 * Should be used inside entity, that needs to be localized
 */
trait OneLocaleTrait
{
    #[ORM\Column(length: 10)]
    private $locale;

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
