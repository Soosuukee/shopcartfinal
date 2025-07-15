<?php

namespace Soosuuke\Shopcart\Repository;

use PDO;
use Soosuuke\Shopcart\Model\Color;

class ColorRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(int $id): ?Color
    {
        $stmt = $this->pdo->prepare('SELECT * FROM color WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Color((int) $data['id'], $data['name']);
    }

    /**
     * @return Color[]
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM color');
        $colors = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $colors[] = new Color((int) $row['id'], $row['name']);
        }

        return $colors;
    }

    public function save(Color $color): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO color (id, name)
             VALUES (:id, :name)
             ON DUPLICATE KEY UPDATE name = VALUES(name)'
        );

        $stmt->execute([
            'id' => $color->getId(),
            'name' => $color->getName(),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM color WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
