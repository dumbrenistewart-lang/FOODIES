-- ============================================================
--  shop_db — Full Setup Script
--  Run once:  mysql -u root -p < setup_db.sql
--  Or inside MySQL shell: SOURCE /path/to/setup_db.sql;
-- ============================================================

CREATE DATABASE IF NOT EXISTS `shop_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `shop_db`;

-- ────────────────────────────────────────────
--  USERS table  (login / registration)
-- ────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT          NOT NULL AUTO_INCREMENT,
  `username`   VARCHAR(60)  NOT NULL UNIQUE,
  `password`   VARCHAR(255) NOT NULL,          -- bcrypt hash
  `role`       ENUM('admin','user') NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default admin account
-- username : admin  |  password : Admin@123   ← CHANGE THIS IMMEDIATELY after first login!
INSERT IGNORE INTO `users` (`username`, `password`, `role`) VALUES
(
  'admin',
  '$2y$10$X8bytHNAVAhXSLmOS/kQMuyl8QJ7saOisziQRuPhmt7ftKh5x4V9S',  -- bcrypt of "Admin@123"
  'admin'
);

-- ────────────────────────────────────────────
--  PRODUCTS table
-- ────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `products` (
  `id`    INT           NOT NULL AUTO_INCREMENT,
  `name`  VARCHAR(100)  NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `image` VARCHAR(255)  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample products — images must exist in uploaded_img/
INSERT IGNORE INTO `products` (`name`, `price`, `image`) VALUES
  ('Grilled Chicken Burger',  8.99,  'food-1.png'),
  ('Margherita Pizza',        12.99, 'food-2.png'),
  ('Caesar Salad',            6.49,  'food-3.png'),
  ('Beef Tacos (x3)',         9.99,  'food-4.png'),
  ('Spaghetti Carbonara',     11.49, 'food-5.png'),
  ('Chocolate Lava Cake',     5.99,  'food-6.png');

-- ────────────────────────────────────────────
--  CART table
-- ────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `cart` (
  `id`       INT           NOT NULL AUTO_INCREMENT,
  `name`     VARCHAR(100)  NOT NULL,
  `price`    DECIMAL(10,2) NOT NULL,
  `image`    VARCHAR(255)  NOT NULL,
  `quantity` INT           NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ────────────────────────────────────────────
--  ORDER table  (created by checkout.php)
--  Note: checkout.php uses table name `order` (backtick-quoted)
-- ────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `order` (
  `id`             INT           NOT NULL AUTO_INCREMENT,
  `name`           VARCHAR(100)  NOT NULL,
  `number`         VARCHAR(20)   NOT NULL,
  `email`          VARCHAR(100)  NOT NULL,
  `method`         VARCHAR(50)   NOT NULL,
  `flat`           VARCHAR(100)  NOT NULL,
  `street`         VARCHAR(100)  NOT NULL,
  `city`           VARCHAR(100)  NOT NULL,
  `state`          VARCHAR(100)  NOT NULL,
  `country`        VARCHAR(100)  NOT NULL,
  `pin_code`       VARCHAR(20)   NOT NULL,
  `total_products` TEXT          NOT NULL,
  `total_price`    DECIMAL(10,2) NOT NULL,
  `placed_on`      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_status` ENUM('pending','paid','failed') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  Done! Verify with:
--    USE shop_db;
--    SHOW TABLES;
--    SELECT * FROM products;
-- ============================================================
