<?php

namespace Soosuuke\Shopcart\Fixtures;

use Soosuuke\Shopcart\Model\Product;
// use Soosuuke\Shopcart\Model\ProductColor;
// use Soosuuke\Shopcart\Model\ProductMaterial;
use Soosuuke\Shopcart\Repository\ProductRepository;
use Soosuuke\Shopcart\Repository\CategoryRepository;
use Soosuuke\Shopcart\Repository\ColorRepository;
use Soosuuke\Shopcart\Repository\MaterialRepository;

class ProductFixtures
{
    public static function load(
        ProductRepository $productRepo,
        CategoryRepository $categoryRepo,
        ColorRepository $colorRepo,
        MaterialRepository $materialRepo
    ): void {
        $products = [
            // Sacs & Maroquinerie
            ['Sac à dos Herschel', 'hershel-backpack.jpg', 'Un sac classique pour un usage quotidien', 1],
            ['Porte-monnaie Fossil', 'fossil-wallet.jpg', 'Compact et élégant, idéal pour les poches', 1],
            ['Sac bandoulière Michael Kors', 'kors-handbag.jpg', 'Parfait pour une sortie chic', 1],

            // Accessoires téléphones
            ['Coque iPhone MagSafe', 'magsafe-case.jpg', 'Compatible MagSafe, résistante aux chocs', 2],
            ['Support téléphone voiture', 'smartphone-holder.jpg', 'Fixation magnétique et rotation 360°', 2],
            ['Chargeur sans fil Anker', 'anker-charger.jpg', 'Recharge rapide et design épuré', 2],

            // Montres & Bijoux
            ['Montre Casio G-Shock', 'gshock-watch.jpg', 'Résistante aux chocs et étanche', 3],
            ['Bracelet Pandora', 'pandora-bracelet.jpg', 'Personnalisable avec des charms', 3],
            ['Montre connectée Samsung', 'samsung-watch.jpg', 'Suivi santé et notifications', 3],

            // Décoration maison
            ['Lampe LED d’ambiance', 'mood-lampe.jpg', 'Change de couleur via télécommande', 4],
            ['Cadre photo bois', 'wooden-frame.jpg', 'Minimaliste et chaleureux', 4],
            ['Horloge murale vintage', 'vintage-clock.jpg', 'Style rétro pour le salon', 4],

            // Électronique
            ['Enceinte Bluetooth JBL', 'jbl-speaker.jpg', 'Son puissant et compact', 5],
            ['Écouteurs Xiaomi Redmi Buds', 'xiaomi-buds.jpg', 'Excellente autonomie à petit prix', 5],
            ['Clé USB 128 Go SanDisk', 'sandisk-usb.jpg', 'Rapide et fiable pour vos fichiers', 5],

            // Gaming
            ['Manette Xbox Series', 'xbox-controller.jpg', 'Ergonomique et sans fil', 6],
            ['Tapis de souris RGB', 'rgb-mousepad.jpg', 'Antidérapant avec effets lumineux', 6],
            ['Clavier mécanique Redragon', 'redragonkeyboard.jpg', 'Switchs rouges silencieux', 6],

            // Sport & Fitness
            ['Tapis de yoga antidérapant', 'nonslide-yoga.jpg', 'Confortable et durable', 7],
            ['Chaussures Nike Air Zoom', 'nike-sneaker.jpg', 'Confortables et légères pour le sport', 7],
            ['Haltères ajustables 20kg', 'adjustable-dumbell.jpg', 'Modulables pour chaque entraînement', 7],

            // Beauté
            ['Palette Fenty Beauty', 'fenty-makeup.jpg', 'Couleurs pigmentées pour les yeux', 8],
            ['Sèche-cheveux Dyson', 'dyson-hairdryer.jpg', 'Technologie sans lame puissante', 8],
            ['Brosse nettoyante visage', 'facecleaning-brush.jpg', 'Élimine impuretés et excès de sébum', 8],

            // Mode Homme
            ['Chemise en lin Zara', 'zara-shirt.jpg', 'Légère et idéale pour l’été', 9],
            ['Jean Levis 501', 'levis-jean.jpg', 'Indémodable et robuste', 9],
            ['Blouson cuir Schott', 'black-jacket.jpg', 'Authentique style biker', 9],

            // Mode Femme
            ['Robe longue fleurie H&M', 'hm-dress.jpg', 'Élégante pour les beaux jours', 10],
            ['Pantalon palazzo Mango', 'palazzo-mango.jpg', 'Fluide et confortable', 10],
            ['Manteau oversized Uniqlo', 'uniqlo-coat.jpg', 'Style cocooning tendance', 10],

            // Enfants & Bébé
            ['Peluche géante panda', 'panda-plush.jpg', 'Doux compagnon pour enfant', 11],
            ['Tapis d’éveil musical', 'play-mat.jpg', 'Stimulation sensorielle pour bébé', 11],
            ['Vêtements bébé bio', 'baby-cloth.jpg', 'Coton doux pour peau sensible', 11],

            // Bureau & Papeterie
            ['Agenda 2025 Moleskine', 'moleskine-agenda.jpg', 'Compact et élégant', 12],
            ['Stylo plume LAMY', 'fountain-pen.jpg', 'Écriture fluide et design allemand', 12],
            ['Organiseur de bureau bambou', 'desk-organizer.jpg', 'Rangement pratique et naturel', 12],
        ];

        $colorIds = range(1, 16);
        $materialIds = range(1, 20);
        $promoIndices = array_rand($products, (int) floor(count($products) / 4));

        foreach ($products as $index => [$name, $img, $desc, $categoryId]) {
            $price = rand(10, 200);
            $promo = in_array($index, (array) $promoIndices, true) ? rand(5, 30) : 0;
            $category = $categoryRepo->find($categoryId);

            $product = new Product(
                $index + 1,
                $name,
                $img,
                $desc,
                $price,
                $promo,
                $category
            );

            // Couleurs aléatoires (1 à 3)
            shuffle($colorIds);
            foreach (array_slice($colorIds, 0, rand(1, 3)) as $colorId) {
                $product->addColor($colorRepo->find($colorId));
            }

            // Matériaux aléatoires (1 à 3)
            shuffle($materialIds);
            foreach (array_slice($materialIds, 0, rand(1, 3)) as $matId) {
                $product->addMaterial($materialRepo->find($matId));
            }

            $productRepo->save($product);
        }

        echo "✅ Produits insérés avec succès.\n";
    }
}
