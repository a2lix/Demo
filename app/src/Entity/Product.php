<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    use Common\IdTrait;
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Column()
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

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function setMedia(ProductMedia $media)
    {
        $this->media = $media;

        return $this;
    }

    public function __call($method, $arguments)
    {
        return \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
}
