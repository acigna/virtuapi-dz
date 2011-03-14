-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 14 Mars 2011 à 10:09
-- Version du serveur: 5.1.30
-- Version de PHP: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `oms`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE IF NOT EXISTS `administrateur` (
  `IdAdministrateur` int(70) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IdAdministrateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `annee`
--

CREATE TABLE IF NOT EXISTS `annee` (
  `Id` int(4) NOT NULL AUTO_INCREMENT,
  `NomAnnee` varchar(255) NOT NULL DEFAULT '',
  `IdSpecialite` int(11) NOT NULL DEFAULT '0',
  `TimeStampAjout` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNIQUE` (`NomAnnee`,`IdSpecialite`),
  KEY `INDEX` (`IdSpecialite`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `chapitre`
--

CREATE TABLE IF NOT EXISTS `chapitre` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `NumChapitre` tinyint(4) NOT NULL DEFAULT '0',
  `NomChapitre` varchar(255) NOT NULL DEFAULT '',
  `IdModule` int(11) NOT NULL DEFAULT '0',
  `TimeStampAjout` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNIQUE` (`NumChapitre`,`IdModule`),
  KEY `INDEX` (`IdModule`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=123 ;

-- --------------------------------------------------------

--
-- Structure de la table `contacteznous`
--

CREATE TABLE IF NOT EXISTS `contacteznous` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) NOT NULL DEFAULT '',
  `EMail` varchar(50) NOT NULL DEFAULT '',
  `Telephone` varchar(40) NOT NULL DEFAULT '',
  `Objet` varchar(80) NOT NULL DEFAULT '',
  `Message` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE IF NOT EXISTS `cours` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdChapitre` int(11) NOT NULL DEFAULT '0',
  `Type` varchar(7) NOT NULL DEFAULT '',
  `IdPubliant` int(11) NOT NULL DEFAULT '0',
  `TypeFichier` varchar(4) NOT NULL DEFAULT '',
  `TimeStampPub` int(10) NOT NULL DEFAULT '0',
  `TimeStampDernModif` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNIQUE` (`IdChapitre`,`Type`),
  KEY `INDEX` (`IdPubliant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Structure de la table `coursamoderer`
--

CREATE TABLE IF NOT EXISTS `coursamoderer` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdChapitre` int(11) NOT NULL DEFAULT '0',
  `Type` varchar(7) NOT NULL DEFAULT '',
  `IdPubliant` int(11) NOT NULL DEFAULT '0',
  `TypeFichier` varchar(4) NOT NULL DEFAULT '',
  `TimeStampModeration` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`),
  KEY `INDEX` (`IdChapitre`),
  KEY `INDEX2` (`IdPubliant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Pseudo` varchar(50) NOT NULL DEFAULT '',
  `Nom` varchar(50) NOT NULL DEFAULT '',
  `Prenom` varchar(50) NOT NULL DEFAULT '',
  `TypeMembre` varchar(10) NOT NULL DEFAULT '',
  `EMail` varchar(50) NOT NULL DEFAULT '',
  `MotDePasse` varchar(255) NOT NULL DEFAULT '',
  `TimeStampInscrit` int(10) NOT NULL DEFAULT '0',
  `DernEssai` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNIQUE` (`Pseudo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Structure de la table `moderateur`
--

CREATE TABLE IF NOT EXISTS `moderateur` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdModerateur` int(11) NOT NULL DEFAULT '0',
  `IdSpecialite` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNIQUE` (`IdModerateur`,`IdSpecialite`),
  KEY `INDEX` (`IdSpecialite`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `NomModule` varchar(255) NOT NULL DEFAULT '',
  `IdAnnee` int(4) NOT NULL DEFAULT '0',
  `TimeStampAjout` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNIQUE` (`IdAnnee`,`NomModule`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL DEFAULT '',
  `contenu` text NOT NULL,
  `actif` tinyint(4) NOT NULL DEFAULT '0',
  `timestamp` bigint(20) NOT NULL DEFAULT '0',
  KEY `id` (`id_news`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

CREATE TABLE IF NOT EXISTS `specialite` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `NomSpecialite` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `TimeStampAjout` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNIQUE` (`NomSpecialite`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `sujets`
--

CREATE TABLE IF NOT EXISTS `sujets` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdModule` int(11) NOT NULL DEFAULT '0',
  `Type` varchar(8) NOT NULL DEFAULT '',
  `NumSujet` tinyint(4) NOT NULL DEFAULT '0',
  `TypeExam` varchar(10) NOT NULL DEFAULT '',
  `AnneeUniv` varchar(9) NOT NULL DEFAULT '',
  `IdPubliant` int(11) NOT NULL DEFAULT '0',
  `TypeFichier` varchar(4) NOT NULL DEFAULT '',
  `TimeStampPub` int(10) NOT NULL DEFAULT '0',
  `TimeStampDernModif` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNIQUE` (`IdModule`,`Type`,`NumSujet`,`TypeExam`,`AnneeUniv`),
  KEY `INDEX` (`IdPubliant`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

-- --------------------------------------------------------

--
-- Structure de la table `sujetsamoderer`
--

CREATE TABLE IF NOT EXISTS `sujetsamoderer` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdModule` int(11) NOT NULL DEFAULT '0',
  `Type` varchar(8) NOT NULL DEFAULT '',
  `NumSujet` tinyint(4) DEFAULT NULL,
  `TypeExam` varchar(10) NOT NULL DEFAULT '',
  `AnneeUniv` varchar(9) NOT NULL DEFAULT '',
  `IdPubliant` int(11) NOT NULL DEFAULT '0',
  `TypeFichier` varchar(4) NOT NULL DEFAULT '',
  `TimeStampModeration` int(11) NOT NULL DEFAULT '0',
  `NouvelleVersion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `INDEX` (`IdModule`),
  KEY `INDEX2` (`IdPubliant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `td`
--

CREATE TABLE IF NOT EXISTS `td` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdChapitre` int(11) NOT NULL DEFAULT '0',
  `Type` varchar(8) NOT NULL DEFAULT '',
  `NumSerie` tinyint(4) NOT NULL DEFAULT '0',
  `IdPubliant` int(11) NOT NULL DEFAULT '0',
  `TypeFichier` varchar(4) NOT NULL DEFAULT '',
  `TimeStampPub` int(10) NOT NULL DEFAULT '0',
  `TimeStampDernModif` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNIQUE` (`IdChapitre`,`Type`,`NumSerie`),
  KEY `INDEX` (`IdPubliant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tdamoderer`
--

CREATE TABLE IF NOT EXISTS `tdamoderer` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdChapitre` varchar(11) NOT NULL DEFAULT '',
  `Type` varchar(8) NOT NULL DEFAULT '',
  `NumSerie` tinyint(4) NOT NULL DEFAULT '0',
  `IdPubliant` int(11) NOT NULL DEFAULT '0',
  `TypeFichier` varchar(4) NOT NULL DEFAULT '',
  `TimeStampModeration` int(10) NOT NULL DEFAULT '0',
  `NouvelleVersion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `INDEX` (`IdChapitre`),
  KEY `INDEX2` (`IdPubliant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tp`
--

CREATE TABLE IF NOT EXISTS `tp` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Intitule` varchar(255) NOT NULL DEFAULT '',
  `IdModule` int(11) NOT NULL DEFAULT '0',
  `Type` varchar(8) NOT NULL DEFAULT '',
  `NumTP` tinyint(4) NOT NULL DEFAULT '0',
  `IdPubliant` int(11) NOT NULL DEFAULT '0',
  `TypeFichier` varchar(4) NOT NULL DEFAULT '',
  `TimeStampPub` int(10) NOT NULL DEFAULT '0',
  `TimeStampDernModif` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNIQUE` (`IdModule`,`Type`,`NumTP`),
  KEY `INDEX` (`IdPubliant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tpamoderer`
--

CREATE TABLE IF NOT EXISTS `tpamoderer` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Intitule` varchar(255) NOT NULL DEFAULT '',
  `IdModule` int(11) NOT NULL DEFAULT '0',
  `Type` varchar(8) NOT NULL DEFAULT '',
  `NumTP` tinyint(4) NOT NULL DEFAULT '0',
  `IdPubliant` int(11) NOT NULL DEFAULT '0',
  `TypeFichier` varchar(4) NOT NULL DEFAULT '',
  `TimeStampModeration` int(10) NOT NULL DEFAULT '0',
  `NouvelleVersion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `INDEX` (`IdModule`),
  KEY `INDEX2` (`IdPubliant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD CONSTRAINT `administrateur_ibfk_1` FOREIGN KEY (`IdAdministrateur`) REFERENCES `membre` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `annee`
--
ALTER TABLE `annee`
  ADD CONSTRAINT `annee_ibfk_1` FOREIGN KEY (`IdSpecialite`) REFERENCES `specialite` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `chapitre`
--
ALTER TABLE `chapitre`
  ADD CONSTRAINT `chapitre_ibfk_1` FOREIGN KEY (`IdModule`) REFERENCES `module` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `cours_ibfk_3` FOREIGN KEY (`IdChapitre`) REFERENCES `chapitre` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cours_ibfk_4` FOREIGN KEY (`IdPubliant`) REFERENCES `membre` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `coursamoderer`
--
ALTER TABLE `coursamoderer`
  ADD CONSTRAINT `coursamoderer_ibfk_3` FOREIGN KEY (`IdChapitre`) REFERENCES `chapitre` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `coursamoderer_ibfk_4` FOREIGN KEY (`IdPubliant`) REFERENCES `membre` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `moderateur`
--
ALTER TABLE `moderateur`
  ADD CONSTRAINT `moderateur_ibfk_3` FOREIGN KEY (`IdModerateur`) REFERENCES `membre` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `moderateur_ibfk_4` FOREIGN KEY (`IdSpecialite`) REFERENCES `specialite` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`IdAnnee`) REFERENCES `annee` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sujets`
--
ALTER TABLE `sujets`
  ADD CONSTRAINT `sujets_ibfk_3` FOREIGN KEY (`IdModule`) REFERENCES `module` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sujets_ibfk_4` FOREIGN KEY (`IdPubliant`) REFERENCES `membre` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `sujetsamoderer`
--
ALTER TABLE `sujetsamoderer`
  ADD CONSTRAINT `sujetsamoderer_ibfk_3` FOREIGN KEY (`IdModule`) REFERENCES `module` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sujetsamoderer_ibfk_4` FOREIGN KEY (`IdPubliant`) REFERENCES `membre` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `td`
--
ALTER TABLE `td`
  ADD CONSTRAINT `td_ibfk_3` FOREIGN KEY (`IdChapitre`) REFERENCES `chapitre` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `td_ibfk_4` FOREIGN KEY (`IdPubliant`) REFERENCES `membre` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tdamoderer`
--
ALTER TABLE `tdamoderer`
  ADD CONSTRAINT `tdamoderer_ibfk_1` FOREIGN KEY (`IdPubliant`) REFERENCES `membre` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tp`
--
ALTER TABLE `tp`
  ADD CONSTRAINT `tp_ibfk_3` FOREIGN KEY (`IdModule`) REFERENCES `module` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tp_ibfk_4` FOREIGN KEY (`IdPubliant`) REFERENCES `membre` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tpamoderer`
--
ALTER TABLE `tpamoderer`
  ADD CONSTRAINT `tpamoderer_ibfk_5` FOREIGN KEY (`IdModule`) REFERENCES `module` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tpamoderer_ibfk_6` FOREIGN KEY (`IdPubliant`) REFERENCES `membre` (`Id`) ON UPDATE CASCADE;
