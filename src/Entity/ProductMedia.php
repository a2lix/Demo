<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Common\IdTrait;
use App\Repository\ProductMediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

#[ORM\Entity(repositoryClass: ProductMediaRepository::class)]
class ProductMedia implements TranslatableInterface
{
    use IdTrait;
    use TranslatableTrait;

    public function __call($method, $arguments)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
}
