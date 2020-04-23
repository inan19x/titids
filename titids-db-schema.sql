-- phpMyAdmin SQL Dump
--

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `titids`
--

-- --------------------------------------------------------

--
-- Table structure for table `INTRUDERS`
--

CREATE TABLE IF NOT EXISTS `INTRUDERS` (
  `IP` varchar(20) DEFAULT NULL,
  `Protocol` varchar(8) DEFAULT NULL,
  `Port` int(5) unsigned DEFAULT NULL,
  `Alert` text NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `NETADM`
--

CREATE TABLE IF NOT EXISTS `NETADM` (
  `uname` varchar(20) NOT NULL,
  `passwd` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `NETADM`
--

INSERT INTO `NETADM` (`uname`, `passwd`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
