<?php

namespace Soosuuke\Shopcart\Repository;

use PDO;
// use Soosuuke\Shopcart\Model\Product;
use Soosuuke\Shopcart\Model\Material;
use Soosuuke\Shopcart\Model\ProductMaterial;

class ProductMaterialRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(ProductMaterial $productMaterial): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO product_material (product_id, material_id)
             VALUES (:product_id, :material_id)
             ON DUPLICATE KEY UPDATE product_id = product_id'
        );

        $stmt->execute([
            'product_id' => $productMaterial->getProduct()->getId(),
            'material_id' => $productMaterial->getMaterial()->getId(),
        ]);
    }

    public function delete(int $productId, int $materialId): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM product_material WHERE product_id = :product_id AND material_id = :material_id'
        );

        $stmt->execute([
            'product_id' => $productId,
            'material_id' => $materialId,
        ]);
    }

    /**
     * @return Material[]
     */
    public function findMaterialsByProductId(int $productId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT m.* FROM material m
             INNER JOIN product_material pm ON pm.material_id = m.id
             WHERE pm.product_id = :product_id'
        );

        $stmt->execute(['product_id' => $productId]);

        $materials = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $materials[] = new Material((int) $row['id'], $row['name']);
        }

        return $materials;
    }
}
