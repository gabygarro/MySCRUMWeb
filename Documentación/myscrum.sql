-- MySQL dump 10.13  Distrib 5.7.16, for Win64 (x86_64)
--
-- Host: localhost    Database: myscrum
-- ------------------------------------------------------
-- Server version	5.7.16-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `myscrum`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `myscrum` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `myscrum`;

--
-- Table structure for table `estrategiamanejo`
--

DROP TABLE IF EXISTS `estrategiamanejo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estrategiamanejo` (
  `idEstrategiaManejo` int(11) NOT NULL,
  `estrategia` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idEstrategiaManejo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estrategiamanejo`
--

LOCK TABLES `estrategiamanejo` WRITE;
/*!40000 ALTER TABLE `estrategiamanejo` DISABLE KEYS */;
INSERT INTO `estrategiamanejo` VALUES (1,'Evitar'),(2,'Mitigar'),(3,'Transferir'),(4,'Aceptar');
/*!40000 ALTER TABLE `estrategiamanejo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `impacto`
--

DROP TABLE IF EXISTS `impacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `impacto` (
  `idImpacto` int(11) NOT NULL,
  `impacto` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idImpacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `impacto`
--

LOCK TABLES `impacto` WRITE;
/*!40000 ALTER TABLE `impacto` DISABLE KEYS */;
INSERT INTO `impacto` VALUES (1,'Muy bajo'),(2,'Bajo'),(3,'Medio'),(4,'Alto'),(5,'Muy alto');
/*!40000 ALTER TABLE `impacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyecto` (
  `idProyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `duracionSprint` int(11) DEFAULT NULL,
  PRIMARY KEY (`idProyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto`
--

LOCK TABLES `proyecto` WRITE;
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
INSERT INTO `proyecto` VALUES (1,'BN Móvil','Aplicación móvil para trámites bancarios',2);
/*!40000 ALTER TABLE `proyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `release`
--

DROP TABLE IF EXISTS `release`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `release` (
  `idRelease` int(11) NOT NULL AUTO_INCREMENT,
  `numRelease` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`idRelease`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `release`
--

LOCK TABLES `release` WRITE;
/*!40000 ALTER TABLE `release` DISABLE KEYS */;
INSERT INTO `release` VALUES (1,1,'Release 1'),(2,2,'Release 2'),(3,3,'Release 3');
/*!40000 ALTER TABLE `release` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `releasexproyecto`
--

DROP TABLE IF EXISTS `releasexproyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `releasexproyecto` (
  `Proyecto_idProyecto` int(11) NOT NULL,
  `Release_idRelease` int(11) NOT NULL,
  PRIMARY KEY (`Proyecto_idProyecto`,`Release_idRelease`),
  KEY `fk_Proyecto_has_Release_Release1_idx` (`Release_idRelease`),
  KEY `fk_Proyecto_has_Release_Proyecto1_idx` (`Proyecto_idProyecto`),
  CONSTRAINT `fk_Proyecto_has_Release_Proyecto1` FOREIGN KEY (`Proyecto_idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Proyecto_has_Release_Release1` FOREIGN KEY (`Release_idRelease`) REFERENCES `release` (`idRelease`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `releasexproyecto`
--

LOCK TABLES `releasexproyecto` WRITE;
/*!40000 ALTER TABLE `releasexproyecto` DISABLE KEYS */;
INSERT INTO `releasexproyecto` VALUES (1,1),(1,2),(1,3);
/*!40000 ALTER TABLE `releasexproyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riesgo`
--

DROP TABLE IF EXISTS `riesgo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `riesgo` (
  `idRiesgo` int(11) NOT NULL AUTO_INCREMENT,
  `identificador` varchar(6) NOT NULL,
  `descripcionCorta` varchar(200) DEFAULT NULL,
  `descripcionLarga` varchar(500) DEFAULT NULL,
  `probabilidad` float DEFAULT NULL,
  `planAccion` varchar(500) DEFAULT NULL,
  `Stakeholder_responsable` int(11) NOT NULL,
  `EstrategiaManejo_idEstrategiaManejo` int(11) NOT NULL,
  `Impacto_idImpacto` int(11) NOT NULL,
  PRIMARY KEY (`idRiesgo`),
  UNIQUE KEY `identificador_UNIQUE` (`identificador`),
  KEY `fk_Riesgo_Stakeholder1_idx` (`Stakeholder_responsable`),
  KEY `fk_Riesgo_EstrategiaManejo1_idx` (`EstrategiaManejo_idEstrategiaManejo`),
  KEY `fk_Riesgo_Impacto1_idx` (`Impacto_idImpacto`),
  CONSTRAINT `fk_Riesgo_EstrategiaManejo1` FOREIGN KEY (`EstrategiaManejo_idEstrategiaManejo`) REFERENCES `estrategiamanejo` (`idEstrategiaManejo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Riesgo_Impacto1` FOREIGN KEY (`Impacto_idImpacto`) REFERENCES `impacto` (`idImpacto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Riesgo_Stakeholder1` FOREIGN KEY (`Stakeholder_responsable`) REFERENCES `stakeholder` (`idStakeholder`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riesgo`
--

LOCK TABLES `riesgo` WRITE;
/*!40000 ALTER TABLE `riesgo` DISABLE KEYS */;
INSERT INTO `riesgo` VALUES (1,'BNM001','Esta es una descripción corta de un riesgo','Esta es una descripción larga de un riesgo',20,'Este es un plan de acción',1,1,2),(2,'BNM002','Esta es una descripción corta de un riesgo','Esta es una descripción larga de un riesgo',14,'Este es un plan de acción',1,1,1);
/*!40000 ALTER TABLE `riesgo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riesgoxsprint`
--

DROP TABLE IF EXISTS `riesgoxsprint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `riesgoxsprint` (
  `Riesgo_idRiesgo` int(11) NOT NULL,
  `Sprint_idSprint` int(11) NOT NULL,
  PRIMARY KEY (`Riesgo_idRiesgo`,`Sprint_idSprint`),
  KEY `fk_Riesgo_has_Sprint_Sprint1_idx` (`Sprint_idSprint`),
  KEY `fk_Riesgo_has_Sprint_Riesgo1_idx` (`Riesgo_idRiesgo`),
  CONSTRAINT `fk_Riesgo_has_Sprint_Riesgo1` FOREIGN KEY (`Riesgo_idRiesgo`) REFERENCES `riesgo` (`idRiesgo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Riesgo_has_Sprint_Sprint1` FOREIGN KEY (`Sprint_idSprint`) REFERENCES `sprint` (`idSprint`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riesgoxsprint`
--

LOCK TABLES `riesgoxsprint` WRITE;
/*!40000 ALTER TABLE `riesgoxsprint` DISABLE KEYS */;
INSERT INTO `riesgoxsprint` VALUES (1,1),(2,2);
/*!40000 ALTER TABLE `riesgoxsprint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `nombreRol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'SysAdmin'),(2,'Product Owner'),(3,'SCRUM Master'),(4,'Developer / Tester');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scrummeeting`
--

DROP TABLE IF EXISTS `scrummeeting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scrummeeting` (
  `idSCRUMMeeting` int(11) NOT NULL,
  `Sprint_idSprint` int(11) NOT NULL,
  PRIMARY KEY (`idSCRUMMeeting`),
  KEY `fk_SCRUMMeeting_Sprint1_idx` (`Sprint_idSprint`),
  CONSTRAINT `fk_SCRUMMeeting_Sprint1` FOREIGN KEY (`Sprint_idSprint`) REFERENCES `sprint` (`idSprint`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scrummeeting`
--

LOCK TABLES `scrummeeting` WRITE;
/*!40000 ALTER TABLE `scrummeeting` DISABLE KEYS */;
/*!40000 ALTER TABLE `scrummeeting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sprint`
--

DROP TABLE IF EXISTS `sprint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sprint` (
  `idSprint` int(11) NOT NULL AUTO_INCREMENT,
  `numSprint` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idSprint`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sprint`
--

LOCK TABLES `sprint` WRITE;
/*!40000 ALTER TABLE `sprint` DISABLE KEYS */;
INSERT INTO `sprint` VALUES (1,1,'Sprint 1'),(2,2,'Sprint 2'),(3,3,'Sprint 3'),(4,1,'Sprint 1'),(5,2,'Sprint 2'),(6,3,'Sprint 3'),(7,1,'Sprint 1'),(8,2,'Sprint 2'),(9,3,'Sprint 3');
/*!40000 ALTER TABLE `sprint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sprintxrelease`
--

DROP TABLE IF EXISTS `sprintxrelease`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sprintxrelease` (
  `Sprint_idSprint` int(11) NOT NULL,
  `Release_idRelease` int(11) NOT NULL,
  PRIMARY KEY (`Sprint_idSprint`,`Release_idRelease`),
  KEY `fk_Sprint_has_Release_Release1_idx` (`Release_idRelease`),
  KEY `fk_Sprint_has_Release_Sprint1_idx` (`Sprint_idSprint`),
  CONSTRAINT `fk_Sprint_has_Release_Release1` FOREIGN KEY (`Release_idRelease`) REFERENCES `release` (`idRelease`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Sprint_has_Release_Sprint1` FOREIGN KEY (`Sprint_idSprint`) REFERENCES `sprint` (`idSprint`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sprintxrelease`
--

LOCK TABLES `sprintxrelease` WRITE;
/*!40000 ALTER TABLE `sprintxrelease` DISABLE KEYS */;
INSERT INTO `sprintxrelease` VALUES (1,1),(2,1),(3,1),(4,2),(5,2),(6,2),(7,3),(8,3),(9,3);
/*!40000 ALTER TABLE `sprintxrelease` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stakeholder`
--

DROP TABLE IF EXISTS `stakeholder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stakeholder` (
  `idStakeholder` int(11) NOT NULL AUTO_INCREMENT,
  `interes` tinyint(1) DEFAULT NULL,
  `poder` tinyint(1) DEFAULT NULL,
  `expectativa` varchar(200) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `rol` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idStakeholder`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stakeholder`
--

LOCK TABLES `stakeholder` WRITE;
/*!40000 ALTER TABLE `stakeholder` DISABLE KEYS */;
INSERT INTO `stakeholder` VALUES (1,1,1,'Que el proyecto sea culminado lo más antes posible','fwalker@bncr.fi.cr','Fabricio','Walker','Product Owner');
/*!40000 ALTER TABLE `stakeholder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stakeholderxproyecto`
--

DROP TABLE IF EXISTS `stakeholderxproyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stakeholderxproyecto` (
  `Stakeholder_idStakeholder` int(11) NOT NULL,
  `Proyecto_idProyecto` int(11) NOT NULL,
  PRIMARY KEY (`Stakeholder_idStakeholder`,`Proyecto_idProyecto`),
  KEY `fk_Stakeholder_has_Proyecto_Proyecto1_idx` (`Proyecto_idProyecto`),
  KEY `fk_Stakeholder_has_Proyecto_Stakeholder1_idx` (`Stakeholder_idStakeholder`),
  CONSTRAINT `fk_Stakeholder_has_Proyecto_Proyecto1` FOREIGN KEY (`Proyecto_idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Stakeholder_has_Proyecto_Stakeholder1` FOREIGN KEY (`Stakeholder_idStakeholder`) REFERENCES `stakeholder` (`idStakeholder`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stakeholderxproyecto`
--

LOCK TABLES `stakeholderxproyecto` WRITE;
/*!40000 ALTER TABLE `stakeholderxproyecto` DISABLE KEYS */;
INSERT INTO `stakeholderxproyecto` VALUES (1,1);
/*!40000 ALTER TABLE `stakeholderxproyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `story`
--

DROP TABLE IF EXISTS `story`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `story` (
  `idStory` int(11) NOT NULL AUTO_INCREMENT,
  `Proyecto_idProyecto` int(11) NOT NULL,
  `texto` varchar(300) DEFAULT NULL,
  `prioridad` int(11) DEFAULT NULL,
  PRIMARY KEY (`idStory`),
  KEY `fk_Story_Proyecto1_idx` (`Proyecto_idProyecto`),
  CONSTRAINT `fk_Story_Proyecto1` FOREIGN KEY (`Proyecto_idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `story`
--

LOCK TABLES `story` WRITE;
/*!40000 ALTER TABLE `story` DISABLE KEYS */;
/*!40000 ALTER TABLE `story` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarea`
--

DROP TABLE IF EXISTS `tarea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tarea` (
  `idTarea` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL,
  `horas` int(11) NOT NULL,
  `puntos` int(11) NOT NULL,
  `Stakeholder_idStakeholder` int(11) NOT NULL,
  `inicio` datetime(6) DEFAULT NULL,
  `fin` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`idTarea`,`Stakeholder_idStakeholder`,`horas`,`puntos`,`descripcion`),
  KEY `fk_Tarea_Stakeholder1_idx` (`Stakeholder_idStakeholder`),
  CONSTRAINT `fk_Tarea_Stakeholder1` FOREIGN KEY (`Stakeholder_idStakeholder`) REFERENCES `stakeholder` (`idStakeholder`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarea`
--

LOCK TABLES `tarea` WRITE;
/*!40000 ALTER TABLE `tarea` DISABLE KEYS */;
/*!40000 ALTER TABLE `tarea` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tareaxsprint`
--

DROP TABLE IF EXISTS `tareaxsprint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tareaxsprint` (
  `Sprint_idSprint` int(11) NOT NULL,
  `Tarea_idTarea` int(11) NOT NULL,
  PRIMARY KEY (`Sprint_idSprint`,`Tarea_idTarea`),
  KEY `fk_Sprint_has_Tarea_Tarea1_idx` (`Tarea_idTarea`),
  KEY `fk_Sprint_has_Tarea_Sprint1_idx` (`Sprint_idSprint`),
  CONSTRAINT `fk_Sprint_has_Tarea_Sprint1` FOREIGN KEY (`Sprint_idSprint`) REFERENCES `sprint` (`idSprint`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Sprint_has_Tarea_Tarea1` FOREIGN KEY (`Tarea_idTarea`) REFERENCES `tarea` (`idTarea`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareaxsprint`
--

LOCK TABLES `tareaxsprint` WRITE;
/*!40000 ALTER TABLE `tareaxsprint` DISABLE KEYS */;
/*!40000 ALTER TABLE `tareaxsprint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) DEFAULT NULL,
  `contrasena` varchar(45) DEFAULT NULL,
  `Rol_idRol` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `fk_Usuario_Rol1_idx` (`Rol_idRol`),
  CONSTRAINT `fk_Usuario_Rol1` FOREIGN KEY (`Rol_idRol`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'scrummaster@icost.com','scrummaster',3);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarioxproyecto`
--

DROP TABLE IF EXISTS `usuarioxproyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarioxproyecto` (
  `Proyecto_idProyecto` int(11) NOT NULL,
  `Usuario_idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`Proyecto_idProyecto`,`Usuario_idUsuario`),
  KEY `fk_Proyecto_has_Usuario_Usuario1_idx` (`Usuario_idUsuario`),
  KEY `fk_Proyecto_has_Usuario_Proyecto_idx` (`Proyecto_idProyecto`),
  CONSTRAINT `fk_Proyecto_has_Usuario_Proyecto` FOREIGN KEY (`Proyecto_idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Proyecto_has_Usuario_Usuario1` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarioxproyecto`
--

LOCK TABLES `usuarioxproyecto` WRITE;
/*!40000 ALTER TABLE `usuarioxproyecto` DISABLE KEYS */;
INSERT INTO `usuarioxproyecto` VALUES (1,1);
/*!40000 ALTER TABLE `usuarioxproyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarioxscrummeeting`
--

DROP TABLE IF EXISTS `usuarioxscrummeeting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarioxscrummeeting` (
  `Usuario_idUsuario` int(11) NOT NULL,
  `SCRUMMeeting_idSCRUMMeeting` int(11) NOT NULL,
  `queHice` varchar(200) DEFAULT NULL,
  `queVoyAHacer` varchar(200) DEFAULT NULL,
  `inconvenientes` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Usuario_idUsuario`,`SCRUMMeeting_idSCRUMMeeting`),
  KEY `fk_Usuario_has_SCRUMMeeting_SCRUMMeeting1_idx` (`SCRUMMeeting_idSCRUMMeeting`),
  KEY `fk_Usuario_has_SCRUMMeeting_Usuario1_idx` (`Usuario_idUsuario`),
  CONSTRAINT `fk_Usuario_has_SCRUMMeeting_SCRUMMeeting1` FOREIGN KEY (`SCRUMMeeting_idSCRUMMeeting`) REFERENCES `scrummeeting` (`idSCRUMMeeting`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_SCRUMMeeting_Usuario1` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarioxscrummeeting`
--

LOCK TABLES `usuarioxscrummeeting` WRITE;
/*!40000 ALTER TABLE `usuarioxscrummeeting` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarioxscrummeeting` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-31 23:03:56
