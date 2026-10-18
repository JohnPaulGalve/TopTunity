-- Migration for existing installs. Run after schema.sql and uploads.sql.
-- Work-log project ids use the site's public id (database project id + 1000),
-- distinct from internal database ids.
CREATE TABLE IF NOT EXISTS work_logs (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  project_id    INT UNSIGNED NOT NULL,
  freelancer_id INT UNSIGNED NOT NULL,
  work_date     DATE NOT NULL,
  hours         DECIMAL(5,2) NOT NULL,
  task          VARCHAR(500) NOT NULL,
  status        ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  review_note   VARCHAR(500) NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX work_logs_project (project_id, id),
  FOREIGN KEY (freelancer_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contact_inquiries (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name         VARCHAR(120) NOT NULL,
  email        VARCHAR(190) NOT NULL,
  subject      VARCHAR(160) NOT NULL,
  message      TEXT NOT NULL,
  reply        TEXT NULL,
  status       ENUM('new','responded') NOT NULL DEFAULT 'new',
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  responded_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS password_reset_tokens (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NOT NULL,
  token_hash CHAR(64) NOT NULL UNIQUE,
  expires_at DATETIME NOT NULL,
  used_at    DATETIME NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX password_reset_user (user_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS project_submissions (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  project_id    INT UNSIGNED NOT NULL,
  freelancer_id INT UNSIGNED NOT NULL,
  message       TEXT NOT NULL,
  status        ENUM('pending','approved','revision') NOT NULL DEFAULT 'pending',
  review_note   VARCHAR(1000) NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX project_submissions_project (project_id, id),
  FOREIGN KEY (freelancer_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE projects
  ADD COLUMN IF NOT EXISTS late_work_allowed TINYINT(1) NOT NULL DEFAULT 0;

ALTER TABLE projects
  MODIFY status ENUM('open','ongoing','overdue','completed','past','closed','suspended','cancelled') NOT NULL DEFAULT 'open';
