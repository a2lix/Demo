<?php

namespace App\Entity\Common;

use Doctrine\ORM\Mapping as ORM;

trait IdTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
