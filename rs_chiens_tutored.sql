-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 27 fév. 2020 à 21:43
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `rs_chiens_tutored`
--

-- --------------------------------------------------------

--
-- Structure de la table `chiots`
--

DROP TABLE IF EXISTS `chiots`;
CREATE TABLE IF NOT EXISTS `chiots` (
  `idChiot` int(11) NOT NULL,
  PRIMARY KEY (`idChiot`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chiots`
--

INSERT INTO `chiots` (`idChiot`) VALUES
(1),
(2),
(3),
(4),
(5);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `idComment` int(11) NOT NULL,
  `txtComment` text NOT NULL,
  `idChiotAuteur` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  `dateComment` date NOT NULL,
  PRIMARY KEY (`idComment`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`idComment`, `txtComment`, `idChiotAuteur`, `idPost`, `dateComment`) VALUES
(1, 'Enorme !', 4, 1, '2020-02-11'),
(2, 'Trop bien', 5, 1, '2020-02-11'),
(3, 'Cool', 2, 1, '2020-02-12'),
(4, 'J\'aime trop ', 3, 2, '2020-02-13'),
(5, 'Je vous envie ! ', 2, 1, '2020-02-14'),
(6, 'A l\'aise :) !', 1, 2, '2020-02-15'),
(7, 'trop mignon ! ', 4, 3, '2020-02-16'),
(8, 'skuskuuuuu ', 1, 3, '2020-02-04'),
(9, 'woouhhouuuu', 2, 3, '2020-02-06'),
(10, 'Ah oui oui ', 5, 4, '2020-02-05'),
(11, 'La classe a dallas ! ', 3, 4, '2020-02-07'),
(12, 'Content que ça se passe bien :) ', 2, 4, '2020-02-10'),
(13, 'Ouaaaah ', 1, 5, '2020-02-11'),
(14, 'OKLM ', 2, 5, '2020-02-09'),
(15, 'Cool ', 3, 5, '2020-02-12');

-- --------------------------------------------------------

--
-- Structure de la table `imagepost`
--

DROP TABLE IF EXISTS `imagepost`;
CREATE TABLE IF NOT EXISTS `imagepost` (
  `idImage` int(11) NOT NULL,
  `urlImage1` varchar(40) NOT NULL,
  `urlImage2` varchar(40) NOT NULL,
  `urlImage3` varchar(40) NOT NULL,
  `urlImage4` varchar(40) NOT NULL,
  PRIMARY KEY (`idImage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `imagepost`
--

INSERT INTO `imagepost` (`idImage`, `urlImage1`, `urlImage2`, `urlImage3`, `urlImage4`) VALUES
(1, 'img/chiot1_1', '', '', ''),
(2, 'img/chiot2_1', '', '', ''),
(3, 'img/chiot3_1', '', '', ''),
(4, 'img/chiot4_1', '', '', ''),
(5, 'img/chiot1_2', '', '', ''),
(6, 'uploads/chiot5_2.jpg', '', '', ''),
(7, 'uploads/chiot2_0.jpg', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `idPost` int(11) NOT NULL,
  `txtPost` text NOT NULL,
  `idImageAssoc` int(11) NOT NULL,
  `idChiot` int(11) NOT NULL,
  `datePost` date NOT NULL,
  PRIMARY KEY (`idPost`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`idPost`, `txtPost`, `idImageAssoc`, `idChiot`, `datePost`) VALUES
(1, 'Philou se sent tr&egrave;s bien dans sa nouvelle famille! Gros bisous de sa part :)', 1, 1, '2020-01-02'),
(2, 'Volt se familiarise d&eacute;j&agrave; avec notre chat Tesla, que de bonheur ! Nous pensons &agrave; prendre un hamster et le nommer Amp&egrave;re hahaha \r\nGros bisous !  ', 2, 2, '2020-01-15'),
(3, 'Coucou de la part de Rex et son nouveau jouet pr&eacute;f&eacute;r&eacute; ! Pouet Pouet !!! :D ', 3, 3, '2020-02-01'),
(4, 'Le dressage de Sacha a commenc&eacute; hier, il conna&icirc;t d&eacute;j&agrave; plein de nouveaux tours ! Sacha donne la patte ! haha ', 4, 4, '2020-02-12'),
(5, 'Philou dort comme un lard ! hahaha bonne nuit tout le monde ! ', 5, 1, '2020-02-10'),
(6, 'BONJOUR A TOUS, fin de transmianfoznaozmd', 6, 5, '2020-02-25'),
(7, 'OUAAAAAIS ', 7, 2, '2020-02-25');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
