<?php

namespace App\Controller;

use App\DTO\ProductDTO;
use App\Infrastructure\ObjectReader\ObjectReaderInterface;
use App\Infrastructure\ObjectReader\ObjectReaderSource;
use App\Mapping\SimpleMapper;
use App\Repository\ProductRepository;
use App\Service\API\Common\GenericApi;
use App\Service\Entity\ProductService;
use App\Service\Entity\PropertyAuditService;
use App\Service\Importer\ObjectImporter;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController 
{

    private $service;
    private $logger;
    private $genericApi;
    /* private $paservice; */

    public function __construct(ProductService $service, /* PropertyAuditService $paservice,  */LoggerInterface $logger, GenericApi $genericApi)
    {
        $this->service = $service;
        $this->logger = $logger;
        $this->genericApi = $genericApi;
        /* $this->paservice = $paservice; */
    }

    /**
     * @Route("/api/product/all", name="product_all")
     */
    public function list(Request $request) {
        $this->logger->info(__CLASS__.'::'.__FUNCTION__);

        $entityList = $this->service->getAll();

        $response = new JsonResponse();
        $response->setData([
            'success' => true,
            'data' => $entityList
                ]);
        return $response;
    }


    /**
     * @Route("/api/product/import/xml", name="product_import_xml")
     */
    public function readXml(Request $request, ObjectReaderInterface $xmlReader, KernelInterface $appKernel) {

        $source = new ObjectReaderSource();
        $source->setUrl($appKernel->getProjectDir()."/public/assets"."/bigbuy/Articulos.xml");
        $xmlReader->setSource($source);
        $responseData = $xmlReader->readFromSource();

        $importedList = $this->service->importFromFileWithMapping($responseData, \App\Mapping\Product\XmlGeneric);

        $response = new JsonResponse();
        $response->setData($importedList);
        return $response;
    }


    /**
     * @Route("/api/product/import/json", name="product_import_json")
     */
    public function readJson(Request $request, ObjectReaderInterface $jsonReader, ObjectImporter $importer, KernelInterface $appKernel) {
        $source = new ObjectReaderSource();
        $source->setUrl($appKernel->getProjectDir()."/public/assets"."/bigbuy/catalog.json");
        $jsonReader->setSource($source);
        $responseData = $jsonReader->readFromSource();

        $importedList = $this->service->importFromFileWithMapping($responseData, \App\Mapping\Product\JsonGeneric);

        foreach ($importedList as $key => &$item) {
            $item = SimpleMapper::Map($item, new ProductDTO());
        }

        $response = new JsonResponse();
        $response->setData($importedList);
        return $response;
    }



    /**
     * @Route("/api/product/import/xlsx", name="product_import_xlsx")
     */
    public function readXlsx(Request $request, ObjectReaderInterface $xlsxReader, ObjectImporter $importer, KernelInterface $appKernel) {
        $source = new ObjectReaderSource();
        $source->setUrl($appKernel->getProjectDir()."/public/assets"."/bigbuy/Productos.xlsx");
        $xlsxReader->setSource($source);
        $responseData = $xlsxReader->readFromSource();

        $importedList = $this->service->importFromFileWithMapping($responseData, \App\Mapping\Product\XlsxGeneric);

        foreach ($importedList as $key => &$item) {
            $item = SimpleMapper::Map($item, new ProductDTO());
        }

        $response = new JsonResponse();
        $response->setData($importedList);
        return $response;
    }
}