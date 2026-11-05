-- Demo data for visual presentation. Run after schema.sql and all database/*.sql migrations.
-- Safe to run repeatedly. Demo password for every account: Demo12345
-- Cleanup: run database/demo-cleanup.sql

SET @demo_password_hash := '$2y$10$i9czN7gzkC4Aipq1ZfluK.1n8WjL6Bnu6BZIH8HAVJhHg.P4BCNkG';

-- Shared catalog data; retained after demo cleanup because other accounts may use it.
INSERT IGNORE INTO categories (name, work_group) VALUES
  ('Web Development', 'Programmer'),
  ('Mobile App Development', 'Programmer'),
  ('Graphic Design', 'Designer'),
  ('UI/UX Design', 'Designer'),
  ('Writing and Content', 'Writer'),
  ('Digital Marketing', 'Marketer'),
  ('Video and Animation', 'Editor'),
  ('Data Entry and Admin', 'Admin Assistant');

UPDATE categories SET work_group = 'Programmer' WHERE name IN ('Web Development', 'Mobile App Development');
UPDATE categories SET work_group = 'Designer' WHERE name IN ('Graphic Design', 'UI/UX Design');
UPDATE categories SET work_group = 'Writer' WHERE name = 'Writing and Content';
UPDATE categories SET work_group = 'Marketer' WHERE name = 'Digital Marketing';
UPDATE categories SET work_group = 'Editor' WHERE name = 'Video and Animation';
UPDATE categories SET work_group = 'Admin Assistant' WHERE name = 'Data Entry and Admin';

INSERT INTO skills (name, category_id)
SELECT x.name, c.id
FROM (
  SELECT 'PHP' AS name, 'Web Development' AS category UNION ALL
  SELECT 'MySQL', 'Web Development' UNION ALL
  SELECT 'JavaScript', 'Web Development' UNION ALL
  SELECT 'Laravel', 'Web Development' UNION ALL
  SELECT 'React', 'Web Development' UNION ALL
  SELECT 'HTML/CSS', 'Web Development' UNION ALL
  SELECT 'REST API', 'Web Development' UNION ALL
  SELECT 'Flutter', 'Mobile App Development' UNION ALL
  SELECT 'Firebase', 'Mobile App Development' UNION ALL
  SELECT 'Android Development', 'Mobile App Development' UNION ALL
  SELECT 'Logo Design', 'Graphic Design' UNION ALL
  SELECT 'Adobe Illustrator', 'Graphic Design' UNION ALL
  SELECT 'Photoshop', 'Graphic Design' UNION ALL
  SELECT 'Figma', 'UI/UX Design' UNION ALL
  SELECT 'UI Design', 'UI/UX Design' UNION ALL
  SELECT 'Prototyping', 'UI/UX Design' UNION ALL
  SELECT 'Copywriting', 'Writing and Content' UNION ALL
  SELECT 'Blog Writing', 'Writing and Content' UNION ALL
  SELECT 'Social Media Marketing', 'Digital Marketing' UNION ALL
  SELECT 'Google Ads', 'Digital Marketing' UNION ALL
  SELECT 'SEO', 'Digital Marketing' UNION ALL
  SELECT 'Premiere Pro', 'Video and Animation' UNION ALL
  SELECT 'After Effects', 'Video and Animation' UNION ALL
  SELECT 'Data Entry', 'Data Entry and Admin' UNION ALL
  SELECT 'Microsoft Excel', 'Data Entry and Admin' UNION ALL
  SELECT 'Virtual Assistance', 'Data Entry and Admin'
) x
JOIN categories c ON c.name = x.category
WHERE NOT EXISTS (SELECT 1 FROM skills s WHERE s.name = x.name);

-- Ten clients and ten freelancers. Existing demo accounts are reused by email.
INSERT IGNORE INTO users (name, email, password_hash, role, status) VALUES
  ('Andrea Reyes', 'andrea.reyes@demo.toptunity.local', @demo_password_hash, 'client', 'active'),
  ('Mark Santos', 'mark.santos@demo.toptunity.local', @demo_password_hash, 'client', 'active'),
  ('Liza Ramos', 'liza.ramos@demo.toptunity.local', @demo_password_hash, 'client', 'active'),
  ('Carlo Dizon', 'carlo.dizon@demo.toptunity.local', @demo_password_hash, 'client', 'active'),
  ('Grace Lim', 'grace.lim@demo.toptunity.local', @demo_password_hash, 'client', 'active'),
  ('Noel Garcia', 'noel.garcia@demo.toptunity.local', @demo_password_hash, 'client', 'active'),
  ('Mia Flores', 'mia.flores@demo.toptunity.local', @demo_password_hash, 'client', 'active'),
  ('Paolo Herrera', 'paolo.herrera@demo.toptunity.local', @demo_password_hash, 'client', 'active'),
  ('Rhea Villanueva', 'rhea.villanueva@demo.toptunity.local', @demo_password_hash, 'client', 'active'),
  ('Dante Cruz', 'dante.cruz@demo.toptunity.local', @demo_password_hash, 'client', 'active'),
  ('Miguel Cruz', 'miguel.cruz@demo.toptunity.local', @demo_password_hash, 'freelancer', 'active'),
  ('Bea Lim', 'bea.lim@demo.toptunity.local', @demo_password_hash, 'freelancer', 'active'),
  ('Jerome Castillo', 'jerome.castillo@demo.toptunity.local', @demo_password_hash, 'freelancer', 'active'),
  ('Janelle Aquino', 'janelle.aquino@demo.toptunity.local', @demo_password_hash, 'freelancer', 'active'),
  ('Ramon Villanueva', 'ramon.villanueva@demo.toptunity.local', @demo_password_hash, 'freelancer', 'active'),
  ('Noel Bautista', 'noel.bautista@demo.toptunity.local', @demo_password_hash, 'freelancer', 'active'),
  ('Ana Mendoza', 'ana.mendoza@demo.toptunity.local', @demo_password_hash, 'freelancer', 'active'),
  ('Paolo Garcia', 'paolo.garcia@demo.toptunity.local', @demo_password_hash, 'freelancer', 'active'),
  ('Rhea Santos', 'rhea.santos@demo.toptunity.local', @demo_password_hash, 'freelancer', 'active'),
  ('Kyla Torres', 'kyla.torres@demo.toptunity.local', @demo_password_hash, 'freelancer', 'active');

INSERT INTO client_profiles (user_id, company, location, phone, about)
SELECT u.id, x.company, x.location, x.phone, x.about
FROM (
  SELECT 'andrea.reyes@demo.toptunity.local' AS email, 'Kape Lokal' AS company, 'Quezon City, Philippines' AS location, '+63 917 555 0101' AS phone, 'A neighborhood coffee shop growing its online ordering and loyalty experience.' AS about UNION ALL
  SELECT 'mark.santos@demo.toptunity.local', 'Santos Family Clinic', 'Makati City, Philippines', '+63 917 555 0102', 'A family clinic improving patient booking and follow-up.' UNION ALL
  SELECT 'liza.ramos@demo.toptunity.local', 'Ramos Bakehouse', 'Cebu City, Philippines', '+63 917 555 0103', 'A small bakery building a recognizable brand and better online presence.' UNION ALL
  SELECT 'carlo.dizon@demo.toptunity.local', 'Dizon Beach Resort', 'Batangas, Philippines', '+63 917 555 0104', 'A local resort attracting more guests through digital content.' UNION ALL
  SELECT 'grace.lim@demo.toptunity.local', 'Lim Logistics', 'Davao City, Philippines', '+63 917 555 0105', 'A growing delivery team digitizing customer and driver workflows.' UNION ALL
  SELECT 'noel.garcia@demo.toptunity.local', 'Northstar Learning Hub', 'Pasig City, Philippines', '+63 917 555 0106', 'A learning center creating useful resources for students and parents.' UNION ALL
  SELECT 'mia.flores@demo.toptunity.local', 'Flores Home Goods', 'Iloilo City, Philippines', '+63 917 555 0107', 'An independent home-goods shop preparing to expand online.' UNION ALL
  SELECT 'paolo.herrera@demo.toptunity.local', 'Herrera Property Group', 'Taguig City, Philippines', '+63 917 555 0108', 'A property team looking for practical tools and clear marketing.' UNION ALL
  SELECT 'rhea.villanueva@demo.toptunity.local', 'Green Basket Market', 'Bacolod City, Philippines', '+63 917 555 0109', 'A local grocery service improving operations and customer communications.' UNION ALL
  SELECT 'dante.cruz@demo.toptunity.local', 'Cruz Fitness Studio', 'Mandaluyong City, Philippines', '+63 917 555 0110', 'A fitness studio building a stronger community and online class experience.'
) x
JOIN users u ON u.email = x.email
ON DUPLICATE KEY UPDATE company = VALUES(company), location = VALUES(location), phone = VALUES(phone), about = VALUES(about);

INSERT INTO freelancer_profiles (user_id, title, location, hourly_rate, languages, about, available, phone)
SELECT u.id, x.title, x.location, x.rate, x.languages, x.about, x.available, x.phone
FROM (
  SELECT 'miguel.cruz@demo.toptunity.local' AS email, 'Full-Stack PHP Developer' AS title, 'Cebu City, Philippines' AS location, 450 AS rate, 'English, Cebuano' AS languages, 'I build dependable PHP and MySQL systems for small businesses, from ordering flows to inventory dashboards.' AS about, 1 AS available, '+63 917 555 0201' AS phone UNION ALL
  SELECT 'bea.lim@demo.toptunity.local', 'Brand and Graphic Designer', 'Quezon City, Philippines', 380, 'English, Filipino', 'I create thoughtful visual identities, packaging, and campaign artwork with production-ready files.', 1, '+63 917 555 0202' UNION ALL
  SELECT 'jerome.castillo@demo.toptunity.local', 'Backend and API Developer', 'Davao City, Philippines', 520, 'English, Filipino', 'I design documented REST APIs and database structures that are secure, maintainable, and easy to extend.', 1, '+63 917 555 0203' UNION ALL
  SELECT 'janelle.aquino@demo.toptunity.local', 'UI/UX and Web Designer', 'Bacolod City, Philippines', 420, 'English, Hiligaynon', 'I turn complex requirements into clear user flows, responsive interfaces, and testable prototypes.', 1, '+63 917 555 0204' UNION ALL
  SELECT 'ramon.villanueva@demo.toptunity.local', 'Flutter Mobile App Developer', 'Iloilo City, Philippines', 600, 'English, Ilonggo', 'I build Flutter apps with Firebase services, clear milestones, and practical release documentation.', 1, '+63 917 555 0205' UNION ALL
  SELECT 'noel.bautista@demo.toptunity.local', 'Video Editor and Motion Designer', 'Makati City, Philippines', 390, 'English, Filipino', 'I edit short-form social videos, event highlights, and product promos with captions and motion graphics.', 1, '+63 917 555 0206' UNION ALL
  SELECT 'ana.mendoza@demo.toptunity.local', 'Copywriter and Content Writer', 'Pasig City, Philippines', 320, 'English, Filipino', 'I write useful website copy, blog articles, and product descriptions in a friendly, consistent voice.', 1, '+63 917 555 0207' UNION ALL
  SELECT 'paolo.garcia@demo.toptunity.local', 'Digital Marketing Specialist', 'Taguig City, Philippines', 480, 'English, Filipino', 'I plan social campaigns and paid ads, then report results in plain language with practical next steps.', 1, '+63 917 555 0208' UNION ALL
  SELECT 'rhea.santos@demo.toptunity.local', 'Data and Virtual Admin Assistant', 'Cebu City, Philippines', 260, 'English, Cebuano', 'I organize records, spreadsheets, and recurring admin tasks with a careful eye for accuracy.', 1, '+63 917 555 0209' UNION ALL
  SELECT 'kyla.torres@demo.toptunity.local', 'Product Designer and Frontend Developer', 'Quezon City, Philippines', 560, 'English, Filipino', 'I combine Figma prototyping with React and accessible HTML/CSS to deliver polished product experiences.', 0, '+63 917 555 0210'
) x
JOIN users u ON u.email = x.email
ON DUPLICATE KEY UPDATE title = VALUES(title), location = VALUES(location), hourly_rate = VALUES(hourly_rate),
  languages = VALUES(languages), about = VALUES(about), available = VALUES(available), phone = VALUES(phone);

INSERT IGNORE INTO freelancer_skills (freelancer_id, skill_id)
SELECT u.id, s.id
FROM (
  SELECT 'miguel.cruz@demo.toptunity.local' AS email, 'PHP' AS skill UNION ALL SELECT 'miguel.cruz@demo.toptunity.local', 'MySQL' UNION ALL SELECT 'miguel.cruz@demo.toptunity.local', 'Laravel' UNION ALL SELECT 'miguel.cruz@demo.toptunity.local', 'JavaScript' UNION ALL
  SELECT 'bea.lim@demo.toptunity.local', 'Logo Design' UNION ALL SELECT 'bea.lim@demo.toptunity.local', 'Adobe Illustrator' UNION ALL SELECT 'bea.lim@demo.toptunity.local', 'Photoshop' UNION ALL
  SELECT 'jerome.castillo@demo.toptunity.local', 'REST API' UNION ALL SELECT 'jerome.castillo@demo.toptunity.local', 'PHP' UNION ALL SELECT 'jerome.castillo@demo.toptunity.local', 'MySQL' UNION ALL
  SELECT 'janelle.aquino@demo.toptunity.local', 'Figma' UNION ALL SELECT 'janelle.aquino@demo.toptunity.local', 'UI Design' UNION ALL SELECT 'janelle.aquino@demo.toptunity.local', 'Prototyping' UNION ALL SELECT 'janelle.aquino@demo.toptunity.local', 'HTML/CSS' UNION ALL
  SELECT 'ramon.villanueva@demo.toptunity.local', 'Flutter' UNION ALL SELECT 'ramon.villanueva@demo.toptunity.local', 'Firebase' UNION ALL SELECT 'ramon.villanueva@demo.toptunity.local', 'Android Development' UNION ALL
  SELECT 'noel.bautista@demo.toptunity.local', 'Premiere Pro' UNION ALL SELECT 'noel.bautista@demo.toptunity.local', 'After Effects' UNION ALL
  SELECT 'ana.mendoza@demo.toptunity.local', 'Copywriting' UNION ALL SELECT 'ana.mendoza@demo.toptunity.local', 'Blog Writing' UNION ALL SELECT 'ana.mendoza@demo.toptunity.local', 'SEO' UNION ALL
  SELECT 'paolo.garcia@demo.toptunity.local', 'Social Media Marketing' UNION ALL SELECT 'paolo.garcia@demo.toptunity.local', 'Google Ads' UNION ALL SELECT 'paolo.garcia@demo.toptunity.local', 'SEO' UNION ALL
  SELECT 'rhea.santos@demo.toptunity.local', 'Data Entry' UNION ALL SELECT 'rhea.santos@demo.toptunity.local', 'Microsoft Excel' UNION ALL SELECT 'rhea.santos@demo.toptunity.local', 'Virtual Assistance' UNION ALL
  SELECT 'kyla.torres@demo.toptunity.local', 'Figma' UNION ALL SELECT 'kyla.torres@demo.toptunity.local', 'React' UNION ALL SELECT 'kyla.torres@demo.toptunity.local', 'HTML/CSS' UNION ALL SELECT 'kyla.torres@demo.toptunity.local', 'Prototyping'
) x
JOIN users u ON u.email = x.email
JOIN skills s ON s.name = x.skill;

-- Sixteen projects cover all categories, both billing types, multiple statuses, and varied clients.
INSERT INTO projects
  (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline,
   status, contract_status, freelancer_id, agreed_amount, start_date, contract_sent_at, created_at)
SELECT c.id, cat.id, x.title, x.description, x.billing_type, x.budget, x.hourly_rate, x.max_hours,
  DATE_ADD(CURDATE(), INTERVAL x.deadline_days DAY), x.project_status, x.contract_status, f.id,
  x.agreed_amount,
  CASE WHEN x.project_status IN ('ongoing', 'completed') THEN DATE_SUB(CURDATE(), INTERVAL x.age_days DAY) ELSE NULL END,
  CASE WHEN x.contract_status <> 'none' THEN DATE_SUB(NOW(), INTERVAL x.age_days DAY) ELSE NULL END,
  DATE_SUB(NOW(), INTERVAL x.age_days DAY)
FROM (
  SELECT 'Kape Lokal Ordering Website' AS title, 'Build a responsive menu and ordering site with pickup slots, order status, and a simple staff dashboard.' AS description, 'Web Development' AS category, 'andrea.reyes@demo.toptunity.local' AS client_email, 'fixed' AS billing_type, 48000 AS budget, 0 AS hourly_rate, 0 AS max_hours, 35 AS deadline_days, 'open' AS project_status, 'none' AS contract_status, NULL AS freelancer_email, 0 AS agreed_amount, 3 AS age_days UNION ALL
  SELECT 'Clinic Booking Website', 'Create a mobile-friendly clinic site with doctor profiles, appointment requests, and a staff scheduling view.', 'Web Development', 'mark.santos@demo.toptunity.local', 'fixed', 62000, 0, 0, 25, 'completed', 'completed', 'miguel.cruz@demo.toptunity.local', 59000, 55 UNION ALL
  SELECT 'Lim Logistics Tracking App', 'Create a customer and driver app for shipment updates, delivery proof, and status notifications.', 'Mobile App Development', 'grace.lim@demo.toptunity.local', 'fixed', 125000, 0, 0, 60, 'open', 'none', NULL, 0, 2 UNION ALL
  SELECT 'Resort Guest Companion App', 'Build a lightweight Flutter app for room requests, resort maps, and activity bookings.', 'Mobile App Development', 'carlo.dizon@demo.toptunity.local', 'fixed', 98000, 0, 0, 30, 'completed', 'completed', 'ramon.villanueva@demo.toptunity.local', 92000, 65 UNION ALL
  SELECT 'Ramos Bakehouse Brand Kit', 'Design a warm, memorable bakery identity with logo variations, packaging artwork, and a short usage guide.', 'Graphic Design', 'liza.ramos@demo.toptunity.local', 'fixed', 16000, 0, 0, 28, 'open', 'none', NULL, 0, 4 UNION ALL
  SELECT 'Flores Home Goods Product Set', 'Create a consistent set of product images and promotional graphics for a small online shop.', 'Graphic Design', 'mia.flores@demo.toptunity.local', 'fixed', 12000, 0, 0, 20, 'completed', 'completed', 'bea.lim@demo.toptunity.local', 11500, 48 UNION ALL
  SELECT 'Fitness Studio Member Experience', 'Map and prototype a simple member journey for class discovery, booking, and account management.', 'UI/UX Design', 'dante.cruz@demo.toptunity.local', 'hourly', 0, 480, 40, 35, 'open', 'none', NULL, 0, 1 UNION ALL
  SELECT 'Northstar Learning Portal Redesign', 'Improve the student dashboard, course navigation, and parent-facing progress screens.', 'UI/UX Design', 'noel.garcia@demo.toptunity.local', 'fixed', 36000, 0, 0, 18, 'completed', 'completed', 'janelle.aquino@demo.toptunity.local', 34000, 58 UNION ALL
  SELECT 'Green Basket Product Guides', 'Write clear product descriptions and two helpful articles for a local grocery delivery service.', 'Writing and Content', 'rhea.villanueva@demo.toptunity.local', 'fixed', 14000, 0, 0, 22, 'open', 'none', NULL, 0, 5 UNION ALL
  SELECT 'Herrera Property Area Guides', 'Write neighborhood guides and listing copy that sound accurate, welcoming, and easy to scan.', 'Writing and Content', 'paolo.herrera@demo.toptunity.local', 'fixed', 18000, 0, 0, 16, 'completed', 'completed', 'ana.mendoza@demo.toptunity.local', 17000, 72 UNION ALL
  SELECT 'Dizon Resort Social Campaign', 'Plan a month of social posts, short campaign copy, and a compact performance report.', 'Digital Marketing', 'carlo.dizon@demo.toptunity.local', 'hourly', 0, 420, 32, 30, 'open', 'none', NULL, 0, 2 UNION ALL
  SELECT 'Kape Lokal Launch Campaign', 'Prepare a local launch campaign with social content, audience testing, and clear weekly reporting.', 'Digital Marketing', 'andrea.reyes@demo.toptunity.local', 'fixed', 28000, 0, 0, 14, 'ongoing', 'active', 'paolo.garcia@demo.toptunity.local', 26000, 22 UNION ALL
  SELECT 'Cruz Studio Reels Package', 'Edit short workout reels with clean captions, consistent color, and a reusable title animation.', 'Video and Animation', 'dante.cruz@demo.toptunity.local', 'fixed', 22000, 0, 0, 25, 'open', 'none', NULL, 0, 3 UNION ALL
  SELECT 'Ramos Bakehouse Promo Video', 'Edit a short bakery profile video from supplied footage with captions and music.', 'Video and Animation', 'liza.ramos@demo.toptunity.local', 'fixed', 15000, 0, 0, 12, 'completed', 'completed', 'noel.bautista@demo.toptunity.local', 14500, 42 UNION ALL
  SELECT 'Green Basket Inventory Cleanup', 'Organize product and stock spreadsheets, remove duplicates, and prepare a clear weekly summary.', 'Data Entry and Admin', 'rhea.villanueva@demo.toptunity.local', 'hourly', 0, 240, 24, 21, 'open', 'none', NULL, 0, 1 UNION ALL
  SELECT 'Northstar Enrollment Records', 'Clean and reconcile enrollment records, document the process, and prepare a reusable Excel tracker.', 'Data Entry and Admin', 'noel.garcia@demo.toptunity.local', 'fixed', 11000, 0, 0, 10, 'completed', 'completed', 'rhea.santos@demo.toptunity.local', 10500, 80
) x
JOIN users c ON c.email = x.client_email
JOIN categories cat ON cat.name = x.category
LEFT JOIN users f ON f.email = x.freelancer_email
WHERE NOT EXISTS (SELECT 1 FROM projects p WHERE p.client_id = c.id AND p.title = x.title);

-- Skills required by each seeded project.
INSERT IGNORE INTO project_skills (project_id, skill_id)
SELECT p.id, s.id
FROM (
  SELECT 'Kape Lokal Ordering Website' AS title, 'PHP' AS skill UNION ALL SELECT 'Kape Lokal Ordering Website', 'MySQL' UNION ALL SELECT 'Kape Lokal Ordering Website', 'JavaScript' UNION ALL
  SELECT 'Clinic Booking Website', 'Laravel' UNION ALL SELECT 'Clinic Booking Website', 'MySQL' UNION ALL
  SELECT 'Lim Logistics Tracking App', 'Flutter' UNION ALL SELECT 'Lim Logistics Tracking App', 'Firebase' UNION ALL
  SELECT 'Resort Guest Companion App', 'Flutter' UNION ALL SELECT 'Resort Guest Companion App', 'Android Development' UNION ALL SELECT 'Resort Guest Companion App', 'Firebase' UNION ALL
  SELECT 'Ramos Bakehouse Brand Kit', 'Logo Design' UNION ALL SELECT 'Ramos Bakehouse Brand Kit', 'Adobe Illustrator' UNION ALL
  SELECT 'Flores Home Goods Product Set', 'Photoshop' UNION ALL SELECT 'Flores Home Goods Product Set', 'Adobe Illustrator' UNION ALL
  SELECT 'Fitness Studio Member Experience', 'Figma' UNION ALL SELECT 'Fitness Studio Member Experience', 'Prototyping' UNION ALL
  SELECT 'Northstar Learning Portal Redesign', 'Figma' UNION ALL SELECT 'Northstar Learning Portal Redesign', 'UI Design' UNION ALL
  SELECT 'Green Basket Product Guides', 'Copywriting' UNION ALL SELECT 'Green Basket Product Guides', 'Blog Writing' UNION ALL
  SELECT 'Herrera Property Area Guides', 'Copywriting' UNION ALL SELECT 'Herrera Property Area Guides', 'SEO' UNION ALL
  SELECT 'Dizon Resort Social Campaign', 'Social Media Marketing' UNION ALL SELECT 'Dizon Resort Social Campaign', 'Google Ads' UNION ALL
  SELECT 'Kape Lokal Launch Campaign', 'Social Media Marketing' UNION ALL SELECT 'Kape Lokal Launch Campaign', 'Google Ads' UNION ALL
  SELECT 'Cruz Studio Reels Package', 'Premiere Pro' UNION ALL SELECT 'Cruz Studio Reels Package', 'After Effects' UNION ALL
  SELECT 'Ramos Bakehouse Promo Video', 'Premiere Pro' UNION ALL SELECT 'Ramos Bakehouse Promo Video', 'After Effects' UNION ALL
  SELECT 'Green Basket Inventory Cleanup', 'Data Entry' UNION ALL SELECT 'Green Basket Inventory Cleanup', 'Microsoft Excel' UNION ALL
  SELECT 'Northstar Enrollment Records', 'Microsoft Excel' UNION ALL SELECT 'Northstar Enrollment Records', 'Virtual Assistance'
) x
JOIN projects p ON p.title = x.title
JOIN skills s ON s.name = x.skill
JOIN users c ON c.id = p.client_id AND c.email LIKE '%@demo.toptunity.local';

-- Varied proposals for open and contracted projects. Unique project/freelancer pairs make reruns safe.
INSERT INTO proposals (project_id, freelancer_id, offer, days, cover_letter, status, created_at)
SELECT p.id, f.id, x.offer, x.days, x.cover_letter, x.proposal_status, DATE_SUB(NOW(), INTERVAL x.age_days DAY)
FROM (
  SELECT 'Kape Lokal Ordering Website' AS title, 'miguel.cruz@demo.toptunity.local' AS email, 45500 AS offer, 24 AS days, 'I have built ordering and inventory tools for small businesses. I would start with the pickup flow, then test the staff dashboard on mobile.' AS cover_letter, 'pending' AS proposal_status, 1 AS age_days UNION ALL
  SELECT 'Kape Lokal Ordering Website', 'kyla.torres@demo.toptunity.local', 47000, 28, 'I can map the customer journey first and then build the responsive ordering experience in React with a clear handover.', 'pending', 2 UNION ALL
  SELECT 'Clinic Booking Website', 'miguel.cruz@demo.toptunity.local', 59000, 28, 'I will deliver the booking flow and staff schedule with clear validation and a concise setup guide.', 'selected', 58 UNION ALL
  SELECT 'Clinic Booking Website', 'jerome.castillo@demo.toptunity.local', 62000, 32, 'My PHP and MySQL experience fits the requested patient and staff workflows. I can include testing and deployment notes.', 'not_selected', 60 UNION ALL
  SELECT 'Lim Logistics Tracking App', 'ramon.villanueva@demo.toptunity.local', 118000, 55, 'I have delivered Flutter and Firebase apps with status updates. I would stage the driver and customer flows for review.', 'pending', 1 UNION ALL
  SELECT 'Lim Logistics Tracking App', 'jerome.castillo@demo.toptunity.local', 121000, 62, 'I can design the tracking API and data model first, then coordinate the mobile integration with documented endpoints.', 'pending', 2 UNION ALL
  SELECT 'Resort Guest Companion App', 'ramon.villanueva@demo.toptunity.local', 92000, 50, 'I will build the guest request and booking screens in Flutter and provide a test build with release notes.', 'selected', 68 UNION ALL
  SELECT 'Ramos Bakehouse Brand Kit', 'bea.lim@demo.toptunity.local', 14800, 12, 'I will share three visual directions, refine the selected identity, and provide packaging-ready and digital exports.', 'pending', 2 UNION ALL
  SELECT 'Ramos Bakehouse Brand Kit', 'janelle.aquino@demo.toptunity.local', 15500, 15, 'I can connect the brand system to a small set of digital templates and present the concepts in a review-ready file.', 'pending', 3 UNION ALL
  SELECT 'Flores Home Goods Product Set', 'bea.lim@demo.toptunity.local', 11500, 8, 'I will standardize the product imagery and prepare reusable promotional layouts in the same visual system.', 'selected', 51 UNION ALL
  SELECT 'Fitness Studio Member Experience', 'janelle.aquino@demo.toptunity.local', 450, 36, 'I will map the class discovery and booking journey, then prototype the key screens for a quick stakeholder review.', 'pending', 1 UNION ALL
  SELECT 'Fitness Studio Member Experience', 'kyla.torres@demo.toptunity.local', 470, 40, 'I can deliver a clickable Figma prototype with accessible components and a concise interaction specification.', 'pending', 2 UNION ALL
  SELECT 'Northstar Learning Portal Redesign', 'janelle.aquino@demo.toptunity.local', 34000, 20, 'I will simplify course navigation and make the student and parent views easier to scan on smaller screens.', 'selected', 62 UNION ALL
  SELECT 'Green Basket Product Guides', 'ana.mendoza@demo.toptunity.local', 13200, 12, 'I will create a consistent product voice, write the articles, and provide a lightweight SEO checklist.', 'pending', 3 UNION ALL
  SELECT 'Herrera Property Area Guides', 'ana.mendoza@demo.toptunity.local', 17000, 16, 'I will research each area, draft listing copy in the same voice, and share the editable content for review.', 'selected', 75 UNION ALL
  SELECT 'Dizon Resort Social Campaign', 'paolo.garcia@demo.toptunity.local', 410, 30, 'I will prepare the content calendar and campaign variants, then report reach and engagement each week.', 'pending', 2 UNION ALL
  SELECT 'Kape Lokal Launch Campaign', 'paolo.garcia@demo.toptunity.local', 26000, 25, 'I will test local audiences and creative variations, keep weekly notes, and adjust spend based on results.', 'selected', 25 UNION ALL
  SELECT 'Cruz Studio Reels Package', 'noel.bautista@demo.toptunity.local', 21000, 14, 'I will edit a first reel for feedback, then apply the approved caption and title style to the remaining clips.', 'pending', 1 UNION ALL
  SELECT 'Ramos Bakehouse Promo Video', 'noel.bautista@demo.toptunity.local', 14500, 10, 'I will assemble the supplied footage into a warm short profile with readable captions and a clean audio mix.', 'selected', 47 UNION ALL
  SELECT 'Green Basket Inventory Cleanup', 'rhea.santos@demo.toptunity.local', 240, 24, 'I will reconcile the sheet, document any uncertain records, and provide a reusable weekly stock template.', 'pending', 1 UNION ALL
  SELECT 'Northstar Enrollment Records', 'rhea.santos@demo.toptunity.local', 10500, 10, 'I will clean the enrollment list, preserve an audit copy, and build a tracker that staff can update safely.', 'selected', 83
) x
JOIN projects p ON p.title = x.title
JOIN users c ON c.id = p.client_id AND c.email LIKE '%@demo.toptunity.local'
JOIN users f ON f.email = x.email
WHERE NOT EXISTS (
  SELECT 1 FROM proposals old WHERE old.project_id = p.id AND old.freelancer_id = f.id
);

-- Escrow and release history for completed projects; a held payment for the ongoing contract.
INSERT INTO payments (project_id, type, amount, service_fee, status, created_at)
SELECT p.id, x.payment_type, x.amount, x.service_fee, x.payment_status, DATE_SUB(NOW(), INTERVAL x.age_days DAY)
FROM (
  SELECT 'Clinic Booking Website' AS title, 'escrow' AS payment_type, 59000 AS amount, 0 AS service_fee, 'paid' AS payment_status, 55 AS age_days UNION ALL
  SELECT 'Clinic Booking Website', 'release', 59000, 5900, 'released', 45 UNION ALL
  SELECT 'Resort Guest Companion App', 'escrow', 92000, 0, 'paid', 65 UNION ALL
  SELECT 'Resort Guest Companion App', 'release', 92000, 9200, 'released', 53 UNION ALL
  SELECT 'Flores Home Goods Product Set', 'escrow', 11500, 0, 'paid', 48 UNION ALL
  SELECT 'Flores Home Goods Product Set', 'release', 11500, 1150, 'released', 39 UNION ALL
  SELECT 'Northstar Learning Portal Redesign', 'escrow', 34000, 0, 'paid', 58 UNION ALL
  SELECT 'Northstar Learning Portal Redesign', 'release', 34000, 3400, 'released', 46 UNION ALL
  SELECT 'Herrera Property Area Guides', 'escrow', 17000, 0, 'paid', 72 UNION ALL
  SELECT 'Herrera Property Area Guides', 'release', 17000, 1700, 'released', 60 UNION ALL
  SELECT 'Ramos Bakehouse Promo Video', 'escrow', 14500, 0, 'paid', 42 UNION ALL
  SELECT 'Ramos Bakehouse Promo Video', 'release', 14500, 1450, 'released', 34 UNION ALL
  SELECT 'Northstar Enrollment Records', 'escrow', 10500, 0, 'paid', 80 UNION ALL
  SELECT 'Northstar Enrollment Records', 'release', 10500, 1050, 'released', 69 UNION ALL
  SELECT 'Kape Lokal Launch Campaign', 'escrow', 26000, 0, 'held', 18
) x
JOIN projects p ON p.title = x.title
JOIN users c ON c.id = p.client_id AND c.email LIKE '%@demo.toptunity.local'
WHERE NOT EXISTS (SELECT 1 FROM payments old WHERE old.project_id = p.id AND old.type = x.payment_type);

-- Completion records for the freelancer dashboards and delivery history.
INSERT INTO project_submissions (project_id, freelancer_id, message, status, review_note, created_at)
SELECT p.id, f.id, x.message, 'approved', x.review_note, DATE_SUB(NOW(), INTERVAL x.age_days DAY)
FROM (
  SELECT 'Clinic Booking Website' AS title, 'Completed patient booking and staff scheduling pages with setup notes.' AS message, 'Clear handover and the staff flow works as discussed.' AS review_note, 44 AS age_days UNION ALL
  SELECT 'Resort Guest Companion App', 'Delivered the guest request flow and Android test build with release notes.', 'The test build was easy to review and the updates were clear.', 52 UNION ALL
  SELECT 'Flores Home Goods Product Set', 'Delivered the revised product image set and editable promotional layouts.', 'Consistent visual treatment across the product collection.', 38 UNION ALL
  SELECT 'Northstar Learning Portal Redesign', 'Delivered the final prototype and annotated component states.', 'The new navigation is much easier for families to follow.', 45 UNION ALL
  SELECT 'Herrera Property Area Guides', 'Delivered the area guides, listing copy, and editable source document.', 'Well-researched writing and quick, thoughtful revisions.', 59 UNION ALL
  SELECT 'Ramos Bakehouse Promo Video', 'Delivered the final short video with captions and social exports.', 'The video feels on brand and is ready to post.', 33 UNION ALL
  SELECT 'Northstar Enrollment Records', 'Delivered the cleaned records, reconciliation notes, and reusable tracker.', 'The tracker is clear and reduced our weekly cleanup time.', 68
) x
JOIN projects p ON p.title = x.title AND p.status = 'completed'
JOIN users c ON c.id = p.client_id AND c.email LIKE '%@demo.toptunity.local'
JOIN users f ON f.id = p.freelancer_id
WHERE NOT EXISTS (SELECT 1 FROM project_submissions old WHERE old.project_id = p.id AND old.status = 'approved');

-- Different client and freelancer reviews on completed work.
INSERT INTO reviews (reviewer_id, reviewee_id, project_id, rating, body, created_at)
SELECT reviewer.id, reviewee.id, p.id, x.rating, x.body, DATE_SUB(NOW(), INTERVAL x.age_days DAY)
FROM (
  SELECT 'Clinic Booking Website' AS title, 'andrea.reyes@demo.toptunity.local' AS reviewer_email, 'miguel.cruz@demo.toptunity.local' AS reviewee_email, 5 AS rating, 'Miguel understood the clinic workflow quickly and delivered a reliable booking flow with a clear handover.' AS body, 43 AS age_days UNION ALL
  SELECT 'Clinic Booking Website', 'miguel.cruz@demo.toptunity.local', 'andrea.reyes@demo.toptunity.local', 5, 'Andrea gave a detailed brief and timely feedback. The project stayed organized from start to finish.', 42 UNION ALL
  SELECT 'Resort Guest Companion App', 'carlo.dizon@demo.toptunity.local', 'ramon.villanueva@demo.toptunity.local', 5, 'The guest request flow is smooth, and Ramon kept us informed throughout testing.', 51 UNION ALL
  SELECT 'Resort Guest Companion App', 'ramon.villanueva@demo.toptunity.local', 'carlo.dizon@demo.toptunity.local', 4, 'Carlo had a clear vision and responded quickly. A few new ideas came in late but we worked them through.', 50 UNION ALL
  SELECT 'Flores Home Goods Product Set', 'mia.flores@demo.toptunity.local', 'bea.lim@demo.toptunity.local', 4, 'The images now feel consistent across the shop. One extra revision was needed, but the final set looks great.', 37 UNION ALL
  SELECT 'Flores Home Goods Product Set', 'bea.lim@demo.toptunity.local', 'mia.flores@demo.toptunity.local', 5, 'Mia supplied excellent references and made decisions quickly, which helped us finish ahead of schedule.', 36 UNION ALL
  SELECT 'Northstar Learning Portal Redesign', 'noel.garcia@demo.toptunity.local', 'janelle.aquino@demo.toptunity.local', 5, 'Janelle made a complicated student portal much easier to understand. The prototype was polished and practical.', 44 UNION ALL
  SELECT 'Northstar Learning Portal Redesign', 'janelle.aquino@demo.toptunity.local', 'noel.garcia@demo.toptunity.local', 5, 'Noel brought useful feedback from both students and parents and kept reviews focused.', 43 UNION ALL
  SELECT 'Herrera Property Area Guides', 'paolo.herrera@demo.toptunity.local', 'ana.mendoza@demo.toptunity.local', 5, 'The neighborhood guides sound natural, are well researched, and match the tone we wanted.', 58 UNION ALL
  SELECT 'Herrera Property Area Guides', 'ana.mendoza@demo.toptunity.local', 'paolo.herrera@demo.toptunity.local', 4, 'Paolo provided clear source material and helpful edits. I would gladly work with him again.', 57 UNION ALL
  SELECT 'Ramos Bakehouse Promo Video', 'liza.ramos@demo.toptunity.local', 'noel.bautista@demo.toptunity.local', 5, 'The final edit captures the bakery perfectly and is ready to share on our social pages.', 32 UNION ALL
  SELECT 'Ramos Bakehouse Promo Video', 'noel.bautista@demo.toptunity.local', 'liza.ramos@demo.toptunity.local', 5, 'Liza shared great footage and gave thoughtful feedback. The collaboration was easy and positive.', 31 UNION ALL
  SELECT 'Northstar Enrollment Records', 'noel.garcia@demo.toptunity.local', 'rhea.santos@demo.toptunity.local', 4, 'Rhea cleaned a large set of records carefully and left useful notes for our staff.', 67 UNION ALL
  SELECT 'Northstar Enrollment Records', 'rhea.santos@demo.toptunity.local', 'noel.garcia@demo.toptunity.local', 5, 'Noel explained the requirements clearly and verified the tracker with the team before sign-off.', 66
) x
JOIN projects p ON p.title = x.title AND p.status = 'completed'
JOIN users c ON c.id = p.client_id AND c.email LIKE '%@demo.toptunity.local'
JOIN users f ON f.id = p.freelancer_id
JOIN users reviewer ON reviewer.email = x.reviewer_email
JOIN users reviewee ON reviewee.email = x.reviewee_email
WHERE NOT EXISTS (
  SELECT 1 FROM reviews old
  WHERE old.project_id = p.id AND old.reviewer_id = reviewer.id AND old.reviewee_id = reviewee.id
);

-- A small set of realistic conversation and notification activity for dashboard presentation.
INSERT INTO messages (sender_id, receiver_id, project_id, body, is_read, created_at)
SELECT sender.id, receiver.id, p.id, x.body, x.is_read, DATE_SUB(NOW(), INTERVAL x.age_hours HOUR)
FROM (
  SELECT 'andrea.reyes@demo.toptunity.local' AS sender_email, 'miguel.cruz@demo.toptunity.local' AS receiver_email, 'Clinic Booking Website' AS title, 'The staff team reviewed the booking flow. We are happy with the final handover, thank you.' AS body, 1 AS is_read, 106 AS age_hours UNION ALL
  SELECT 'miguel.cruz@demo.toptunity.local', 'andrea.reyes@demo.toptunity.local', 'Clinic Booking Website', 'Thanks, Andrea. I have added the setup notes and included the final tested version.', 1, 104 UNION ALL
  SELECT 'carlo.dizon@demo.toptunity.local', 'ramon.villanueva@demo.toptunity.local', 'Resort Guest Companion App', 'Could we review the guest request screen together before the next test build?', 0, 3 UNION ALL
  SELECT 'ramon.villanueva@demo.toptunity.local', 'carlo.dizon@demo.toptunity.local', 'Resort Guest Companion App', 'Absolutely. I will share the updated build and a short list of changes this afternoon.', 0, 1 UNION ALL
  SELECT 'liza.ramos@demo.toptunity.local', 'bea.lim@demo.toptunity.local', 'Ramos Bakehouse Brand Kit', 'The second color direction feels closest to the shop. Can we see it on a paper bag mockup?', 0, 5 UNION ALL
  SELECT 'bea.lim@demo.toptunity.local', 'liza.ramos@demo.toptunity.local', 'Ramos Bakehouse Brand Kit', 'Yes, I will prepare that mockup and send it with the revised logo lockup.', 0, 2
) x
JOIN users sender ON sender.email = x.sender_email
JOIN users receiver ON receiver.email = x.receiver_email
JOIN projects p ON p.title = x.title
JOIN users c ON c.id = p.client_id AND c.email LIKE '%@demo.toptunity.local'
WHERE NOT EXISTS (
  SELECT 1 FROM messages old
  WHERE old.sender_id = sender.id AND old.receiver_id = receiver.id AND old.project_id = p.id AND old.body = x.body
);

INSERT INTO notifications (user_id, category, title, body, is_read, created_at)
SELECT u.id, x.category, x.title, x.body, x.is_read, DATE_SUB(NOW(), INTERVAL x.age_hours HOUR)
FROM (
  SELECT 'andrea.reyes@demo.toptunity.local' AS email, 'responses' AS category, 'Project completed' AS title, 'The Clinic Booking Website has been completed and reviewed.' AS body, 0 AS is_read, 44 AS age_hours UNION ALL
  SELECT 'andrea.reyes@demo.toptunity.local', 'projects', 'New proposal received', 'A freelancer submitted a proposal for the Kape Lokal Ordering Website.', 0, 2 UNION ALL
  SELECT 'miguel.cruz@demo.toptunity.local', 'payments', 'Payment released', 'Your payment for the Clinic Booking Website has been released.', 1, 43 UNION ALL
  SELECT 'bea.lim@demo.toptunity.local', 'responses', 'New review received', 'Mia Flores left a review for your completed product design project.', 0, 36 UNION ALL
  SELECT 'ramon.villanueva@demo.toptunity.local', 'messages', 'New message', 'Carlo Dizon sent a message about the guest companion app.', 0, 3 UNION ALL
  SELECT 'paolo.garcia@demo.toptunity.local', 'projects', 'Contract in progress', 'The Kape Lokal Launch Campaign contract is active.', 1, 18
) x
JOIN users u ON u.email = x.email
WHERE NOT EXISTS (
  SELECT 1 FROM notifications old
  WHERE old.user_id = u.id AND old.title = x.title AND old.body = x.body
);
