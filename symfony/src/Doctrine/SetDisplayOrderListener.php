<?php

namespace App\Doctrine;

use Doctrine\Persistence\Event\LifecycleEventArgs;


class SetDisplayOrderListener
{

    public function prePersist($entity, LifecycleEventArgs $args): void
    {

//        $entityManager = $args->getObjectManager();
//
//        if ($entity instanceof Slider) {
//            /** @var Slider $lastSlider */
//            $lastSlider = $entityManager->getRepository(Slider::class)->createQueryBuilder('s')
//                ->orderBy('s.displayOrder','desc')
//                ->setMaxResults(1)
//                ->getQuery()
//                ->getOneOrNullResult();
//
//            if ($lastSlider !== null) {
//                $entity->setDisplayOrder((int)$lastSlider->getDisplayOrder() + 1);
//            }
//
//        }

    }

}
