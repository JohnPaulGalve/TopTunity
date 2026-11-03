-- Records when a user's account status last changed (used for the "Suspended on" date in admin). Run once.
ALTER TABLE users ADD COLUMN IF NOT EXISTS status_changed_at DATETIME NULL;