/*
SQLyog Ultimate v12.14 (64 bit)
MySQL - 5.7.24 : Database - db_kcmit
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_kcmit` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db_kcmit`;

/*Table structure for table `comment` */

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Comment` mediumtext,
  `CommentDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `comment` */

insert  into `comment`(`ID`,`Name`,`Email`,`Comment`,`CommentDate`) values 
(1,'gff','furz_soooraz@hotmail.com','hgygygygy','2016-03-28 20:23:08'),
(2,'hhghg','ghgh@ggg.com','hghghghghg','2016-03-28 21:33:09'),
(3,'jgg','hghg@hgh.com','gfgfgfiji ihijhi','2016-03-28 21:36:14'),
(4,'gg','gvg@fd.com','jhgjjghg','2016-03-28 21:36:47'),
(5,'gfgf','furz_soooraz@hotmail.com','gfg','2016-03-28 21:39:40'),
(6,'hhhhhh','furz_soooraz@hotmail.com','uhuhuh','2016-03-28 21:41:14'),
(7,'ghf','furz_soooraz@hotmail.com','hghg','2016-03-28 21:41:47'),
(8,'ggug','furz_soooraz@hotmail.com','iijij','2016-03-28 21:42:23');

/*Table structure for table `daily_health_tips` */

DROP TABLE IF EXISTS `daily_health_tips`;

