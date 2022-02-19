<?php

declare(strict_types=1);

namespace App\Entity\Common;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait IdTrait
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
