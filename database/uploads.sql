-- Stores uploaded files (project attachments, report and dispute files, deliverables, portfolio samples)
-- and profile photos. Run ONCE in phpMyAdmin (select the toptunity database, then Import).
CREATE TABLE IF NOT EXISTS attachments (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  owner_type    ENUM('project','deliverable','report','dispute','portfolio') NOT NULL,
  owner_id      INT UNSIGNED NOT NULL,
  user_id       INT UNSIGNED NOT NULL,
  label         VARCHAR(160) NULL,
  original_name VARCHAR(255) NOT NULL,
  stored_name   VARCHAR(80) NOT NULL,
  size_label    VARCHAR(20) NOT NULL,
  file_type     VARCHAR(20) NOT NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (owner_type, owner_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE client_profiles ADD COLUMN IF NOT EXISTS photo VARCHAR(80) NULL;
ALTER TABLE freelancer_profiles ADD COLUMN IF NOT EXISTS photo VARCHAR(80) NULL;