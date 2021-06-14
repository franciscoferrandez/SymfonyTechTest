<?php
namespace App\Infrastructure\ObjectReader;

use Psr\Log\LoggerInterface;
use stdClass;
use Symfony\Component\DomCrawler\Crawler;

class XmlReader implements ObjectReaderInterface
{
    private $source;
    private $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
        $this->logger->info(__CLASS__.'::'.__FUNCTION__);
    }

    public function setSource(?ObjectReaderSourceInterface $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function readFromSource()
    {
        $source = file_get_contents($this->source->getUrl());
        $crawler = new Crawler();
        $crawler->addXmlContent($source);

        $nodeValues = $crawler->filterXPath('//Articulos/*')->each(function (Crawler $node, $i) {
            return $node;
        });
        $articulos = array();
        foreach ($nodeValues as $articulo) {
            $atributos = $articulo->children()->extract(['_name', '_text']);
            //$articulos[] =$atributos;
            $articulo = new stdClass();
            foreach ($atributos as $key => $value) {
                $attname = $value[0];
                $articulo->$attname = $value[1];
            }
            $articulos[] = $articulo;
        }

        dd($articulos);
    }

}