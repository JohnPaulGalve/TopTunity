-- demo-seed.sql: ALL demo data in one file (accounts, profiles, projects, proposals, contracts, payments, reviews, portfolio).
-- Run AFTER the schema files. Safe to run twice. Password for every demo account: Demo12345
-- Remove demo data later with: DELETE FROM users WHERE email LIKE '%@demo.toptunity.local';
-- demo-seed.sql: 5 demo clients, 5 demo freelancers, projects, proposals, contracts and payments.
-- Run AFTER all the schema files. Safe to run twice (existing demo rows are skipped).
-- Every demo account uses the password:  Demo12345
-- Delete the demo accounts later with:  DELETE FROM users WHERE email LIKE '%@demo.toptunity.local';

SET @pw := '$2y$10$i9czN7gzkC4Aipq1ZfluK.1n8WjL6Bnu6BZIH8HAVJhHg.P4BCNkG';

-- Categories and skills (same names the site uses)
INSERT IGNORE INTO categories (name) VALUES ('Web Development'), ('Mobile App Development'), ('Graphic Design'),
  ('UI/UX Design'), ('Writing and Content'), ('Digital Marketing'), ('Video and Animation'), ('Data Entry and Admin');

INSERT INTO skills (name, category_id)
SELECT s.name, c.id FROM (
  SELECT 'PHP' AS name, 'Web Development' AS cat UNION ALL SELECT 'MySQL', 'Web Development'
  UNION ALL SELECT 'JavaScript', 'Web Development' UNION ALL SELECT 'Laravel', 'Web Development'
  UNION ALL SELECT 'Bootstrap', 'Web Development' UNION ALL SELECT 'REST API', 'Web Development'
  UNION ALL SELECT 'HTML/CSS', 'Web Development' UNION ALL SELECT 'React', 'Web Development'
  UNION ALL SELECT 'Flutter', 'Mobile App Development' UNION ALL SELECT 'Firebase', 'Mobile App Development'
  UNION ALL SELECT 'Logo Design', 'Graphic Design' UNION ALL SELECT 'Adobe Illustrator', 'Graphic Design'
  UNION ALL SELECT 'Photoshop', 'Graphic Design' UNION ALL SELECT 'Figma', 'UI/UX Design'
  UNION ALL SELECT 'UI Design', 'UI/UX Design' UNION ALL SELECT 'Social Media Marketing', 'Digital Marketing'
  UNION ALL SELECT 'Copywriting', 'Writing and Content'
) s JOIN categories c ON c.name = s.cat
WHERE NOT EXISTS (SELECT 1 FROM skills k WHERE k.name = s.name);

-- Demo clients
INSERT IGNORE INTO users (name, email, password_hash, role, status) VALUES
  ('Andrea Reyes', 'andrea.reyes@demo.toptunity.local', @pw, 'client', 'active'),
  ('Mark Santos', 'mark.santos@demo.toptunity.local', @pw, 'client', 'active'),
  ('Liza Ramos', 'liza.ramos@demo.toptunity.local', @pw, 'client', 'active'),
  ('Carlo Dizon', 'carlo.dizon@demo.toptunity.local', @pw, 'client', 'active'),
  ('Grace Lim', 'grace.lim@demo.toptunity.local', @pw, 'client', 'active');

-- Demo freelancers
INSERT IGNORE INTO users (name, email, password_hash, role, status) VALUES
  ('Miguel Cruz', 'miguel.cruz@demo.toptunity.local', @pw, 'freelancer', 'active'),
  ('Bea Lim', 'bea.lim@demo.toptunity.local', @pw, 'freelancer', 'active'),
  ('Jerome Castillo', 'jerome.castillo@demo.toptunity.local', @pw, 'freelancer', 'active'),
  ('Janelle Aquino', 'janelle.aquino@demo.toptunity.local', @pw, 'freelancer', 'active'),
  ('Ramon Villanueva', 'ramon.villanueva@demo.toptunity.local', @pw, 'freelancer', 'active');

-- Client profiles
INSERT IGNORE INTO client_profiles (user_id, company, location, phone, about)
SELECT id, 'Kape Lokal', 'Quezon City, Philippines', '+63 917 555 0101', 'We run two coffee shops and want a simple online ordering system for our customers.' FROM users WHERE email = 'andrea.reyes@demo.toptunity.local'
UNION ALL SELECT id, 'Santos Family Clinic', 'Makati City, Philippines', '+63 917 555 0102', 'A family clinic looking for an online appointment booking system for patients.' FROM users WHERE email = 'mark.santos@demo.toptunity.local'
UNION ALL SELECT id, 'Ramos Bakehouse', 'Cebu City, Philippines', '+63 917 555 0103', 'A small bakery that needs a logo and brand kit for its new packaging.' FROM users WHERE email = 'liza.ramos@demo.toptunity.local'
UNION ALL SELECT id, 'Dizon Resort', 'Batangas, Philippines', '+63 917 555 0104', 'A beach resort looking for social media help to grow bookings.' FROM users WHERE email = 'carlo.dizon@demo.toptunity.local'
UNION ALL SELECT id, 'Lim Logistics', 'Davao City, Philippines', '+63 917 555 0105', 'A delivery company that wants a mobile app for tracking shipments in real time.' FROM users WHERE email = 'grace.lim@demo.toptunity.local';

