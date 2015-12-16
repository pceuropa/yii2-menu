-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
-- Version Server: 10.1.9-MariaDB
-- Version PHP: 5.6.15

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `gr` int(2) NOT NULL DEFAULT '0',
  `serialize` int(11) DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


ALTER TABLE `menu` ADD PRIMARY KEY (`menu_id`);
ALTER TABLE `menu` MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT;