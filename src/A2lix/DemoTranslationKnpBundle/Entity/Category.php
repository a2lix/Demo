<?php

namespace A2lix\DemoTranslationKnpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 */
class Category
{
    use \A2lix\CommonBundle\Doctrine\Traits\Id;
    use ORMBehaviors\Translatable\Translatable;

    public function __call($method, $arguments)
    {
        if (in_array($method, ['get_action', 'getBatch'], true)) {
            return;
        }

        $method = ('get' === substr($method, 0, 3)) ? $method : 'get'.ucfirst($method);

        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}
