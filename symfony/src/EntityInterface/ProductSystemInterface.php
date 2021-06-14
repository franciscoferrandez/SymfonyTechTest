<?php
namespace App\EntityInterface;

interface ProductSystemInterface
{
    public function getId(): ?int;

    public function setSku(string $sku);

    public function getSku(): ?string;

    public function setEan13(?string $ean13);

    public function getEan13(): ?string;

    public function setEanVirtual(?string $eanVirtual);

    public function getEanVirtual(): ?string;

    public function setProductEans(array $eans);

    public function getProductEans(): array;

    public function setStock(int $stock);

    public function getStock(): ?int;

    public function setStockCatalog(int $stockCatalog);

    public function getStockCatalog(): ?int;

    public function setStockToShow(int $stockToShow);

    public function getStockToShow(): int;

    public function setStockAvailable(int $stockAvailable);

    public function getStockAvailable(): int;

    public function setCategoryName(?string $categoryName);

    public function getCategoryName(): ?string;

    public function setBrandName(?string $brandName);

    public function getBrandName(): ?string;

    public function getPartNumber(): ?string;

    public function setPartNumber(?string $partNumber);

    public function setCollection(?string $collection);

    public function getCollection(): ?string;

    public function setPriceCatalog(float $priceCatalog);

    public function getPriceCatalog(): ?float;

    public function setPriceWholesale(?float $priceWholesale);

    public function getPriceWholesale(): ?float;

    public function setPriceRetail(float $priceRetail);

    public function getPriceRetail(): float;

    public function setPvp(float $pvp);

    public function getPvp(): float;

    public function setDiscount(float $priceRetail);

    public function getDiscount(): ?float;

    public function getWeight(): ?float;

    public function getHeight(): ?float;

    public function getWidth(): ?float;

    public function getLength(): ?float;

    public function getWeightPackaging(): ?float;

    public function getLengthPackaging(): ?float;

    public function getHeightPackaging(): ?float;

    public function getWidthPackaging(): ?float;

    public function getWeightMaster(): ?float;

    public function getLengthMaster(): ?float;

    public function getHeightMaster(): ?float;

    public function getWidthMaster(): ?float;

    public function setName(?string $name);

    public function getName(): ?string;

    public function setDescription(?string $description);

    public function getDescription(): ?string;

    //public function setProductLangsSupplier(array $productLangsSupplier);

    /** @return ProductLang[] */
    //public function getProductLangsSupplier(): array;

    public function setProductImages(array $productImages);

    public function getProductImages(): array;

    public function getTax(): ?float;

    //public function setProductAttributes(array $productAttributes);

    /** @return ProductAttribute[] */
    //public function getProductAttributes(): array;

    //public function addProductAttribute(ProductAttribute $productAttribute);

    public function getUnitBox(): ?int;

    public function setUnitBox(int $unitBox);

    public function getUnitPalet(): ?int;

    public function setUnitPalet(int $unitPalet);

    public function getAssortment(): int;

    public function setAssortment(int $assortment);

    public function getMinSalesUnit(): int;

    public function setMinSalesUnit(int $minSalesUnit);
}