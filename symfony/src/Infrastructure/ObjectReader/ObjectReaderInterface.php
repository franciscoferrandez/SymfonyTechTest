<?php
namespace App\Infrastructure\ObjectReader;

interface ObjectReaderInterface
{
    public function setSource(?ObjectReaderSourceInterface $source);
    public function readFromSource ();
}