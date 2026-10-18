-- Category for portfolio samples. Run ONCE in phpMyAdmin (select the toptunity database, then Import).
ALTER TABLE attachments ADD COLUMN IF NOT EXISTS category VARCHAR(80) NULL;