-- Freelancer profiles
INSERT IGNORE INTO freelancer_profiles (user_id, title, location, hourly_rate, languages, about, available, phone)
SELECT id, 'Full-Stack PHP Developer', 'Cebu City, Philippines', 250, 'English, Cebuano', 'I build PHP and MySQL web systems for small businesses, including ordering, booking and inventory tools. I write clean code and explain every step.', 1, '+63 917 555 0201' FROM users WHERE email = 'miguel.cruz@demo.toptunity.local'
UNION ALL SELECT id, 'Graphic Designer', 'Quezon City, Philippines', 200, 'English, Filipino', 'Logo and brand designer for food and retail businesses. I deliver print-ready files and a short brand guide.', 1, '+63 917 555 0202' FROM users WHERE email = 'bea.lim@demo.toptunity.local'
UNION ALL SELECT id, 'Backend and REST API Developer', 'Davao City, Philippines', 280, 'English, Filipino', 'I design REST APIs and database structures for web and mobile apps, with clear documentation.', 1, '+63 917 555 0203' FROM users WHERE email = 'jerome.castillo@demo.toptunity.local'
UNION ALL SELECT id, 'Web and Database Developer', 'Bacolod City, Philippines', 300, 'English, Hiligaynon', 'Frontend and database developer for responsive websites, with a focus on clean layouts and fast pages.', 1, '+63 917 555 0204' FROM users WHERE email = 'janelle.aquino@demo.toptunity.local'
UNION ALL SELECT id, 'Mobile App Developer', 'Iloilo City, Philippines', 320, 'English, Ilonggo', 'Flutter developer for Android and iOS apps, with Firebase backends and clear progress updates.', 1, '+63 917 555 0205' FROM users WHERE email = 'ramon.villanueva@demo.toptunity.local';

-- Freelancer skills
INSERT IGNORE INTO freelancer_skills (freelancer_id, skill_id)
SELECT u.id, s.id FROM users u JOIN skills s ON s.name IN ('PHP','MySQL','JavaScript','Laravel','Bootstrap') WHERE u.email = 'miguel.cruz@demo.toptunity.local'
UNION ALL SELECT u.id, s.id FROM users u JOIN skills s ON s.name IN ('Logo Design','Adobe Illustrator','Photoshop','Figma') WHERE u.email = 'bea.lim@demo.toptunity.local'
UNION ALL SELECT u.id, s.id FROM users u JOIN skills s ON s.name IN ('REST API','PHP','MySQL') WHERE u.email = 'jerome.castillo@demo.toptunity.local'
UNION ALL SELECT u.id, s.id FROM users u JOIN skills s ON s.name IN ('HTML/CSS','JavaScript','MySQL','React') WHERE u.email = 'janelle.aquino@demo.toptunity.local'
UNION ALL SELECT u.id, s.id FROM users u JOIN skills s ON s.name IN ('Flutter','Firebase','UI Design') WHERE u.email = 'ramon.villanueva@demo.toptunity.local';

-- Projects (open, ongoing and completed). Each is added only once, by title.
INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, created_at)
SELECT u.id, c.id, 'Online Ordering Website for a Coffee Shop',
  'We need a website where customers can browse the menu, add items to a cart, choose pick-up time and pay on pick-up. Include a staff dashboard to see and update orders.',
  'fixed', 45000, 0, 0, '2026-12-20', 'open', 'none', NOW()
FROM users u JOIN categories c ON c.name = 'Web Development' WHERE u.email = 'andrea.reyes@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Online Ordering Website for a Coffee Shop');

INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, created_at)
SELECT u.id, c.id, 'Clinic Appointment Booking System',
  'A booking page where patients pick a doctor, date and time slot, plus an admin page for the clinic staff to confirm or move appointments.',
  'fixed', 60000, 0, 0, '2026-12-30', 'open', 'none', NOW()
FROM users u JOIN categories c ON c.name = 'Web Development' WHERE u.email = 'mark.santos@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Clinic Appointment Booking System');

INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, created_at)
SELECT u.id, c.id, 'Logo and Brand Kit for a Bakery',
  'A new logo, color palette and typeface choices, with print-ready files for boxes, bags and stickers.',
  'fixed', 8000, 0, 0, '2026-11-30', 'open', 'none', NOW()
FROM users u JOIN categories c ON c.name = 'Graphic Design' WHERE u.email = 'liza.ramos@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Logo and Brand Kit for a Bakery');

INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, created_at)
SELECT u.id, c.id, 'Social Media Management for a Beach Resort',
  'Plan and post weekly content on Facebook and Instagram, reply to comments and report the results each month.',
  'hourly', 0, 350, 40, '2026-12-15', 'open', 'none', NOW()
