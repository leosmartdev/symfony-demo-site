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
('DoctrineMigrations\\Version20220205012030','2022-02-07 19:10:59',6857),
('DoctrineMigrations\\Version20220207181403','2022-02-07 19:14:17',227),
('DoctrineMigrations\\Version20220208132333','2022-02-08 14:23:55',491);

/*Table structure for table `symfony_demo_user` */

DROP TABLE IF EXISTS `symfony_demo_user`;

CREATE TABLE `symfony_demo_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `update_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `update_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8FB094A1F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8FB094A1E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `symfony_demo_user` */

insert  into `symfony_demo_user`(`id`,`full_name`,`username`,`email`,`password`,`roles`,`surname`,`add_user`,`update_user`,`create_at`,`update_at`,`country`) values 
(1,'alex','admin','admin@gmail.com','$2y$13$c/ezopePEbBTrILv4wDAq.p3SS3WWIc7wN5vONpQAO/RLt37sOnJG','[\"ROLE_ADMIN\"]','L','alex','alex','2022-02-06 10:17:00','2022-02-07 10:17:00','admin'),
(39,'controller 1','controller1','controller1@gmail.com','$2y$13$Bpo3OH9YAifIe5e9WLGBeelBlfn7MHfUADRMQ5uFfPcGO6CW5botu','[\"ROLE_CONTROLLER\"]','T','admin','admin','2017-01-01 00:00:00','2017-01-01 00:00:00','FR'),
(40,'controller2','controller2','controller2@gmail.com','$2y$13$bRinJXMJwQqch6AghdI8bOWT69C.X6adkVt7p.vSHxLEzurHPvuXS','[\"ROLE_CONTROLLER\"]','T','admin','admin','2017-01-01 00:00:00','2017-01-01 00:00:00','RU'),
(41,'controller3','controller3','controller3@gmail.com','$2y$13$rU75aIBfE56Mn7yzf2XLn.FUuoQ0JN0g3kK2g0NC5iRnKOTNHj69C','[\"ROLE_CONTROLLER\"]','R','admin','admin','2017-01-01 00:00:00','2017-01-01 00:00:00','US'),
(42,'FrUser1','FrUser1','FrUser1@gmail.com','$2y$13$ur/8F2JdC2caUUM5m1WI8Ok9ZKNydX6Sb1UHbkcDg5Npa0e.6Vsly','[\"ROLE_USER\"]','T','controller1','controller1','2017-01-01 00:00:00','2017-01-01 00:00:00','FR'),
(43,'RuUser1','RuUser1','RuUser1@gmail.com','$2y$13$/s5UguRnAtO2vLUW24rfHeWmIhtpPW0J3RPy/MGD3ZJVGc2.1WBgi','[\"ROLE_USER\"]','R','controller2','controller2','2017-01-01 00:00:00','2017-01-01 00:00:00','RU'),
(44,'UsUser1','UsUser1','UsUser1@gmail.com','$2y$13$8ZusE3oDIDqrT3Rj10QfqeYoy743Hnqw.FdKMl6t5BbZW7HYL7tOy','[\"ROLE_USER\"]','W','controller3','controller3','2017-01-01 00:00:00','2017-01-01 00:00:00','US');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
