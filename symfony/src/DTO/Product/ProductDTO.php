<?php

namespace App\DTO;

class ProductDTO 
{

    public $id;

    public $sku;

    public $ean13;

    public $eanVirtual;

    public $productEans = [];

    public $stock = 0;

    public $stockCatalog;

    public $stockToShow = 0;

    public $stockAvailable = 0;

    public $categoryName;

    public $brandName;

    public $partNumber;

    public $collection;

    public $priceCatalog;

    public $priceWholesale;

    public $priceRetail = 0;

    public $pvp = 0;

    public $discount;

    public $weight;

    public $height;

    public $width;

    public $length;

    public $weightPackaging;

    public $lengthPackaging;

    public $widthPackaging;

    public $heightPackaging;

    public $weightMaster;

    public $lengthMaster;

    public $heightMaster;

    public $widthMaster;

    public $name;

    public $description;

    public $productImages = [];

    public $tax;

    public $unitBox;

    public $unitPalet;

    public $assortment = 0;

    public $minSalesUnit = 0;
}