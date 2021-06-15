<?php

namespace App\Service\Entity;

use App\Entity\PropertyAudit;
use App\Repository\PropertyAuditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class PropertyAuditService {

    private $em;
    private $repository;
    private $logger;

    public function __construct(EntityManagerInterface $em, PropertyAuditRepository $repository, LoggerInterface $logger ) {
        $this->em = $em;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function save(PropertyAudit $obj)
    {
        $this->em->persist($obj);
        $this->em->flush();
    }


}