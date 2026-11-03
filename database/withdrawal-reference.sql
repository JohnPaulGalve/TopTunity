-- Adds the processing date and the transfer reference to withdrawals. Run once, after the schema files.
ALTER TABLE withdrawals ADD COLUMN IF NOT EXISTS processed_at DATETIME NULL;
ALTER TABLE withdrawals ADD COLUMN IF NOT EXISTS reference VARCHAR(30) NULL;