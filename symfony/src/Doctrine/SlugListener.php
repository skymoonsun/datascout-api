<?php

namespace App\Doctrine;

use App\Entity\UserTarget;
use App\Helper\StringHelper;

class SlugListener
{

    public function prePersist($object)
    {
        if ($object instanceof UserTarget) {
            $object->setSlug(StringHelper::slugify($object->getName()));
        }

    }

}