<?php

namespace Soosuuke\Shopcart\Model;

use Soosuuke\Shopcart\Model\Product;
use Soosuuke\Shopcart\Model\Color;

class ProductColor implements \JsonSerializable
{
    private Product $product;
    private Color $color;

    public function __construct(Product $product, Color $color)
    {
        $this->product = $product;
        $this->color = $color;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getColor(): Color
    {
        return $this->color;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'product_id' => $this->product->getId(),
            'color' => $this->color
        ];
    }
}
