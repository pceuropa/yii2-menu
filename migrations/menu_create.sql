-- phpMyAdmin SQL Dump
-- version 4.6.4deb1+deb.cihar.com~xenial.1
-- https://www.phpmyadmin.net/
-- Generation Time: Oct 01, 2016 at 06:31 PM
-- Server version: 10.1.17-MariaDB-1~xenial
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

ALTER TABLE `menu` ADD PRIMARY KEY (`menu_id`);
ALTER TABLE `menu` MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT;
