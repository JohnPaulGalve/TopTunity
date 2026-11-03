-- Payment reference, method and client's transfer reference. Run once, after the schema files.
ALTER TABLE payments ADD COLUMN IF NOT EXISTS reference VARCHAR(30) NULL;
ALTER TABLE payments ADD COLUMN IF NOT EXISTS method VARCHAR(20) NULL;
ALTER TABLE payments ADD COLUMN IF NOT EXISTS transfer_ref VARCHAR(40) NULL;