-- Saved freelancers and saved projects (the heart and Save buttons).
-- Run ONCE in phpMyAdmin (select the toptunity database, then Import).
CREATE TABLE IF NOT EXISTS saved_items (
  user_id    INT UNSIGNED NOT NULL,
  kind       ENUM('freelancer','project') NOT NULL,
  item_id    INT UNSIGNED NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, kind, item_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;