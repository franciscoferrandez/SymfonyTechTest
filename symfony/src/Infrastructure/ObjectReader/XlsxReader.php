<?php
namespace App\Infrastructure\ObjectReader;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Psr\Log\LoggerInterface;
use stdClass;
use Symfony\Component\DomCrawler\Crawler;

class XlsxReader implements ObjectReaderInterface
{
    private $source;
    private $logger;
    private $spreadsheet;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
        $this->logger->info(__CLASS__.'::'.__FUNCTION__);
        $this->spreadsheet = new Spreadsheet();
    }

    public function setSource(?ObjectReaderSourceInterface $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function readFromSource()
    {

        /**  Identify the type of $inputFileName  **/
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($this->source->getUrl());
        /**  Create a new Reader of the type that has been identified  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $this->spreadsheet = $reader->load($this->source->getUrl());

        $worksheet = $this->spreadsheet->getActiveSheet();

        $propertyNames = array();
        $items = array();
        $rownum = 0;


        foreach ($worksheet->getRowIterator() as $row) {
            $rownum++;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                                                               //    even if a cell value is not set.
                                                               // For 'TRUE', we loop through cells
                                                               //    only when their value is set.
                                                               // If this method is not called,
                                                               //    the default value is 'false'.
            $item = new stdClass();
            foreach ($cellIterator as $cellkey => $cell) {
                if ($rownum == 1) {
                    $propertyNames[$cellkey] = $cell->getValue();
                } else {
                    $item->{$propertyNames[$cellkey]} = $cell->getValue();
                }
            }
            if ($rownum > 1) $items[] = $item;
        }

        return $items;
    }

}