FROM users u JOIN categories c ON c.name = 'Digital Marketing' WHERE u.email = 'carlo.dizon@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Social Media Management for a Beach Resort');

INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, created_at)
SELECT u.id, c.id, 'Mobile App for Delivery Tracking',
  'An Android and iOS app where drivers update delivery status and customers see live progress on a map.',
  'fixed', 120000, 0, 0, '2027-02-28', 'open', 'none', NOW()
FROM users u JOIN categories c ON c.name = 'Mobile App Development' WHERE u.email = 'grace.lim@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Mobile App for Delivery Tracking');

INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, freelancer_id, agreed_amount, created_at)
SELECT u.id, c.id, 'Inventory Dashboard for a Sari-Sari Store',
  'A simple inventory page to add products, record stock in and out, and see low-stock alerts.',
  'hourly', 0, 300, 60, '2026-12-05', 'open', 'pending', f.id, 18000, NOW() - INTERVAL 2 DAY
FROM users u JOIN categories c ON c.name = 'Web Development'
JOIN users f ON f.email = 'miguel.cruz@demo.toptunity.local'
WHERE u.email = 'andrea.reyes@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Inventory Dashboard for a Sari-Sari Store');

INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, freelancer_id, agreed_amount, created_at)
SELECT u.id, c.id, 'Product Photo Editing for an Online Shop',
  'Clean up 30 product photos: remove backgrounds, match colors and export web and print sizes.',
  'fixed', 6000, 0, 0, '2026-10-25', 'completed', 'completed', f.id, 6000, NOW() - INTERVAL 20 DAY
FROM users u JOIN categories c ON c.name = 'Graphic Design'
JOIN users f ON f.email = 'bea.lim@demo.toptunity.local'
WHERE u.email = 'mark.santos@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Product Photo Editing for an Online Shop');

-- Project skills
INSERT IGNORE INTO project_skills (project_id, skill_id)
SELECT p.id, s.id FROM projects p JOIN skills s ON s.name IN ('PHP','MySQL','JavaScript') WHERE p.title = 'Online Ordering Website for a Coffee Shop'
UNION ALL SELECT p.id, s.id FROM projects p JOIN skills s ON s.name IN ('Laravel','MySQL') WHERE p.title = 'Clinic Appointment Booking System'
UNION ALL SELECT p.id, s.id FROM projects p JOIN skills s ON s.name IN ('Logo Design','Adobe Illustrator') WHERE p.title = 'Logo and Brand Kit for a Bakery'
UNION ALL SELECT p.id, s.id FROM projects p JOIN skills s ON s.name IN ('Social Media Marketing','Copywriting') WHERE p.title = 'Social Media Management for a Beach Resort'
UNION ALL SELECT p.id, s.id FROM projects p JOIN skills s ON s.name IN ('Flutter','Firebase') WHERE p.title = 'Mobile App for Delivery Tracking'
UNION ALL SELECT p.id, s.id FROM projects p JOIN skills s ON s.name IN ('PHP','MySQL') WHERE p.title = 'Inventory Dashboard for a Sari-Sari Store'
UNION ALL SELECT p.id, s.id FROM projects p JOIN skills s ON s.name IN ('Photoshop','Adobe Illustrator') WHERE p.title = 'Product Photo Editing for an Online Shop';

