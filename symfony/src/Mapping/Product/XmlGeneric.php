<?php
namespace App\Mapping\Product;

define (__NAMESPACE__ . '\\'.basename(__FILE__,'.php'), [
    "Codigo" => "sku",
    "Descripcion" => "name",
    "CodigoBarras" => "ean13",
    "Precio" => "pvp",
    "Cantidad" => "stockToShow",
    "StockReal" => "stock",
    "StockDisponible" => "stockAvailable"
]);