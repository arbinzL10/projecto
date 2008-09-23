-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 14 Août 2008 à 11:44
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
  `cout_bois` int(11) NOT NULL,
  `cout_pierre` int(11) NOT NULL,
  `cout_gemme` int(11) NOT NULL,
  `cout_cristaux` int(11) NOT NULL,
  `cout_souffre` int(11) NOT NULL,
  `pv` int(10) unsigned zerofill default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `batiments`
--

INSERT INTO `batiments` (`id`, `nom`, `description`, `cout_or`, `cout_bois`, `cout_pierre`, `cout_gemme`, `cout_cristaux`, `cout_souffre`, `pv`) VALUES
(0, 'chateau', NULL, 1000, 500, 600, 0, 0, 0, 0000000500),
(2, 'caserne', NULL, 500, 200, 230, 0, 0, 0, 0000000200),
(1, 'forge', 'c''est une forge', 300, 0, 150, 0, 0, 0, 0000000100);

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE `joueurs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pseudo` varchar(255) NOT NULL default '',
  `pass` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `joueurs`
--

INSERT INTO `joueurs` (`id`, `pseudo`, `pass`) VALUES
(6, 'kirub', 'blabla'),
(7, 'silk', 'lilalice'),
(13, 'sdf', 'sdf'),
(14, 'pouet', 'pouet');

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
(6, 1, 0000000001, 0, 0),
(6, 2, 0000000003, 0, 0),
(7, 2, 0000000027, 0, 0),
(7, 0, 0000000034, 0, 0),
(7, 1, 0000000002, 0, 0);

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
(7, 1, 0000010000),
(7, 2, 0000009000),
(7, 3, 0000007000),
(7, 4, 0000000300),
(7, 5, 0000000500),
(7, 6, 0000000200);

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
(6, 2, 0000000010, 0, 0),
(6, 3, 0000000012, 0, 0),
(7, 2, 0000000131, 0, 0),
(7, 3, 0000000012, 0, 0),
(7, 1, 0000000061, 0, 0);

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
(1, 'or', 'bah.. c''est de l''or'),
(2, 'bois', 'bah.. c''est du bois'),
(3, 'pierre', 'bah.. c''est de la pierre'),
(4, 'gemmes', 'bah.. c''est des gemmes'),
(5, 'cristaux', 'bah.. c''est des cristaux'),
(6, 'souffre', 'bah.. c''est du souffre');

-- --------------------------------------------------------

--
-- Structure de la table `unites`
--

CREATE TABLE `unites` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `cout_or` int(11) default NULL,
  `cout_bois` int(11) NOT NULL,
  `cout_pierre` int(11) NOT NULL,
  `cout_gemme` int(11) NOT NULL,
  `cout_cristaux` int(11) NOT NULL,
  `cout_souffre` int(11) NOT NULL,
  `attaque` int(11) unsigned zerofill default NULL,
  `portee` int(11) unsigned zerofill default NULL,
  `pv` int(11) unsigned zerofill default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `unites`
--

INSERT INTO `unites` (`id`, `nom`, `description`, `cout_or`, `cout_bois`, `cout_pierre`, `cout_gemme`, `cout_cristaux`, `cout_souffre`, `attaque`, `portee`, `pv`) VALUES
(1, 'ouvrier', NULL, 50, 0, 0, 0, 0, 0, 00000000000, 00000000002, 00000000005),
(2, 'guerrier', NULL, 100, 50, 10, 2, 2, 2, 00000000001, 00000000001, 00000000010),
(3, 'archer', NULL, 100, 30, 20, 1, 2, 2, 00000000001, 00000000002, 00000000010);
