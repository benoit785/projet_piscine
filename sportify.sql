-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 28 mai 2024 à 11:42
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sportify`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
-- Rajout de la seule ligne suivante pour ajoute de la photo dans la table client : ALTER TABLE client ADD photo_client VARCHAR(255) DEFAULT NULL; 


DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `id_activite` int NOT NULL AUTO_INCREMENT,
  `nom_activite` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id_activite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(50) NOT NULL,
  `prenom_client` varchar(50) NOT NULL,
  `sexe_client` varchar(10) DEFAULT NULL,
  `mdp_client` varchar(255) NOT NULL,
  `email_client` varchar(100) NOT NULL,
  `num_telephone` varchar(20) DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `date_de_naissance` date DEFAULT NULL,
  PRIMARY KEY (`id_client`),
  UNIQUE KEY `email_client` (`email_client`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom_client`, `prenom_client`, `sexe_client`, `mdp_client`, `email_client`, `num_telephone`, `profession`, `date_de_naissance`) VALUES
(1, 'Doe', 'John', 'Male', 'hashedpassword', 'john.doe@example.com', '1234567890', 'Engineer', '1980-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `coach`
--

DROP TABLE IF EXISTS `coach`;
CREATE TABLE IF NOT EXISTS `coach` (
  `id_coach` int NOT NULL AUTO_INCREMENT,
  `nom_coach` varchar(50) NOT NULL,
  `prenom_coach` varchar(50) NOT NULL,
  `sexe_coach` varchar(10) DEFAULT NULL,
  `mdp_coach` varchar(255) NOT NULL,
  `email_coach` varchar(100) NOT NULL,
  `cv_coach` varchar(255) DEFAULT NULL,
  `bureau_coach` varchar(100) DEFAULT NULL,
  `photo_coach` varchar(255) DEFAULT NULL,
  `specialite_coach` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_coach`),
  UNIQUE KEY `email_coach` (`email_coach`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `coach`
--

INSERT INTO `coach` (`id_coach`, `nom_coach`, `prenom_coach`, `sexe_coach`, `mdp_coach`, `email_coach`, `cv_coach`, `bureau_coach`, `photo_coach`, `specialite_coach`) VALUES
(1, 'Smith', 'Jane', 'Female', 'hashedpassword', 'jane.smith@example.com', 'cv_jane.pdf', 'Bureau 101', 'jane.jpg', 'Fitness');

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE IF NOT EXISTS `evaluation` (
  `id_evaluation` int NOT NULL AUTO_INCREMENT,
  `id_client` int DEFAULT NULL,
  `id_coach` int DEFAULT NULL,
  `note` int DEFAULT NULL,
  `commentaire` text,
  `date_evaluation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_evaluation`),
  KEY `id_client` (`id_client`),
  KEY `id_coach` (`id_coach`)
) ;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `id_client` int DEFAULT NULL,
  `id_coach` int DEFAULT NULL,
  `message_text` text,
  `date_message` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_message`),
  KEY `id_client` (`id_client`),
  KEY `id_coach` (`id_coach`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id_paiement` int NOT NULL AUTO_INCREMENT,
  `id_client` int DEFAULT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date_paiement` datetime DEFAULT CURRENT_TIMESTAMP,
  `method_paiement` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_paiement`),
  KEY `id_client` (`id_client`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prise_de_rendez_vous`
--

DROP TABLE IF EXISTS `prise_de_rendez_vous`;
CREATE TABLE IF NOT EXISTS `prise_de_rendez_vous` (
  `id_rdv` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_coach` int NOT NULL,
  `id_salle` int NOT NULL,
  `date_rdv` datetime NOT NULL,
  `type_communication` varchar(50) DEFAULT NULL,
  `statut_rdv` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_rdv`),
  KEY `id_client` (`id_client`),
  KEY `id_coach` (`id_coach`),
  KEY `id_salle` (`id_salle`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `prise_de_rendez_vous`
--

INSERT INTO `prise_de_rendez_vous` (`id_rdv`, `id_client`, `id_coach`, `id_salle`, `date_rdv`, `type_communication`, `statut_rdv`) VALUES
(1, 1, 1, 1, '2024-06-01 10:00:00', 'In-person', 1);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int NOT NULL AUTO_INCREMENT,
  `nom_salle` varchar(100) NOT NULL,
  `adresse_salle` varchar(255) NOT NULL,
  `capacite` int DEFAULT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `nom_salle`, `adresse_salle`, `capacite`) VALUES
(1, 'Salle A', '10 rue de Paris, 75000 Paris', 20);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
