<?php
namespace App\Service\Importer;

use App\Mapping\ObjectMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class ObjectImporter {

    private $em;

    private $repository;
    private $mapping;
    private $key;

    private $mapper;

    public function __construct(EntityManagerInterface $em, ObjectMapper $mapper)
    {
        $this->mapper = $mapper;
        $this->em = $em;
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
        foreach ($list as $key => $item) {
            $mappedObj = $this->mapper->map($item, $this->mapping);
            $dbObj = $this->repository->findOneBy(
                array($this->key=> $mappedObj->{$this->key}), 
                array('id' => 'ASC'));

            $dbObj = $this->setFieldByField($dbObj, $mappedObj);

            $this->em->persist($dbObj);
            $this->em->flush();
        }
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
                if (method_exists($dst, $methodName)) call_user_func(array($dst, $methodName), $value);
            }

        }

        return $dst;
    }
}