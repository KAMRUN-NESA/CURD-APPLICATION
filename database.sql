-- ============================================
-- database.sql - CRUD Application Setup
-- Run this file in phpMyAdmin or MySQL CLI
-- ============================================

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS `CRUD`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `CRUD`;

-- Create users table
CREATE TABLE IF NOT EXISTS `loginn` (
  `Id`          INT(10)      NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(100) NOT NULL,
  `email`       VARCHAR(100) NOT NULL UNIQUE,
  `password`    VARCHAR(255) NOT NULL,
  `description` TEXT         NULL,
  `image`       VARCHAR(255) NULL,
  `created_at`  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- If table already exists, add missing columns:
ALTER TABLE `loginn`
  MODIFY COLUMN `name`        VARCHAR(100) NOT NULL,
  MODIFY COLUMN `email`       VARCHAR(100) NOT NULL,
  MODIFY COLUMN `password`    VARCHAR(255) NOT NULL;

ALTER TABLE `loginn`
  ADD COLUMN IF NOT EXISTS `description` TEXT NULL AFTER `password`;

ALTER TABLE `loginn`
  ADD COLUMN IF NOT EXISTS `image` VARCHAR(255) NULL AFTER `description`;

ALTER TABLE `loginn`
  ADD COLUMN IF NOT EXISTS `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER `image`;
