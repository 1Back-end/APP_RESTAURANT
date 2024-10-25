-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 25 oct. 2024 à 18:17
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
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_users`
--

INSERT INTO `admin_users` (`admin_uuid`, `username`, `email`, `password`, `photo`, `created_at`, `is_deleted`) VALUES
('cc1b0dae-9116-11ef-b2d9-24418c1325d5', 'Laurent Alphonse', 'laurentalphonsewilfried@gmail.com', '$2y$10$w1yvaWpCzg09QIIX2bLHFeG9RvPHJyJeQ8tuhNaW3ZyhjFrt.Z.k6', NULL, '2024-10-23 08:14:12', 0);

-- --------------------------------------------------------

--
-- Structure de la table `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_uuid` char(36) NOT NULL,
  `order_uuid` char(36) DEFAULT NULL,
  `agent_uuid` char(36) DEFAULT NULL,
  `delivery_status` enum('en attente','en route','livré') DEFAULT 'en attente',
  `delivery_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('3775-ef67-1001-4032-b90c', 'AGT-202412', 'Claire', 'Marie', 'marie.claire@example.com', '+237650654321', NULL, 'CNI987654321', '277753625_286541043653132_6647136332779368253_n.jpg', 1, '24h/24', '2024-10-25 09:34:19', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('4a42-42c6-140c-4a32-b0ca', 'AGT-202485', 'Durand', 'Sophie', 'sophie.durand@example.com', '+237650456789', NULL, 'CNI345678901', NULL, 1, '4h/24', '2024-10-25 11:48:16', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('5b5f-a4bf-6b38-4991-8969', 'AGT-202489', 'Alphonse', 'Laurent', 'laurentalphonsewilfried@gmail.com', '+237678536884', NULL, 'CNI123456722', '../uploads/671b8850cf953-WhatsApp Image 2024-05-23 à 14.11.42_a12d25c4.jpg', 0, '2h/24', '2024-10-25 12:00:16', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('c636-b711-0aa4-4ba2-96d3', 'AGT-202467', 'Martin', 'Paul', 'paul.martin@example.com', '+237650876543', NULL, 'CNI234567890', 'png-transparent-computer-icons-job-job-hire-hand-sticker-cartoon-thumbnail.png', 1, '8h/24', '2024-10-25 09:41:20', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('db17-d541-19be-4799-bf9f', 'AGT-202458', 'Martin', 'Sophie', 'sophie.martin@example.com', '+237690987654', NULL, 'CNI123456700', '../uploads/671b8954332b2-WhatsApp Image 2024-10-10 à 14.46.29_43e913f3.jpg', 1, '2h/24', '2024-10-25 12:04:36', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('ede7-398e-8150-40eb-bd42', 'AGT-202499', 'Leroy', 'Luc', 'luc.leroy@example.com', '+237650567890', NULL, 'CNI456789012', NULL, 0, '12h/24', '2024-10-25 11:55:32', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5'),
('f262-7879-17dd-492d-9127', 'AGT-202410', 'Dupont', 'Jean', 'jean.dupont@example.com', '+237678536820', NULL, 'CNI123456789', NULL, 1, '8h/24', '2024-10-25 09:17:05', 0, 'cc1b0dae-9116-11ef-b2d9-24418c1325d5');

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
('5e45-6bed-969e-44dd-9548', 'Canette', 'Une canette de cola pétillant et rafraîchissant.', 1500, '671914c5369f1.jpg,671914c536c4c.jpg,671914c536f1a.jpg,671914c53727e.jpg', 1, '2024-10-24', 'c4f6-fdda-d80f-4d3c-b83e', '2024-10-23 15:22:45', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('7ba2-c0e9-17ad-46a6-a288', 'Pâtes Carbonara', 'Pâtes à la sauce crémeuse au bacon et au parmesan.', 8500, '671a23a0794b2.jpg,671a23a079a8a.jpg,671a23a079db5.jpg,671a23a07a034.jpg', 1, '2024-10-25', 'ceb2-df92-2aaa-4685-b7d1', '2024-10-24 10:38:24', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('a04b-cf3b-aa3d-4f54-9618', 'Humberger', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Veritatis reprehenderit autem iure, quidem vero incidunt dolorum excepturi commodi architecto repellendus iste velit obcaecati debitis eos, corrupti nesciunt repellat, ea temporibus?', 25000, '671913ec21f3e.jpg,671913ec2218e.jpg,671913ec22513.jpg,671913ec227f1.jpg', 1, '2024-10-14', '305d-ede6-5a3a-49c6-97dc', '2024-10-23 15:19:08', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('a0e7-1171-1bb9-4d60-b048', 'Pizza Margherita', 'Pizza avec sauce tomate, mozzarella et basilic frais.', 12000, '67190a62923b5.jpg,67190a6292619.jpg,67190a62928d8.jpg,67190a6292b56.jpg', 0, '2024-10-14', '305d-ede6-5a3a-49c6-97dc', '2024-10-23 14:38:26', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0),
('bf65-a2b2-f10a-4818-b659', 'Caesar Selections', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores veniam, consequatur assumenda illum vitae, fugit magnam fugiat unde officiis tempora cumque, blanditiis sapiente nam iste amet delectus voluptas atque omnis.', 8500, '671bb176b8d5b.jpg,671bb176b9037.jpg,671bb176b92d6.jpg,671bb176b9565.jpg', 1, '2024-11-09', '42df-f4bc-2b58-4c5c-98da', '2024-10-25 14:55:50', 'cc1b0dae-9116-11ef-b2d9-24418c1325d5', 0);

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
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `order_uuid` char(36) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_uuid` char(36) NOT NULL,
  `order_uuid` char(36) NOT NULL,
  `meal_uuid` char(36) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `price_at_order` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_uuid` char(36) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_uuid`, `username`, `email`, `password`, `created_at`, `is_deleted`) VALUES
('00c4cdc7f45e2cf4bfbc6ac97f283196', 'Laurent Alphonse', 'laurentalphonsewilfried@gmail.com', '$2y$10$8sbILxgzvgI6msV9jTdiZeIO1KhWLLMUp9jyznMxWwMmqIumRoItW', '2024-10-24 16:38:09', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_uuid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`delivery_uuid`),
  ADD KEY `order_uuid` (`order_uuid`),
  ADD KEY `agent_uuid` (`agent_uuid`);

--
-- Index pour la table `delivery_agents`
--
ALTER TABLE `delivery_agents`
  ADD PRIMARY KEY (`agent_uuid`),
  ADD UNIQUE KEY `agent_code` (`agent_code`),
  ADD KEY `added_by` (`added_by`);

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
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_uuid`),
  ADD KEY `user_uuid` (`user_uuid`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_uuid`),
  ADD KEY `order_uuid` (`order_uuid`),
  ADD KEY `meal_uuid` (`meal_uuid`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_uuid`),
  ADD KEY `order_uuid` (`order_uuid`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_uuid`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`order_uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `deliveries_ibfk_2` FOREIGN KEY (`agent_uuid`) REFERENCES `delivery_agents` (`agent_uuid`) ON DELETE CASCADE;

--
-- Contraintes pour la table `delivery_agents`
--
ALTER TABLE `delivery_agents`
  ADD CONSTRAINT `delivery_agents_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `admin_users` (`admin_uuid`);

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
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`user_uuid`) ON DELETE CASCADE;

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`order_uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`meal_uuid`) REFERENCES `meals` (`meal_uuid`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_uuid`) REFERENCES `orders` (`order_uuid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
