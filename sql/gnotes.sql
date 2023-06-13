-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 13 juin 2023 à 11:27
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

INSERT INTO `annees_scolaires` (`id`, `libelle`, `supprime`) VALUES
(1, '2022-2023', 0);

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

INSERT INTO `classes` (`id`, `libelle`, `id_niveau`, `supprime`) VALUES
(26, 'CI', 36, 0),
(27, 'CP', 36, 0),
(28, '6eme', 37, 0),
(29, '5eme', 37, 0);

-- --------------------------------------------------------

--
-- Structure de la table `classes_disciplines`
--

CREATE TABLE `classes_disciplines` (
  `id` int NOT NULL,
  `id_classe` int NOT NULL,
  `id_discipline` int NOT NULL,
  `id_annee` int NOT NULL,
  `max_ressource` float NOT NULL DEFAULT '0',
  `max_examen` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `classes_disciplines`
--

INSERT INTO `classes_disciplines` (`id`, `id_classe`, `id_discipline`, `id_annee`, `max_ressource`, `max_examen`) VALUES
(1, 26, 1, 1, 0, 20),
(2, 26, 3, 1, 0, 20),
(3, 29, 4, 1, 20, 20),
(4, 29, 6, 1, 10, 20),
(5, 29, 9, 1, 20, 20),
(6, 28, 9, 1, 10, 20),
(7, 28, 6, 1, 10, 20),
(8, 28, 10, 1, 10, 20),
(9, 27, 10, 1, 10, 0);

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
  `id_groupe` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `disciplines`
--

INSERT INTO `disciplines` (`id`, `id_groupe`, `nom`, `code`) VALUES
(1, 1, 'ALGEBRE', 'ALG'),
(3, 1, 'MATHEMATIQUES', 'MAT'),
(4, 3, 'FRANCAIS', 'FRA'),
(6, 3, 'VOCABULAIRE', 'VOC'),
(9, 3, 'GRAMMAIRE', 'GRA'),
(10, 1, 'ARITHMETIQUE', 'ARI');

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

INSERT INTO `eleves` (`id`, `numero`, `type`, `supprime`, `prenom`, `nom`, `telephone`, `adresse`, `email`, `naissance`) VALUES
(26, 4420, 'externe', 0, 'Ibrahima', 'Sylla', '785354479', 'Sicap Mbao Villa N?336', 'isyll711@gmail.com', '1999-11-04'),
(27, 9044, 'externe', 0, 'Assane', 'Ba', NULL, NULL, NULL, NULL),
(28, 4678, 'interne', 0, 'Abdou', 'Bodian', NULL, NULL, NULL, '2023-06-01'),
(29, NULL, 'externe', 0, 'Amadou', 'Ba', NULL, NULL, NULL, '2023-05-31'),
(30, 146, 'interne', 0, 'Aliou', 'Ba', NULL, NULL, 'jay@gm.com', '2023-06-09'),
(31, 4695, 'externe', 0, 'Samori', 'Samb', NULL, NULL, 'emxample@gmail.com', '2023-06-09'),
(32, 80, 'externe', 0, 'Jason', 'Brown', NULL, NULL, 'odin@nido.com', '2023-06-09'),
(33, 9001, 'externe', 0, 'Benoit', 'Prism', NULL, NULL, NULL, '2023-06-15');

-- --------------------------------------------------------

--
-- Structure de la table `groupes_disciplines`
--

CREATE TABLE `groupes_disciplines` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `supprime` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `groupes_disciplines`
--

INSERT INTO `groupes_disciplines` (`id`, `nom`, `supprime`) VALUES
(1, 'MATHEMATIQUES', 0),
(2, 'ACTIVITES NUMERIQUES', 0),
(3, 'LANGUES ET COMUNICATION', 0);

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

INSERT INTO `inscriptions` (`id`, `id_eleve`, `id_classe`, `id_annee`) VALUES
(18, 26, 26, 1),
(19, 27, 26, 1),
(20, 28, 29, 1),
(21, 29, 29, 1),
(22, 30, 26, 1),
(23, 31, 26, 1),
(24, 32, 26, 1),
(25, 33, 26, 1);

-- --------------------------------------------------------

--
-- Structure de la table `niveaux`
--

CREATE TABLE `niveaux` (
  `id` int NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `supprime` tinyint(1) NOT NULL DEFAULT '0',
  `nom_cycle` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `nb_cycles` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `niveaux`
--

INSERT INTO `niveaux` (`id`, `libelle`, `supprime`, `nom_cycle`, `nb_cycles`) VALUES
(36, 'Elementaire', 0, 'Trimestre', 3),
(37, 'Secondaire', 0, 'Semestre', 2),
(38, 'Ed', 1, 'Edede', 12);

-- --------------------------------------------------------

--
-- Structure de la table `notes_eleves`
--

CREATE TABLE `notes_eleves` (
  `id` int NOT NULL,
  `id_cd` int NOT NULL,
  `id_insc` int NOT NULL,
  `cycle` int NOT NULL,
  `type_note` varchar(255) NOT NULL,
  `note` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `notes_eleves`
--

INSERT INTO `notes_eleves` (`id`, `id_cd`, `id_insc`, `cycle`, `type_note`, `note`) VALUES
(1, 3, 20, 1, 'ressource', 18.93),
(2, 3, 21, 1, 'ressource', 11.95),
(3, 4, 21, 1, 'ressource', 0),
(4, 4, 20, 1, 'ressource', 17.63),
(5, 5, 20, 1, 'ressource', 18.0067),
(6, 5, 21, 1, 'ressource', 14.44),
(7, 3, 20, 2, 'examen', 11.22);

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
-- Index pour la table `classes_disciplines`
--
ALTER TABLE `classes_disciplines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `id_discipline` (`id_discipline`),
  ADD KEY `id_annee` (`id_annee`);

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
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `id_groupe` (`id_groupe`);

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
-- Index pour la table `notes_eleves`
--
ALTER TABLE `notes_eleves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cd` (`id_cd`),
  ADD KEY `id_insc` (`id_insc`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `classes_disciplines`
--
ALTER TABLE `classes_disciplines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `groupes_disciplines`
--
ALTER TABLE `groupes_disciplines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `niveaux`
--
ALTER TABLE `niveaux`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `notes_eleves`
--
ALTER TABLE `notes_eleves`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Contraintes pour la table `classes_disciplines`
--
ALTER TABLE `classes_disciplines`
  ADD CONSTRAINT `classes_disciplines_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_disciplines_ibfk_2` FOREIGN KEY (`id_discipline`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_disciplines_ibfk_3` FOREIGN KEY (`id_annee`) REFERENCES `annees_scolaires` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `disciplines`
--
ALTER TABLE `disciplines`
  ADD CONSTRAINT `disciplines_ibfk_1` FOREIGN KEY (`id_groupe`) REFERENCES `groupes_disciplines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_2` FOREIGN KEY (`id_eleve`) REFERENCES `eleves` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_3` FOREIGN KEY (`id_annee`) REFERENCES `annees_scolaires` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notes_eleves`
--
ALTER TABLE `notes_eleves`
  ADD CONSTRAINT `notes_eleves_ibfk_1` FOREIGN KEY (`id_cd`) REFERENCES `classes_disciplines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notes_eleves_ibfk_2` FOREIGN KEY (`id_insc`) REFERENCES `inscriptions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
