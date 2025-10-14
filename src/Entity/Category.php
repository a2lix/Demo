<?php

declare(strict_types=1);

namespace App\Entity;

use A2lix\AutoFormBundle\Form\Attribute\AutoTypeCustom;
use App\Entity\Common\IdTrait;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    use IdTrait;

    #[ORM\Column]
    #[AutoTypeCustom(['label' => 'cccaat'])]
    private string $code;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'categories')]
    private ?Company $company = null;

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
