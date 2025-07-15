<?php

namespace Soosuuke\Shopcart\Controller;

use Soosuuke\Shopcart\Repository\MaterialRepository;

class MaterialController
{
    private MaterialRepository $repo;

    public function __construct(MaterialRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(): void
    {
        $materials = $this->repo->findAll();
        $this->json($materials);
    }

    private function json(mixed $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
