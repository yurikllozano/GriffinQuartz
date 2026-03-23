-- =====================================================
-- Griffin Quartz - Lead Sources Migration
-- Run this in cPanel phpMyAdmin
-- (The `source` column already exists on the leads table)
-- =====================================================

-- Create managed lead sources table
CREATE TABLE IF NOT EXISTS lead_sources (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed with default sources
INSERT IGNORE INTO lead_sources (name, is_active, sort_order) VALUES
    ('Contact Form', 1, 1),
    ('Newsletter Popup', 1, 2),
    ('Meta Ads', 1, 3),
    ('Referral', 1, 4),
    ('Walk-in', 1, 5),
    ('WebFindYou Import', 1, 6),
    ('Other', 1, 99);
