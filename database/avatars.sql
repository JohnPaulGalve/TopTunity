-- Adds persistent avatar selection for existing TopTunity accounts.
-- Run once after schema.sql. Existing accounts receive a random site avatar
-- the first time their profile/avatar is rendered.
ALTER TABLE users ADD COLUMN IF NOT EXISTS avatar VARCHAR(80) NULL;
