-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 31 mai 2023 à 19:34
-- Version du serveur : 8.0.33-0ubuntu0.22.04.2
-- Version de PHP : 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gnotes`
--
CREATE DATABASE IF NOT EXISTS `gnotes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `gnotes`;

-- --------------------------------------------------------

--
-- Structure de la table `accesscontrol`
--

CREATE TABLE `accesscontrol` (
  `id` int NOT NULL,
  `role` varchar(255) NOT NULL,
  `permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `accesscontrol`
--

INSERT INTO `accesscontrol` (`id`, `role`, `permissions`) VALUES
(1, 'admin', 'all'),
(2, 'user', 'viewStudents,viewClasses,viewTeachers,viewNiveaux,viewAnneescolaires'),
(3, 'visitor', '');

-- --------------------------------------------------------

--
-- Structure de la table `annees_scolaires`
--

CREATE TABLE `annees_scolaires` (
  `id` int NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `supprime` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `annees_scolaires`
--

INSERT INTO `annees_scolaires` (`libelle`, `supprime`) VALUES
-- (1, '2040-2041', 1),
-- (2, '2019-2020', 0),
-- (3, '2020-2021', 0),
-- (4, '2026-2027', 0),
-- (6, '2021-2022', 0),
-- (7, '2903-2904', 1),
-- (8, '2222-2223', 1),
-- (9, '2333-2334', 1),
-- (10, '2003-2004', 1),
-- (11, '2012-2013', 1),
-- (12, '2009-2010', 1),
-- (13, '2034-2035', 1),
-- (14, '3300-3301', 1),
('2022-2023', 0);

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` int NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `id_niveau` int NOT NULL,
  `supprime` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `classes`
--

-- INSERT INTO `classes` (`id`, `libelle`, `id_niveau`, `supprime`) VALUES
-- (1, 'CI', 1, 0),
-- (2, 'CP', 1, 0),
-- (3, '6ème', 2, 0),
-- (4, '5ème', 2, 0),
-- (9, 'CE1', 1, 0),
-- (10, 'efefefefefsqd', 1, 1),
-- (11, 'fefefef', 1, 1),
-- (12, 'test', 1, 1),
-- (14, 'test', 1, 1),
-- (15, 'test', 1, 1),
-- (16, 'test', 1, 1),
-- (17, 'test', 1, 1),
-- (18, 'Badbitch', 1, 1),
-- (19, 'test', 2, 1),
-- (20, 'Brekh 1', 33, 0),
-- (21, 'Classe 2', 34, 0),
-- (22, 'classe R', 34, 1),
-- (23, 'Classe R', 34, 1),
-- (24, 'Kak', 1, 1),
-- (25, 'Brekh 2', 33, 0);

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `id` int NOT NULL,
  `username` varchar(32) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) NOT NULL,
  `type` set('admin','user') NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`id`, `username`, `prenom`, `nom`, `email`, `telephone`, `type`, `password_hash`, `photo`) VALUES
(1, 'ibou', 'Ibrahima', 'Sylla', 'isyll711@gmail.com', '785354479', 'admin', '$2y$10$TC7n3q2ZyneX13uy/Ec0TOdvgjcGxWf9AyvsEIQjSCV3Wx7w2H4p.', '/img/profiles/pp_64735fb650d24.png');

-- --------------------------------------------------------

--
-- Structure de la table `disciplines`
--

CREATE TABLE `disciplines` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

