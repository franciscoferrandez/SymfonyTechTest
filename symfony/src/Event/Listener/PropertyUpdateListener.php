<?php

namespace App\EventListener;

use App\CustomEvents\PropertyUpdateEvent;
use App\Entity\PropertyAudit;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PropertyUpdateListener 
{

    public function postPersist(LifecycleEventArgs $args)   
    {
       $entity = $args->getObject();
       if (!$entity instanceof PropertyAudit) return;
    }

    public function propertyUpdateAudit(PropertyUpdateEvent $propertyUpdateEvent)   
    {
        echo "Estoy en el listener<br>";
    }
}