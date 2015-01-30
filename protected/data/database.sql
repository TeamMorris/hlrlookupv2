-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.67-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema hlrv2
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ hlrv2;
USE hlrv2;

--
-- Table structure for table `hlrv2`.`mobilenumberrecord`
--

DROP TABLE IF EXISTS `mobilenumberrecord`;
CREATE TABLE `mobilenumberrecord` (
  `rec_id` int(11) NOT NULL auto_increment,
  `queue_id` int(11) default NULL,
  `mobileNumber` varchar(255) NOT NULL,
  `location` varchar(255) default NULL,
  `region` varchar(255) default NULL,
  `originalNetwork` varchar(255) default NULL,
  `timezone` varchar(255) default NULL,
  `status` varchar(255) default NULL,
  `date_created` datetime default NULL,
  `date_updated` datetime default NULL,
  PRIMARY KEY  (`rec_id`),
  KEY `FK_mobilenumberrecord_1` (`queue_id`),
  CONSTRAINT `FK_mobilenumberrecord_1` FOREIGN KEY (`queue_id`) REFERENCES `queue` (`queue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hlrv2`.`mobilenumberrecord`
--

/*!40000 ALTER TABLE `mobilenumberrecord` DISABLE KEYS */;
/*!40000 ALTER TABLE `mobilenumberrecord` ENABLE KEYS */;


--
-- Table structure for table `hlrv2`.`queue`
--

DROP TABLE IF EXISTS `queue`;
CREATE TABLE `queue` (
  `queue_id` int(11) NOT NULL auto_increment,
  `fileLocation` varchar(255) default NULL,
  `queue_status` varchar(255) default NULL,
  `date_created` datetime default NULL,
  `date_finished` datetime default NULL,
  PRIMARY KEY  (`queue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hlrv2`.`queue`
--

/*!40000 ALTER TABLE `queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `queue` ENABLE KEYS */;


--
-- Table structure for table `hlrv2`.`tbl_migration`
--

DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) default NULL,
  PRIMARY KEY  (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hlrv2`.`tbl_migration`
--

/*!40000 ALTER TABLE `tbl_migration` DISABLE KEYS */;
INSERT INTO `tbl_migration` (`version`,`apply_time`) VALUES 
 ('m000000_000000_base',1422557305),
 ('m150129_183938_create_mobile_number_record_table',1422557768),
 ('m150129_183953_create_queue_table',1422557768);
/*!40000 ALTER TABLE `tbl_migration` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
