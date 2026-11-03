-- Risk alerts: contracts, proposals and projects that go beyond normal limits.
CREATE TABLE IF NOT EXISTS risk_alerts (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  source      ENUM('project','proposal','contract') NOT NULL,
  project_id  INT UNSIGNED NULL,
  user_id     INT UNSIGNED NOT NULL,
  amount      INT UNSIGNED NOT NULL DEFAULT 0,
  reason      VARCHAR(255) NOT NULL,
  status      ENUM('new','reviewed') NOT NULL DEFAULT 'new',
  created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX risk_alerts_status (status, id),
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;