-- Proposals on the open projects, and the accepted ones on the ongoing and completed projects
INSERT IGNORE INTO proposals (project_id, freelancer_id, offer, days, cover_letter, status, created_at)
SELECT p.id, f.id, 42000, 21, 'I have built several ordering systems for cafes in Cebu. I can deliver the menu, cart, pick-up scheduling and a staff dashboard within three weeks.', 'pending', NOW() FROM projects p JOIN users f ON f.email = 'miguel.cruz@demo.toptunity.local' WHERE p.title = 'Online Ordering Website for a Coffee Shop'
UNION ALL SELECT p.id, f.id, 45000, 25, 'I can build the full ordering flow and the staff view with clean, mobile-friendly pages and a short training guide.', 'pending', NOW() FROM projects p JOIN users f ON f.email = 'janelle.aquino@demo.toptunity.local' WHERE p.title = 'Online Ordering Website for a Coffee Shop'
UNION ALL SELECT p.id, f.id, 58000, 30, 'I design booking systems with clear time-slot rules and an admin view for staff. I include testing before handover.', 'pending', NOW() FROM projects p JOIN users f ON f.email = 'jerome.castillo@demo.toptunity.local' WHERE p.title = 'Clinic Appointment Booking System'
UNION ALL SELECT p.id, f.id, 60000, 35, 'Laravel and MySQL are my main stack. I will deliver the booking page, the admin view and a handover document.', 'pending', NOW() FROM projects p JOIN users f ON f.email = 'miguel.cruz@demo.toptunity.local' WHERE p.title = 'Clinic Appointment Booking System'
UNION ALL SELECT p.id, f.id, 7500, 7, 'Logo and brand kit is my specialty. I will send three concepts and then finish the one you pick with all print files.', 'pending', NOW() FROM projects p JOIN users f ON f.email = 'bea.lim@demo.toptunity.local' WHERE p.title = 'Logo and Brand Kit for a Bakery'
UNION ALL SELECT p.id, f.id, 330, 40, 'I manage resort social pages every week and report the results monthly. My hourly rate includes content planning.', 'pending', NOW() FROM projects p JOIN users f ON f.email = 'janelle.aquino@demo.toptunity.local' WHERE p.title = 'Social Media Management for a Beach Resort'
UNION ALL SELECT p.id, f.id, 115000, 60, 'I have built delivery and tracking apps in Flutter with Firebase. I will include driver and customer screens and live map updates.', 'pending', NOW() FROM projects p JOIN users f ON f.email = 'ramon.villanueva@demo.toptunity.local' WHERE p.title = 'Mobile App for Delivery Tracking'
UNION ALL SELECT p.id, f.id, 300, 60, 'I will build the inventory dashboard with stock in and out records and low-stock alerts.', 'selected', NOW() FROM projects p JOIN users f ON f.email = 'miguel.cruz@demo.toptunity.local' WHERE p.title = 'Inventory Dashboard for a Sari-Sari Store'
UNION ALL SELECT p.id, f.id, 6000, 5, 'I will clean up all 30 photos with consistent colors and export both web and print sizes.', 'selected', NOW() FROM projects p JOIN users f ON f.email = 'bea.lim@demo.toptunity.local' WHERE p.title = 'Product Photo Editing for an Online Shop';

-- Payments for the completed project only (escrow paid, then released with the 10% fee). The Sari-Sari offer is still waiting for the freelancer to accept, so it has no payment yet.
INSERT INTO payments (project_id, type, amount, service_fee, status, created_at)
SELECT p.id, 'escrow', 6000, 0, 'paid', NOW() - INTERVAL 20 DAY FROM projects p WHERE p.title = 'Product Photo Editing for an Online Shop' AND NOT EXISTS (SELECT 1 FROM payments x WHERE x.project_id = p.id)
UNION ALL SELECT p.id, 'release', 6000, 600, 'released', NOW() - INTERVAL 2 DAY FROM projects p WHERE p.title = 'Product Photo Editing for an Online Shop' AND NOT EXISTS (SELECT 1 FROM payments x WHERE x.project_id = p.id AND x.type = 'release')
;

-- Platform reviews (published, one per user)
INSERT IGNORE INTO platform_reviews (user_id, rating, body, status)
SELECT u.id, 5, 'TopTunity made it easy to find a designer and keep track of every step. The payment process was clear.', 'published' FROM users u WHERE u.email = 'liza.ramos@demo.toptunity.local'
UNION ALL SELECT u.id, 4, 'I found steady clients here. The proposal and contract steps are simple, and I always know where a project stands.', 'published' FROM users u WHERE u.email = 'miguel.cruz@demo.toptunity.local'
UNION ALL SELECT u.id, 5, 'We posted our project in the morning and had several good proposals by the afternoon. Very helpful for a small business.', 'published' FROM users u WHERE u.email = 'andrea.reyes@demo.toptunity.local';

-- ===== Portfolio, completed projects, payments and reviews =====

-- Two more completed projects (fixed price)
INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, freelancer_id, agreed_amount, created_at)
SELECT c.id, cat.id, 'Clinic Website Redesign',
  'Redesign the clinic website with a new booking page, service list and mobile-friendly layout.',
  'fixed', 35000, 0, 0, '2026-10-10', 'completed', 'completed', f.id, 35000, NOW() - INTERVAL 40 DAY
FROM users c JOIN categories cat ON cat.name = 'Web Development' JOIN users f ON f.email = 'jerome.castillo@demo.toptunity.local'
WHERE c.email = 'mark.santos@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Clinic Website Redesign');

INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, freelancer_id, agreed_amount, created_at)
SELECT c.id, cat.id, 'Resort Booking Mobile App',
  'A mobile app where guests check room availability, book a stay and pay a deposit.',
  'fixed', 90000, 0, 0, '2026-09-30', 'completed', 'completed', f.id, 90000, NOW() - INTERVAL 60 DAY
FROM users c JOIN categories cat ON cat.name = 'Mobile App Development' JOIN users f ON f.email = 'ramon.villanueva@demo.toptunity.local'
WHERE c.email = 'carlo.dizon@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Resort Booking Mobile App');

