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

    #[ORM\Column(type: 'json')]
    private array $tags = [];

    #[ORM\Column]
    private string $code;

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

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function addTag(string $tag): self
    {
        $this->tags[] = $tag;

        return $this;
    }

    public function removeTag(string $tag): self
    {
        $this->tags = array_filter($this->tags, fn ($t) => $t !== $tag);

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
