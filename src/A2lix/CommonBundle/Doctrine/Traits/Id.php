<?php

namespace A2lix\CommonBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Id
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
