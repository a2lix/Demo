<?php

namespace A2lix\DemoTranslationKnpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class Product
{
    use \A2lix\CommonBundle\Doctrine\Traits\Id;
    use ORMBehaviors\Translatable\Translatable;

    public function __call($method, $arguments)
    {
        if (in_array($method, array('get_action', 'getBatch'))) {
            return;
        }

        $method = ('get' === substr($method, 0, 3)) ? $method : 'get'. ucfirst($method);
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}