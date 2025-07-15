<?php

namespace Soosuuke\Shopcart\Controller;

use Soosuuke\Shopcart\Repository\CategoryRepository;

class CategoryController
{
    private CategoryRepository $repo;

    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(): void
    {
        $categories = $this->repo->findAll();
        $this->json($categories);
    }

    private function json(mixed $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
