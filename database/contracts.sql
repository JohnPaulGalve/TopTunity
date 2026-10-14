-- Contract workflow columns for the projects table.
-- Run ONCE in phpMyAdmin (select the toptunity database, then Import or the SQL tab).
ALTER TABLE projects
  ADD COLUMN IF NOT EXISTS freelancer_id INT UNSIGNED NULL,
  ADD COLUMN IF NOT EXISTS contract_status ENUM('none','pending','active','completed','declined') NOT NULL DEFAULT 'none',
  ADD COLUMN IF NOT EXISTS agreed_amount INT UNSIGNED NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS start_date DATE NULL,
  ADD COLUMN IF NOT EXISTS contract_sent_at TIMESTAMP NULL;