-- Accepted proposals for those two projects
INSERT IGNORE INTO proposals (project_id, freelancer_id, offer, days, cover_letter, status, created_at)
SELECT p.id, f.id, 35000, 14, 'I redesign clinic websites with clear booking steps and a mobile-friendly layout. I will walk the team through every page.', 'selected', NOW() - INTERVAL 45 DAY
FROM projects p JOIN users f ON f.email = 'jerome.castillo@demo.toptunity.local' WHERE p.title = 'Clinic Website Redesign'
UNION ALL SELECT p.id, f.id, 90000, 45, 'I have built booking apps in Flutter with Firebase. I will deliver Android and iOS builds with a test release.', 'selected', NOW() - INTERVAL 65 DAY
FROM projects p JOIN users f ON f.email = 'ramon.villanueva@demo.toptunity.local' WHERE p.title = 'Resort Booking Mobile App';

-- Payments: escrow paid, then released with the 10% fee
INSERT INTO payments (project_id, type, amount, service_fee, status, created_at)
SELECT p.id, 'escrow', 35000, 0, 'paid', NOW() - INTERVAL 40 DAY FROM projects p WHERE p.title = 'Clinic Website Redesign' AND NOT EXISTS (SELECT 1 FROM payments x WHERE x.project_id = p.id)
UNION ALL SELECT p.id, 'release', 35000, 3500, 'released', NOW() - INTERVAL 30 DAY FROM projects p WHERE p.title = 'Clinic Website Redesign' AND NOT EXISTS (SELECT 1 FROM payments x WHERE x.project_id = p.id AND x.type = 'release')
UNION ALL SELECT p.id, 'escrow', 90000, 0, 'paid', NOW() - INTERVAL 60 DAY FROM projects p WHERE p.title = 'Resort Booking Mobile App' AND NOT EXISTS (SELECT 1 FROM payments x WHERE x.project_id = p.id)
UNION ALL SELECT p.id, 'release', 90000, 9000, 'released', NOW() - INTERVAL 50 DAY FROM projects p WHERE p.title = 'Resort Booking Mobile App' AND NOT EXISTS (SELECT 1 FROM payments x WHERE x.project_id = p.id AND x.type = 'release');

-- Reviews on the completed projects, both directions
INSERT INTO reviews (reviewer_id, reviewee_id, project_id, rating, body, created_at)
SELECT c.id, f.id, p.id, 5, 'Fast turnaround and clean edits. Our product photos look consistent now.', NOW() - INTERVAL 3 DAY
FROM projects p JOIN users c ON c.id = p.client_id JOIN users f ON f.id = p.freelancer_id
WHERE p.title = 'Product Photo Editing for an Online Shop' AND NOT EXISTS (SELECT 1 FROM reviews r WHERE r.reviewer_id = c.id AND r.project_id = p.id)
UNION ALL SELECT f.id, c.id, p.id, 5, 'Clear brief and quick feedback. Easy client to work with.', NOW() - INTERVAL 3 DAY
FROM projects p JOIN users c ON c.id = p.client_id JOIN users f ON f.id = p.freelancer_id
WHERE p.title = 'Product Photo Editing for an Online Shop' AND NOT EXISTS (SELECT 1 FROM reviews r WHERE r.reviewer_id = f.id AND r.project_id = p.id)
UNION ALL SELECT c.id, f.id, p.id, 5, 'Our booking page is simple and fast now. Jerome explained every change.', NOW() - INTERVAL 28 DAY
FROM projects p JOIN users c ON c.id = p.client_id JOIN users f ON f.id = p.freelancer_id
WHERE p.title = 'Clinic Website Redesign' AND NOT EXISTS (SELECT 1 FROM reviews r WHERE r.reviewer_id = c.id AND r.project_id = p.id)
UNION ALL SELECT f.id, c.id, p.id, 4, 'Good scope and payment on time. Feedback could have come a little sooner.', NOW() - INTERVAL 28 DAY
FROM projects p JOIN users c ON c.id = p.client_id JOIN users f ON f.id = p.freelancer_id
WHERE p.title = 'Clinic Website Redesign' AND NOT EXISTS (SELECT 1 FROM reviews r WHERE r.reviewer_id = f.id AND r.project_id = p.id)
UNION ALL SELECT c.id, f.id, p.id, 5, 'Smooth app and very responsive. Guests can book in a few taps.', NOW() - INTERVAL 48 DAY
FROM projects p JOIN users c ON c.id = p.client_id JOIN users f ON f.id = p.freelancer_id
WHERE p.title = 'Resort Booking Mobile App' AND NOT EXISTS (SELECT 1 FROM reviews r WHERE r.reviewer_id = c.id AND r.project_id = p.id)
UNION ALL SELECT f.id, c.id, p.id, 5, 'Clear requirements and fair communication.', NOW() - INTERVAL 48 DAY
FROM projects p JOIN users c ON c.id = p.client_id JOIN users f ON f.id = p.freelancer_id
WHERE p.title = 'Resort Booking Mobile App' AND NOT EXISTS (SELECT 1 FROM reviews r WHERE r.reviewer_id = f.id AND r.project_id = p.id);

