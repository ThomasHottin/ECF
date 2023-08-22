-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 04 août 2023 à 12:02
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `type_etoiles`
--

-- --------------------------------------------------------

--
-- Structure de la table `etoiles`
--

CREATE TABLE `etoiles` (
  `id_etoile` int(11) NOT NULL,
  `type_etoile` varchar(100) DEFAULT NULL,
  `descriptif_etoile` varchar(300) DEFAULT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `etoiles`
--

INSERT INTO `etoiles` (`id_etoile`, `type_etoile`, `descriptif_etoile`, `image`) VALUES
(1, 'Étoile à neutrons', 'Étoiles massives au cœur effondré, parmi les plus chaudes de l\'univers, brillant intensément d\'une lueur incandescente.', ''),
(2, 'Naine brune', 'Des étoiles ratées, trop petites pour allumer des feux nucléaires, émettant une lueur discrète et douce.', ''),
(3, 'Naine blanche', 'Les vestiges éteints d\'étoiles de faible masse, éclairant l\'espace d\'une douce lumière blanche.', ''),
(4, 'Naine rouge', 'Les étoiles les plus courantes de l\'univers, modestes en taille, émettant une lueur rougeâtre et apaisante.', ''),
(5, 'Étoile de type solaire', 'Des étoiles comme notre Soleil, dégageant une lumière blanche ou jaune équilibrée et familière.', ''),
(6, 'Géante rouge', 'Étoiles évoluées, ayant épuisé leur hydrogène, devenues énormes et d\'une lueur rouge éblouissante.', ''),
(7, 'Géante bleue', 'D\'une taille impressionnante, ces étoiles massives illuminent l\'univers d\'une splendeur bleue éclatante.', ''),
(8, 'Supergéante bleue', 'Les mastodontes de l\'espace, parmi les étoiles les plus chaudes et les plus lumineuses, rayonnant d\'une lueur bleue ardente.', ''),
(9, 'Supergéante rouge', 'Les plus grandes étoiles connues, en fin de vie, émettant une lumière rouge intense et magnétique.', '');

-- --------------------------------------------------------

--
-- Structure de la table `tailles`
--

CREATE TABLE `tailles` (
  `id_taille` int(11) NOT NULL,
  `taille` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `tailles`
--

INSERT INTO `tailles` (`id_taille`, `taille`) VALUES
(1, 'Environ 10 kilomètres de diamètre'),
(2, 'Environ 0,01 à 0,1 fois le rayon du Soleil'),
(3, 'Environ 0,01 à 0,1 fois le rayon du Soleil'),
(4, 'Environ 0,1 à 0,5 fois le rayon du Soleil'),
(5, 'Le rayon du Soleil est d\'environ 696 340 kilomètres'),
(6, 'Environ 1 à 10 fois le rayon du Soleil'),
(7, 'Environ 5 à 20 fois le rayon du Soleil'),
(8, 'Environ 10 à 50 fois le rayon du Soleil'),
(9, 'Environ 100 à 1 000 fois le rayon du Soleil');

-- --------------------------------------------------------

--
-- Structure de la table `temperatures`
--

CREATE TABLE `temperatures` (
  `id_temperature` int(11) NOT NULL,
  `temperature` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `temperatures`
--

INSERT INTO `temperatures` (`id_temperature`, `temperature`) VALUES
(1, 1000000000),
(2, 2000),
(3, 12000),
(4, 2500),
(5, 5500),
(6, 3200),
(7, 20000),
(8, 35000),
(9, 3500);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `pseudo` varchar(100) DEFAULT NULL,
  `mdp` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `etoiles`
--
ALTER TABLE `etoiles`
  ADD PRIMARY KEY (`id_etoile`);

--
-- Index pour la table `tailles`
--
ALTER TABLE `tailles`
  ADD PRIMARY KEY (`id_taille`);

--
-- Index pour la table `temperatures`
--
ALTER TABLE `temperatures`
  ADD PRIMARY KEY (`id_temperature`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `etoiles`
--
ALTER TABLE `etoiles`
  MODIFY `id_etoile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `tailles`
--
ALTER TABLE `tailles`
  MODIFY `id_taille` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `temperatures`
--
ALTER TABLE `temperatures`
  MODIFY `id_temperature` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35001;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
