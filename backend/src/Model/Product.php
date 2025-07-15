<?php

namespace Soosuuke\Shopcart\Model;

use Soosuuke\Shopcart\Model\Category;
use Soosuuke\Shopcart\Model\Color;
use Soosuuke\Shopcart\Model\Material;

class Product implements \JsonSerializable
{
    private int $id;
    private string $name;
    private string $image;
    private string $shortDescription;
    private float $price;
    private float $promotionPercentage;
    private Category $category;

    /** @var Color[] */
    private array $colors = [];

    /** @var Material[] */
    private array $materials = [];

    public function __construct(
        int $id,
        string $name,
        string $image,
        string $shortDescription,
        float $price,
        float $promotionPercentage,
        Category $category
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->shortDescription = $shortDescription;
        $this->price = $price;
        $this->setPromotionPercentage($promotionPercentage);
        $this->category = $category;
    }

    // Getters / Setters identiques...

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getImage(): string
    {
        return $this->image;
    }
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }
    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPromotionPercentage(): float
    {
        return $this->promotionPercentage;
    }
    public function setPromotionPercentage(float $promotionPercentage): void
    {
        if ($promotionPercentage < 0) {
            throw new \InvalidArgumentException('Promotion percentage cannot be negative.');
        }
        $this->promotionPercentage = $promotionPercentage;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    // Couleurs
    public function getColors(): array
    {
        return $this->colors;
    }
    public function setColors(array $colors): void
    {
        $this->colors = $colors;
    }

    public function addColor(Color $color): void
    {
        foreach ($this->colors as $existing) {
            if ($existing->getId() === $color->getId()) return;
        }
        $this->colors[] = $color;
    }

    public function removeColor(int $colorId): void
    {
        $this->colors = array_filter($this->colors, fn($c) => $c->getId() !== $colorId);
    }

    // Matériaux
    public function getMaterials(): array
    {
        return $this->materials;
    }
    public function setMaterials(array $materials): void
    {
        $this->materials = $materials;
    }

    public function addMaterial(Material $material): void
    {
        foreach ($this->materials as $existing) {
            if ($existing->getId() === $material->getId()) return;
        }
        $this->materials[] = $material;
    }

    public function removeMaterial(int $materialId): void
    {
        $this->materials = array_filter($this->materials, fn($m) => $m->getId() !== $materialId);
    }

    // Pour json_encode()
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'short_description' => $this->shortDescription,
            'price' => $this->price,
            'promotion_percentage' => $this->promotionPercentage,
            'category' => [
                'id' => $this->category->getId(),
                'name' => $this->category->getName()
            ],
            'colors' => array_map(fn(Color $c) => [
                'id' => $c->getId(),
                'name' => $c->getName()
            ], $this->colors),
            'materials' => array_map(fn(Material $m) => [
                'id' => $m->getId(),
                'name' => $m->getName()
            ], $this->materials),
        ];
    }
}
