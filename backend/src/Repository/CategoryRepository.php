<?php

namespace Soosuuke\Shopcart\Repository;

use PDO;
use Soosuuke\Shopcart\Model\Category;

class CategoryRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id): ?Category
    {
        $stmt = $this->pdo->prepare('SELECT * FROM category WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Category((int) $data['id'], $data['name']);
    }

    /**
     * @return Category[]
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM category');
        $categories = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category((int) $row['id'], $row['name']);
        }

        return $categories;
    }

    public function save(Category $category): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO category (id, name)
             VALUES (:id, :name)
             ON DUPLICATE KEY UPDATE name = VALUES(name)'
        );

        $stmt->execute([
            'id' => $category->getId(),
            'name' => $category->getName(),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM category WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
