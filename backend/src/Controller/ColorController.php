<?php

namespace Soosuuke\Shopcart\Controller;

use Soosuuke\Shopcart\Repository\ColorRepository;

class ColorController
{
    private ColorRepository $repo;

    public function __construct(ColorRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(): void
    {
        $colors = $this->repo->findAll();
        $this->json($colors);
    }

    private function json(mixed $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
