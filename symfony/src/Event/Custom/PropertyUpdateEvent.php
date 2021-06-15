<?php

namespace App\CustomEvents;

use App\Entity\PropertyAudit;
use Symfony\Component\EventDispatcher\Event;

class PropertyUpdateEvent extends Event
{
    public const NAME = 'property.update';

    protected $propertyAudit;

    public function __construct(PropertyAudit $propertyAudit) {
        $this->propertyAudit = $propertyAudit;
    }

    public function getPropertyAudit() {
        return $this->propertyAudit;
    }
}