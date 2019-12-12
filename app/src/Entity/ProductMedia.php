<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductMediaRepository")
 */
class ProductMedia implements TranslatableInterface
{
    use Common\IdTrait;
    use TranslatableTrait;

    public function __call($method, $arguments)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
}
