-- MySQL dump 10.13  Distrib 9.3.0, for Linux (x86_64)
--
-- Host: localhost    Database: shopcart_db
-- ------------------------------------------------------
-- Server version	9.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Sacs & Maroquinerie'),(2,'Accessoires téléphones'),(3,'Montres & Bijoux'),(4,'Décoration maison'),(5,'Électronique'),(6,'Gaming'),(7,'Sport & Fitness'),(8,'Beauté'),(9,'Mode Homme'),(10,'Mode Femme'),(11,'Enfants & Bébé'),(12,'Bureau & Papeterie');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `color`
--

DROP TABLE IF EXISTS `color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `color` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color`
--

LOCK TABLES `color` WRITE;
/*!40000 ALTER TABLE `color` DISABLE KEYS */;
INSERT INTO `color` VALUES (1,'Rouge'),(2,'Bleu'),(3,'Vert'),(4,'Jaune'),(5,'Noir'),(6,'Blanc'),(7,'Gris'),(8,'Orange'),(9,'Rose'),(10,'Violet'),(11,'Turquoise'),(12,'#FF5733'),(13,'#3498DB'),(14,'#2ECC71'),(15,'#F1C40F'),(16,'#8E44AD');
/*!40000 ALTER TABLE `color` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `material` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material`
--

LOCK TABLES `material` WRITE;
/*!40000 ALTER TABLE `material` DISABLE KEYS */;
INSERT INTO `material` VALUES (1,'Coton'),(2,'Cuir'),(3,'Métal'),(4,'Plastique'),(5,'Bois'),(6,'Verre'),(7,'Acier inoxydable'),(8,'Aluminium'),(9,'Silicone'),(10,'Polycarbonate'),(11,'Céramique'),(12,'Fibre de carbone'),(13,'Néoprène'),(14,'Caoutchouc'),(15,'Liège'),(16,'Chanvre'),(17,'Lin'),(18,'Nylon'),(19,'Laine'),(20,'Mousse à mémoire de forme');
/*!40000 ALTER TABLE `material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `promotion_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Sac à dos Herschel','hershel-backpack.jpg','Un sac classique pour un usage quotidien',68.00,0.00,1),(2,'Porte-monnaie Fossil','fossil-wallet.jpg','Compact et élégant, idéal pour les poches',132.00,18.00,1),(3,'Sac bandoulière Michael Kors','kors-handbag.jpg','Parfait pour une sortie chic',57.00,0.00,1),(4,'Coque iPhone MagSafe','magsafe-case.jpg','Compatible MagSafe, résistante aux chocs',192.00,0.00,2),(5,'Support téléphone voiture','smartphone-holder.jpg','Fixation magnétique et rotation 360°',28.00,0.00,2),(6,'Chargeur sans fil Anker','anker-charger.jpg','Recharge rapide et design épuré',75.00,0.00,2),(7,'Montre Casio G-Shock','gshock-watch.jpg','Résistante aux chocs et étanche',112.00,0.00,3),(8,'Bracelet Pandora','pandora-bracelet.jpg','Personnalisable avec des charms',13.00,0.00,3),(9,'Montre connectée Samsung','samsung-watch.jpg','Suivi santé et notifications',159.00,0.00,3),(10,'Lampe LED d’ambiance','mood-lampe.jpg','Change de couleur via télécommande',88.00,0.00,4),(11,'Cadre photo bois','wooden-frame.jpg','Minimaliste et chaleureux',48.00,0.00,4),(12,'Horloge murale vintage','vintage-clock.jpg','Style rétro pour le salon',199.00,16.00,4),(13,'Enceinte Bluetooth JBL','jbl-speaker.jpg','Son puissant et compact',60.00,0.00,5),(14,'Écouteurs Xiaomi Redmi Buds','xiaomi-buds.jpg','Excellente autonomie à petit prix',153.00,0.00,5),(15,'Clé USB 128 Go SanDisk','sandisk-usb.jpg','Rapide et fiable pour vos fichiers',58.00,0.00,5),(16,'Manette Xbox Series','xbox-controller.jpg','Ergonomique et sans fil',170.00,19.00,6),(17,'Tapis de souris RGB','rgb-mousepad.jpg','Antidérapant avec effets lumineux',103.00,0.00,6),(18,'Clavier mécanique Redragon','redragonkeyboard.jpg','Switchs rouges silencieux',21.00,0.00,6),(19,'Tapis de yoga antidérapant','nonslide-yoga.jpg','Confortable et durable',158.00,0.00,7),(20,'Chaussures Nike Air Zoom','nike-sneaker.jpg','Confortables et légères pour le sport',119.00,0.00,7),(21,'Haltères ajustables 20kg','adjustable-dumbell.jpg','Modulables pour chaque entraînement',27.00,0.00,7),(22,'Palette Fenty Beauty','fenty-makeup.jpg','Couleurs pigmentées pour les yeux',112.00,23.00,8),(23,'Sèche-cheveux Dyson','dyson-hairdryer.jpg','Technologie sans lame puissante',200.00,8.00,8),(24,'Brosse nettoyante visage','facecleaning-brush.jpg','Élimine impuretés et excès de sébum',166.00,0.00,8),(25,'Chemise en lin Zara','zara-shirt.jpg','Légère et idéale pour l’été',200.00,0.00,9),(26,'Jean Levis 501','levis-jean.jpg','Indémodable et robuste',195.00,0.00,9),(27,'Blouson cuir Schott','black-jacket.jpg','Authentique style biker',53.00,6.00,9),(28,'Robe longue fleurie H&M','hm-dress.jpg','Élégante pour les beaux jours',149.00,22.00,10),(29,'Pantalon palazzo Mango','palazzo-mango.jpg','Fluide et confortable',200.00,0.00,10),(30,'Manteau oversized Uniqlo','uniqlo-coat.jpg','Style cocooning tendance',56.00,0.00,10),(31,'Peluche géante panda','panda-plush.jpg','Doux compagnon pour enfant',73.00,13.00,11),(32,'Tapis d’éveil musical','play-mat.jpg','Stimulation sensorielle pour bébé',37.00,0.00,11),(33,'Vêtements bébé bio','baby-cloth.jpg','Coton doux pour peau sensible',15.00,0.00,11),(34,'Agenda 2025 Moleskine','moleskine-agenda.jpg','Compact et élégant',95.00,0.00,12),(35,'Stylo plume LAMY','fountain-pen.jpg','Écriture fluide et design allemand',27.00,0.00,12),(36,'Organiseur de bureau bambou','desk-organizer.jpg','Rangement pratique et naturel',113.00,11.00,12);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_color`
--

DROP TABLE IF EXISTS `product_color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_color` (
  `product_id` int NOT NULL,
  `color_id` int NOT NULL,
  PRIMARY KEY (`product_id`,`color_id`),
  KEY `color_id` (`color_id`),
  CONSTRAINT `product_color_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_color_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_color`
--

LOCK TABLES `product_color` WRITE;
/*!40000 ALTER TABLE `product_color` DISABLE KEYS */;
INSERT INTO `product_color` VALUES (8,1),(9,1),(16,1),(33,1),(2,2),(14,2),(15,2),(23,2),(36,2),(2,3),(5,3),(12,3),(14,3),(28,3),(7,4),(28,4),(35,4),(3,5),(5,5),(13,5),(20,5),(21,5),(26,5),(32,5),(34,5),(36,5),(1,6),(4,6),(16,6),(36,6),(15,7),(21,7),(12,8),(16,8),(22,8),(34,8),(11,9),(1,10),(3,10),(7,10),(13,10),(31,10),(2,11),(4,11),(17,11),(26,11),(6,12),(11,12),(24,12),(8,13),(12,13),(18,13),(21,13),(3,14),(4,14),(14,14),(15,14),(18,14),(30,14),(33,14),(7,15),(10,15),(19,15),(25,15),(27,15),(35,15),(6,16),(29,16);
/*!40000 ALTER TABLE `product_color` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_material`
--

DROP TABLE IF EXISTS `product_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_material` (
  `product_id` int NOT NULL,
  `material_id` int NOT NULL,
  PRIMARY KEY (`product_id`,`material_id`),
  KEY `material_id` (`material_id`),
  CONSTRAINT `product_material_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_material_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `material` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_material`
--

LOCK TABLES `product_material` WRITE;
/*!40000 ALTER TABLE `product_material` DISABLE KEYS */;
INSERT INTO `product_material` VALUES (10,1),(21,1),(7,2),(9,2),(28,2),(30,2),(31,2),(4,3),(21,3),(32,3),(2,4),(6,4),(13,4),(22,4),(29,4),(33,4),(7,5),(25,5),(6,6),(15,6),(11,7),(17,7),(19,7),(22,7),(35,7),(36,7),(4,8),(5,8),(6,8),(10,8),(28,8),(2,9),(8,9),(14,9),(28,9),(1,10),(4,10),(15,10),(31,10),(34,10),(35,10),(27,11),(35,11),(10,12),(18,12),(20,12),(17,13),(17,14),(26,14),(22,15),(26,15),(34,15),(1,16),(5,16),(21,16),(32,16),(5,17),(15,17),(16,17),(26,17),(2,18),(3,18),(8,18),(23,18),(24,18),(25,18),(27,18),(30,18),(9,19),(20,19),(12,20);
/*!40000 ALTER TABLE `product_material` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-11  2:52:55
