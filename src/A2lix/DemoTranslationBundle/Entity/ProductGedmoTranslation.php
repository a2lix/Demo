<?php

namespace A2lix\DemoTranslationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="category_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="lookup_unique_idx", columns={"locale", "object_id", "field"})}
 * )
 */
class ProductGedmoTranslation extends AbstractPersonalTranslation
{
   /**
    * @ORM\ManyToOne(targetEntity="ProductGedmo", inversedBy="translations")
    * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
    */
    protected $object;
}