-- Portfolio items (two per freelancer)
INSERT INTO attachments (owner_type, owner_id, user_id, label, category, original_name, stored_name, size_label, file_type, created_at)
SELECT 'portfolio', u.id, u.id, x.label, x.cat, x.orig, x.stored, '8 KB', 'png', NOW() - INTERVAL 30 DAY
FROM (
  SELECT 'miguel.cruz@demo.toptunity.local' AS em, 'Coffee shop ordering app' AS label, 'Web Development' AS cat, 'coffee-shop-app.png' AS orig, 'demo-pf-01.png' AS stored
  UNION ALL SELECT 'miguel.cruz@demo.toptunity.local', 'Inventory admin panel', 'Web Development', 'inventory-panel.png', 'demo-pf-03.png'
  UNION ALL SELECT 'bea.lim@demo.toptunity.local', 'Logo set for a bakery', 'Graphic Design', 'bakery-logo.png', 'demo-pf-04.png'
  UNION ALL SELECT 'bea.lim@demo.toptunity.local', 'Product packaging mockup', 'Graphic Design', 'packaging-mockup.png', 'demo-pf-05.png'
  UNION ALL SELECT 'jerome.castillo@demo.toptunity.local', 'Clinic booking dashboard', 'Web Development', 'clinic-dashboard.png', 'demo-pf-02.png'
  UNION ALL SELECT 'jerome.castillo@demo.toptunity.local', 'REST API documentation', 'Web Development', 'api-docs.png', 'demo-pf-08.png'
  UNION ALL SELECT 'janelle.aquino@demo.toptunity.local', 'Responsive landing page', 'Web Development', 'landing-page.png', 'demo-pf-09.png'
  UNION ALL SELECT 'janelle.aquino@demo.toptunity.local', 'Resort social media plan', 'Digital Marketing', 'resort-social-plan.png', 'demo-pf-06.png'
  UNION ALL SELECT 'ramon.villanueva@demo.toptunity.local', 'Delivery tracking app', 'Mobile App Development', 'delivery-app.png', 'demo-pf-07.png'
  UNION ALL SELECT 'ramon.villanueva@demo.toptunity.local', 'Flutter booking app screens', 'Mobile App Development', 'booking-screens.png', 'demo-pf-10.png'
) x JOIN users u ON u.email = x.em
WHERE NOT EXISTS (SELECT 1 FROM attachments a WHERE a.owner_type = 'portfolio' AND a.user_id = u.id AND a.label = x.label);

-- ===== Reviews for Miguel Cruz and Janelle Aquino =====
-- Completed project for Miguel Cruz (client Andrea Reyes)
INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, freelancer_id, agreed_amount, created_at)
SELECT c.id, cat.id, 'Bakery Stock Dashboard',
  'A simple stock dashboard for the bakery: record ingredients in and out, and see low-stock alerts.',
  'fixed', 12000, 0, 0, '2026-09-20', 'completed', 'completed', f.id, 12000, NOW() - INTERVAL 50 DAY
FROM users c JOIN categories cat ON cat.name = 'Web Development' JOIN users f ON f.email = 'miguel.cruz@demo.toptunity.local'
WHERE c.email = 'andrea.reyes@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Bakery Stock Dashboard');

-- Completed project for Janelle Aquino (client Liza Ramos)
INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, freelancer_id, agreed_amount, created_at)
SELECT c.id, cat.id, 'Bakery Landing Page',
  'A one-page website for the bakery with the menu, store hours and a contact form.',
  'fixed', 9000, 0, 0, '2026-09-15', 'completed', 'completed', f.id, 9000, NOW() - INTERVAL 55 DAY
FROM users c JOIN categories cat ON cat.name = 'Web Development' JOIN users f ON f.email = 'janelle.aquino@demo.toptunity.local'
WHERE c.email = 'liza.ramos@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Bakery Landing Page');

-- Accepted proposals for those projects
INSERT IGNORE INTO proposals (project_id, freelancer_id, offer, days, cover_letter, status, created_at)
SELECT p.id, f.id, 12000, 12, 'I will build the stock dashboard with ingredient records and low-stock alerts.', 'selected', NOW() - INTERVAL 60 DAY
FROM projects p JOIN users f ON f.email = 'miguel.cruz@demo.toptunity.local' WHERE p.title = 'Bakery Stock Dashboard'
UNION ALL SELECT p.id, f.id, 9000, 10, 'I will build a clean one-page site with the menu and a working contact form.', 'selected', NOW() - INTERVAL 60 DAY
FROM projects p JOIN users f ON f.email = 'janelle.aquino@demo.toptunity.local' WHERE p.title = 'Bakery Landing Page';

