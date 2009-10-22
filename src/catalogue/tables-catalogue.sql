
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;




CREATE TABLE IF NOT EXISTS `annee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idfac-etab` int(11) NOT NULL,
  `numannee` tinyint(4) NOT NULL,
  `idcycle` int(11) NOT NULL,
  `branche` varchar(255) NOT NULL,
  `timestampajout` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `anneeunique` (`idfac-etab`,`numannee`,`idcycle`,`branche`),
  KEY `anneeindex` (`idfac-etab`),
  KEY `cycleindex` (`idcycle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `chapitre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` tinyint(4) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `idmodule` int(11) NOT NULL,
  `timestampajout` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chapitreindex` (`idmodule`,`num`),
  UNIQUE KEY `chapitrenomindex` (`idmodule`,`nom`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `cycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codecycleindex` (`code`),
  UNIQUE KEY `cycleindex` (`code`,`nom`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `etablissement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `abrv` varchar(50) NOT NULL,
  `timestampajout` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nometablissementunique` (`nom`),
  UNIQUE KEY `abrvetablissementunique` (`abrv`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `faculte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `abrv` varchar(50) NOT NULL,
  `timestampajout` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomfaculteunique` (`nom`),
  UNIQUE KEY `abrvfaculteunique` (`abrv`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `faculte-etablissement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idfaculte` int(11) NOT NULL,
  `idetablissement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faculte-etablissementunique` (`idfaculte`,`idetablissement`),
  KEY `faculteindex` (`idfaculte`),
  KEY `etablissementindex` (`idetablissement`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `abrv` varchar(50) NOT NULL,
  `idannee` int(11) NOT NULL,
  `timestampajout` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `moduleunique` (`idannee`,`nom`),
  UNIQUE KEY `abrvmoduleunique` (`idannee`,`abrv`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


ALTER TABLE `annee`
  ADD CONSTRAINT `annee_ibfk_1` FOREIGN KEY (`idfac-etab`) REFERENCES `faculte-etablissement` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `annee_ibfk_2` FOREIGN KEY (`idcycle`) REFERENCES `cycle` (`id`) ON UPDATE CASCADE;

ALTER TABLE `chapitre`
  ADD CONSTRAINT `chapitre_ibfk_1` FOREIGN KEY (`idmodule`) REFERENCES `module` (`id`);

ALTER TABLE `faculte-etablissement`
  ADD CONSTRAINT `faculte@002detablissement_ibfk_3` FOREIGN KEY (`idfaculte`) REFERENCES `faculte` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `faculte@002detablissement_ibfk_4` FOREIGN KEY (`idetablissement`) REFERENCES `etablissement` (`id`) ON UPDATE CASCADE;

ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`idannee`) REFERENCES `annee` (`id`) ON UPDATE CASCADE;
