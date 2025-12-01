<?php

declare(strict_types=1);

namespace App\Entity\Common;

use Doctrine\ORM\Mapping as ORM;

trait OneLocaleTrait
{
    #[ORM\Column(length: 10)]
    public string $locale;
}
