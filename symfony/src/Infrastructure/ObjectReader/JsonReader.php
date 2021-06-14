<?php
namespace App\Infrastructure\ObjectReader;

use Psr\Log\LoggerInterface;
use stdClass;

class JsonReader implements ObjectReaderInterface
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
        
        $sourceContent = json_decode($source);

        return ($sourceContent->Data);
    }

}