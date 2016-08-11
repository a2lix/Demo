<?php

namespace A2lix\DemoTranslationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class Product
{
    use \A2lix\CommonBundle\Doctrine\Traits\Id;
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Column()
     */
    protected $code;

    /**
     * @ORM\ManyToOne(targetEntity="\A2lix\DemoTranslationBundle\Entity\Category")
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
        if (in_array($method, ['get_action', 'getBatch'], true)) {
            return;
        }

        $method = ('get' === substr($method, 0, 3)) ? $method : 'get'.ucfirst($method);

        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}
