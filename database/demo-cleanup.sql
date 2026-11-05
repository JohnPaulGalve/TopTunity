-- Remove demo accounts and their demo activity.
-- Run only against the database used for the presentation/demo.
-- Shared categories and skills are intentionally retained.

START TRANSACTION;

-- These tables do not enforce a project foreign key, so remove their rows explicitly.
DELETE FROM project_submissions
WHERE freelancer_id IN (
  SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local'
)
OR project_id IN (
  SELECT id FROM projects
  WHERE client_id IN (SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local')
     OR freelancer_id IN (SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local')
);

DELETE FROM work_logs
WHERE freelancer_id IN (
  SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local'
)
OR project_id IN (
  SELECT id FROM projects
  WHERE client_id IN (SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local')
     OR freelancer_id IN (SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local')
);

DELETE FROM attachments
WHERE user_id IN (
  SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local'
)
OR (
  owner_type IN ('project', 'deliverable')
  AND owner_id IN (
    SELECT id FROM projects
    WHERE client_id IN (SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local')
       OR freelancer_id IN (SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local')
  )
);

DELETE FROM audit_logs
WHERE user_id IN (
  SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local'
);

-- Remove demo-owned or demo-assigned projects; dependent FK rows cascade.
DELETE FROM projects
WHERE client_id IN (
  SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local'
)
OR freelancer_id IN (
  SELECT id FROM users WHERE email LIKE '%@demo.toptunity.local'
);

-- Remaining profile, proposal, message, review, notification and account rows cascade.
DELETE FROM users
WHERE email LIKE '%@demo.toptunity.local';

COMMIT;
