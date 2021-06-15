<?php

namespace App\EventListener;

use App\Service\Entity\PropertyAuditService;
use App\CustomEvents\PropertyUpdateEvent;
use App\Entity\PropertyAudit;
use Doctrine\ORM\Event\LifecycleEventArgs;

class PropertyUpdateListener 
{

    private $service;

    public function __construct(PropertyAuditService $service)
    {
        $this->service = $service;
    }

    public function postPersist(LifecycleEventArgs $args)   
    {
       $entity = $args->getObject();
       if (!$entity instanceof PropertyAudit) return;

       //TODO: Aquí debería realizarse el guardado de las propertyAudits
    }

    public function propertyUpdateAudit(PropertyUpdateEvent $propertyUpdateEvent)   
    {
        $this->service->save($propertyUpdateEvent->getPropertyAudit());
    }
}