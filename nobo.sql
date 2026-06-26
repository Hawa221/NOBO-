-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 26 juin 2026 à 09:11
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
-- Base de données : `nobo`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','validee','expediee','annulee') DEFAULT 'en_attente',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_commande`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `id_utilisateur`, `total`, `statut`, `created_at`) VALUES
(1, 2, 49.00, 'validee', '2026-06-25 04:15:48'),
(2, 2, 430.00, 'validee', '2026-06-26 09:04:28');

-- --------------------------------------------------------

--
-- Structure de la table `commande_produits`
--

DROP TABLE IF EXISTS `commande_produits`;
CREATE TABLE IF NOT EXISTS `commande_produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_commande` int NOT NULL,
  `id_produit` int NOT NULL,
  `quantite` int NOT NULL DEFAULT '1',
  `prix_unitaire` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_commande` (`id_commande`),
  KEY `id_produit` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande_produits`
--

INSERT INTO `commande_produits` (`id`, `id_commande`, `id_produit`, `quantite`, `prix_unitaire`) VALUES
(1, 1, 11, 1, 49.00),
(2, 2, 12, 1, 120.00),
(3, 2, 10, 2, 110.00),
(4, 2, 13, 1, 90.00);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `submitted_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_produit` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `description` text,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `nom`, `description`, `prix`, `image`) VALUES
(1, '\r\nT-shirt NOBO', 'T-shirt oversize 100 % coton bio, coupe droite unisexe. Logo discret brodé sur la manche.', 29.00, 't-shirtnobo.png'),
(2, 'Pull Essence', 'Sweat à capuche ou sans capuche unisexe en coton bio épais, coupe confortable, capuche doublée et cordons assortis. Motif “NOBO” brodé ton sur ton sur la poitrine.', 45.00, 'pullnobo.png'),
(4, 'Ensemble Harmonie\r\n\r\n', 'Ensemble coordonné jogging + sweat unisexe, disponible en 3 coloris neutres. Matière ultra-douce, parfaite pour le quotidien. Pantalon ajustable à la taille + sweat col rond.', 79.00, 'ensembleharmonie.png'),
(5, 'Casquette Vision', 'Casquette unisexe en coton recyclé, visière courbée, réglable à l’arrière. Broderie “NOBO” centrée sur le devant. Confort léger, look minimaliste et affirmé.', 29.00, 'casquettevision.png'),
(6, 'Ensemble Libre', 'Ensemble unisexe composé d’un pull col rond léger et d’un short assorti, en coton bio doux. Idéal pour la mi-saison. Logo NOBO discret sur le bas du pull et l’ourlet du short. Disponible en bleu, noir et sauge.', 70.00, 'ensemblelibre.png'),
(7, 'Lunettes Ombre', 'Lunettes de soleil unisexe au design minimaliste. Monture noire mate recyclée, verres protection UV400. Légeres et confortables. Gravure discrète “NOBO” sur la branche gauche.\r\n\r\n', 39.00, 'lunettesombre.png'),
(8, 'Chemise Horizons', 'Chemise manches longues unisexe, coupe droite et fluide, tissu rayé bleu et blanc en coton biologique. Boutons nacrés, col souple. Design non genré idéal pour toutes les morphologies.\r\n\r\n', 49.00, 'chemisehorizons.png'),
(9, 'Chemise Souffle', 'Chemise unisexe blanche à manches trois-quarts, tissu en coton bio effet lin, très léger et respirant. Coupe oversize fluide, col ouvert sans bouton. Élégance naturelle et non genrée.', 58.00, 'chemisesouffle.png'),
(10, 'Ensemble Indigo\r\n\r\n', ' Ensemble unisexe composé d’une veste droite et d’un pantalon coupe droite en denim brut écoresponsable. Détails minimalistes, coutures ton sur ton, étiquette NOBO tissée au dos. Style affirmé et inclusif.', 110.00, 'ensembleindigo.png'),
(11, 'Sabots Flow', 'Chaussures unisexe inspirées du style Crocs, fabriquées à partir de matières recyclées. Ultra légères, respirantes et confortables. Logo NOBO gravé discrètement sur le côté. Parfaites pour une démarche libre et fluide.', 49.00, 'sabotsflow.png'),
(12, 'Manteau Terre', 'Manteau court et/ou 3/4 unisexe, décliné en denim brut foncé ou coton lourd marron. Coupe droite, coutures discrètes ton sur ton, boutons noirs mats. Tissu durable à base de coton bio ou denim recyclé. Minimaliste, intemporel, inclusif.', 120.00, 'manteauterre.png'),
(13, 'Montre Nuit', 'Montre épurée unisexe, boîtier noir mat en acier inoxydable recyclé (Ø 40 mm), cadran entièrement noir, verre saphir, mouvement quartz suisse, bracelet interchangeable en cuir végan ou maille milanaise noire. Étanche jusqu’à 3 ATM. Parfaite pour un style sobre et durable.', 90.00, 'montrenuit.png');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('client','admin','sales') DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `created_at`) VALUES
(1, 'Admin', 'NOBO', 'admin@nobo.fr', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.ucrm3a.Oe', 'admin', '2026-06-09 15:47:56'),
(2, 'Doucouré', 'Hawa', 'doucourehawa2006@gmail.com', '$2y$10$FilH.vNGcnMj09Mm./6vwuQXTMzkmgjZSsN..fQFNb5IMG6s0VRIW', 'client', '2026-06-23 12:42:22'),
(3, 'paris', 'lil', 'lili-sales@nobo.fr', '$2y$10$JlRGFmAZLJORVGgd.f7Hc.urHvwCb4mx7frlSErIwbQXC3kfqaaXe', 'sales', '2026-06-26 10:08:57');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD CONSTRAINT `commande_produits_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id_commande`),
  ADD CONSTRAINT `commande_produits_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
