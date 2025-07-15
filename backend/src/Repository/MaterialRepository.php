<?php

namespace Soosuuke\Shopcart\Repository;

use PDO;
use Soosuuke\Shopcart\Model\Material;

class MaterialRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id): ?Material
    {
        $stmt = $this->pdo->prepare('SELECT * FROM material WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Material((int) $data['id'], $data['name']);
    }

    /**
     * @return Material[]
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM material');
        $materials = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $materials[] = new Material((int) $row['id'], $row['name']);
        }

        return $materials;
    }

    public function save(Material $material): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO material (id, name)
             VALUES (:id, :name)
             ON DUPLICATE KEY UPDATE name = VALUES(name)'
        );

        $stmt->execute([
            'id' => $material->getId(),
            'name' => $material->getName(),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM material WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
