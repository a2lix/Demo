<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use A2lix\TranslationFormBundle\Helper\KnpTranslatableAccessorTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category implements TranslatableInterface
{
    use IdTrait;
    use TranslatableTrait;
    use KnpTranslatableAccessorTrait;

    #[ORM\Column]
    public string $code;

    #[ORM\Column(type: 'json')]
    public array $tags = [];

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'categories')]
    public ?Company $company = null;

    public function addTag(string $tag): self
    {
        if (!in_array($tag, $this->tags, true)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(string $tag): self
    {
        $this->tags = array_filter($this->tags, static fn(string $t) => $t !== $tag);

        return $this;
    }

    public function render(): string
    {
        return sprintf(
            '%s (%s)',
            $this->title,
            $this->company->title,
        );
    }
}
