<?php
namespace App\Mapping;

class ObjectMapper {
    public function map($src, $mapping) {
        foreach ($mapping as $kmap => $valmap) {
            $src->$valmap = $src->$kmap;
        }
        return $src;
    }
}