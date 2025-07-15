<?php

namespace Soosuuke\Shopcart\Fixtures;

use Soosuuke\Shopcart\Model\Material;
use Soosuuke\Shopcart\Repository\MaterialRepository;

class MaterialFixtures
{
    public static function load(MaterialRepository $repo): void
    {
        $materials = [
            ['id' => 1, 'name' => 'Coton'],
            ['id' => 2, 'name' => 'Cuir'],
            ['id' => 3, 'name' => 'Métal'],
            ['id' => 4, 'name' => 'Plastique'],
            ['id' => 5, 'name' => 'Bois'],
            ['id' => 6, 'name' => 'Verre'],
            ['id' => 7, 'name' => 'Acier inoxydable'],
            ['id' => 8, 'name' => 'Aluminium'],
            ['id' => 9, 'name' => 'Silicone'],
            ['id' => 10, 'name' => 'Polycarbonate'],
            ['id' => 11, 'name' => 'Céramique'],
            ['id' => 12, 'name' => 'Fibre de carbone'],
            ['id' => 13, 'name' => 'Néoprène'],
            ['id' => 14, 'name' => 'Caoutchouc'],
            ['id' => 15, 'name' => 'Liège'],
            ['id' => 16, 'name' => 'Chanvre'],
            ['id' => 17, 'name' => 'Lin'],
            ['id' => 18, 'name' => 'Nylon'],
            ['id' => 19, 'name' => 'Laine'],
            ['id' => 20, 'name' => 'Mousse à mémoire de forme'],
        ];

        foreach ($materials as $data) {
            $material = new Material($data['id'], $data['name']);
            $repo->save($material);
        }
    }
}
