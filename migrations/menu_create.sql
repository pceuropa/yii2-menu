-- #Copyright (c) 2017 Rafal Marguzewicz pceuropa.net
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `menu` (
`menu_id` int(11) NOT NULL,
  `menu` text NOT NULL,
  `menu_name` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `menu` ADD PRIMARY KEY (`menu_id`);
ALTER TABLE `menu` MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
ALTER TABLE `menu` ADD PRIMARY KEY (`menu_id`), ADD KEY `unique-index-menu-menu_name` (`menu_name`);
