<?php

namespace App\Doctrine;

use App\Entity\DataFeed;
use App\Entity\UserTarget;

class TimestampListener
{

    public function prePersist($object): void
    {
        if ($object instanceof UserTarget || $object instanceof DataFeed) {
            $datetime = new \DateTime();
            $object->setCreatedAt($datetime);
            $object->setUpdatedAt($datetime);
        }
    }

    public function preUpdate($object):void
    {
        if ($object instanceof UserTarget || $object instanceof DataFeed) {
            $object->setUpdatedAt(new \DateTime());
        }
    }

}