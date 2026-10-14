-- Saves for the client profile, platform review, report and dispute forms.
-- Run ONCE in phpMyAdmin (select the toptunity database, then Import).
CREATE TABLE IF NOT EXISTS platform_reviews (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NOT NULL UNIQUE,
  rating     TINYINT UNSIGNED NOT NULL,
  body       TEXT NOT NULL,
  status     ENUM('new','published','hidden') NOT NULL DEFAULT 'new',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE client_profiles
  ADD COLUMN IF NOT EXISTS address VARCHAR(200) NULL,
  ADD COLUMN IF NOT EXISTS tin VARCHAR(40) NULL;