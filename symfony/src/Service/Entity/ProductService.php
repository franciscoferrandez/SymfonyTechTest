<?php

namespace App\Service\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use App\Mapping\SimpleMapper;
use App\DTO\ProductDTO;
use App\Service\Importer\ObjectImporter;

class ProductService {

    private $em;
    private $repository;
    private $logger;
    private $importer;

    public function __construct(EntityManagerInterface $em, ProductRepository $repository, LoggerInterface $logger, ObjectImporter $importer ) {
        $this->em = $em;
        $this->repository = $repository;
        $this->logger = $logger;
        $this->importer = $importer;
    }

    public function getAll()
    {
        $entityList = $this->repository->findAll();
        foreach ($entityList as $key => &$item) {
            $item = SimpleMapper::Map($item, new ProductDTO());
        }
        return $entityList;
    }

    public function importFromFileWithMapping($list, $mapping)
    {

        $this->importer->setRepository($this->repository);
        $this->importer->setMapping($mapping);
        $this->importer->setKey('sku');

        $importedList = $this->importer->import($list);

        foreach ($importedList as $key => &$item) {
            $item = SimpleMapper::Map($item, new ProductDTO());
        }

        return $importedList;
    }


}