<?php

namespace Soosuuke\Shopcart\Repository;

use PDO;
// use Soosuuke\Shopcart\Model\Product;
use Soosuuke\Shopcart\Model\Color;
use Soosuuke\Shopcart\Model\ProductColor;

class ProductColorRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(ProductColor $productColor): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO product_color (product_id, color_id)
             VALUES (:product_id, :color_id)
             ON DUPLICATE KEY UPDATE product_id = product_id'
        );

        $stmt->execute([
            'product_id' => $productColor->getProduct()->getId(),
            'color_id' => $productColor->getColor()->getId(),
        ]);
    }

    public function delete(int $productId, int $colorId): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM product_color WHERE product_id = :product_id AND color_id = :color_id'
        );

        $stmt->execute([
            'product_id' => $productId,
            'color_id' => $colorId,
        ]);
    }

    /**
     * @return Color[]
     */
    public function findColorsByProductId(int $productId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT c.* FROM color c
             INNER JOIN product_color pc ON pc.color_id = c.id
             WHERE pc.product_id = :product_id'
        );

        $stmt->execute(['product_id' => $productId]);

        $colors = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $colors[] = new Color((int) $row['id'], $row['name']);
        }

        return $colors;
    }
}
