<?php

namespace App\Controller;

use App\DTO\ProductDTO;
use App\Infrastructure\ObjectReader\ObjectReaderInterface;
use App\Infrastructure\ObjectReader\ObjectReaderSource;
use App\Mapping\SimpleMapper;
use App\Repository\ProductRepository;
use App\Service\API\Common\GenericApi;
use App\Service\Importer\ObjectImporter;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController 
{

    private $logger;
    private $genericApi;

    public function __construct(LoggerInterface $logger, GenericApi $genericApi)
    {
        $this->logger = $logger;
        $this->genericApi = $genericApi;
    }

    /**
     * @Route("/library/list", name="library_list")
     */
    public function list(Request $request, ProductRepository $productRepository) {
        $this->logger->info(__CLASS__.'::'.__FUNCTION__);

        $entityList = $productRepository->findAll();
        foreach ($entityList as $key => &$item) {
            $item = SimpleMapper::Map($item, new ProductDTO());
        }

        $response = new JsonResponse();
        $response->setData([
            'success' => true,
            'data' => $entityList
                ]);
        return $response;
    }

    /**
     * @Route("/library/constants", name="library_constants")
     */
    public function constants(Request $request) {
        $constants = get_defined_constants(TRUE)['user'];

        foreach ($constants as $name => $value)
        {
        
          //if (0 === strpos($name, 'services\storage\connectors'))
          //{
            $services_storage_connectors[] = $name;
          //}
        
        }
        $response = new JsonResponse();
        $response->setData($services_storage_connectors);
        return $response;
    }

    /**
     * @Route("/library/constantvaluetest", name="library_constant_value_test")
     */
    public function constantValueTest(Request $request) {
        $response = new JsonResponse();
        $response->setData(\App\Mapping\Product\JsonGeneric);
        return $response;
    }

    /**
     * @Route("/library/readxml", name="library_readxml")
     */
    public function readXml(Request $request, ProductRepository $repository, ObjectReaderInterface $xmlReader, ObjectImporter $importer, KernelInterface $appKernel) {
        $source = new ObjectReaderSource();
        $source->setUrl($appKernel->getProjectDir()."/public/assets"."/bigbuy/Articulos.xml");
        $xmlReader->setSource($source);

        $responseData = [];

        $responseData = $xmlReader->readFromSource();

        //dd($responseData);

        $importer->setRepository($repository);
        $importer->setMapping(\App\Mapping\Product\XmlGeneric);
        $importer->setKey('sku');

        $importedList = $importer->import($responseData);

        foreach ($importedList as $key => &$item) {
            $item = SimpleMapper::Map($item, new ProductDTO());
        }

        $response = new JsonResponse();
        $response->setData($importedList);
        return $response;
    }


    /**
     * @Route("/library/readjson", name="library_readjson")
     */
    public function readJson(Request $request, ProductRepository $repository, ObjectReaderInterface $jsonReader, ObjectImporter $importer, KernelInterface $appKernel) {
        $source = new ObjectReaderSource();
        $source->setUrl($appKernel->getProjectDir()."/public/assets"."/bigbuy/catalog.json");
        $jsonReader->setSource($source);

        $responseData = [];

        $responseData = $jsonReader->readFromSource();

        //dd($responseData);

        $importer->setRepository($repository);
        $importer->setMapping(\App\Mapping\Product\JsonGeneric);
        $importer->setKey('sku');

        $importedList = $importer->import($responseData);

        foreach ($importedList as $key => &$item) {
            $item = SimpleMapper::Map($item, new ProductDTO());
        }

        $response = new JsonResponse();
        $response->setData($importedList);
        return $response;
    }
}