-- shop_db.sql
-- Run this in MySQL/phpMyAdmin to set up the database with an admin account.

CREATE DATABASE IF NOT EXISTS shop_db;
USE shop_db;

CREATE TABLE IF NOT EXISTS `users` (
  `id`       INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role`     ENUM('admin','user') NOT NULL DEFAULT 'user'
);

CREATE TABLE IF NOT EXISTS `products` (
  `id`    INT AUTO_INCREMENT PRIMARY KEY,
  `name`  VARCHAR(200) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `image` VARCHAR(255) NOT NULL
);

-- Admin user with bcrypt hash of 'Admin@123'
-- Generated via: password_hash('Admin@123', PASSWORD_DEFAULT)
-- If this hash doesn't work, run seed_admin.php instead.
-- CHANGE THIS PASSWORD IMMEDIATELY after first login!
INSERT INTO `users` (username, password, role) VALUES (
  'admin',
  '$2y$10$X8bytHNAVAhXSLmOS/kQMuyl8QJ7saOisziQRuPhmt7ftKh5x4V9S',
  'admin'
) ON DUPLICATE KEY UPDATE role='admin';

-- NOTE: The hash above is a placeholder.
-- Use seed_admin.php for a guaranteed working hash on your PHP version.