-- Payments: escrow paid, then released with the 10% fee
INSERT INTO payments (project_id, type, amount, service_fee, status, created_at)
SELECT p.id, 'escrow', 12000, 0, 'paid', NOW() - INTERVAL 50 DAY FROM projects p WHERE p.title = 'Bakery Stock Dashboard' AND NOT EXISTS (SELECT 1 FROM payments x WHERE x.project_id = p.id)
UNION ALL SELECT p.id, 'release', 12000, 1200, 'released', NOW() - INTERVAL 40 DAY FROM projects p WHERE p.title = 'Bakery Stock Dashboard' AND NOT EXISTS (SELECT 1 FROM payments x WHERE x.project_id = p.id AND x.type = 'release')
UNION ALL SELECT p.id, 'escrow', 9000, 0, 'paid', NOW() - INTERVAL 55 DAY FROM projects p WHERE p.title = 'Bakery Landing Page' AND NOT EXISTS (SELECT 1 FROM payments x WHERE x.project_id = p.id)
UNION ALL SELECT p.id, 'release', 9000, 900, 'released', NOW() - INTERVAL 45 DAY FROM projects p WHERE p.title = 'Bakery Landing Page' AND NOT EXISTS (SELECT 1 FROM payments x WHERE x.project_id = p.id AND x.type = 'release');

-- Delivered work before the deadline (used for the on-time figure)
INSERT INTO project_submissions (project_id, freelancer_id, message, status, review_note, created_at)
SELECT p.id, p.freelancer_id, 'Final dashboard delivered with the handover notes.', 'approved', NULL, '2026-09-18 10:00:00'
FROM projects p WHERE p.title = 'Bakery Stock Dashboard' AND NOT EXISTS (SELECT 1 FROM project_submissions s WHERE s.project_id = p.id)
UNION ALL SELECT p.id, p.freelancer_id, 'Landing page delivered, with the contact form tested.', 'approved', NULL, '2026-09-12 09:00:00'
FROM projects p WHERE p.title = 'Bakery Landing Page' AND NOT EXISTS (SELECT 1 FROM project_submissions s WHERE s.project_id = p.id);

-- Client reviews for Miguel Cruz and Janelle Aquino (different wording and ratings)
INSERT INTO reviews (reviewer_id, reviewee_id, project_id, rating, body, created_at)
SELECT c.id, f.id, p.id, 5, 'Our stock counts are finally accurate. Miguel explained every step and delivered before the date.', NOW() - INTERVAL 40 DAY
FROM projects p JOIN users c ON c.id = p.client_id JOIN users f ON f.id = p.freelancer_id
WHERE p.title = 'Bakery Stock Dashboard' AND NOT EXISTS (SELECT 1 FROM reviews r WHERE r.reviewer_id = c.id AND r.project_id = p.id)
UNION ALL SELECT c.id, f.id, p.id, 4, 'Nice landing page that loads fast. A few small layout changes took an extra week.', NOW() - INTERVAL 45 DAY
FROM projects p JOIN users c ON c.id = p.client_id JOIN users f ON f.id = p.freelancer_id
WHERE p.title = 'Bakery Landing Page' AND NOT EXISTS (SELECT 1 FROM reviews r WHERE r.reviewer_id = c.id AND r.project_id = p.id);

-- ===== Accounts and projects for every Type of Work (Editor, Writer, Marketer, Admin Assistant) =====
INSERT IGNORE INTO categories (name) VALUES ('Video and Animation'), ('Writing and Content'), ('Digital Marketing'), ('Data Entry and Admin');
UPDATE categories SET work_group = 'Editor' WHERE name = 'Video and Animation';
UPDATE categories SET work_group = 'Writer' WHERE name = 'Writing and Content';
UPDATE categories SET work_group = 'Marketer' WHERE name = 'Digital Marketing';
UPDATE categories SET work_group = 'Admin Assistant' WHERE name = 'Data Entry and Admin';

INSERT INTO skills (name, category_id)
SELECT s.name, c.id FROM (
  SELECT 'Premiere Pro' AS name, 'Video and Animation' AS cat UNION ALL SELECT 'After Effects', 'Video and Animation'
  UNION ALL SELECT 'Copywriting', 'Writing and Content' UNION ALL SELECT 'Blog Writing', 'Writing and Content'
  UNION ALL SELECT 'SEO', 'Digital Marketing' UNION ALL SELECT 'Social Media Marketing', 'Digital Marketing'
  UNION ALL SELECT 'Data Entry', 'Data Entry and Admin' UNION ALL SELECT 'Microsoft Excel', 'Data Entry and Admin'
) s JOIN categories c ON c.name = s.cat
WHERE NOT EXISTS (SELECT 1 FROM skills k WHERE k.name = s.name);

INSERT IGNORE INTO users (name, email, password_hash, role, status) VALUES
  ('Noel Bautista', 'noel.bautista@demo.toptunity.local', @pw, 'freelancer', 'active'),
  ('Ana Mendoza', 'ana.mendoza@demo.toptunity.local', @pw, 'freelancer', 'active'),
  ('Paolo Garcia', 'paolo.garcia@demo.toptunity.local', @pw, 'freelancer', 'active'),
  ('Rhea Santos', 'rhea.santos@demo.toptunity.local', @pw, 'freelancer', 'active');

