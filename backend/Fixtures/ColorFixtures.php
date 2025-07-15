<?php

namespace Soosuuke\Shopcart\Fixtures;

use Soosuuke\Shopcart\Model\Color;
use Soosuuke\Shopcart\Repository\ColorRepository;

class ColorFixtures
{
    public static function load(ColorRepository $repo): void
    {
        $colors = [
            ['id' => 1, 'name' => 'Rouge'],
            ['id' => 2, 'name' => 'Bleu'],
            ['id' => 3, 'name' => 'Vert'],
            ['id' => 4, 'name' => 'Jaune'],
            ['id' => 5, 'name' => 'Noir'],
            ['id' => 6, 'name' => 'Blanc'],
            ['id' => 7, 'name' => 'Gris'],
            ['id' => 8, 'name' => 'Orange'],
            ['id' => 9, 'name' => 'Rose'],
            ['id' => 10, 'name' => 'Violet'],
            ['id' => 11, 'name' => 'Turquoise'],
            ['id' => 12, 'name' => '#FF5733'],     // Rouge-orangé vif
            ['id' => 13, 'name' => '#3498DB'],     // Bleu clair
            ['id' => 14, 'name' => '#2ECC71'],     // Vert émeraude
            ['id' => 15, 'name' => '#F1C40F'],     // Jaune doré
            ['id' => 16, 'name' => '#8E44AD'],     // Violet profond
        ];

        foreach ($colors as $colorData) {
            $color = new Color($colorData['id'], $colorData['name']);
            $repo->save($color);
        }
    }
}