CREATE TABLE `eleves` (
  `id` int NOT NULL,
  `numero` int DEFAULT NULL,
  `type` enum('externe','interne') NOT NULL,
  `supprime` tinyint(1) NOT NULL DEFAULT '0',
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `adresse` text,
  `email` varchar(255) DEFAULT NULL,
  `naissance` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `eleves`
--

-- INSERT INTO `eleves` (`id`, `numero`, `type`, `supprime`, `prenom`, `nom`, `telephone`, `adresse`, `email`, `naissance`) VALUES
-- (4, NULL, 'interne', 0, 'Ibrahima', 'Sylla', NULL, NULL, 'abre@goffr.com', '1999-11-04'),
-- (9, 7885, 'externe', 0, 'Assane', 'Faye', NULL, '', NULL, NULL),
-- (10, 8864, 'interne', 0, 'Amadou', 'Ba', NULL, '', NULL, NULL),
-- (11, 8814, 'interne', 0, 'Diop', 'Fall', NULL, '', NULL, NULL),
-- (12, 5253, 'interne', 0, 'Samba', 'Diouf', NULL, '', NULL, NULL),
-- (13, 5446, 'externe', 0, 'Samba', 'Dia', NULL, '', NULL, NULL),
-- (14, 7883, 'interne', 0, 'Ibeagiaez', 'Kfnefe', NULL, '', NULL, NULL),
-- (15, 9880, 'externe', 0, 'Ibeagiaez', 'Kfnefe', NULL, '', NULL, NULL),
-- (16, 6785, 'externe', 0, 'Ibrahima', 'Sylla', NULL, '', NULL, NULL),
-- (17, 3684, 'externe', 0, 'Ldvkndflkn', 'Fvelkndfmk', NULL, '', NULL, NULL),
-- (18, NULL, 'externe', 0, 'Absa', 'Diop', NULL, NULL, NULL, NULL),
-- (19, 9466, 'externe', 1, 'Assane', 'Faye', NULL, NULL, NULL, '2023-05-04'),
-- (20, 4565, 'interne', 1, 'Ibrahima', 'Sylla', NULL, NULL, 'isyll711@gmail.com', '1999-11-04'),
-- (21, NULL, 'interne', 0, 'Abdou', 'Mbow', '786758909', 'Sicap Mbao', 'abdoufaye@hotmail.com', '2023-05-07'),
-- (22, 277, 'interne', 0, 'Moussa', 'Doff', '767676767', 'eioedfe', 'ieihfe@gmail.com', '1984-06-06'),
-- (24, NULL, 'interne', 0, 'Ala', 'Djiby', NULL, NULL, NULL, '2023-05-01'),
-- (25, 1955, 'interne', 0, 'Dgrgfrfrf', 'Rfrfrfr', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `groupes_disciplines`
--

CREATE TABLE `groupes_disciplines` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id` int NOT NULL,
  `id_eleve` int NOT NULL,
  `id_classe` int NOT NULL,
  `id_annee` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `inscriptions`
--

-- INSERT INTO `inscriptions` (`id`, `id_eleve`, `id_classe`, `id_annee`) VALUES
-- (1, 4, 1, 3),
-- (2, 9, 1, 3),
-- (3, 10, 1, 3),
-- (4, 11, 1, 3),
-- (5, 12, 1, 3),
-- (6, 13, 1, 3),
-- (7, 14, 20, 3),
-- (8, 15, 20, 3),
-- (9, 16, 21, 3),
-- (10, 17, 21, 3),
-- (11, 18, 1, 3),
-- (12, 19, 1, 3),
-- (13, 20, 1, 3),
-- (14, 21, 9, 3),
-- (15, 22, 9, 3),
-- (16, 24, 25, 3),
-- (17, 25, 9, 3);

-- --------------------------------------------------------

--
-- Structure de la table `niveaux`
--

CREATE TABLE `niveaux` (
  `id` int NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `supprime` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `niveaux`
--

-- INSERT INTO `niveaux` (`id`, `libelle`, `supprime`) VALUES
-- (1, 'Elémentaire', 0),
-- (2, 'Secondaire', 0),
-- (8, 'Primaire', 1),
-- (9, 'test', 1),
-- (10, 'test', 1),
-- (11, 'test', 1),
-- (12, 'test', 1),
-- (13, 'test', 1),
-- (14, 'test', 1),
-- (15, 'test', 1),
-- (16, 'test', 1),
-- (17, 'test', 1),
-- (18, 'un niveau', 1),
-- (19, 'test', 1),
-- (20, 'test', 1),
-- (21, 'test', 1),
-- (22, 'test', 1),
-- (23, 'test', 1),
-- (24, 'test', 1),
-- (25, 'test', 1),
-- (26, 'Okok', 1),
-- (27, 'test', 1),
-- (28, 'est', 1),
-- (29, 'Baddddd', 1),
-- (30, 'test', 1),
-- (31, 'Badddd', 1),
-- (32, 'Test', 1),
-- (33, 'Brekh Niveau', 0),
-- (34, 'Etoile', 1),
-- (35, 'Test', 1);

-- --------------------------------------------------------

--
-- Structure de la table `params`
--

CREATE TABLE `params` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `valeur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `params`
--

INSERT INTO `params` (`id`, `nom`, `description`, `valeur`) VALUES
(1, 'annee-actuelle', NULL, '2022-2023');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accesscontrol`
--
ALTER TABLE `accesscontrol`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `annees_scolaires`
--
ALTER TABLE `annees_scolaires`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `periode` (`libelle`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classes_ibfk_1` (`id_niveau`);

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `telephone` (`telephone`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `telephone` (`telephone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `groupes_disciplines`
--
ALTER TABLE `groupes_disciplines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `id_eleve` (`id_eleve`),
  ADD KEY `id_annee` (`id_annee`);

--
-- Index pour la table `niveaux`
--
ALTER TABLE `niveaux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `params`
--
ALTER TABLE `params`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accesscontrol`
--
ALTER TABLE `accesscontrol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `annees_scolaires`
--
ALTER TABLE `annees_scolaires`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `groupes_disciplines`
--
ALTER TABLE `groupes_disciplines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `niveaux`
--
ALTER TABLE `niveaux`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `params`
--
ALTER TABLE `params`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`id_niveau`) REFERENCES `niveaux` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_2` FOREIGN KEY (`id_eleve`) REFERENCES `eleves` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_3` FOREIGN KEY (`id_annee`) REFERENCES `annees_scolaires` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
