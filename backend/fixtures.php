<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Soosuuke\Shopcart\Config\Database;
use Soosuuke\Shopcart\Repository\CategoryRepository;
use Soosuuke\Shopcart\Repository\ColorRepository;
use Soosuuke\Shopcart\Repository\MaterialRepository;
use Soosuuke\Shopcart\Repository\ProductRepository;
use Soosuuke\Shopcart\Repository\ProductColorRepository;
use Soosuuke\Shopcart\Repository\ProductMaterialRepository;

use Soosuuke\Shopcart\Fixtures\CategoryFixtures;
use Soosuuke\Shopcart\Fixtures\ColorFixtures;
use Soosuuke\Shopcart\Fixtures\MaterialFixtures;
use Soosuuke\Shopcart\Fixtures\ProductFixtures;

// Chargement des variables d’environnement
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connexion à la base de données
$pdo = Database::connect();

// Référentiels
$categoryRepo = new CategoryRepository($pdo);
$colorRepo = new ColorRepository($pdo);
$materialRepo = new MaterialRepository($pdo);
$productColorRepo = new ProductColorRepository($pdo);
$productMaterialRepo = new ProductMaterialRepository($pdo);
$productRepo = new ProductRepository($pdo, $categoryRepo, $productColorRepo, $productMaterialRepo);

// Chargement des fixtures
CategoryFixtures::load($categoryRepo);
ColorFixtures::load($colorRepo);
MaterialFixtures::load($materialRepo);
ProductFixtures::load($productRepo, $categoryRepo, $colorRepo, $materialRepo);

echo "✅ Données de test insérées avec succès !\n";
