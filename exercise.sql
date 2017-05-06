CREATE DATABASE IF NOT EXISTS `exercise` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `exercise`;

CREATE TABLE `contact` (
  `contact_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` varchar(254) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `phone` varchar(30) DEFAULT NULL
);
