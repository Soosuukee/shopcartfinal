<?php

namespace Soosuuke\Shopcart\Repository;

use PDO;
use Soosuuke\Shopcart\Model\Product;
use Soosuuke\Shopcart\Repository\CategoryRepository;
use Soosuuke\Shopcart\Repository\ProductColorRepository;
use Soosuuke\Shopcart\Repository\ProductMaterialRepository;



class ProductRepository
{
    private PDO $pdo;
    private CategoryRepository $categoryRepo;
    private ProductColorRepository $productColorRepo;
    private ProductMaterialRepository $productMaterialRepo;

    public function __construct(
        PDO $pdo,
        CategoryRepository $categoryRepo,
        ProductColorRepository $productColorRepo,
        ProductMaterialRepository $productMaterialRepo
    ) {
        $this->pdo = $pdo;
        $this->categoryRepo = $categoryRepo;
        $this->productColorRepo = $productColorRepo;
        $this->productMaterialRepo = $productMaterialRepo;
    }

    /**
     * @param \PDOStatement $stmt
     * @return Product[]
     */
    private function hydrateProductResults(\PDOStatement $stmt): array
    {
        $products = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = $this->categoryRepo->find((int) $row['category_id']);

            $product = new Product(
                (int) $row['id'],
                $row['name'],
                $row['image'],
                $row['short_description'],
                (float) $row['price'],
                (float) $row['promotion_percentage'],
                $category
            );

            $product->setColors($this->productColorRepo->findColorsByProductId($product->getId()));
            $product->setMaterials($this->productMaterialRepo->findMaterialsByProductId($product->getId()));

            $products[] = $product;
        }

        return $products;
    }

    public function find(int $id): ?Product
    {
        $stmt = $this->pdo->prepare('SELECT * FROM product WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $category = $this->categoryRepo->find((int) $data['category_id']);

        $product = new Product(
            (int) $data['id'],
            $data['name'],
            $data['image'],
            $data['short_description'],
            (float) $data['price'],
            (float) $data['promotion_percentage'],
            $category
        );

        $product->setColors($this->productColorRepo->findColorsByProductId($product->getId()));
        $product->setMaterials($this->productMaterialRepo->findMaterialsByProductId($product->getId()));

        return $product;
    }

    /**
     * @return Product[]
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM product');
        return $this->hydrateProductResults($stmt);
    }

    public function save(Product $product): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO product (id, name, image, short_description, price, promotion_percentage, category_id)
             VALUES (:id, :name, :image,:short_description, :price, :promotion_percentage, :category_id)
             ON DUPLICATE KEY UPDATE
                name = VALUES(name),
                short_description = VALUES(short_description),
                price = VALUES(price),
                promotion_percentage = VALUES(promotion_percentage),
                category_id = VALUES(category_id)'
        );

        $stmt->execute([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'image' => $product->getImage(),
            'short_description' => $product->getShortDescription(),
            'price' => $product->getPrice(),
            'promotion_percentage' => $product->getPromotionPercentage(),
            'category_id' => $product->getCategory()->getId()
        ]);

        // sync couleurs
        foreach ($this->productColorRepo->findColorsByProductId($product->getId()) as $existingColor) {
            $this->productColorRepo->delete($product->getId(), $existingColor->getId());
        }
        foreach ($product->getColors() as $color) {
            $this->productColorRepo->save(
                new \Soosuuke\Shopcart\Model\ProductColor($product, $color)
            );
        }

        // sync matériaux
        foreach ($this->productMaterialRepo->findMaterialsByProductId($product->getId()) as $existingMaterial) {
            $this->productMaterialRepo->delete($product->getId(), $existingMaterial->getId());
        }
        foreach ($product->getMaterials() as $material) {
            $this->productMaterialRepo->save(
                new \Soosuuke\Shopcart\Model\ProductMaterial($product, $material)
            );
        }
    }

    public function delete(int $id): void
    {
        $this->pdo->prepare('DELETE FROM product WHERE id = :id')->execute(['id' => $id]);
    }

    public function findByCategoryId(int $categoryId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM product WHERE category_id = :category_id');
        $stmt->execute(['category_id' => $categoryId]);
        return $this->hydrateProductResults($stmt);
    }

    public function findPromotedProducts(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM product WHERE promotion_percentage > 0');
        return $this->hydrateProductResults($stmt);
    }

    public function findByColorId(int $colorId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.* FROM product p
         INNER JOIN product_color pc ON p.id = pc.product_id
         WHERE pc.color_id = :color_id'
        );
        $stmt->execute(['color_id' => $colorId]);

        return $this->hydrateProductResults($stmt);
    }

    public function findByMaterialId(int $materialId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.* FROM product p
         INNER JOIN product_material pm ON p.id = pm.product_id
         WHERE pm.material_id = :material_id'
        );
        $stmt->execute(['material_id' => $materialId]);

        return $this->hydrateProductResults($stmt);
    }

    public function search(string $query): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM product
         WHERE name LIKE :q OR short_description LIKE :q'
        );
        $stmt->execute(['q' => '%' . $query . '%']);

        return $this->hydrateProductResults($stmt);
    }

    public function filter(array $criteria): array
    {
        $joins = [];
        $conditions = [];
        $params = [];
        $sql = 'SELECT DISTINCT p.* FROM product p';

        if (!empty($criteria['color_id'])) {
            $joins[] = 'INNER JOIN product_color pc ON pc.product_id = p.id';
            $conditions[] = 'pc.color_id = :color_id';
            $params['color_id'] = $criteria['color_id'];
        }

        if (!empty($criteria['material_id'])) {
            $joins[] = 'INNER JOIN product_material pm ON pm.product_id = p.id';
            $conditions[] = 'pm.material_id = :material_id';
            $params['material_id'] = $criteria['material_id'];
        }

        if (!empty($criteria['category_id'])) {
            $conditions[] = 'p.category_id = :category_id';
            $params['category_id'] = $criteria['category_id'];
        }

        if (!empty($criteria['q'])) {
            $conditions[] = '(p.name LIKE :q OR p.short_description LIKE :q)';
            $params['q'] = '%' . $criteria['q'] . '%';
        }

        if ($joins) {
            $sql .= ' ' . implode(' ', $joins);
        }

        if ($conditions) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        // --- Gestion du tri sécurisé ---
        $allowedOrderBy = ['name', 'price', 'promotion_percentage'];
        $allowedOrderDir = ['asc', 'desc'];

        $orderBy = in_array(strtolower($criteria['order_by'] ?? ''), $allowedOrderBy)
            ? $criteria['order_by']
            : null;

        $orderDir = in_array(strtolower($criteria['order_dir'] ?? ''), $allowedOrderDir)
            ? strtoupper($criteria['order_dir'])
            : 'ASC';

        if ($orderBy) {
            $sql .= " ORDER BY p.$orderBy $orderDir";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $this->hydrateProductResults($stmt);
    }
}
