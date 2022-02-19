<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product implements TranslatableInterface
{
    use IdTrait;
    use TranslatableTrait;

    #[Assert\Valid]
    protected $translations;

    #[ORM\Column]
    #[Assert\NotBlank]
    private $code;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    private ?Category $category = null;

    #[ORM\OneToOne(targetEntity: ProductMedia::class, cascade: ['all'], orphanRemoval: true)]
    private ?ProductMedia $media = null;

    public function __call($method, $arguments)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getMedia(): ?ProductMedia
    {
        return $this->media;
    }

    public function setMedia(ProductMedia $media): self
    {
        $this->media = $media;

        return $this;
    }
}
