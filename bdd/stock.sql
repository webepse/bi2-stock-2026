-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 oct. 2025 à 12:50
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

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `login`, `password`) VALUES
(1, 'admin', '$2y$10$tJKd5u9SLHglYvLsjKWVmuurt/mZhx28fFTj8Zw9IsLYpq6.BGCbq');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `category` int NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `date`, `category`, `description`, `cover`) VALUES
(1, 'Product 1', '2025-10-07', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc arcu felis, ultrices et nisl nec, iaculis malesuada elit. Morbi quis diam in dolor suscipit lacinia. Suspendisse enim arcu, bibendum a turpis id, pulvinar mattis ex. Phasellus efficitur auctor quam ac blandit. Integer ac ligula sed magna dignissim facilisis. Nulla gravida eu ex eu bibendum. Maecenas in rhoncus ipsum. In hac habitasse platea dictumst. Sed lorem purus, malesuada non viverra et, ultrices eget lorem. Phasellus at neque ut felis porta blandit sed ut tortor. Ut non nunc massa. Sed sapien elit, feugiat id euismod in, varius eget erat. ', 'image.jpg'),
(2, 'Product 2', '2025-09-09', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc arcu felis, ultrices et nisl nec, iaculis malesuada elit. Morbi quis diam in dolor suscipit lacinia. Suspendisse enim arcu, bibendum a turpis id, pulvinar mattis ex. Phasellus efficitur auctor quam ac blandit. Integer ac ligula sed magna dignissim facilisis. Nulla gravida eu ex eu bibendum. Maecenas in rhoncus ipsum. In hac habitasse platea dictumst. Sed lorem purus, malesuada non viverra et, ultrices eget lorem. Phasellus at neque ut felis porta blandit sed ut tortor. Ut non nunc massa. Sed sapien elit, feugiat id euismod in, varius eget erat. ', 'image.jpg'),
(3, 'Product 3', '2025-07-08', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc arcu felis, ultrices et nisl nec, iaculis malesuada elit. Morbi quis diam in dolor suscipit lacinia. Suspendisse enim arcu, bibendum a turpis id, pulvinar mattis ex. Phasellus efficitur auctor quam ac blandit. Integer ac ligula sed magna dignissim facilisis. Nulla gravida eu ex eu bibendum. Maecenas in rhoncus ipsum. In hac habitasse platea dictumst. Sed lorem purus, malesuada non viverra et, ultrices eget lorem. Phasellus at neque ut felis porta blandit sed ut tortor. Ut non nunc massa. Sed sapien elit, feugiat id euismod in, varius eget erat. ', 'image.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
