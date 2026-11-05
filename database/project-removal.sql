-- Removing a project now closes it and keeps its history. Also lets an admin restore it. Run once.
ALTER TABLE projects MODIFY status ENUM('open','ongoing','overdue','completed','past','closed','suspended','cancelled','removed') NOT NULL DEFAULT 'open';
ALTER TABLE projects ADD COLUMN IF NOT EXISTS removed_from_status VARCHAR(20) NULL;
ALTER TABLE projects ADD COLUMN IF NOT EXISTS removed_at DATETIME NULL;