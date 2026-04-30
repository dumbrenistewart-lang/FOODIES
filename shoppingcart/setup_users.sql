-- ============================================================
--  Run this SQL in your shop_db database to enable login.
--  Execute once: mysql -u root shop_db < setup_users.sql
-- ============================================================

CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT          NOT NULL AUTO_INCREMENT,
  `username`   VARCHAR(60)  NOT NULL UNIQUE,
  `password`   VARCHAR(255) NOT NULL,          -- bcrypt hash
  `role`       ENUM('admin','user') NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
--  Default admin account
--  username : admin
--  password : Admin@123        ← CHANGE THIS IMMEDIATELY after first login!
-- ============================================================
INSERT IGNORE INTO `users` (`username`, `password`, `role`)
VALUES (
  'admin',
  '$2y$10$X8bytHNAVAhXSLmOS/kQMuyl8QJ7saOisziQRuPhmt7ftKh5x4V9S',  -- bcrypt of "Admin@123"
  'admin'
);
