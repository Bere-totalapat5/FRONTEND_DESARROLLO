-- MySQL dump 10.13  Distrib 5.5.24, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: sibjdf
-- ------------------------------------------------------
-- Server version	5.5.24-0ubuntu0.12.04.1-log

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
-- Table structure for table `conciliacion`
--

DROP TABLE IF EXISTS `conciliacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conciliacion` (
  `id_susicor` bigint(20) unsigned NOT NULL,
  `id_deposito` bigint(20) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `concil_susicor_deposito` (`id_susicor`,`id_deposito`),
  CONSTRAINT `fk_conciliacion_su` FOREIGN KEY (`id_susicor`) REFERENCES `saldo_usuario` (`id_saldo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=1482 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `paths`
--

DROP TABLE IF EXISTS `paths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paths` (
  `path` varchar(254) COLLATE utf8_bin DEFAULT NULL,
  `path_no` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`path_no`),
  UNIQUE KEY `paths_path` (`path`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `filename` varchar(254) COLLATE utf8_bin DEFAULT NULL,
  `path_no` bigint(20) DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL,
  `mtime` datetime DEFAULT NULL,
  `id_file` bigint(20) NOT NULL AUTO_INCREMENT,
  `md5` char(32) COLLATE utf8_bin DEFAULT NULL,
  `aplicado` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_file`),
  UNIQUE KEY `files_file_path` (`path_no`,`filename`) USING BTREE,
  KEY `files_md5` (`md5`) USING BTREE,
  CONSTRAINT `fk_files_paths` FOREIGN KEY (`path_no`) REFERENCES `paths` (`path_no`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87487 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `afil`
--

DROP TABLE IF EXISTS `afil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `afil` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cuenta` varchar(30) COLLATE utf8_bin NOT NULL,
  `tipo_tc` char(1) COLLATE utf8_bin NOT NULL,
  `tarjeta` varchar(24) COLLATE utf8_bin NOT NULL,
  `num_autorizacion` bigint(20) unsigned NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `fecha_operacion` datetime NOT NULL,
  `visamc` char(1) COLLATE utf8_bin NOT NULL,
  `id_archivo` bigint(20) NOT NULL,
  `aplicado` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aplicado` (`aplicado`),
  KEY `afil_z_archivo` (`id_archivo`),
  CONSTRAINT `afil_z_archivo` FOREIGN KEY (`id_archivo`) REFERENCES `files` (`id_file`),
  CONSTRAINT `afil_z_su` FOREIGN KEY (`aplicado`) REFERENCES `saldo_usuario` (`id_saldo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=565 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buzon_santander`
--

DROP TABLE IF EXISTS `buzon_santander`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buzon_santander` (
  `convenio` bigint(20) DEFAULT NULL,
  `cuenta` bigint(20) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `cod_oper` smallint(6) DEFAULT NULL,
  `folio` bigint(20) DEFAULT NULL,
  `signo` char(1) COLLATE utf8_bin DEFAULT NULL,
  `importe` decimal(12,2) DEFAULT NULL,
  `referencia_santander` char(32) COLLATE utf8_bin DEFAULT NULL,
  `descripcion` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `centro_oper` smallint(6) DEFAULT NULL,
  `id_buzon_santander` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_archivo` bigint(20) DEFAULT NULL,
  `linehash` char(22) COLLATE utf8_bin NOT NULL DEFAULT 'NOHASH',
  `fecha_proceso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `aplicado` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_buzon_santander`),
  UNIQUE KEY `z_linehash` (`linehash`),
  KEY `referencia_santander_z` (`referencia_santander`) USING BTREE,
  KEY `aplicacion_movimiento` (`aplicado`) USING BTREE,
  KEY `fk_z_archivo` (`id_archivo`),
  CONSTRAINT `fk_z_archivo` FOREIGN KEY (`id_archivo`) REFERENCES `files` (`id_file`),
  CONSTRAINT `fk_z_su` FOREIGN KEY (`aplicado`) REFERENCES `saldo_usuario` (`id_saldo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=1826 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-06  3:09:06
