-- ============================================================
-- PORTFOLIO DATABASE SCHEMA
-- ============================================================
-- Create the database first (or use an existing one):
--   CREATE DATABASE portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
--
-- The table is also auto-created by send_contact.php, so running
-- this file is optional — it is here for reference and for
-- manual setup. Import via phpMyAdmin, MySQL Workbench or:
--   mysql -u root -p portfolio_db < database.sql
-- ============================================================

CREATE TABLE IF NOT EXISTS contacts (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)    NOT NULL,
    email       VARCHAR(255)    NOT NULL,
    subject     VARCHAR(255)    NOT NULL,
    message     TEXT            NOT NULL,
    ip_address  VARCHAR(45)     DEFAULT NULL,
    user_agent  VARCHAR(255)    DEFAULT NULL,
    is_read     TINYINT(1)      NOT NULL DEFAULT 0,
    created_at  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_created_at (created_at),
    INDEX idx_email      (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
