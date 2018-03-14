<?php

declare(strict_types=1);

namespace App\Entity;

use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    use Common\IdTrait;
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="categories")
     */
    protected $company;

    /**
     * @Assert\Valid
     */
    protected $translations;

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    public function displayWithCompany()
    {
        return $this->getTitle().' ('.$this->getCompany()->getTitle().')';
    }

    public function __call($method, $arguments)
    {
        return \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
}
