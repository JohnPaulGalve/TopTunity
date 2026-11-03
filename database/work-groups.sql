-- Work groups: plain-language types of work for clients who do not know the technical skill names.
-- Each category belongs to one group. Run this once after the schema files.
ALTER TABLE categories ADD COLUMN IF NOT EXISTS work_group VARCHAR(40) NULL;

UPDATE categories SET work_group = 'Programmer'      WHERE name IN ('Web Development', 'Mobile App Development');
UPDATE categories SET work_group = 'Designer'        WHERE name IN ('Graphic Design', 'UI/UX Design');
UPDATE categories SET work_group = 'Editor'          WHERE name IN ('Video and Animation');
UPDATE categories SET work_group = 'Writer'          WHERE name IN ('Writing and Content');
UPDATE categories SET work_group = 'Marketer'        WHERE name IN ('Digital Marketing');
UPDATE categories SET work_group = 'Admin Assistant' WHERE name IN ('Data Entry and Admin');