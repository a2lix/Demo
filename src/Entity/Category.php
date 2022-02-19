<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category implements TranslatableInterface
{
    use IdTrait;
    use TranslatableTrait;

    #[Assert\Valid]
    protected $translations;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'categories')]
    private ?Company $company = null;

    public function __call($method, $arguments)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function displayWithCompany(): string
    {
        return $this->getTitle().' ('.$this->getCompany()->getTitle().')';
    }
}
