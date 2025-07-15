<?php

namespace Soosuuke\Shopcart\Fixtures;

use Soosuuke\Shopcart\Model\Category;
use Soosuuke\Shopcart\Repository\CategoryRepository;

class CategoryFixtures
{
    public static function load(CategoryRepository $repo): void
    {
        $categories = [
            'Sacs & Maroquinerie',
            'Accessoires téléphones',
            'Montres & Bijoux',
            'Décoration maison',
            'Électronique',
            'Gaming',
            'Sport & Fitness',
            'Beauté',
            'Mode Homme',
            'Mode Femme',
            'Enfants & Bébé',
            'Bureau & Papeterie'
        ];

        foreach ($categories as $index => $name) {
            $category = new Category($index + 1, $name);
            $repo->save($category);
        }
    }
}
