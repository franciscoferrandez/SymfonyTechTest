<?php
namespace App\Service\Importer;

use App\CustomEvents\PropertyUpdateEvent;
use App\Entity\PropertyAudit;
use App\Mapping\ObjectMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ObjectImporter {

    private $em;

    private $repository;
    private $mapping;
    private $key;

    private $mapper;

    private $eventDispatcher;

    public function __construct(EntityManagerInterface $em, ObjectMapper $mapper, EventDispatcherInterface $eventDispatcher)
    {
        $this->mapper = $mapper;
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function setRepository(ServiceEntityRepository $repository) {
        $this->repository = $repository;
    }

    public function setMapping($mapping) {
        $this->mapping = $mapping;
    }

    public function setKey(string $key) {
        $this->key = $key;
    }

    public function import($list) {
        $importedList = array();
        foreach ($list as $key => $item) {
            $mappedObj = $this->mapper->map($item, $this->mapping);
            $dbObj = $this->repository->findOneBy(
                array($this->key=> $mappedObj->{$this->key}), 
                array('id' => 'ASC'));

            $dbObj = $this->setFieldByField($dbObj, $mappedObj);

            $this->em->persist($dbObj);
            $this->em->flush();
            $importedList[] = $dbObj;
        }
        return $importedList;
    }

    private function setFieldByField($dst, $src) {
        if ($dst == null) {
            $repositoryClass = $this->repository->getClassName();
            $dst = new $repositoryClass();
        }

        foreach ($src as $key => $value) {
            if ($key == "id") continue;
            
            if (property_exists($dst, $key)) {
                $methodName = "set".ucfirst($key);
                if (method_exists($dst, $methodName)) {
                    call_user_func(array($dst, $methodName), $value);

                    $audit = new PropertyAudit();
                    $audit
                        ->setEntityClass($this->repository->getClassName())
                        ->setPropertyName($key)
                        ->setOldValue('')
                        ->setNewValue($value);
                    $propertyUpdateEvent = new PropertyUpdateEvent($audit);
                    $this->eventDispatcher->dispatch(\App\CustomEvents\PropertyUpdateEvent::NAME, $propertyUpdateEvent);

                    // https://www.youtube.com/watch?v=4JaWJfOLN8w

                }
            }

        }

        return $dst;
    }
}