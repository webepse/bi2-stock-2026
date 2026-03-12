-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 12 mars 2026 à 10:52
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stock`
--
CREATE DATABASE IF NOT EXISTS `stock` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `stock`;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `login`, `password`) VALUES
(1, 'admin', '$2y$10$tJKd5u9SLHglYvLsjKWVmuurt/mZhx28fFTj8Zw9IsLYpq6.BGCbq');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`) VALUES
(1, 'catégorie 1', NULL, NULL),
(2, 'Catégorie 2', NULL, NULL),
(3, 'Catégorie 32', NULL, NULL),
(4, 'webdev1', NULL, NULL),
(5, 'BI1', NULL, NULL),
(6, 'test WebDev1', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `nom`, `email`, `date`, `message`) VALUES
(1, 'berti Jordan', 'berti@myepse.be', '2025-12-11 10:34:48', 'hello');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fichier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_product` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_product` (`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `category` int NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `date`, `category`, `description`, `cover`) VALUES
(1, 'Product 1', '2025-10-07', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc arcu felis, ultrices et nisl nec, iaculis malesuada elit. Morbi quis diam in dolor suscipit lacinia. Suspendisse enim arcu, bibendum a turpis id, pulvinar mattis ex. Phasellus efficitur auctor quam ac blandit. Integer ac ligula sed magna dignissim facilisis. Nulla gravida eu ex eu bibendum. Maecenas in rhoncus ipsum. In hac habitasse platea dictumst. Sed lorem purus, malesuada non viverra et, ultrices eget lorem. Phasellus at neque ut felis porta blandit sed ut tortor. Ut non nunc massa. Sed sapien elit, feugiat id euismod in, varius eget erat. ', 'image.jpg'),
(2, 'Product 2', '2025-09-09', 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc arcu felis, ultrices et nisl nec, iaculis malesuada elit. Morbi quis diam in dolor suscipit lacinia. Suspendisse enim arcu, bibendum a turpis id, pulvinar mattis ex. Phasellus efficitur auctor quam ac blandit. Integer ac ligula sed magna dignissim facilisis. Nulla gravida eu ex eu bibendum. Maecenas in rhoncus ipsum. In hac habitasse platea dictumst. Sed lorem purus, malesuada non viverra et, ultrices eget lorem. Phasellus at neque ut felis porta blandit sed ut tortor. Ut non nunc massa. Sed sapien elit, feugiat id euismod in, varius eget erat. ', 'image.jpg'),
(3, 'Product 3', '2025-07-08', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc arcu felis, ultrices et nisl nec, iaculis malesuada elit. Morbi quis diam in dolor suscipit lacinia. Suspendisse enim arcu, bibendum a turpis id, pulvinar mattis ex. Phasellus efficitur auctor quam ac blandit. Integer ac ligula sed magna dignissim facilisis. Nulla gravida eu ex eu bibendum. Maecenas in rhoncus ipsum. In hac habitasse platea dictumst. Sed lorem purus, malesuada non viverra et, ultrices eget lorem. Phasellus at neque ut felis porta blandit sed ut tortor. Ut non nunc massa. Sed sapien elit, feugiat id euismod in, varius eget erat. ', 'image.jpg'),
(4, 'Produit test', '2025-11-14', 3, 'test', 'https://media.istockphoto.com/id/814423752/fr/photo/oeil-du-mod%C3%A8le-avec-le-maquillage-art-color%C3%A9-gros-plan.jpg?s=612x612&amp;w=0&amp;k=20&amp;c=NeNYcLTUsVfcAyGmFHM7BWpwnFFXvCxsGfSwyZOB8nU='),
(5, 'produit test 2', '2025-11-14', 2, 'test', '691727095e31f-Couv-272116.jpg'),
(6, 'test', '2025-11-14', 2, 'test', '691728d6ea6db-Daredevil-12.jpg'),
(10, 'test', '2026-01-07', 4, 'test', '695b7222e8f25-logo.jpg'),
(11, 'test BI1', '2026-01-06', 5, 'test', '695bcd597716f-wallpaper.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `skills`
--

INSERT INTO `skills` (`id`, `nom`, `image`) VALUES
(1, 'Photoshop', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
