<?php

namespace Soosuuke\Shopcart\Controller;

use Soosuuke\Shopcart\Repository\ProductRepository;

class ProductController
{
    private ProductRepository $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(): void
    {
        $products = $this->repo->findAll();
        $this->json($products);
    }

    public function show(int $id): void
    {
        $product = $this->repo->find($id);

        if (!$product) {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
            return;
        }

        $this->json($product);
    }

    public function promoted(): void
    {
        $products = $this->repo->findPromotedProducts();
        $this->json($products);
    }

    public function search(): void
    {
        $q = $_GET['q'] ?? '';
        $results = $this->repo->search($q);
        $this->json($results);
    }

    public function filter(): void
    {
        $criteria = [
            'category_id'   => $_GET['category_id'] ?? null,
            'color_id'      => $_GET['color_id'] ?? null,
            'material_id'   => $_GET['material_id'] ?? null,
            'q'             => $_GET['q'] ?? null,
            'order_by'      => $_GET['order_by'] ?? null,
            'order_dir'     => $_GET['order_dir'] ?? null,
        ];

        $results = $this->repo->filter($criteria);
        $this->json($results);
    }

    private function json(mixed $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
