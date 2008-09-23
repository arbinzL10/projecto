-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 19 Août 2008 à 19:53
-- Version du serveur: 5.0.51
-- Version de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `jeu`
--

-- --------------------------------------------------------

--
-- Structure de la table `batiments`
--

CREATE TABLE `batiments` (
  `id` int(10) unsigned NOT NULL default '0',
  `nom` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `cout_or` int(11) default NULL,
  `cout_bois` int(11) NOT NULL default '0',
  `cout_pierre` int(11) NOT NULL default '0',
  `cout_gemme` int(11) NOT NULL default '0',
  `cout_cristaux` int(11) NOT NULL default '0',
  `cout_souffre` int(11) NOT NULL default '0',
  `pv` int(10) unsigned zerofill default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `batiments`
--

INSERT INTO `batiments` (`id`, `nom`, `description`, `cout_or`, `cout_bois`, `cout_pierre`, `cout_gemme`, `cout_cristaux`, `cout_souffre`, `pv`) VALUES
(1, 'forge', 'zerze', 12, 200, 200, 0, 0, 0, NULL),
(2, 'marché', 'sdfs', 30, 100, 200, 2, 1, 5, NULL),
(3, 'bastille', NULL, 20, 200, 1000, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE `joueurs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pseudo` varchar(255) NOT NULL default '',
  `pass` varchar(255) default NULL,
  `mail` varchar(255) NOT NULL default 'admin@jeu.fr',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `joueurs`
--

INSERT INTO `joueurs` (`id`, `pseudo`, `pass`, `mail`) VALUES
(1, 'silk', '720849fc17227e95cdf7d76c838c00a7', 'hkoruuu@hotmail.fr'),
(2, 'Silk2', '2a7623888beaf5394c394a87f9226c03', 'hkoruu@hotmail.fr'),
(3, 'poeut', '8042cf2f132b1f15d82aa053bbe81571', 'azraz@zerzr.fr');

-- --------------------------------------------------------

--
-- Structure de la table `map`
--

CREATE TABLE `map` (
  `id` int(11) NOT NULL auto_increment,
  `joueur_id` int(11) NOT NULL default '0',
  `name` varchar(255) default NULL,
  `path` varchar(255) default NULL,
  `x` int(11) NOT NULL default '0',
  `y` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='table contenant les maps des joueurs généré auto à la cr' AUTO_INCREMENT=4 ;

--
-- Contenu de la table `map`
--

INSERT INTO `map` (`id`, `joueur_id`, `name`, `path`, `x`, `y`) VALUES
(1, 1, 'table ovale', 'C:/Program Files/EasyPHP1-8/www/ressources/table ovale.png', 1, 0),
(2, 2, 'POUET', 'C:/Program Files/EasyPHP1-8/www/ressources/POUET.png', 2, 0),
(3, 3, 'zer', 'C:/Program Files/EasyPHP1-8/www/ressources/zer.png', 2, -1);

-- --------------------------------------------------------

--
-- Structure de la table `possession_bat`
--

CREATE TABLE `possession_bat` (
  `id_joueur` int(10) unsigned NOT NULL default '0',
  `id_batiment` int(10) unsigned NOT NULL default '0',
  `nombre` int(10) unsigned zerofill default '0000000000',
  `x` int(11) default '0',
  `y` int(11) default '0',
  PRIMARY KEY  (`id_joueur`,`id_batiment`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `possession_bat`
--

INSERT INTO `possession_bat` (`id_joueur`, `id_batiment`, `nombre`, `x`, `y`) VALUES
(7, 1, 0000000000, 0, 0),
(7, 0, 0000000000, 0, 0),
(0, 1, 0000000000, 0, 0),
(0, 2, 0000000000, 0, 0),
(1, 2, 0000000000, 0, 0),
(1, 1, 0000000003, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `possession_ressources`
--

CREATE TABLE `possession_ressources` (
  `joueur_id` int(10) unsigned NOT NULL default '0',
  `ressources_id` int(10) unsigned NOT NULL default '0',
  `nombre` int(10) unsigned zerofill default NULL,
  PRIMARY KEY  (`joueur_id`,`ressources_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `possession_ressources`
--

INSERT INTO `possession_ressources` (`joueur_id`, `ressources_id`, `nombre`) VALUES
(1, 1, 0000099864),
(1, 2, 0000054885),
(1, 3, 0000043844),
(1, 4, 0000004996),
(1, 5, 0000003464),
(1, 6, 0000000198);

-- --------------------------------------------------------

--
-- Structure de la table `possession_unit`
--

CREATE TABLE `possession_unit` (
  `joueur_id` int(10) unsigned NOT NULL default '0',
  `unites_id` int(10) unsigned NOT NULL default '0',
  `nombre` int(10) unsigned zerofill default NULL,
  `x` int(11) default '0',
  `y` int(11) default '0',
  PRIMARY KEY  (`joueur_id`,`unites_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `possession_unit`
--

INSERT INTO `possession_unit` (`joueur_id`, `unites_id`, `nombre`, `x`, `y`) VALUES
(0, 0, 0000000002, 0, 0),
(0, 1, 0000000000, 0, 0),
(1, 1, 0000000002, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ressources`
--

CREATE TABLE `ressources` (
  `id` int(10) unsigned NOT NULL default '0',
  `nom` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ressources`
--

INSERT INTO `ressources` (`id`, `nom`, `description`) VALUES
(1, 'Or', NULL),
(2, 'Bois', NULL),
(3, 'Pierre', NULL),
(4, 'Cristaux', NULL),
(5, 'Gemmes', NULL),
(6, 'Souffre', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tiles`
--

CREATE TABLE `tiles` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) default NULL,
  `type` varchar(255) default NULL,
  `passthru` binary(1) NOT NULL default '0',
  `path` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `tiles`
--


-- --------------------------------------------------------

--
-- Structure de la table `unites`
--

CREATE TABLE `unites` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `cout_or` int(11) default NULL,
  `cout_bois` int(11) NOT NULL default '0',
  `cout_pierre` int(11) NOT NULL default '0',
  `cout_gemme` int(11) NOT NULL default '0',
  `cout_cristaux` int(11) NOT NULL default '0',
  `cout_souffre` int(11) NOT NULL default '0',
  `attaque` int(11) unsigned zerofill default NULL,
  `portee` int(11) unsigned zerofill default NULL,
  `pv` int(11) unsigned zerofill default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `unites`
--

INSERT INTO `unites` (`id`, `nom`, `description`, `cout_or`, `cout_bois`, `cout_pierre`, `cout_gemme`, `cout_cristaux`, `cout_souffre`, `attaque`, `portee`, `pv`) VALUES
(1, 'guerrier squellette', 'grosse dobe', 50, 35, 0, 2, 1, 1, 00000000005, 00000000001, 00000000003),
(2, 'troll', 'gros bourrin', 500, 300, 50, 0, 1, 2, 00000000050, 00000000001, 00000000100);
