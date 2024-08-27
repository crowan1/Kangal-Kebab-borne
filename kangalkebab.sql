-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 27 août 2024 à 22:27
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `kangalkebab`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Kebabs'),
(2, 'Boissons'),
(3, 'Accompagnements'),
(4, 'Sandwich'),
(5, 'Durum'),
(6, 'Menu sandwich'),
(7, 'Menu durum'),
(8, 'Barquette'),
(9, 'Assiette');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delivery_time` datetime DEFAULT NULL,
  `additional_info` text,
  `status` varchar(50) DEFAULT 'new',
  `delivery_day` datetime DEFAULT CURRENT_TIMESTAMP,
  `modeService` varchar(50) NOT NULL,
  `getCommande` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sauces` text,
  `crudites` text,
  `supplements` text,
  `boisson` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `priceBorne` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT '1',
  `description` varchar(250) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `priceBorne`, `category_id`, `stock`, `description`, `image`, `points`) VALUES
(1, 'Kebab', '6.00', '6.00', 4, 1, 'Un délicieux sandwich avec de fines tranches de viande de kebab, marinées et grillées à la perfection. Servi avec deux sauces au choix et des garnitures fraîches de salade, tomate, et oignon.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(2, 'Maxi Kebab', '6.00', '6.00', 4, 1, 'Une version plus généreuse du kebab classique, avec une double portion de viande pour les gros appétits. Toujours accompagné de deux sauces au choix et des mêmes garnitures fraîches.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(3, 'Mini Kebab', '6.00', '6.00', 4, 1, 'Une version réduite du kebab, parfaite pour une petite faim. Servi avec deux sauces au choix et les garnitures classiques de salade, tomate, et oignon.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(4, 'Poulet', '6.00', '6.00', 4, 1, 'Du poulet mariné et grillé, tendre et savoureux, servi dans un pain rond avec deux sauces au choix et des garnitures croquantes de salade, tomate, et oignon.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(5, 'Köfte', '6.00', '6.00', 4, 1, 'Des boulettes de viande hachée épicée, grillées à la perfection. Servies avec deux sauces au choix et les garnitures classiques de salade, tomate, et oignon. Une spécialité turque qui ne manquera pas de vous séduire.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(6, 'Adana', '6.00', '6.00', 4, 1, 'Une brochette de viande hachée épicée, originaire de la région d\'Adana en Turquie. Le tout servi dans un pain rond avec deux sauces au choix, salade, tomate, et oignon pour un goût intense et savoureux.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(7, 'Hamburger', '6.00', '6.00', 4, 1, 'Un classique avec un steak de bœuf juteux, cuit à la perfection, accompagné de deux sauces au choix et de garnitures fraîches.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(8, 'Cheeseburger', '6.00', '6.00', 4, 1, 'Comme le hamburger, mais avec une tranche de fromage fondant ajoutée sur le steak, pour un goût encore plus gourmand. Servi avec deux sauces au choix et des garnitures fraîches.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(9, 'Double Cheeseburger', '6.00', '6.00', 4, 1, 'Une version encore plus généreuse du cheeseburger, avec deux steaks de bœuf et deux tranches de fromage, le tout accompagné de deux sauces au choix, salade, tomate, et oignon.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(10, 'Escalope Pané', '6.00', '6.00', 4, 1, 'Une escalope de poulet panée, croustillante à l\'extérieur et tendre à l\'intérieur. Servie avec deux sauces au choix et des garnitures de salade, tomate, et oignon.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(11, 'Sucuk', '6.00', '6.00', 4, 1, 'Du sucuk, une saucisse turque épicée et savoureuse, grillée et servie dans un pain rond avec deux sauces au choix et des garnitures croquantes.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(12, 'Poisson Pané', '6.00', '6.00', 4, 1, 'Un filet de poisson pané, croustillant à l\'extérieur et moelleux à l\'intérieur. Servi avec deux sauces au choix et des garnitures fraîches pour un repas léger et délicieux.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(13, 'Feta', '6.00', '6.00', 4, 1, 'Un sandwich végétarien avec des morceaux de feta crémeuse, accompagnés de deux sauces au choix, salade, tomate, et oignon pour un goût frais et savoureux.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(14, 'Vegan', '6.00', '6.00', 4, 1, 'Une option 100% végétalienne avec une garniture de légumes grillés ou un steak végétal. Servi avec deux sauces au choix et des garnitures de salade, tomate, et oignon.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(15, 'Belge', '6.00', '6.00', 4, 1, 'Un sandwich unique avec des frites croustillantes directement ajoutées dans le pain, accompagné de deux sauces au choix, salade, tomate, oignon, pour une touche belge irrésistible.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(16, 'Durum Kebab', '6.00', '6.00', 5, 1, 'Des tranches de viande de kebab marinée et grillée, enroulées dans un pain lavash avec deux sauces au choix et des garnitures de salade, tomate, et oignon.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(17, 'Durum Poulet', '6.00', '6.00', 5, 1, 'Du poulet mariné et grillé, enroulé dans un pain lavash fin et savoureux, accompagné de deux sauces au choix, salade, tomate, et oignon.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(18, 'Durum Köfte', '6.00', '6.00', 5, 1, 'Des boulettes de viande hachée épicée, grillées à la perfection, enroulées dans un pain lavash avec deux sauces au choix et des garnitures de salade, tomate, et oignon.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(19, 'Menu Kebab', '6.00', '6.00', 6, 1, 'Un délicieux sandwich avec de fines tranches de viande de kebab, marinées et grillées à la perfection. Servi avec deux sauces au choix, des garnitures fraîches de salade, tomate, et oignon, accompagné de frites et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(20, 'Menu Maxi Kebab', '6.00', '6.00', 6, 1, 'Une version plus généreuse du kebab classique, avec une double portion de viande. Accompagné de deux sauces au choix, de garnitures fraîches, de frites, et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(21, 'Menu Mini Kebab', '6.00', '6.00', 6, 1, 'Une version réduite du kebab, parfaite pour une petite faim. Servi avec deux sauces au choix, des garnitures classiques de salade, tomate, et oignon, accompagné de frites et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(22, 'Menu Köfte', '6.00', '6.00', 6, 1, 'Des boulettes de viande hachée épicée, grillées à la perfection. Servies avec deux sauces au choix, des garnitures de salade, tomate, et oignon, accompagnées de frites et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(23, 'Menu Poulet', '6.00', '6.00', 6, 1, 'Du poulet mariné et grillé, en sandwich avec deux sauces au choix et des garnitures croquantes de salade, tomate, et oignon, accompagné de frites et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(24, 'Menu Adana', '6.00', '6.00', 6, 1, 'Une brochette de viande hachée épicée, en sandwich avec deux sauces au choix, salade, tomate, et oignon, accompagné de frites et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(25, 'Menu Hamburger', '6.00', '6.00', 6, 1, 'Un classique avec un steak de bœuf juteux, accompagné de deux sauces au choix, de garnitures fraîches, de frites, et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(26, 'Menu Cheeseburger', '6.00', '6.00', 6, 1, 'Comme le hamburger, avec une tranche de fromage fondant. Servi avec deux sauces au choix, des garnitures fraîches, des frites, et une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(27, 'Menu Double Cheeseburger', '6.00', '6.00', 6, 1, 'Une version plus généreuse avec deux steaks de bœuf et deux tranches de fromage, accompagné de deux sauces au choix, de frites, et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(28, 'Menu Escalope Panée', '6.00', '6.00', 6, 1, 'Une escalope de poulet panée, croustillante à l\'extérieur et tendre à l\'intérieur, accompagnée de deux sauces au choix, de garnitures de salade, tomate, et oignon, de frites, et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(29, 'Menu Sucuk', '6.00', '6.00', 6, 1, 'Du sucuk, une saucisse turque épicée et savoureuse, grillée et servie avec deux sauces au choix, des garnitures croquantes, des frites, et une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(30, 'Menu Poisson Pané', '6.00', '6.00', 6, 1, 'Un filet de poisson pané, croustillant à l\'extérieur et moelleux à l\'intérieur, accompagné de deux sauces au choix, de garnitures fraîches, de frites, et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(31, 'Menu Feta', '6.00', '6.00', 6, 1, 'Un sandwich végétarien avec des morceaux de feta crémeuse, accompagné de deux sauces au choix, de salade, tomate, et oignon, de frites, et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(32, 'Menu Vegan', '6.00', '6.00', 6, 1, 'Une option 100% végétalienne avec une garniture de légumes grillés ou un steak végétal, accompagnée de deux sauces au choix, de frites, et d\'une boisson de 33cl au choix.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 6),
(33, 'Assiette Kebab', '8.00', '8.00', 7, 1, 'Une généreuse portion de viande de kebab marinée et grillée, servie avec des crudités fraîches (salade, tomates, oignons). Accompagnée de deux sauces au choix et de bulgur ou de frites, pour un repas complet et savoureux.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(34, 'Assiette Poulet', '8.00', '8.00', 7, 1, 'Des morceaux de poulet marinés et grillés à la perfection, accompagnés de crudités classiques telles que salade, tomates, et oignons. Servie avec deux sauces au choix et de bulgur ou de frites pour un équilibre parfait de saveurs.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(35, 'Assiette Köfte', '8.00', '8.00', 7, 1, 'Des boulettes de viande hachée épicée et grillée, servies avec des crudités fraîches comme salade, tomates, et oignons. Accompagnée de deux sauces au choix et de bulgur ou de frites, offrant un goût authentique et généreux.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(36, 'Assiette Adana', '8.00', '8.00', 7, 1, 'Une brochette de viande hachée épicée grillée et savoureuse, originaire de la région d\'Adana en Turquie, servie avec des crudités (salade, tomates, oignons). Accompagnée de deux sauces au choix et de bulgur ou de frites, pour une explosion de saveurs', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(37, 'Assiette Mixte', '10.00', '10.00', 7, 1, 'Un assortiment de viandes grillées, incluant kebab, poulet et köfte, accompagné de crudités classiques telles que salade, tomates, et oignons. Servie avec deux sauces au choix et de bulgur ou de frites pour une expérience variée et complète.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(38, 'Assiette Escalope Panée', '8.00', '8.00', 7, 1, 'Une escalope de poulet panée, croustillante et tendre, accompagnée de crudités fraîches (salade, tomates, oignons). Servie avec deux sauces au choix et de bulgur ou de frites pour un repas rassasiant et délicieux.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(39, 'Assiette Poisson Pané', '8.00', '8.00', 7, 1, 'Un filet de poisson pané, croustillant à l\'extérieur et moelleux à l\'intérieur, servi avec des crudités comme salade, tomates, et oignons. Accompagnée de deux sauces au choix et de bulgur ou de frites pour une touche légère et savoureuse.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(40, 'Assiette Hamburger', '8.00', '8.00', 7, 1, 'Un steak de bœuf juteux, cuit à la perfection, servi avec des crudités fraîches (salade, tomates, oignons). Accompagné de deux sauces au choix et de bulgur ou de frites pour un classique réconfortant.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(41, 'Assiette Cheeseburger', '8.00', '8.00', 7, 1, 'Comme l\'assiette hamburger, mais avec une tranche de fromage fondant ajoutée sur le steak. Servie avec des crudités (salade, tomates, oignons), deux sauces au choix, et de bulgur ou de frites pour un goût encore plus gourmand.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(42, 'Assiette Sucuk', '8.00', '8.00', 7, 1, 'Une saucisse turque épicée, grillée et savoureuse, servie avec des crudités fraîches (salade, tomates, oignons). Accompagnée de deux sauces au choix et de bulgur ou de frites pour une expérience épicée et complète.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(43, 'Assiette Nuggets', '7.00', '7.00', 7, 1, 'Une portion de 7 nuggets de poulet croustillants, accompagnés de crudités classiques telles que salade, tomates, et oignons. Servie avec deux sauces au choix et de bulgur ou de frites pour un repas qui plaira aux petits et grands.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(44, 'Grandes Frites', '3.00', '3.00', 8, 1, 'Une grande portion de frites dorées et croustillantes, idéale pour les amateurs de frites ou pour partager. Parfaites en accompagnement de tout repas.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(45, 'Petite Frites', '2.00', '2.00', 8, 1, 'Une portion plus modeste de frites croustillantes, parfaite pour une petite faim ou en complément d\'un autre plat.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(46, 'Bulgur', '3.00', '3.00', 8, 1, 'Un plat de bulgur savoureux, cuit à la perfection et légèrement épicé, offrant une alternative saine et nutritive aux féculents classiques.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(47, 'Grandes Viandes', '7.00', '7.00', 8, 1, 'Une généreuse barquette de viande de kebab, marinée et grillée à la perfection. Cette portion est idéale pour les gros appétits ou pour être partagée, offrant une viande savoureuse et bien assaisonnée.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(48, 'Petite Viandes', '5.00', '5.00', 8, 1, 'Une barquette plus petite de viande de kebab, parfaite pour accompagner un autre plat ou pour une portion plus légère. La viande est marinée et grillée, offrant un goût délicieux et authentique.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(49, 'Nuggets', '4.00', '4.00', 8, 1, 'Une portion de 7 nuggets de poulet, croustillants à l\'extérieur et tendres à l\'intérieur, servis avec la sauce de votre choix. Parfait pour les petits et grands gourmands.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(50, 'Box Grandes', '10.00', '10.00', 9, 1, 'Une généreuse box remplie de viande de kebab marinée et grillée à la perfection, accompagnée de frites croustillantes. Le tout servi avec deux sauces au choix, parfait pour les gros appétits ou pour être partagée.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(51, 'Box Petite', '7.00', '7.00', 9, 1, 'Une version plus compacte de la box, avec une portion de viande de kebab savoureuse et des frites croustillantes. Accompagnée de deux sauces au choix, cette box est idéale pour une portion plus légère ou un petit repas rapide.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(52, 'Tiramisu Oréo', '4.00', '4.00', 9, 1, 'Un dessert italien classique revisité, avec une base crémeuse et onctueuse de mascarpone, surmontée de couches de biscuits imbibés, saveur Oréo, pour une touche chocolatée et croustillante.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(53, 'Tiramisu Speculos', '4.00', '4.00', 9, 1, 'Un dessert italien classique revisité, avec une base crémeuse et onctueuse de mascarpone, surmontée de couches de biscuits imbibés, saveur Speculos, pour un goût épicé et caramélisé.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(54, 'Baklava', '3.00', '3.00', 9, 1, 'Un dessert traditionnel oriental composé de fines couches de pâte filo, garnies de noix concassées et imbibées de sirop de miel. Chaque bouchée est un mélange parfait de douceur, de croquant et de saveurs riches et parfumées.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7),
(55, 'Kit Kat', '2.00', '2.00', 9, 1, 'Une portion de ce célèbre chocolat composé de fines couches de gaufrette croustillante enrobées de chocolat au lait. Parfait pour une petite pause sucrée ou pour combler une envie de chocolat.', 'https://media.istockphoto.com/id/1075374570/fr/vectoriel/à-venir.jpg?s=612x612&w=0&k=20&c=0jS1orhujDx7Il4v9vYpBkXYLIGPrOMKAnw_fykvl10=', 7);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code` varchar(10) NOT NULL,
  `Qrcode` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`, `code`, `Qrcode`) VALUES
(1, 'Muharrem', 'Ozipek', 'ozipek.mu@gmail.com', '$2y$10$HXLX9qTTGMeYbh.OOOdOfO1D8jQrhkm.fDRTgVhkA7hhSyGM4Sddq', '2024-08-18 22:08:11', 'y7MZI9P', ''),
(2, 'borne', 'borne', 'borne@gmail.com', '$2y$10$7tSLIswTCqvX/cmFmmWrxet54OfLdghq6bnHCI0/Qz2t0iRep3xkG', '2024-08-24 00:52:25', 'RzG58qG', '');

-- --------------------------------------------------------

--
-- Structure de la table `user_points`
--

CREATE TABLE `user_points` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `user_points`
--
ALTER TABLE `user_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user_points`
--
ALTER TABLE `user_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `user_points`
--
ALTER TABLE `user_points`
  ADD CONSTRAINT `user_points_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
