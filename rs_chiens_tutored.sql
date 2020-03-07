-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 07 mars 2020 à 22:51
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rs_chiens_tutored`
--

-- --------------------------------------------------------

--
-- Structure de la table `chiots`
--

CREATE TABLE `chiots` (
  `idChiot` int(11) NOT NULL,
  `nomChiot` varchar(32) NOT NULL,
  `sexe` varchar(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chiots`
--

INSERT INTO `chiots` (`idChiot`, `nomChiot`, `sexe`) VALUES
(1, 'Ora', 'F'),
(2, 'Ourson', 'M'),
(3, 'Oups', 'M'),
(4, 'Océane', 'F'),
(5, 'Oupi', 'M'),
(6, 'Oseille', 'F');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `idComment` int(11) NOT NULL,
  `txtComment` text NOT NULL,
  `idChiotAuteur` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  `dateComment` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`idComment`, `txtComment`, `idChiotAuteur`, `idPost`, `dateComment`) VALUES
(1, 'Enorme !', 4, 1, '2020-02-11 22:00:00'),
(2, 'Trop bien', 5, 1, '2020-02-11 19:00:00'),
(3, 'Cool', 2, 1, '2020-02-12 00:21:00'),
(4, 'J\'aime trop ', 3, 2, '2020-02-13 07:30:00'),
(5, 'Je vous envie ! ', 2, 1, '2020-02-14 11:00:00'),
(6, 'A l\'aise :) !', 1, 2, '2020-02-15 00:12:00'),
(7, 'trop mignon ! ', 4, 3, '2020-02-16 10:05:00'),
(8, 'skuskuuuuu ', 1, 3, '2020-02-04 17:03:00'),
(9, 'woouhhouuuu', 2, 3, '2020-02-06 23:02:00'),
(10, 'Ah oui oui ', 5, 4, '2020-02-05 09:09:00'),
(11, 'La classe a dallas ! ', 3, 4, '2020-02-07 10:01:00'),
(12, 'Content que ça se passe bien :) ', 2, 4, '2020-02-10 05:50:00'),
(13, 'Ouaaaah ', 1, 5, '2020-02-11 04:00:00'),
(14, 'OKLM ', 2, 5, '2020-02-09 02:13:00'),
(15, 'Cool ', 3, 5, '2020-02-12 20:40:00'),
(19, 'Ca alors ! ', 4, 4, '2020-03-05 06:00:00'),
(20, 'Magnifique ! ', 3, 5, '2020-03-05 00:00:00'),
(21, 'Super ! ', 4, 3, '2020-03-05 13:10:00'),
(22, 'Salut ! ', 6, 2, '2020-03-05 17:00:00'),
(24, 'mdrr ! ', 3, 26, '2020-03-07 22:50:24'),
(25, 'Mdrrrrrrrr !', 2, 26, '2020-03-07 22:50:35');

-- --------------------------------------------------------

--
-- Structure de la table `imagepost`
--

CREATE TABLE `imagepost` (
  `idImage` int(11) NOT NULL,
  `urlImage1` varchar(40) NOT NULL,
  `urlImage2` varchar(40) NOT NULL,
  `urlImage3` varchar(40) NOT NULL,
  `urlImage4` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `imagepost`
--

INSERT INTO `imagepost` (`idImage`, `urlImage1`, `urlImage2`, `urlImage3`, `urlImage4`) VALUES
(1, 'img/chiot1_1.jpg', 'img/chiot2_1.jpg', 'img/chiot1_2.jpg', 'img/chiot4_1.jpg'),
(2, 'img/chiot2_1.jpg', 'img/chiot4_1.jpg', 'img/chiot2_1.jpg', 'img/chiot3_1.jpg'),
(3, 'img/chiot3_1.jpg', 'img/chiot1_2.jpg', 'img/chiot2_1.jpg', ''),
(4, 'img/chiot4_1.jpg', 'img/chiot3_1.jpg', '', ''),
(5, 'img/chiot1_2.jpg', '', '', ''),
(30, 'uploads/chiot1_0.jpg', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `idPost` int(11) NOT NULL,
  `txtPost` text NOT NULL,
  `idImageAssoc` int(11) NOT NULL,
  `idChiot` int(11) NOT NULL,
  `datePost` datetime NOT NULL,
  `titre` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`idPost`, `txtPost`, `idImageAssoc`, `idChiot`, `datePost`, `titre`) VALUES
(1, 'Philou se sent tr&egrave;s bien dans sa nouvelle famille! Gros bisous de sa part :)', 1, 1, '2020-01-02 10:00:01', 'Famille'),
(2, 'Volt se familiarise d&eacute;j&agrave; avec notre chat Tesla, que de bonheur ! Nous pensons &agrave; prendre un hamster et le nommer Amp&egrave;re hahaha \r\nGros bisous !  ', 2, 2, '2020-01-02 10:00:03', 'Amour entre chien et chat'),
(3, 'Coucou de la part de Rex et son nouveau jouet pr&eacute;f&eacute;r&eacute; ! Pouet Pouet !!! :D ', 3, 3, '2020-02-01 23:00:00', 'Nouveau jouet!'),
(4, 'Le dressage de Sacha a commenc&eacute; hier, il conna&icirc;t d&eacute;j&agrave; plein de nouveaux tours ! Sacha donne la patte ! haha ', 4, 4, '2020-02-12 01:00:00', 'Dressage'),
(5, 'Philou dort comme un lard ! hahaha bonne nuit tout le monde ! ', 5, 1, '2020-02-10 05:45:00', 'Sommeil profond'),
(26, 'Hahah trop drole Ourson ! ', 30, 1, '2020-03-07 00:00:00', 'AAAAAA');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chiots`
--
ALTER TABLE `chiots`
  ADD PRIMARY KEY (`idChiot`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`idComment`);

--
-- Index pour la table `imagepost`
--
ALTER TABLE `imagepost`
  ADD PRIMARY KEY (`idImage`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`idPost`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chiots`
--
ALTER TABLE `chiots`
  MODIFY `idChiot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `idComment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `imagepost`
--
ALTER TABLE `imagepost`
  MODIFY `idImage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `idPost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
