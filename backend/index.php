<?php

require_once __DIR__ . '/vendor/autoload.php';

use Soosuuke\Shopcart\Config\Database;
use Soosuuke\Shopcart\Repository\ProductRepository;
use Soosuuke\Shopcart\Repository\CategoryRepository;
use Soosuuke\Shopcart\Repository\ColorRepository;
use Soosuuke\Shopcart\Repository\MaterialRepository;
use Soosuuke\Shopcart\Repository\ProductColorRepository;
use Soosuuke\Shopcart\Repository\ProductMaterialRepository;
use Soosuuke\Shopcart\Controller\ProductController;
use Soosuuke\Shopcart\Controller\CategoryController;
use Soosuuke\Shopcart\Controller\ColorController;
use Soosuuke\Shopcart\Controller\MaterialController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // adapte le chemin si besoin
$dotenv->load();

// 🔐 CORS HEADERS pour Angular (localhost:4200)
header('Access-Control-Allow-Origin: http://104.155.43.118');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// OPTIONS prévol = on sort sans traitement
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 🌍 Connexion à la base
$pdo = Database::connect();

// 📦 Dépendances
$categoryRepo         = new CategoryRepository($pdo);
$colorRepo            = new ColorRepository($pdo);
$materialRepo         = new MaterialRepository($pdo);
$productColorRepo     = new ProductColorRepository($pdo, $colorRepo);
$productMaterialRepo  = new ProductMaterialRepository($pdo, $materialRepo);
$productRepo          = new ProductRepository($pdo, $categoryRepo, $productColorRepo, $productMaterialRepo);

// 🧠 Contrôleurs
$productController   = new ProductController($productRepo);
$categoryController  = new CategoryController($categoryRepo);
$colorController     = new ColorController($colorRepo);
$materialController  = new MaterialController($materialRepo);

// 🛣️ Routage basique (GET uniquement)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/products':
        $productController->index();
        break;
    case (preg_match('#^/products/(\d+)$#', $uri, $matches) ? true : false):
        $productController->show((int) $matches[1]);
        break;
    case '/products/search':
        $productController->search();
        break;
    case '/products/promoted':
        $productController->promoted();
        break;
    case '/products/filter':
        $productController->filter();
        break;
    case '/categories':
        $categoryController->index();
        break;
    case '/colors':
        $colorController->index();
        break;
    case '/materials':
        $materialController->index();
        break;
    case '/':
        require_once('doc.html');
        break;
    default:
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Route not found']);
}
