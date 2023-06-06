<?php

namespace App\Doctrine;

use App\Entity\UserTarget;

class TimestampListener
{

    public function prePersist($object): void
    {
        if ($object instanceof UserTarget) {
            $datetime = new \DateTime();
            $object->setCreatedAt($datetime);
            $object->setUpdatedAt($datetime);
        }
    }

    public function preUpdate($object):void
    {
        if ($object instanceof UserTarget) {
            $object->setUpdatedAt(new \DateTime());
        }
    }

}