CREATE TABLE `daily_health_tips` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) DEFAULT NULL,
  `Content` text,
  `Image1` varchar(255) DEFAULT NULL,
  `Image2` varchar(255) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `Hits` int(11) DEFAULT NULL,
  `AddedDate` datetime DEFAULT NULL,
  `LastUpdateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `daily_health_tips` */

insert  into `daily_health_tips`(`ID`,`Title`,`Content`,`Image1`,`Image2`,`Status`,`Hits`,`AddedDate`,`LastUpdateDate`) values 
(2,'New Health Tips','<p>bhvgvgvtgfv</p>','nagarita 1Large20160328044414.PNG','image-26Large20160328044414.jpg',1,NULL,'2016-03-28 19:29:14','2016-03-28 19:29:14');

/*Table structure for table `health_news` */

DROP TABLE IF EXISTS `health_news`;

CREATE TABLE `health_news` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) DEFAULT NULL,
  `SubTitle` tinytext,
  `Content` longtext,
  `Image1` varchar(255) DEFAULT NULL,
  `Image2` varchar(255) DEFAULT NULL,
  `Image3` varchar(255) DEFAULT NULL,
  `Slug` varchar(255) DEFAULT NULL,
  `AddedDate` datetime NOT NULL,
  `LastUpdateDate` datetime DEFAULT NULL,
  `MetaTitle` varchar(255) DEFAULT NULL,
  `MetaKeyWords` tinytext,
  `MetaDescription` text,
  `Hits` int(11) DEFAULT NULL,
  `Author` varchar(100) DEFAULT NULL,
  `Status` int(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Slug` (`Slug`),
  KEY `Status` (`Status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `health_news` */

/*Table structure for table `health_tips` */

DROP TABLE IF EXISTS `health_tips`;

CREATE TABLE `health_tips` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) DEFAULT NULL,
  `SubTitle` tinytext,
  `Content` longtext,
  `Image1` varchar(255) DEFAULT NULL,
  `Image2` varchar(255) DEFAULT NULL,
  `Image3` varchar(255) DEFAULT NULL,
  `Slug` varchar(255) NOT NULL,
  `AddedDate` datetime DEFAULT NULL,
  `LastUpdateDate` datetime DEFAULT NULL,
  `MetaTitle` varchar(255) DEFAULT NULL,
  `MetaKeyWords` tinytext,
  `MetaDescription` text,
  `Hits` int(11) DEFAULT NULL,
  `Author` varchar(100) DEFAULT NULL,
  `Status` int(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Slug` (`Slug`),
  KEY `Status` (`Status`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `health_tips` */

insert  into `health_tips`(`ID`,`Title`,`SubTitle`,`Content`,`Image1`,`Image2`,`Image3`,`Slug`,`AddedDate`,`LastUpdateDate`,`MetaTitle`,`MetaKeyWords`,`MetaDescription`,`Hits`,`Author`,`Status`) values 
(7,'Eum congue voluptua luptatum consequat invenire erroribus corrumpit popop','Tota argumentum nec in. Sed an everti melius eleifend. Et tation legere referrentur eos. Duo erat tempor ea. An mollis delicata adolescens eum, ea putent eruditi argumentum sit, eos ex facilis rationibus.','<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Usu malorum saperet admodum et, at sea sint nonumes, per graeci diceret indoctum te. Pri unum explicari in, sit exerci dissentias eu. Prompta constituam concludaturque vel ei, ne odio officiis nam. Vis eu vide legendos adipiscing, sed no movet quodsi pertinacia. Causae audire id mel. Ad sit quod falli feugait, quaeque comprehensam mei ne, no vix inani ullamcorper definitionem.</p>\r\n\r\n<p><img alt=\"\" src=\"/localhost/conquer/images/image-26.jpg\" style=\"height:162px; width:350px\" /><img alt=\"\" src=\"/localhost/conquer/images/image-26 - Copy.jpg\" style=\"height:160px; margin-left:10px; margin-right:10px; width:340px\" /></p>\r\n\r\n<p>Vel quis mediocrem consetetur eu, et alii oblique debitis ius. Sea ne dictas aliquip, ea illum idque has, has decore essent commune te. Vis odio etiam ne. Eum accumsan adipiscing omittantur ad, nisl periculis ut usu. Debet laoreet et eos, habemus recteque disputationi sea et.</p>\r\n\r\n<p>No noster dicunt sea, iuvaret theophrastus vel at. Vix ipsum facete liberavisse ei. Dicam viderer nec te, vix id modo eripuit. Discere pertinax suavitate has no, at sea laoreet theophrastus. Lorem rationibus ut usu, nihil accusamus mei ne. Usu in impetus suscipit, vis eu delectus praesent qualisque.</p>\r\n\r\n<p>Qui odio dicta forensibus in. At ridens everti pri. Per ut falli omittam atomorum, quaeque mentitum ad his. Agam oporteat ea sed. Has ut putant dictas elaboraret.</p>\r\n\r\n<h2 style=\"font-style:italic\">&nbsp;</h2>\r\n\r\n<p><span style=\"font-size:16px\"><span style=\"color:#000000\"><u><big><span style=\"font-family:verdana,geneva,sans-serif\">THINGS NOT TO EAT</span></big></u></span></span></p>\r\n\r\n<ul>\r\n	<li>ICE CREAM &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</li>\r\n	<li>Cake</li>\r\n	<li>Pizza</li>\r\n</ul>','image-26Large20160326020717.jpg','benefit-of-hot-waterLarge20160528024300Small20160528025221.png',NULL,'eum-congue-voluptua-luptatum-consequat-invenire-erroribus-corrumpit-popop',NULL,'2016-05-28 18:26:45','This is Meta Title','This is Meta Description','This is Meta Description',NULL,NULL,1),
(14,'Testing oh oh oh oh',NULL,'<p>yhyhyh</p>','CkkreLarge20160528030200.PNG','banner-header-tapete-1452601687FgNSmall20160528030245.jpg',NULL,'testing-oh-oh-oh-oh',NULL,'2016-05-28 17:47:45','yhyh','yhyh','hyhyh',NULL,NULL,1),
(18,'uyuhuhu','huhuh','<p>njhjhjjj</p>','B612_20160413_170939Large20160528034551.jpg','benefit-of-hot-waterMedium20160528034551.png','CaptureSmall20160528034551.PNG','uyuhuhu','2016-05-28 18:30:51','2016-05-28 18:30:51','jhj','hjhjh','jhj',NULL,NULL,1),
(20,'Benefits Of Drinking Hot Water','Start Your Day With A Glass Of Hot Water And Cleanse Your System','<p><em><strong>Water </strong></em>is the most important element in our life and body, most of our day start with tea, coffee which still prepared from the water. Water in any form ice, cold, hot, sweet is very good and a must consume on constantly to keep the body properly hydrated. Water provides many benefits to our body, we need water for survival, well every living being needs.<br />\r\nWe consume water every time; breakfast, lunch and dinner .Mostly we prefer to have cold water but research has shown that for our body hot or warm water is more beneficial than cold water.<br />\r\nHow hot water is beneficial? you may ask, let me elaborate:</p>\r\n\r\n<h2>Relieve Cough &amp; Sore Throat:</h2>\r\n\r\n<p>During a cough and colds, hot/warm water is the simple, easy and natural remedy to make yourself relief. Gargling with &nbsp;the mixture of little amount of salt in hot water helps &nbsp;in relieving cough and sore throat as it dissolves and softens &nbsp;the phlegm and helps to remove it.</p>\r\n\r\n<h2>Help in Blood Circulation:</h2>\r\n\r\n<p>Drinking water makes the good blood flow, and consuming hot water makes circulation even more nicely and enhances in healthy nervous system by breaking down the fat and eliminating the toxins, which result in healthy body.</p>\r\n\r\n<h2>Help in Proper Digestion:</h2>\r\n\r\n<p>As we use hot water to wash off oil from kitchen utensil properly, same goes for our body system also, hot water helps to soften the oil in our stomach which we consume with food and prevent it forming in fat, it also melts down the fats in our body. Hot water helps in breakdown the food we consume and makes easier for digestion.</p>\r\n\r\n<h2>Burns Fat:</h2>\r\n\r\n<p>As mention above , hot water softens the oil and fats in our body and helps in dissolves it, it also help in maintaining a healthy metabolism rate by increasing body temperature which as a result helps a body to burn more calories.</p>\r\n\r\n<h2>Healthy Skin:</h2>\r\n\r\n<p>Hot water deeply cleanses the body and detoxifies your skin. Consumption of hot can help in prevents acne and pimples as it helps to clear your skin pores and eliminating the toxins within the skin. It also acts as a moisturizer for dry skin.</p>\r\n\r\n<h2>Healthy hair.</h2>\r\n\r\n<p>Who doesn&rsquo;t want healthy, shiny hair?Healthy hair helps to enhance you beauty and looks. Unhealthy hair may affect your personality as well, but consumption of hot water regularly may help you to some extent.<br />\r\nAs hot water helps to clear skin pore, it energizes nerve of the root of hair , fight against dry scalp and dandruff which helps in growth of hair and makes them soft and shiny and it also prevents in hair fall out</p>\r\n\r\n<h2>Prevents premature ageing:</h2>\r\n\r\n<p>As hot water play a significant role in making the skin healthy by eliminating the toxins and making the more circulation of blood flow. It also helps in repairing skin cells and increase elasticity which in return prevents wrinkles, dry patches, and dry skin.<br />\r\nPrevent Water-Borne Disease to Some Extent:<br />\r\nHot or boiling water can prevent you from most of the water-borne diseases as it kills most of the bacteria, microorganisms and the microbial agent which cause this diseases.</p>','benefit-of-hot-waterLarge20160528035617.png','benefit-of-hot-waterLarge20160528024300Medium20160528035046.png','CkkreSmall20160528035046.PNG','benefits-of-drinking-hot-water',NULL,'2016-05-28 19:34:02','jhj','jhjh','jhjhjjh',NULL,NULL,1);

/*Table structure for table `hits_details` */

DROP TABLE IF EXISTS `hits_details`;

CREATE TABLE `hits_details` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IPAddress` varchar(255) DEFAULT NULL,
  `DateTimeVisit` date DEFAULT NULL,
  `Slug` varchar(255) DEFAULT NULL,
  `Hits` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

/*Data for the table `hits_details` */

insert  into `hits_details`(`ID`,`IPAddress`,`DateTimeVisit`,`Slug`,`Hits`) values 
(13,'27.34.82.186','2016-03-27','Home',1),
(14,'27.34.82.186','2016-03-27','ContactUs',1),
(15,'27.34.82.186','2016-03-27','HealthTipsHome',1),
(16,'27.34.82.186','2016-03-27','this-is-health-news',1),
(17,'27.34.82.186','2016-03-27','error',1),
(18,'27.34.82.186','2016-03-27','eum-congue-voluptua-luptatum-consequat-invenire-erroribus-corrumpit',1),
(19,'27.34.82.186','2016-03-27','testing-popo-3',1),
(20,'27.34.82.186','2016-03-27','this-is-health-news-2',1),
(21,'27.34.83.219','2016-03-28','',1),
(22,'27.34.83.219','2016-03-28','',1),
(23,'27.34.83.219','2016-03-28','Home',1),
(24,'27.34.83.219','2016-03-28','ContactUs',1),
(25,'27.34.83.219','2016-03-28','HealthTipsHome',1),
(26,'::1','2016-03-28','Home',1),
(27,'::1','2016-03-28','ContactUs',1),
(28,'::1','2016-03-29','AllTipsAndNews',1),
(29,'::1','2016-03-29','HealthTipsHome',1),
(30,'113.199.192.20','2016-04-03','Home',1),
(31,'27.34.100.206','2016-04-09','Home',1),
(32,'27.34.92.42','2016-05-21','Home',1),
(33,'27.34.92.42','2016-05-21','this-is-health-news',1),
(34,'27.34.92.42','2016-05-21','error',1),
(35,'27.34.92.42','2016-05-21','testing-popo',1),
(36,'27.34.92.42','2016-05-21','HealthTipsHome',1),
(37,'::1','2016-05-21','this-is-health-news',1),
(38,'::1','2016-05-21','error',1),
(39,'27.34.46.204','2016-05-21','Home',1),
(40,'27.34.20.30','2016-05-21','Home',1),
(41,'27.34.20.30','2016-05-21','HealthTipsHome',1),
(42,'27.34.20.30','2016-05-21','ContactUs',1),
(43,'27.34.20.30','2016-05-21','AllTipsAndNews',1),
(44,'27.34.20.30','2016-05-21','error',1),
(45,'27.34.46.204','2016-05-21','error',1),
(46,'27.34.46.204','2016-05-21','ContactUs',1),
(47,'27.34.46.204','2016-05-21','HealthTipsHome',1),
(48,'27.34.46.204','2016-05-21','eum-congue-voluptua-luptatum-consequat-invenire-erroribus-corrumpit',1),
(49,'27.34.26.9','2016-05-22','Home',1),
(50,'27.34.26.9','2016-05-22','HealthTipsHome',1),
(51,'27.34.26.9','2016-05-22','this-is-health-news',1),
(52,'27.34.26.9','2016-05-22','error',1),
(53,'27.34.26.9','2016-05-22','AllTipsAndNews',1),
(54,'27.34.47.70','2016-05-22','Home',1),
(55,'27.34.47.70','2016-05-22','eum-congue-voluptua-luptatum-consequat-invenire-erroribus-corrumpit',1),
(56,'27.34.47.70','2016-05-22','AllTipsAndNews',1),
(57,'27.34.47.70','2016-05-22','error',1),
(58,'27.34.47.70','2016-05-22','HealthTipsHome',1),
(59,'27.34.45.207','2016-05-28','Home',1),
(60,'27.34.45.207','2016-05-28','Home',1),
(61,'27.34.45.207','2016-05-28','error',1),
(62,'27.34.45.207','2016-05-28','benefits-of-drinking-hot-water',1),
(63,'27.34.45.207','2016-05-28','eum-congue-voluptua-luptatum-consequat-invenire-erroribus-corrumpit',1),
(64,'::1','2016-05-28','benefits-of-drinking-hot-water',1),
(65,'27.34.43.88','2016-05-28','benefits-of-drinking-hot-water',1),
(66,'27.34.87.209','2016-05-29','Home',1),
(67,'27.34.87.209','2016-05-29','error',1),
(68,'::1','2016-05-30','Home',1),
(69,'27.34.20.148','2016-05-30','Home',1),
(70,'27.34.20.148','2016-05-30','error',1),
(71,'27.34.29.238','2016-05-30','benefits-of-drinking-hot-water',1),
(72,'27.34.90.8','2016-05-31','Home',1),
(73,'27.34.25.141','2016-06-01','Home',1),
(74,'27.34.25.141','2016-06-01','error',1),
(75,'27.34.25.141','2016-06-01','AllTipsAndNews',1),
(76,'27.34.25.141','2016-06-01','HealthTipsHome',1),
(77,'27.34.25.141','2016-06-01','ContactUs',1),
(78,'27.34.29.101','2016-06-01','Home',1),
(79,'27.34.29.101','2016-06-01','error',1),
(80,'27.34.29.101','2016-06-01','benefits-of-drinking-hot-water',1),
(81,'27.34.29.237','2016-06-06','Home',1),
(82,'27.34.100.75','2016-06-06','Home',1),
(83,'27.34.100.75','2016-06-06','error',1),
(84,'27.34.22.172','2016-06-13','Home',1),
(85,'27.34.89.66','2016-06-25','Home',1),
(86,'27.34.89.66','2016-06-25','error',1),
(87,'27.34.89.66','2016-06-25','benefits-of-drinking-hot-water',1),
(88,'27.34.89.66','2016-06-25','HealthTipsHome',1),
(89,'27.34.89.66','2016-06-25','AllTipsAndNews',1),
(90,'27.34.89.66','2016-06-25','healthtips',1),
(91,'27.34.89.66','2016-06-25','',1),
(92,'27.34.89.66','2016-06-25','ContactUs',1);

/*Table structure for table `login_logs` */

DROP TABLE IF EXISTS `login_logs`;

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_ip` int(11) NOT NULL,
  `login_failed` int(11) DEFAULT NULL,
  `last_failed_login` datetime DEFAULT NULL,
  `last_successful_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_ip` (`login_ip`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `login_logs` */

insert  into `login_logs`(`id`,`login_ip`,`login_failed`,`last_failed_login`,`last_successful_login`) values 
(3,455233853,0,'2016-03-19 17:17:35','2016-03-19 20:27:07'),
(4,455217246,0,'2016-03-20 08:14:23','2016-03-20 08:14:29'),
(5,0,1,'2016-05-21 13:36:41',NULL);

/*Table structure for table `login_user` */

DROP TABLE IF EXISTS `login_user`;

CREATE TABLE `login_user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Email` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `UserType` tinyint(1) NOT NULL,
  `LastLogin` datetime DEFAULT NULL,
  `DateCreated` datetime NOT NULL,
  `PasswordUpdatedDate` date NOT NULL,
  `SendNotification` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `login_user` */

insert  into `login_user`(`ID`,`Name`,`Email`,`Username`,`Password`,`UserType`,`LastLogin`,`DateCreated`,`PasswordUpdatedDate`,`SendNotification`) values 
(2,'Suraj','furz_sooraz@','admin','9ffc896c433b4c1dcd7d30d491f74bf7b87f2cddef517c98d7d611012ac3dae1',1,'2019-04-20 17:35:28','2016-03-14 17:00:08','2016-03-16',0);

/*Table structure for table `login_user_logs` */

DROP TABLE IF EXISTS `login_user_logs`;

CREATE TABLE `login_user_logs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) DEFAULT NULL,
  `DateTime` datetime DEFAULT NULL,
  `Action` text CHARACTER SET latin1,
  `ActionFR` text,
  `Ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4511 DEFAULT CHARSET=utf8;

/*Data for the table `login_user_logs` */

insert  into `login_user_logs`(`ID`,`UserId`,`DateTime`,`Action`,`ActionFR`,`Ip`) values 
(4358,2,'2016-03-20 13:52:28','admin Added HealthNews  jhjh ',NULL,NULL),
(4359,2,'2016-03-20 13:54:02','admin Added HealthNews  kij ',NULL,NULL),
(4360,2,'2016-03-20 13:55:54','admin Added HealthNews  kij ',NULL,NULL),
(4361,2,'2016-03-20 14:19:03','admin logged in','admin Вошел',NULL),
(4362,2,'2016-03-20 14:32:18','admin Added HealthNews  kij ',NULL,NULL),
(4363,2,'2016-03-20 14:32:34','admin Added HealthNews  kij ',NULL,NULL),
(4364,2,'2016-03-20 14:35:46','admin Added HealthNews  kijpp ',NULL,NULL),
(4365,2,'2016-03-20 14:37:28','admin Added HealthNews  kij popopopo ',NULL,NULL),
(4366,2,'2016-03-20 14:37:40','admin Added HealthNews  kij ',NULL,NULL),
(4367,2,'2016-03-20 14:38:42','admin Added HealthNews  kij ',NULL,NULL),
(4368,2,'2016-03-20 14:40:26','admin Added HealthNews  Ok Ok ok ',NULL,NULL),
(4369,2,'2016-03-20 14:40:31','admin Added HealthNews  This is test title ok ok ok ',NULL,NULL),
(4370,2,'2016-03-20 14:40:35','admin Added HealthNews  jhjh ',NULL,NULL),
(4371,2,'2016-03-20 14:40:46','admin Added HealthNews  kij ',NULL,NULL),
(4372,2,'2016-03-20 14:41:07','admin Added HealthNews  kij ',NULL,NULL),
(4373,2,'2016-03-20 14:41:24','admin Added HealthNews  kij ',NULL,NULL),
(4374,2,'2016-03-20 14:43:28','admin Added HealthNews  kij ',NULL,NULL),
(4375,2,'2016-03-20 14:43:33','admin Added HealthNews  kij ',NULL,NULL),
(4376,2,'2016-03-20 14:43:47','admin Added HealthNews  kij ',NULL,NULL),
(4377,2,'2016-03-20 14:50:36','admin Deleted Health News  ID   ',NULL,NULL),
(4378,2,'2016-03-20 14:50:55','admin Deleted Health News  ID   ',NULL,NULL),
(4379,2,'2016-03-20 14:50:58','admin Deleted Health News  ID 14 kijpp ',NULL,NULL),
(4380,2,'2016-03-20 14:51:01','admin Deleted Health News  ID 8 kij ',NULL,NULL),
(4381,2,'2016-03-20 14:55:50','admin Deleted Health News  ID 1 Testing Title ',NULL,NULL),
(4382,2,'2016-03-20 15:26:47','admin Set Health News Status  ID 7  To Status 0',NULL,NULL),
(4383,2,'2016-03-20 15:27:36','admin Set Health News Status  ID 6  To Status 0',NULL,NULL),
(4384,2,'2016-03-20 15:28:07','admin Set Health News Status  ID 7  To Status 1',NULL,NULL),
(4385,2,'2016-03-20 15:28:21','admin Set Health News Status  ID 7  To Status 0',NULL,NULL),
(4386,2,'2016-03-20 15:28:53','admin Set Health News Status  ID 6  To Status 1',NULL,NULL),
(4387,2,'2016-03-20 15:29:00','admin Set Health News Status  ID 5  To Status 0',NULL,NULL),
(4388,2,'2016-03-20 15:29:29','admin Set Health News Status  ID 3  To Status 0',NULL,NULL),
(4389,2,'2016-03-20 15:29:55','admin Set Health News Status  ID 6  To Status 0',NULL,NULL),
(4390,2,'2016-03-20 15:29:57','admin Set Health News Status  ID 4  To Status 0',NULL,NULL),
(4391,2,'2016-03-20 15:29:57','admin Set Health News Status  ID 5  To Status 1',NULL,NULL),
(4392,2,'2016-03-20 15:30:07','admin Set Health News Status  ID 6  To Status 1',NULL,NULL),
(4393,2,'2016-03-20 15:30:20','admin Set Health News Status  ID 6  To Status 0',NULL,NULL),
(4394,2,'2016-03-20 15:30:35','admin Set Health News Status  ID 6  To Status 1',NULL,NULL),
(4395,2,'2016-03-20 15:30:36','admin Set Health News Status  ID 6  To Status 0',NULL,NULL),
(4396,2,'2016-03-20 15:30:37','admin Set Health News Status  ID 6  To Status 1',NULL,NULL),
(4397,2,'2016-03-20 15:30:50','admin Deleted Health News  ID 7  ',NULL,NULL),
(4398,2,'2016-03-20 15:30:53','admin Deleted Health News  ID 6  ',NULL,NULL),
(4399,2,'2016-03-20 15:30:55','admin Set Health News Status  ID 2  To Status 0',NULL,NULL),
(4400,2,'2016-03-20 15:30:56','admin Set Health News Status  ID 2  To Status 1',NULL,NULL),
(4401,2,'2016-03-20 15:32:56','admin Deleted Health News  ID 2  ',NULL,NULL),
(4402,2,'2016-03-20 15:32:59','admin Deleted Health News  ID 3  ',NULL,NULL),
(4403,2,'2016-03-20 15:33:02','admin Deleted Health News  ID 4  ',NULL,NULL),
(4404,2,'2016-03-20 15:33:19','admin Added Health News  juhuhuhuh ',NULL,NULL),
(4405,2,'2016-03-20 15:33:22','admin Set Health News Status  ID 5  To Status 0',NULL,NULL),
(4406,2,'2016-03-20 15:33:23','admin Set Health News Status  ID 5  To Status 1',NULL,NULL),
(4407,2,'2016-03-20 15:33:31','admin Set Health News Status  ID 5  To Status 0',NULL,NULL),
(4408,2,'2016-03-20 16:24:08','admin Added Health Tips  testtoo juhuhuh ',NULL,NULL),
(4409,2,'2016-03-20 16:26:26','',NULL,NULL),
(4410,2,'2016-03-20 16:26:41','admin Set Health News Status  ID 5  To Status 1',NULL,NULL),
(4411,2,'2016-03-20 16:26:43','admin Set Health News Status  ID 5  To Status 0',NULL,NULL),
(4412,2,'2016-03-20 16:27:23','admin Set Health News Status  ID 5  To Status 1',NULL,NULL),
(4413,2,'2016-03-20 16:27:25','admin Set Health News Status  ID 5  To Status 0',NULL,NULL),
(4414,2,'2016-03-20 16:27:30','',NULL,NULL),
(4415,2,'2016-03-20 16:28:44','admin Set Health Tips Status  ID 1  To Status 0',NULL,NULL),
(4416,2,'2016-03-20 16:28:46','admin Set Health Tips Status  ID 1  To Status 1',NULL,NULL),
(4417,2,'2016-03-20 16:46:41','admin Added Health Tips  uhuhu ',NULL,NULL),
(4418,2,'2016-03-20 16:47:59','admin Deleted Health Tips  ID 1 testtoo juhuhuh ',NULL,NULL),
(4419,2,'2016-03-20 16:48:02','admin Deleted Health Tips  ID 2 uhuhu ',NULL,NULL),
(4420,2,'2016-03-20 16:48:28','admin Added Health Tips  huhuhuhuh uhuh ',NULL,NULL),
(4421,2,'2016-03-20 16:49:23','admin Added Health Tips  huhuh uhuhuh ',NULL,NULL),
(4422,2,'2016-03-20 16:50:25','admin Added Health Tips  hyh ',NULL,NULL),
(4423,2,'2016-03-20 16:51:10','admin Added Health Tips  juu ',NULL,NULL),
(4424,2,'2016-03-20 16:51:39','admin Added Health Tips  juu ok ok ok ok okkokokok ',NULL,NULL),
(4425,2,'2016-03-20 16:53:08','admin Added Health Tips  juu ok ok ok ok okkokokok ',NULL,NULL),
(4426,2,'2016-03-20 16:53:35','admin Added Health Tips  juu ok ok ok ok okkokokok ',NULL,NULL),
(4427,2,'2016-03-20 16:54:56','admin Added Health Tips  juu ok ok ok ok okkokokok ',NULL,NULL),
(4428,2,'2016-03-20 16:55:15','admin Added Health Tips  juu ok ok ok ok okkokokok ',NULL,NULL),
(4429,2,'2016-03-20 16:56:30','admin Added Health Tips  juu ok ok ok ok okkokokok ppppppp ',NULL,NULL),
(4430,2,'2016-03-20 17:05:18','admin Set Health Tips Status  ID   To Status 1',NULL,NULL),
(4431,2,'2016-03-20 17:11:15','admin Added Health Tips  This is testing Health Tips ok ',NULL,NULL),
(4432,2,'2016-03-20 18:11:50','admin logged in','admin Вошел',NULL),
(4433,2,'2016-03-20 18:13:44','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4434,2,'2016-03-20 18:18:19','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4435,2,'2016-03-20 19:44:09','admin Added Health News  This is health news ',NULL,NULL),
(4436,2,'2016-03-20 19:56:11','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4437,2,'2016-03-20 20:55:29','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4438,2,'2016-03-20 21:15:36','admin logged in','admin Вошел',NULL),
(4439,2,'2016-03-20 21:18:05','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4440,2,'2016-03-20 21:19:50','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4441,2,'2016-03-20 21:21:43','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4442,2,'2016-03-20 21:28:41','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4443,2,'2016-03-20 21:31:21','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4444,2,'2016-03-20 21:32:55','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4445,2,'2016-03-20 23:36:57','admin Added Health Tips  Testing popo ',NULL,NULL),
(4446,2,'2016-03-20 23:37:44','admin Added Health Tips  Testing popo ',NULL,NULL),
(4447,2,'2016-03-20 23:45:58','admin Added Health Tips  Testing popo ',NULL,NULL),
(4448,2,'2016-03-26 13:06:57','admin logged in','admin Вошел',NULL),
(4449,2,'2016-03-26 16:17:54','admin logged in','admin Вошел',NULL),
(4450,2,'2016-03-26 16:52:17','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4451,2,'2016-03-27 15:08:23','admin logged in','admin Вошел',NULL),
(4452,2,'2016-03-27 15:45:01','admin Added Health Tips  hhkjhjhjh ',NULL,NULL),
(4453,2,'2016-03-27 15:51:59','admin Added Daily Health Tips  nghg ',NULL,NULL),
(4454,2,'2016-03-27 15:53:31','admin Added Daily Health Tips  nghg ',NULL,NULL),
(4455,2,'2016-03-27 15:57:34','admin Deleted Daily Health Tips  ID   ',NULL,NULL),
(4456,2,'2016-03-27 16:08:46','admin Deleted Daily Health Tips  ID   ',NULL,NULL),
(4457,2,'2016-03-27 16:08:54','admin Added Daily Health Tips  nghgllllll ',NULL,NULL),
(4458,2,'2016-03-27 16:09:04','admin Added Daily Health Tips  nghgllllll ',NULL,NULL),
(4459,2,'2016-03-28 19:21:45','admin logged in','admin Вошел',NULL),
(4460,2,'2016-03-28 19:28:39','admin Set Health News Status  ID 17  To Status 1',NULL,NULL),
(4461,2,'2016-03-28 19:28:40','admin Set Health News Status  ID 17  To Status 0',NULL,NULL),
(4462,2,'2016-03-28 19:29:14','admin Added Daily Health Tips  New Health Tips ',NULL,NULL),
(4463,2,'2016-03-28 19:29:32','admin Deleted Daily Health Tips  ID 1 nghgllllll ',NULL,NULL),
(4464,2,'2016-05-21 13:36:54','admin logged in','admin Вошел',NULL),
(4465,2,'2016-05-21 13:36:58','admin Set Health News Status  ID 16  To Status 0',NULL,NULL),
(4466,2,'2016-05-21 13:36:59','admin Set Health News Status  ID 16  To Status 1',NULL,NULL),
(4467,2,'2016-05-21 13:37:02','admin Deleted Health News  ID 17  ',NULL,NULL),
(4468,2,'2016-05-21 13:38:12','admin Deleted Health Tips  ID 15 hhkjhjhjh ',NULL,NULL),
(4469,2,'2016-05-28 17:17:56','admin logged in','admin Вошел',NULL),
(4470,2,'2016-05-28 17:28:00','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4471,2,'2016-05-28 17:34:23','admin Deleted Health Tips  ID 8 Testing popo ',NULL,NULL),
(4472,2,'2016-05-28 17:34:27','admin Deleted Health Tips  ID 9 This is testing 2 ',NULL,NULL),
(4473,2,'2016-05-28 17:34:32','admin Deleted Health Tips  ID 10 Testing popo ',NULL,NULL),
(4474,2,'2016-05-28 17:37:21','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit ',NULL,NULL),
(4475,2,'2016-05-28 17:38:06','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4476,2,'2016-05-28 17:39:00','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4477,2,'2016-05-28 17:39:57','admin Added Health Tips  Testing po po po ',NULL,NULL),
(4478,2,'2016-05-28 17:40:12','admin Added Health Tips  Testing po po po ',NULL,NULL),
(4479,2,'2016-05-28 17:40:21','admin Added Health Tips  Testing po po po ',NULL,NULL),
(4480,2,'2016-05-28 17:42:52','admin Added Health Tips  Testing oh oh oh oh ',NULL,NULL),
(4481,2,'2016-05-28 17:44:25','admin Added Health Tips  Testing oh oh oh oh ',NULL,NULL),
(4482,2,'2016-05-28 17:44:37','admin Added Health Tips  Testing oh oh oh oh ',NULL,NULL),
(4483,2,'2016-05-28 17:45:05','admin Added Health Tips  Testing oh oh oh oh ',NULL,NULL),
(4484,2,'2016-05-28 17:47:00','admin Added Health Tips  Testing oh oh oh oh ',NULL,NULL),
(4485,2,'2016-05-28 17:47:16','admin Added Health Tips  Testing oh oh oh oh ',NULL,NULL),
(4486,2,'2016-05-28 17:47:45','admin Added Health Tips  Testing oh oh oh oh ',NULL,NULL),
(4487,2,'2016-05-28 17:48:25','admin Added Health Tips  hjhjh ',NULL,NULL),
(4488,2,'2016-05-28 17:51:15','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4489,2,'2016-05-28 17:54:51','admin Deleted Health News  ID 6 This is health news1 ',NULL,NULL),
(4490,2,'2016-05-28 17:54:54','admin Deleted Health News  ID 8 This is health news2 ',NULL,NULL),
(4491,2,'2016-05-28 17:54:58','admin Deleted Health News  ID 9 This is health news2 ',NULL,NULL),
(4492,2,'2016-05-28 17:55:01','admin Deleted Health News  ID 14 This is health news4 ',NULL,NULL),
(4493,2,'2016-05-28 18:04:29','admin Deleted Health News  ID 15 This is health news5 ',NULL,NULL),
(4494,2,'2016-05-28 18:04:32','admin Deleted Health News  ID 16 This is health news6 ',NULL,NULL),
(4495,2,'2016-05-28 18:17:33','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4496,2,'2016-05-28 18:26:45','admin Added Health Tips  Eum congue voluptua luptatum consequat invenire erroribus corrumpit popop ',NULL,NULL),
(4497,2,'2016-05-28 18:28:46','admin Added Health Tips  jhjhuj ',NULL,NULL),
(4498,2,'2016-05-28 18:30:51','admin Added Health Tips  uyuhuhu ',NULL,NULL),
(4499,2,'2016-05-28 18:31:28','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4500,2,'2016-05-28 18:32:41','admin Added Health Tips  Benefits Of Drinking Hot Waterhghg ',NULL,NULL),
(4501,2,'2016-05-28 18:35:46','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4502,2,'2016-05-28 18:41:17','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4503,2,'2016-05-28 18:43:15','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4504,2,'2016-05-28 18:47:16','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4505,2,'2016-05-28 19:30:51','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4506,2,'2016-05-28 19:34:02','admin Added Health Tips  Benefits Of Drinking Hot Water ',NULL,NULL),
(4507,2,'2016-05-28 19:37:29','admin Deleted Health Tips  ID 16 hjhjh ',NULL,NULL),
(4508,2,'2016-05-28 19:37:33','admin Deleted Health Tips  ID 17 jhjhuj ',NULL,NULL),
(4509,2,'2016-05-28 19:37:40','admin Deleted Health Tips  ID 15 Benefits Of Drinking Hot Waterhghg ',NULL,NULL),
(4510,2,'2019-04-20 17:35:29','admin logged in','admin Вошел',NULL);

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sessionID` varchar(20) DEFAULT NULL,
  `subscriber` varchar(15) DEFAULT NULL,
  `shank_id` int(10) DEFAULT NULL,
  `lang` int(2) DEFAULT NULL,
  `chars` int(5) DEFAULT NULL,
  `coding` int(2) DEFAULT NULL,
  `is_activated` int(2) DEFAULT NULL,
  `activation_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session` (`sessionID`),
  KEY `activated` (`is_activated`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

/*Data for the table `sessions` */

/*Table structure for table `slug` */

DROP TABLE IF EXISTS `slug`;

CREATE TABLE `slug` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Content` varchar(20) DEFAULT NULL,
  `ContentID` int(11) DEFAULT NULL,
  `Slug` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Slug` (`Slug`),
  KEY `Content` (`Content`),
  KEY `ContentID` (`ContentID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `slug` */

insert  into `slug`(`ID`,`Content`,`ContentID`,`Slug`) values 
(3,'HealthTips',7,'eum-congue-voluptua-luptatum-consequat-invenire-erroribus-corrumpit-popop'),
(10,'HealthTips',20,'benefits-of-drinking-hot-water');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
