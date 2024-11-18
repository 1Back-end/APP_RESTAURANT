-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 18 nov. 2024 à 17:51
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `app_restaurant`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_users`
--

CREATE TABLE `admin_users` (
  `admin_uuid` char(36) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_users`
--

INSERT INTO `admin_users` (`admin_uuid`, `username`, `email`, `password`, `photo`, `created_at`, `is_deleted`, `address`, `phone_number`, `is_active`, `deleted_at`, `remember_token`) VALUES
('63d7-e242-72e2-4453-a2b5', 'Dev', 'Dev@gmail.com', '$2y$10$uIPsvkSVtnXElK9UByNx5OkQqMlD11olsyAkQcCXWBME/95/fSEwi', NULL, '2024-11-11 10:06:31', 0, 'Yaoundé,Cameroun', '+237 689001256', 0, NULL, NULL),
('cc1b0dae-9116-11ef-b2d9-24418c1325d5', 'Makaya Dev', 'laurentalphonsewilfried@gmail.com', '$2y$10$zUvcvNypwURV27QNYxcoke2f7IWNQld.D7mUOSFf1ieaaa7W9flcS', 'Photolab-376666105.jpeg', '2024-10-23 08:14:12', 0, '4567 Rue de l\'Exempl', '+237 6 12 34 56 78', 1, NULL, '267a13511916fec6602b29d6e851f81e'),
('f2e8-03d3-5811-4177-87f3', 'Dev', 'Dev123456677@gmail.com', '$2y$10$.1E9X01/uAo5qxaXQAlKPeFSo7YFELdugDL9N7RDEy4jhB49YuQfi', NULL, '2024-11-11 10:11:36', 1, 'Yaoundé,Cameroun', '+237 689001256', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `cancel_order`
--

CREATE TABLE `cancel_order` (
  `cancel_uuid` varchar(36) NOT NULL,
  `order_uuid` varchar(36) DEFAULT NULL,
  `cancellation_reason` varchar(255) DEFAULT NULL,
  `added_by` varchar(36) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cancel_order`
--

INSERT INTO `cancel_order` (`cancel_uuid`, `order_uuid`, `cancellation_reason`, `added_by`, `created_at`) VALUES
('d5b1-3e29-3271-4b31-9fca', '872b222e5ede886f848082526245d519', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat, perspiciatis nulla? Ullam incidunt id, unde veniam modi vitae vel minima libero perspiciatis vero sed distinctio quasi molestiae nobis! Pariatur, natus.', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', '2024-11-10 21:17:28'),
('e7d9-5da1-9257-41f4-91f6', '001c3ae7b553ba8800e6c0e09f9279f7', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Suscipit tempore quasi unde ipsa eius maxime odio accusamus et illum blanditiis, accusantium minus facilis dolor dolorum quis cum dolorem! Voluptates, doloremque.', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', '2024-11-18 10:52:39');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `uuid` char(36) NOT NULL,
  `commentaire` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`uuid`, `commentaire`, `created_at`, `updated_at`, `is_deleted`) VALUES
('07a5cec34d209afab0595d2009108b53', '\r\nLorem ipsum dolor sit, amet consectetur adipisicing elit. Exercitationem quae accusantium veritatis maiores tempore neque iure necessitatibus hic quisquam dolores est fugiat ut a, vitae cupiditate repellendus eos quibusdam soluta.', '2024-11-18 16:37:22', '2024-11-18 16:37:22', 0),
('3aab81ed8d9116c47ab718f683e5bcbc', '\nLorem ipsum dolor sit, amet consectetur adipisicing elit. Exercitationem quae accusantium veritatis maiores tempore neque iure necessitatibus hic quisquam dolores est fugiat ut a, vitae cupiditate repellendus eos quibusdam soluta.', '2024-11-18 16:34:08', '2024-11-18 16:34:31', 0),
('4a36a51ee7fa0d1270692abecf262e21', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore omnis temporibus atque quasi natus, corporis explicabo cumque qui sapiente numquam rerum voluptates vitae id at soluta ab tempora a unde.', '2024-11-18 16:40:33', '2024-11-18 16:40:33', 0),
('4e7d26a14066a1424b37f5fb1d64c822', '                        \nLorem ipsum dolor sit, amet consectetur adipisicing elit. Exercitationem quae accusantium veritatis maiores tempore neque iure necessitatibus hic quisquam dolores est fugiat ut a, vitae cupiditate repellendus eos quibusdam soluta.', '2024-11-18 16:33:38', '2024-11-18 16:34:35', 0);

-- --------------------------------------------------------

--
-- Structure de la table `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `order_uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `agent_uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `delivery_time` timestamp NULL DEFAULT current_timestamp(),
  `delivery_status` enum('pending','Canceled','Delivered','in_progress','paid') NOT NULL DEFAULT 'pending',
  `is_deleted` tinyint(1) DEFAULT 0,
  `added_by` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `deliveries`
--

INSERT INTO `deliveries` (`delivery_uuid`, `order_uuid`, `agent_uuid`, `delivery_time`, `delivery_status`, `is_deleted`, `added_by`) VALUES
('0e4d5383d473f67fe1e13c5dc8f642de', '03a5de6e1fbccb1f75bec004a4c71551', '1252-0c62-259e-403e-ac17', '2024-11-13 15:59:29', 'pending', 0, NULL),
('1a090504010bc2ee7a517895110f9003', '65e536b6ecd6a86dd28acbbe09e3c1d3', 'dfe7-da59-7a0f-4fa8-9a9a', '2024-11-15 16:03:52', 'pending', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('d1d784357a39fdf3b79ba3fbb444e5fe', '81e706eebf441aed4ff353feba64ce70', '3775-ef67-1001-4032-b90c', '2024-11-15 16:01:43', 'pending', 0, NULL),
('e4aca4380f3e4c8440549c8570019306', '10f07dfaf1411b55ca1728ce9b2622c0', 'e81f-b513-4b1f-431b-9c04', '2024-11-18 13:45:10', 'pending', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5');

-- --------------------------------------------------------

--
-- Structure de la table `delivery_agents`
--

CREATE TABLE `delivery_agents` (
  `agent_uuid` char(36) NOT NULL,
  `agent_code` varchar(10) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `alt_phone` varchar(20) DEFAULT NULL,
  `cni_number` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `availability_schedule` varchar(20) DEFAULT '24h/24',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `added_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `delivery_agents`
--

INSERT INTO `delivery_agents` (`agent_uuid`, `agent_code`, `firstname`, `lastname`, `email`, `phone`, `alt_phone`, `cni_number`, `photo`, `available`, `availability_schedule`, `created_at`, `is_deleted`, `added_by`) VALUES
('1252-0c62-259e-403e-ac17', 'LIV202495', 'Dev', 'Laurent ', 'laurentdev@gmail.com', '+237650654321', NULL, 'CNI123456712', NULL, 1, '8h/24', '2024-11-02 20:09:37', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('3775-ef67-1001-4032-b90c', 'LIV202412', 'Claire', 'Marie', 'marie.claire@example.com', '+237650654321', NULL, 'CNI987654321', '277753625_286541043653132_6647136332779368253_n.jpg', 0, '24h/24', '2024-10-25 09:34:19', 1, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('4a42-42c6-140c-4a32-b0ca', 'LIV202485', 'Durand', 'Sophie', 'sophie.durand@example.com', '+237650456789', NULL, 'CNI345678901', NULL, 1, '4h/24', '2024-10-25 11:48:16', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('a34e-8f24-dd39-4132-aca9', 'LIV202496', 'Ab quo ', 'Exercitreicien', 'wykit@mailinator.com', '+1 (575) 349-4922', NULL, 'CNI456789000', NULL, 1, '12h/24', '2024-11-16 19:33:44', 1, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('dfe7-da59-7a0f-4fa8-9a9a', 'LIV202481', 'Dev', 'Dev', 'dev@gmail.com', '+237650654321', NULL, 'CNI123456723', NULL, 0, '24h/24', '2024-11-11 08:46:19', 1, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('e81f-b513-4b1f-431b-9c04', 'LIV202402', 'Fernando', 'Mvondo', 'sewovemum@mailinator.com', '+1 (965) 428-9983', NULL, 'CNI123456787', '../uploads/673a638c6d56b-Photolab-730455886.jpeg', 0, '24h/24', '2024-11-17 21:43:40', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('e8b8-8e57-af80-4202-9605', 'LIV202417', 'Dolore ', 'conseq', 'ligen@mailinator.com', '+1 (926) 689-4193', NULL, 'CNI123456799', '../uploads/6738f65b0e52e-Photolab-376666105.jpeg', 1, '2h/24', '2024-11-16 19:45:31', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5');

-- --------------------------------------------------------

--
-- Structure de la table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `uuid` char(36) NOT NULL,
  `admin_uuid` char(36) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL,
  `status` enum('pending','used') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `forgot_password`
--

INSERT INTO `forgot_password` (`uuid`, `admin_uuid`, `token`, `created_at`, `expires_at`, `status`) VALUES
('43e9371e-a588-11ef-a914-24418c1325d5', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', '6523', '2024-11-18 09:36:54', '2024-11-18 10:21:24', 'used');

-- --------------------------------------------------------

--
-- Structure de la table `meals`
--

CREATE TABLE `meals` (
  `meal_uuid` char(36) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `added_at` date DEFAULT NULL,
  `category_uuid` char(36) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `added_by` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `meals`
--

INSERT INTO `meals` (`meal_uuid`, `name`, `description`, `price`, `image`, `available`, `added_at`, `category_uuid`, `created_at`, `added_by`, `is_deleted`) VALUES
('0361-8adc-e01c-479f-987c', 'Salade César', 'Salade avec poulet grillé, parmesan, croûtons et sauce César.', 7500, '67190771cd8ca.png,67190771cdbd4.jpg,67190771cdf7d.jpg,67190771ce38e.jpg', 1, '2024-10-23', '305d-ede6-5a3a-49c6-97dc', '2024-10-23 14:25:53', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('1007-ab1f-fe4a-4877-a76a', 'Lobster Bisque', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores veniam, consequatur assumenda illum vitae, fugit magnam fugiat unde officiis tempora cumque, blanditiis sapiente nam iste amet delectus voluptas atque omnis.', 5000, '671baffd82322.jpg,671baffd828cc.jpg,671baffd82b49.jpg,671baffd82dd6.jpg', 1, '2024-10-26', '42df-f4bc-2b58-4c5c-98da', '2024-10-25 14:49:33', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('140f-1f99-72e4-49a7-81ca', 'Bread Barrel', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores veniam, consequatur assumenda illum vitae, fugit magnam fugiat unde officiis tempora cumque, blanditiis sapiente nam iste amet delectus voluptas atque omnis.', 25000, '671bb0aca309b.jpg,671bb0aca342b.jpg,671bb0aca373a.jpg,671bb0aca39ba.jpg', 1, '2024-10-26', 'ceb2-df92-2aaa-4685-b7d1', '2024-10-25 14:52:28', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('3752-c9c9-4505-4df6-800e', 'Lobster Roll', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores veniam, consequatur assumenda illum vitae, fugit magnam fugiat unde officiis tempora cumque, blanditiis sapiente nam iste amet delectus voluptas atque omnis.', 10000, '671bb1c885abd.jpg,671bb1c885e41.jpg,671bb1c8861c8.jpg,671bb1c886533.jpg', 1, '2024-11-08', 'ceb2-df92-2aaa-4685-b7d1', '2024-10-25 14:57:12', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('5ac2-4125-ff6b-4d97-9c46', 'Dolorem et aut amet', 'Ipsa nihil reprehen', 6500, '67388e4940eef.jpg,67388e4941438.jpg,67388e494199c.jpg,67388e4941eca.jpg', 1, '2002-07-11', 'b00d-1a1f-8197-493a-bbaa', '2024-11-16 12:21:29', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('5e45-6bed-969e-44dd-9548', 'Canette', 'Une canette de cola pétillant et rafraîchissant.', 1500, '671914c5369f1.jpg,671914c536c4c.jpg,671914c536f1a.jpg,671914c53727e.jpg', 1, '2024-10-24', 'c4f6-fdda-d80f-4d3c-b83e', '2024-10-23 15:22:45', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('7916-4d07-1d8b-4872-9dd7', 'Soupe de légumes', 'Soupe chaude avec un mélange de légumes frais', 2500, '67210c7d25ddd.jpg,67210c7d2616b.jpg,67210c7d26465.jpg,67210c7d2675f.jpg', 0, '2024-10-29', '42df-f4bc-2b58-4c5c-98da', '2024-10-29 16:25:33', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 1),
('7ba2-c0e9-17ad-46a6-a288', 'Pâtes Carbonara', 'Pâtes à la sauce crémeuse au bacon et au parmesan.', 8500, '671a23a0794b2.jpg,671a23a079a8a.jpg,671a23a079db5.jpg,671a23a07a034.jpg', 1, '2024-10-25', 'ceb2-df92-2aaa-4685-b7d1', '2024-10-24 10:38:24', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('7f99-007c-9ef4-4e21-9d13', 'Spaghetti Bolognaise', 'Spaghetti avec une sauce bolognaise maison et du parmesan', 1500, '67210bd406771.jpg,67210bd406a0f.jpg,67210bd406e02.jpg,67210bd407066.jpg', 0, '2024-10-31', 'ceb2-df92-2aaa-4685-b7d1', '2024-10-29 16:22:44', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('a04b-cf3b-aa3d-4f54-9618', 'Humberger', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis reprehenderit autem iure, quidem vero incidunt dolorum excepturi commodi architecto repellendus iste velit obcaecati debitis eos, corrupti nesciunt repellat, ea temporibus?', 25000, '671913ec21f3e.jpg,671913ec2218e.jpg,671913ec22513.jpg,671913ec227f1.jpg', 1, '2024-10-14', '305d-ede6-5a3a-49c6-97dc', '2024-10-23 15:19:08', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('a0e7-1171-1bb9-4d60-b048', 'Pizza Margherita', 'Pizza avec sauce tomate, mozzarella et basilic frais.', 12000, '67190a62923b5.jpg,67190a6292619.jpg,67190a62928d8.jpg,67190a6292b56.jpg', 0, '2024-10-14', '305d-ede6-5a3a-49c6-97dc', '2024-10-23 14:38:26', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('bf65-a2b2-f10a-4818-b659', 'Caesar Selections', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores veniam, consequatur assumenda illum vitae, fugit magnam fugiat unde officiis tempora cumque, blanditiis sapiente nam iste amet delectus voluptas atque omnis.', 8500, '671bb176b8d5b.jpg,671bb176b9037.jpg,671bb176b92d6.jpg,671bb176b9565.jpg', 1, '2024-11-09', '42df-f4bc-2b58-4c5c-98da', '2024-10-25 14:55:50', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('e8e0-4346-5aec-4a56-bd0a', 'Poulet rôti', 'Poulet rôti avec des légumes de saison', 15000, '67210b1055cce.jpg,67210b1055f6f.jpg,67210b1056249.jpeg,67210b10564fe.jpg', 1, '2024-10-30', 'ceb2-df92-2aaa-4685-b7d1', '2024-10-29 16:19:28', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0);

-- --------------------------------------------------------

--
-- Structure de la table `meal_categories`
--

CREATE TABLE `meal_categories` (
  `category_uuid` char(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `added_by` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `meal_categories`
--

INSERT INTO `meal_categories` (`category_uuid`, `name`, `description`, `added_by`, `is_deleted`, `created_at`) VALUES
('305d-ede6-5a3a-49c6-97dc', 'Desserts', 'Description par défaut pour la catégorie.', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0, '2024-10-23 11:13:28'),
('42df-f4bc-2b58-4c5c-98da', 'Entrées', 'Description par défaut pour la catégorie.', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0, '2024-10-23 13:35:50'),
('6460-8fa0-bbcf-42d1-8e77', 'Végétarien', 'Repas sans produits d&#039;origine animale', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0, '2024-10-24 10:33:45'),
('78f6-9b9b-5321-41b9-8c4e', 'Entrées', 'Description par défaut pour la catégorie.', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 1, '2024-10-23 11:17:20'),
('b00d-1a1f-8197-493a-bbaa', 'Grillades', 'Plats cuits au grill pour un goût fumé', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0, '2024-10-24 10:32:05'),
('bb35-4296-0bd3-4ebc-b241', 'Boissons', 'Description par défaut pour la catégorie.', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 1, '2024-10-23 11:17:04'),
('c4f6-fdda-d80f-4d3c-b83e', 'Boissons', 'Description par défaut pour la catégorie.', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0, '2024-10-23 13:34:48'),
('ceb2-df92-2aaa-4685-b7d1', 'Plat principal', 'Les plats principaux de votre choix', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0, '2024-10-24 10:35:29');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE `menus` (
  `menu_uuid` char(36) NOT NULL,
  `menu_label` varchar(255) NOT NULL,
  `menu_link` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`menu_uuid`, `menu_label`, `menu_link`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
('6723577fb74e83.03535269', 'Services', 'services.php', 3, 1, '2024-10-31 10:10:07', '2024-10-31 10:10:07'),
('672357e345a974.50162355', 'Blog', 'blog.php', 2, 1, '2024-10-31 10:11:47', '2024-10-31 10:11:47'),
('67235be857c721.08767762', 'Galerie', 'galerie.php', 1, 1, '2024-10-31 10:28:56', '2024-10-31 10:28:56');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `order_uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','Canceled','Delivered','in_progress','paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `total_amount` int(100) DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `preferences` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `num_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_uuid`, `user_uuid`, `order_date`, `status`, `total_amount`, `address`, `preferences`, `is_deleted`, `num_order`) VALUES
('001c3ae7b553ba8800e6c0e09f9279f7', 'd4eccacd01de17ea04cbe6b2c31064cd', '2024-11-17 22:11:23', 'Canceled', 38500, 'Yaoundé,Cameroun', '', 0, 'COM2024046814'),
('03a5de6e1fbccb1f75bec004a4c71551', 'f66eaddb6ee45883b3952898d6b0f2da', '2024-11-15 13:11:58', 'in_progress', 54500, '456 Avenue des Champs-Élysées, Paris, France', '', 0, 'COM2024776594'),
('10f07dfaf1411b55ca1728ce9b2622c0', '9faaffb58dae8fa0a12d1f9e7979181f', '2024-10-31 09:19:57', 'in_progress', 48500, '4567 Rue de l\'Exemple, Paris, 75001', '', 0, 'COM2024870123'),
('217eb42603746c7b7a8edeb6eaf545ee', '0429a6dd84dcf5b36db2a8359c1233bb', '2024-10-29 16:29:03', 'pending', 39500, 'Avenue Kennedy, Quartier Centre-Ville', '', 0, 'COM2024437651'),
('65e536b6ecd6a86dd28acbbe09e3c1d3', 'd4eccacd01de17ea04cbe6b2c31064cd', '2024-11-11 07:58:21', 'paid', 23000, 'Yaoundé,Cameroun', '', 0, 'COM2024789025'),
('81e706eebf441aed4ff353feba64ce70', 'd4eccacd01de17ea04cbe6b2c31064cd', '2024-11-11 15:06:31', 'in_progress', 31500, 'Yaoundé,Cameroun', '', 0, 'COM2024605602');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` varchar(255) NOT NULL,
  `order_uuid` char(36) DEFAULT NULL,
  `meal_uuid` char(36) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_uuid`, `meal_uuid`, `quantity`, `unit_price`, `total_price`, `created_at`, `is_deleted`) VALUES
('00736fc6981d943ed13cbd209c721def', '10f07dfaf1411b55ca1728ce9b2622c0', '5e45-6bed-969e-44dd-9548', 3, 1500.00, 4500.00, '2024-10-31 11:19:57', 0),
('03c4f200d19e8a30327a04c4ef70cc7d', 'bb4f4115618f54f070785fd16e8401e9', '1007-ab1f-fe4a-4877-a76a', 2, 5000.00, 10000.00, '2024-11-02 10:50:34', 0),
('084bc445ae15a4c16b2a007f9829ef96', '9d0ded635c303fb5d0fcdde808547872', 'a04b-cf3b-aa3d-4f54-9618', 3, 25000.00, 75000.00, '2024-10-29 16:02:35', 0),
('08b6c3de05f8fd694aa99f333a21e8c4', '03a5de6e1fbccb1f75bec004a4c71551', 'a04b-cf3b-aa3d-4f54-9618', 2, 25000.00, 50000.00, '2024-11-15 14:11:58', 0),
('0cabd6b56a1a4a9ca45da7bc68ebdf74', '8ba0f0165cc130f394895d5663e1ce22', '0361-8adc-e01c-479f-987c', 2, 7500.00, 15000.00, '2024-10-29 15:46:06', 0),
('0f2f690787041be23429b1c2061d9871', '10f07dfaf1411b55ca1728ce9b2622c0', 'bf65-a2b2-f10a-4818-b659', 4, 8500.00, 34000.00, '2024-10-31 11:19:57', 0),
('2720185e7fd2b055ab86a97a24bd913e', '217eb42603746c7b7a8edeb6eaf545ee', '7916-4d07-1d8b-4872-9dd7', 2, 2500.00, 5000.00, '2024-10-29 18:29:03', 0),
('27ffe06699f42c7cc41cf889d520824f', 'bb4f4115618f54f070785fd16e8401e9', '5e45-6bed-969e-44dd-9548', 5, 1500.00, 7500.00, '2024-11-02 10:50:34', 0),
('36b9182a70564281b1a134294a46c9b7', '81e706eebf441aed4ff353feba64ce70', 'bf65-a2b2-f10a-4818-b659', 2, 8500.00, 17000.00, '2024-11-11 16:06:31', 0),
('5715632a93cc5a052fc96f6d6560a65d', 'a68b5677f4a99387a1224cf38b2ca63a', '5e45-6bed-969e-44dd-9548', 4, 1500.00, 6000.00, '2024-10-30 14:32:53', 0),
('58e5c6ff7212b5a1716d12559fa95be7', 'f44b04c3c506847d0c59fe4501fae387', '1007-ab1f-fe4a-4877-a76a', 2, 5000.00, 10000.00, '2024-10-29 15:46:06', 0),
('593eb6f98a597dce588c0eaaa06c16ac', 'd6c45404da9ee9910f1a500a28a0c4a3', '7f99-007c-9ef4-4e21-9d13', 3, 1500.00, 4500.00, '2024-10-31 14:11:25', 0),
('5e5971b2dc6f267bc87fbd7eac551b0b', 'a41ec85037dbf1adc9b4f49612cab746', 'e8e0-4346-5aec-4a56-bd0a', 3, 15000.00, 45000.00, '2024-11-10 22:33:07', 0),
('611404848938f7cd54c3ed08f3794e16', 'a41ec85037dbf1adc9b4f49612cab746', '5e45-6bed-969e-44dd-9548', 4, 1500.00, 6000.00, '2024-11-10 22:33:07', 0),
('62eda7a98b7afd8cd5689265be155ce7', '001c3ae7b553ba8800e6c0e09f9279f7', '7ba2-c0e9-17ad-46a6-a288', 4, 8500.00, 34000.00, '2024-11-17 23:11:23', 0),
('6dabcb9469bdb37d6a1dc4dd22f8ca72', 'f44b04c3c506847d0c59fe4501fae387', '5e45-6bed-969e-44dd-9548', 3, 1500.00, 4500.00, '2024-10-29 15:46:06', 0),
('6e35ad0c4944b7371f9026c854360cb0', '872b222e5ede886f848082526245d519', '3752-c9c9-4505-4df6-800e', 3, 10000.00, 30000.00, '2024-11-04 11:06:17', 0),
('736a118c7e440da53d1a05dda766791c', '217eb42603746c7b7a8edeb6eaf545ee', 'e8e0-4346-5aec-4a56-bd0a', 2, 15000.00, 30000.00, '2024-10-29 18:29:03', 0),
('76468af014239843a1bfdcdc827ef370', '9d0ded635c303fb5d0fcdde808547872', '1007-ab1f-fe4a-4877-a76a', 2, 5000.00, 10000.00, '2024-10-29 16:02:35', 0),
('77e0deed0061c970603b7459fdf459ab', '81e706eebf441aed4ff353feba64ce70', '7ba2-c0e9-17ad-46a6-a288', 1, 8500.00, 8500.00, '2024-11-11 16:06:31', 0),
('79cb4e0196d3da111a6f666a9d1f188a', '81e706eebf441aed4ff353feba64ce70', '5e45-6bed-969e-44dd-9548', 4, 1500.00, 6000.00, '2024-11-11 16:06:31', 0),
('7dd42ab868bade3ab2224959e00ae39b', 'd6c45404da9ee9910f1a500a28a0c4a3', '3752-c9c9-4505-4df6-800e', 2, 10000.00, 20000.00, '2024-10-31 14:11:25', 0),
('82f530e0212c070bd1db42080d0d0720', '10f07dfaf1411b55ca1728ce9b2622c0', '1007-ab1f-fe4a-4877-a76a', 2, 5000.00, 10000.00, '2024-10-31 11:19:57', 0),
('8a9fb7d92c6cb2a0bf6a01dabab72658', '217eb42603746c7b7a8edeb6eaf545ee', '7f99-007c-9ef4-4e21-9d13', 3, 1500.00, 4500.00, '2024-10-29 18:29:03', 0),
('8bb8785640843c00e974b82fabf5a48d', '71dba0ac7ac2a7706e71fb17f4f5e4fd', '140f-1f99-72e4-49a7-81ca', 2, 25000.00, 50000.00, '2024-10-29 16:06:46', 0),
('909500efd6b5d240127fdea3ea7e8901', 'a68b5677f4a99387a1224cf38b2ca63a', '140f-1f99-72e4-49a7-81ca', 4, 25000.00, 100000.00, '2024-10-30 14:32:53', 0),
('9a8f990cc204ff66bb815e2ee854cf77', '4ca44f0dbb59d21fc3acf9e6bad94897', '1007-ab1f-fe4a-4877-a76a', 5, 5000.00, 25000.00, '2024-10-31 20:26:02', 0),
('a27f6ad4f65b9bfcf2a881f1ca4c11fd', 'a41ec85037dbf1adc9b4f49612cab746', 'bf65-a2b2-f10a-4818-b659', 2, 8500.00, 17000.00, '2024-11-10 22:33:07', 0),
('a407a496ce30a3188b0380ed59d93da9', '872b222e5ede886f848082526245d519', 'bf65-a2b2-f10a-4818-b659', 2, 8500.00, 17000.00, '2024-11-04 11:06:17', 0),
('ae6d508da836024699aa9cf0d6f96969', '8ba0f0165cc130f394895d5663e1ce22', 'a04b-cf3b-aa3d-4f54-9618', 3, 25000.00, 75000.00, '2024-10-29 15:46:06', 0),
('b4275d47a29a44b992c2ab38bc1a670c', '65e536b6ecd6a86dd28acbbe09e3c1d3', '5e45-6bed-969e-44dd-9548', 4, 1500.00, 6000.00, '2024-11-11 08:58:21', 0),
('b758cb25a0ee9b012fec715b889adb12', '9578f40c0a455365c3a37b728189c6d7', '1007-ab1f-fe4a-4877-a76a', 3, 5000.00, 15000.00, '2024-10-29 16:13:25', 0),
('b95f0fa43429b927eb333fc158a80a4e', 'a68b5677f4a99387a1224cf38b2ca63a', '7f99-007c-9ef4-4e21-9d13', 2, 1500.00, 3000.00, '2024-10-30 14:32:53', 0),
('caaec9887acface00a1700f0fd13315e', '001c3ae7b553ba8800e6c0e09f9279f7', '5e45-6bed-969e-44dd-9548', 3, 1500.00, 4500.00, '2024-11-17 23:11:23', 0),
('ce343296c0a4af09c5dc5bbda07ea2b3', '03a5de6e1fbccb1f75bec004a4c71551', '5e45-6bed-969e-44dd-9548', 3, 1500.00, 4500.00, '2024-11-15 14:11:58', 0),
('cf1398ae3145ea7812e3177e81f00e3a', '4ca44f0dbb59d21fc3acf9e6bad94897', '7ba2-c0e9-17ad-46a6-a288', 3, 8500.00, 25500.00, '2024-10-31 20:26:02', 0),
('d72ba2004881f46fa60931efad36adf8', 'bb4f4115618f54f070785fd16e8401e9', 'bf65-a2b2-f10a-4818-b659', 2, 8500.00, 17000.00, '2024-11-02 10:50:34', 0),
('f754c81de2e615f4a8cb018e1aa12895', '65e536b6ecd6a86dd28acbbe09e3c1d3', '7ba2-c0e9-17ad-46a6-a288', 2, 8500.00, 17000.00, '2024-11-11 08:58:21', 0),
('f78af7b66bd4e015c54336ca9429afd1', '4ca44f0dbb59d21fc3acf9e6bad94897', '3752-c9c9-4505-4df6-800e', 2, 10000.00, 20000.00, '2024-10-31 20:26:02', 0);

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `payment_uuid` char(36) NOT NULL,
  `order_uuid` char(36) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('carte','paypal','cash') DEFAULT 'carte',
  `payment_status` enum('en attente','payé','échec') DEFAULT 'en attente',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `added_by` char(36) DEFAULT NULL,
  `num_payments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `payments`
--

INSERT INTO `payments` (`payment_uuid`, `order_uuid`, `amount`, `payment_method`, `payment_status`, `payment_date`, `added_by`, `num_payments`) VALUES
('4072-1bfe-bc88-433b-b928', '03a5de6e1fbccb1f75bec004a4c71551', 54496.91, 'carte', 'payé', '2024-11-15 13:55:54', 'f66eaddb6ee45883b3952898d6b0f2da', 'PAYMENT2024776594'),
('b216-a2cf-ffde-40fa-8154', '217eb42603746c7b7a8edeb6eaf545ee', 39501.73, 'carte', 'payé', '2024-11-15 14:26:33', '0429a6dd84dcf5b36db2a8359c1233bb', 'PAYMENT2024776512'),
('d61f-3ce9-c88d-4967-8c59', '65e536b6ecd6a86dd28acbbe09e3c1d3', 22997.85, 'carte', 'payé', '2024-11-18 09:22:55', 'd4eccacd01de17ea04cbe6b2c31064cd', 'PAYMENT2024461360');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_uuid` char(36) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `number_of_people` int(11) NOT NULL,
  `status` enum('pending','confirmed','canceled','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`reservation_uuid`, `customer_name`, `customer_email`, `customer_phone`, `reservation_date`, `number_of_people`, `status`, `created_at`, `updated_at`, `is_deleted`) VALUES
('13f370f1e328a0f737233ca2c4d9737a', 'Cruz Sosa', 'jyxebavixu@mailinator.com', '+1 (257) 951-6755', '2024-05-21 16:00:00', 8, 'pending', '2024-11-18 15:24:12', '2024-11-18 15:24:12', 0),
('8809aad1f5a094a14f4a9352bf7a350b', 'Jocelyn Hughes', 'qutekopib@mailinator.com', '+1 (275) 225-8858', '2024-11-18 16:04:17', 4, 'pending', '2024-11-18 15:18:31', '2024-11-18 16:04:17', 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_uuid` char(36) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_uuid`, `username`, `email`, `address`, `phone_number`, `password`, `created_at`, `is_deleted`, `photo`) VALUES
('00c4cdc7f45e2cf4bfbc6ac97f283196', 'Laurent Dev', 'laurentalphonsewilfried@gmail.com', '4567 Rue de l\'Exemple, Paris, 75001', '+237650654321', '$2y$10$8sbILxgzvgI6msV9jTdiZeIO1KhWLLMUp9jyznMxWwMmqIumRoItW', '2024-10-24 16:38:09', 0, NULL),
('0429a6dd84dcf5b36db2a8359c1233bb', 'Laurent Etoudi', 'laurent.etoudi@example.com', 'Avenue Kennedy, Quartier Centre-Ville', '+237650654321', '$2y$10$DeUthTUQvID1hz5AqrerN.rmVB/ZPOTjiSH77hizpuu.DTMGwgIXW', '2024-10-29 16:27:15', 0, NULL),
('160ccee303b12a32baa7ac43afe03490', 'Brock Blankenship', 'lysyf@mailinator.com', NULL, NULL, '$2y$10$HigpI//07MurZoQ.ZxaB7.2QqVfYo.EW/nPe.05rb5EWXIjFXLLRa', '2024-11-18 14:30:33', 0, NULL),
('9faaffb58dae8fa0a12d1f9e7979181f', 'Jean Dupont', 'jeandupont@gmail.com', '4567 Rue de l\'Exemple, Paris, 75001', '', '$2y$10$8.P9grnKyvgAbqpseUACYOcjEcHsptW6BAtCxt3T28y/yG.PiPdD.', '2024-10-31 09:15:58', 0, NULL),
('a703af12b372a172a5a4576cd399b352', 'John Deo', 'johndeo@gmail.com', 'Avenue Kennedy, Quartier Centre-Ville', '', '$2y$10$DUBO8FV6f8zldUrDfPwrqOGLKz4czxOORFI9V4gqCR1nQJMvHsUh2', '2024-10-29 13:54:10', 0, NULL),
('d4eccacd01de17ea04cbe6b2c31064cd', 'DevFullstack', 'devfullstack@gmail.com', 'Yaoundé,Cameroun', '', '$2y$10$Z0AKTSCKOVNIZlX2GCN/gui4.pmgO04M8UHc3U2unAYIOshU1m18G', '2024-11-10 21:30:50', 0, NULL),
('f66eaddb6ee45883b3952898d6b0f2da', 'Admin Dev', 'admin@gmail.com', '456 Avenue des Champs-Élysées, Paris, France', '', '$2y$10$o2EcXYCoy6oFNxvxivcB2uV.ju4v50IQZsWPJYdlTJKS1KGDIAlF.', '2024-11-15 09:54:19', 0, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_uuid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `cancel_order`
--
ALTER TABLE `cancel_order`
  ADD PRIMARY KEY (`cancel_uuid`),
  ADD KEY `order_id` (`order_uuid`),
  ADD KEY `added_by` (`added_by`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`uuid`);

--
-- Index pour la table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`delivery_uuid`),
  ADD KEY `order_uuid` (`order_uuid`),
  ADD KEY `agent_uuid` (`agent_uuid`),
  ADD KEY `added_by` (`added_by`);

--
-- Index pour la table `delivery_agents`
--
ALTER TABLE `delivery_agents`
  ADD PRIMARY KEY (`agent_uuid`),
  ADD UNIQUE KEY `agent_code` (`agent_code`),
  ADD KEY `added_by` (`added_by`);

--
-- Index pour la table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `admin_uuid` (`admin_uuid`);

--
-- Index pour la table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`meal_uuid`),
  ADD KEY `category_uuid` (`category_uuid`),
  ADD KEY `added_by` (`added_by`);

--
-- Index pour la table `meal_categories`
--
ALTER TABLE `meal_categories`
  ADD PRIMARY KEY (`category_uuid`),
  ADD KEY `added_by` (`added_by`);

--
-- Index pour la table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_uuid`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_uuid`),
  ADD KEY `user_uuid` (`user_uuid`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_uuid` (`order_uuid`),
  ADD KEY `meal_uuid` (`meal_uuid`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_uuid`),
  ADD KEY `order_uuid` (`order_uuid`),
  ADD KEY `added_by` (`added_by`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_uuid`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_uuid`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cancel_order`
--
ALTER TABLE `cancel_order`
  ADD CONSTRAINT `cancel_order_ibfk_1` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`order_uuid`),
  ADD CONSTRAINT `cancel_order_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `admin_users` (`admin_uuid`);

--
-- Contraintes pour la table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`order_uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `deliveries_ibfk_2` FOREIGN KEY (`agent_uuid`) REFERENCES `delivery_agents` (`agent_uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `deliveries_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `admin_users` (`admin_uuid`);

--
-- Contraintes pour la table `delivery_agents`
--
ALTER TABLE `delivery_agents`
  ADD CONSTRAINT `delivery_agents_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `admin_users` (`admin_uuid`);

--
-- Contraintes pour la table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD CONSTRAINT `forgot_password_ibfk_1` FOREIGN KEY (`admin_uuid`) REFERENCES `admin_users` (`admin_uuid`) ON DELETE CASCADE;

--
-- Contraintes pour la table `meals`
--
ALTER TABLE `meals`
  ADD CONSTRAINT `meals_ibfk_1` FOREIGN KEY (`category_uuid`) REFERENCES `meal_categories` (`category_uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `meals_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `admin_users` (`admin_uuid`);

--
-- Contraintes pour la table `meal_categories`
--
ALTER TABLE `meal_categories`
  ADD CONSTRAINT `meal_categories_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `admin_users` (`admin_uuid`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`user_uuid`);

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`order_uuid`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`meal_uuid`) REFERENCES `meals` (`meal_uuid`);

--
-- Contraintes pour la table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`order_uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `users` (`user_uuid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
