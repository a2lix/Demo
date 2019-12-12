<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product implements TranslatableInterface
{
    use Common\IdTrait;
    use TranslatableTrait;

    /**
     * @ORM\Column
     * @Assert\NotBlank
     */
    protected $code;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     */
    protected $category;

    /**
     * @ORM\OneToOne(targetEntity="ProductMedia", cascade={"all"}, orphanRemoval=true)
     */
    protected $media;

    /**
     * @Assert\Valid
     */
    protected $translations;

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
