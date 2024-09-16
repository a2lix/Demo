<?php

declare(strict_types=1);

namespace App\Entity;

use A2lix\TranslationFormBundle\Gedmo\TranslatableTrait;
use App\Entity\Common\IdTrait;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[Gedmo\TranslationEntity(class: CategoryTranslation::class)]
class Category
{
    use IdTrait;
    use TranslatableTrait;

    #[Gedmo\Translatable]
    #[ORM\Column]
    private string $title;

    #[ORM\Column(type: 'json')]
    private array $tags = [];

    #[ORM\Column]
    private string $code;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'categories')]
    private ?Company $company = null;

    /** @var CategoryTranslation[]|Collection<int, CategoryTranslation> */
    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: CategoryTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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
        $this->tags = array_reduce($this->tags, static fn (array $carry, string $t) => [...$carry, ...($t !== $tag ? [$t] : [])], []);

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
