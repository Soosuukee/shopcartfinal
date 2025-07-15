<?php

namespace Soosuuke\Shopcart\Model;

use Soosuuke\Shopcart\Model\Product;
use Soosuuke\Shopcart\Model\Material;

class ProductMaterial implements \JsonSerializable
{
    private Product $product;
    private Material $material;

    public function __construct(Product $product, Material $material)
    {
        $this->product = $product;
        $this->material = $material;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'product_id' => $this->product->getId(),
            'material' => $this->material
        ];
    }
}
