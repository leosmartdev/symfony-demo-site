/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.22-MariaDB : Database - symfony
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`symfony` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `symfony`;

/*Table structure for table `doctrine_migration_versions` */

DROP TABLE IF EXISTS `doctrine_migration_versions`;

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `doctrine_migration_versions` */

insert  into `doctrine_migration_versions`(`version`,`executed_at`,`execution_time`) values 
('DoctrineMigrations\\Version20220213183043','2022-02-14 14:12:55',7145),
('DoctrineMigrations\\Version20220213200439','2022-02-14 14:13:02',103),
('DoctrineMigrations\\Version20220214000116','2022-02-14 14:13:02',687);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id_role`,`nombre_role`,`descripcion_role`) values 
(1,'ROLE_ADMIN','Admin'),
(2,'ROLE_CONTROLLER','Partner'),
(3,'ROLE_USER','User');

/*Table structure for table `usu_roles` */

DROP TABLE IF EXISTS `usu_roles`;

CREATE TABLE `usu_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `usu_roles` */

insert  into `usu_roles`(`id`,`id_role`,`id_usu`) values 
(7,3,2),
(8,2,3),
(17,2,4),
(19,3,5),
(21,1,1),
(22,3,6);

/*Table structure for table `usuarios_usu` */

DROP TABLE IF EXISTS `usuarios_usu`;

CREATE TABLE `usuarios_usu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_usu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos_usu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_usu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_usu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass_usu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo_usu` int(11) NOT NULL,
  `fecha_c_usu` datetime DEFAULT NULL,
  `usu_c_usu` int(11) DEFAULT NULL,
  `fecha_m_usu` datetime DEFAULT NULL,
  `usu_m_usu` int(11) DEFAULT NULL,
  `borrado_usu` int(11) NOT NULL,
  `fecha_ult_acceso_usu` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `pais_usu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A9267DC0AA8B458` (`nombre_usu`),
  UNIQUE KEY `UNIQ_A9267DC0C2FC69` (`email_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `usuarios_usu` */

insert  into `usuarios_usu`(`id`,`nombre_usu`,`apellidos_usu`,`tipo_usu`,`email_usu`,`pass_usu`,`activo_usu`,`fecha_c_usu`,`usu_c_usu`,`fecha_m_usu`,`usu_m_usu`,`borrado_usu`,`fecha_ult_acceso_usu`,`roles`,`pais_usu`) values 
(1,'admin','admin','','admin@demo.com','$2y$13$c/ezopePEbBTrILv4wDAq.p3SS3WWIc7wN5vONpQAO/RLt37sOnJG',1,NULL,NULL,'2022-02-14 15:53:00',1,0,NULL,'[1]','AF'),
(2,'Leo Sultanov','Sultanov','','Ilvirsultanovtchub21@gmail.com','$2y$13$c/ezopePEbBTrILv4wDAq.p3SS3WWIc7wN5vONpQAO/RLt37sOnJG',1,'2022-02-14 14:13:47',1,'2022-02-14 15:25:34',1,0,NULL,'[3]','RU'),
(3,'Ilvir Sultanov','Sultanov','','sultanovilvircr@mail.ru','$2y$13$c/ezopePEbBTrILv4wDAq.p3SS3WWIc7wN5vONpQAO/RLt37sOnJG',1,'2022-02-14 14:17:17',1,'2022-02-14 15:25:45',1,0,NULL,'[2]','RU'),
(4,'controller','1','','controller@demo.com','$2y$13$c/ezopePEbBTrILv4wDAq.p3SS3WWIc7wN5vONpQAO/RLt37sOnJG',1,'2022-02-14 15:16:26',1,'2022-02-14 15:43:15',4,0,NULL,'[2]','ES');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
