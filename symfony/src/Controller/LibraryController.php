<?php

namespace App\Controller;

use App\Infrastructure\ObjectReader\ObjectReaderInterface;
use App\Infrastructure\ObjectReader\ObjectReaderSource;
use App\Service\API\Common\GenericApi;
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
    public function list(Request $request) {
        $this->logger->info(__CLASS__.'::'.__FUNCTION__);
        $response = new JsonResponse();
        $response->setData([
            'success' => true,
            'data' => [
                [
                    'id' => 1,
                    'titulo' => 'El nombre de la rosa'
                ],
                [
                    'id' => 2,
                    'titulo' => 'La piel del tambor'
                ]
            ]
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
    public function readXml(Request $request, ObjectReaderInterface $xmlReader, KernelInterface $appKernel) {
        $source = new ObjectReaderSource();
        $source->setUrl($appKernel->getProjectDir()."/public/assets"."/bigbuy/Articulos.xml");
        $xmlReader->setSource($source);

        $responseData = [];

        $responseData = $xmlReader->readFromSource();

        dd($responseData);

        $response = new JsonResponse();
        $response->setData($responseData);
        return $response;
    }
}