INSERT IGNORE INTO freelancer_profiles (user_id, title, location, hourly_rate, languages, about, available, phone)
SELECT id, 'Video Editor', 'Makati City, Philippines', 260, 'English, Filipino', 'I edit promo videos, reels and event highlights for resorts and shops, with captions and music.', 1, '+63 917 555 0206' FROM users WHERE email = 'noel.bautista@demo.toptunity.local'
UNION ALL SELECT id, 'Copywriter and Blog Writer', 'Pasig City, Philippines', 180, 'English, Filipino', 'I write website copy, blog articles and product descriptions that are clear and easy to read.', 1, '+63 917 555 0207' FROM users WHERE email = 'ana.mendoza@demo.toptunity.local'
UNION ALL SELECT id, 'Digital Marketing Specialist', 'Taguig City, Philippines', 240, 'English, Filipino', 'I plan social media content and search engine optimization to bring more customers to small businesses.', 1, '+63 917 555 0208' FROM users WHERE email = 'paolo.garcia@demo.toptunity.local'
UNION ALL SELECT id, 'Data Entry and Office Assistant', 'Cebu City, Philippines', 150, 'English, Cebuano', 'I encode sales records, inventory lists and monthly reports accurately and on time, using Excel.', 1, '+63 917 555 0209' FROM users WHERE email = 'rhea.santos@demo.toptunity.local';

INSERT IGNORE INTO freelancer_skills (freelancer_id, skill_id)
SELECT u.id, s.id FROM users u JOIN skills s ON s.name IN ('Premiere Pro','After Effects') WHERE u.email = 'noel.bautista@demo.toptunity.local'
UNION ALL SELECT u.id, s.id FROM users u JOIN skills s ON s.name IN ('Copywriting','Blog Writing') WHERE u.email = 'ana.mendoza@demo.toptunity.local'
UNION ALL SELECT u.id, s.id FROM users u JOIN skills s ON s.name IN ('SEO','Social Media Marketing') WHERE u.email = 'paolo.garcia@demo.toptunity.local'
UNION ALL SELECT u.id, s.id FROM users u JOIN skills s ON s.name IN ('Data Entry','Microsoft Excel') WHERE u.email = 'rhea.santos@demo.toptunity.local';

INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, created_at)
SELECT u.id, c.id, 'Promo Video for a Beach Resort', 'A 60-second promo video with music, captions and a short version for social media.', 'fixed', 15000, 0, 0, '2027-01-15', 'open', 'none', NOW() - INTERVAL 1 DAY
FROM users u JOIN categories c ON c.name = 'Video and Animation' WHERE u.email = 'carlo.dizon@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Promo Video for a Beach Resort');
INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, created_at)
SELECT u.id, c.id, 'Blog Articles for a Dental Clinic', 'Four blog articles about dental care, written in plain language with a clear call to book an appointment.', 'fixed', 6000, 0, 0, '2026-12-20', 'open', 'none', NOW() - INTERVAL 2 DAY
FROM users u JOIN categories c ON c.name = 'Writing and Content' WHERE u.email = 'mark.santos@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Blog Articles for a Dental Clinic');
INSERT INTO projects (client_id, category_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status, contract_status, created_at)
SELECT u.id, c.id, 'Monthly Sales Data Entry for a Bakery', 'Encode the monthly sales and inventory records into the shop spreadsheet, and check the totals.', 'hourly', 0, 150, 40, '2026-12-10', 'open', 'none', NOW() - INTERVAL 3 DAY
FROM users u JOIN categories c ON c.name = 'Data Entry and Admin' WHERE u.email = 'liza.ramos@demo.toptunity.local'
  AND NOT EXISTS (SELECT 1 FROM projects p WHERE p.title = 'Monthly Sales Data Entry for a Bakery');

INSERT IGNORE INTO project_skills (project_id, skill_id)
SELECT p.id, s.id FROM projects p JOIN skills s ON s.name IN ('Premiere Pro','After Effects') WHERE p.title = 'Promo Video for a Beach Resort'
UNION ALL SELECT p.id, s.id FROM projects p JOIN skills s ON s.name IN ('Copywriting','Blog Writing') WHERE p.title = 'Blog Articles for a Dental Clinic'
UNION ALL SELECT p.id, s.id FROM projects p JOIN skills s ON s.name IN ('Data Entry','Microsoft Excel') WHERE p.title = 'Monthly Sales Data Entry for a Bakery';

-- Type of Work for every category (sets the plain-language groups used by the filters)
UPDATE categories SET work_group = 'Programmer'      WHERE name IN ('Web Development', 'Mobile App Development');
UPDATE categories SET work_group = 'Designer'        WHERE name IN ('Graphic Design', 'UI/UX Design');
UPDATE categories SET work_group = 'Editor'          WHERE name IN ('Video and Animation');
UPDATE categories SET work_group = 'Writer'          WHERE name IN ('Writing and Content');
UPDATE categories SET work_group = 'Marketer'        WHERE name IN ('Digital Marketing');
UPDATE categories SET work_group = 'Admin Assistant' WHERE name IN ('Data Entry and Admin');