<?php
require_once __DIR__ . '/auth.php';
/**
 * includes/data.php
 * Single source of project data for browse-projects.php and project-details.php.
 * Replace the body of toptunity_projects() with a database query later.
 *
 * Each project:
 *   type       'hourly' | 'fixed'
 *   rate       hourly rate (hourly only)
 *   max_hours  maximum hours (hourly only)
 *   budget     fixed price, or rate x max_hours for hourly
 *   posted     Y-m-d
 */

function toptunity_projects()
{
    return [
        1 => [
            'title' => 'Online Ordering Website for a Coffee Shop',
            'category' => 'Web Development', 'status' => 'Open', 'type' => 'fixed',
            'budget' => 45000, 'deadline' => '2026-11-20', 'posted' => '2026-10-06',
            'proposals' => 12, 'ref' => 'TT-1038',
            'desc' => 'We need a simple online ordering website for Kapé Lokal where customers can browse our menu, place pick-up orders and pay on arrival.',
            'intro' => 'We need a simple online ordering website for Kapé Lokal where customers can browse our menu, place pick-up orders and pay on arrival. The admin side should let staff update menu items, mark orders as ready and view daily sales.',
            'features' => [
                'Online menu with photos and prices',
                'Pick-up order form with a pay-on-arrival option',
                'Admin panel for staff to update menu items',
                'Order status board for ready and completed orders',
                'Daily sales summary',
            ],
            'closing' => 'Please share two ordering or shop websites you have built.',
            'skills' => ['PHP', 'MySQL', 'JavaScript'],
            'files' => [['name' => 'menu-draft.pdf', 'size' => '240 KB', 'type' => 'pdf']],
            'client' => ['name' => 'Andrea Santos', 'company' => 'Kapé Lokal Coffee Co.', 'rating' => 4.9, 'reviews' => 9,
                'location' => 'Quezon City', 'projects' => 5, 'since' => 'Mar 2025', 'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'long'],
        ],
        2 => [
            'title' => 'Student Enrollment System for a Tutorial Center',
            'category' => 'Web Development', 'status' => 'Open', 'type' => 'hourly',
            'rate' => 500, 'max_hours' => 80, 'budget' => 40000,
            'deadline' => '2026-12-05', 'posted' => '2026-10-01',
            'proposals' => 8, 'ref' => 'TT-1039',
            'desc' => 'Build a web-based enrollment and payment tracking system for about 300 students across 12 review classes.',
            'intro' => 'BrightPath Tutorial Center is moving away from paper enrollment forms. We need a web-based system where our staff can enroll students into review classes, record tuition payments and print a class list for each tutor.',
            'features' => [
                'Student registration with parent/guardian contact details',
                'Class schedules for 12 review classes (Grades 7–12 and college entrance)',
                'Payment tracking with balances and official receipt numbers',
                'Simple dashboard with total enrollees per class and unpaid balances',
            ],
            'closing' => 'You will work with our office manager. Please include a link to a similar system you have built.',
            'skills' => ['PHP', 'MySQL', 'HTML/CSS', 'JavaScript'],
            'files' => [
                ['name' => 'enrollment-form-sample.pdf', 'size' => '412 KB', 'type' => 'pdf'],
                ['name' => 'class-schedule-2026.xlsx', 'size' => '86 KB', 'type' => 'sheet'],
            ],
            'client' => ['name' => 'Ramon Villanueva', 'company' => 'BrightPath Tutorial Center', 'rating' => 4.7, 'reviews' => 6,
                'location' => 'Mandaluyong City', 'projects' => 7, 'since' => 'Feb 2025', 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short'],
        ],
        3 => [
            'title' => 'Logo and Brand Kit for a Home Bakeshop',
            'category' => 'Graphic Design', 'status' => 'Open', 'type' => 'fixed',
            'budget' => 8500, 'deadline' => '2026-10-25', 'posted' => '2026-10-04',
            'proposals' => 17, 'ref' => 'TT-1040',
            'desc' => 'Looking for a warm, friendly logo plus color palette, packaging sticker and Facebook cover for Bautista Bakeshop.',
            'intro' => 'We are looking for a warm, friendly logo for Bautista Bakeshop, with a matching color palette, a packaging sticker and a Facebook cover image.',
            'features' => [
                'Primary logo with light and dark versions',
                'Color palette with hex and CMYK values',
                'Packaging sticker artwork',
                'Facebook cover image',
            ],
            'closing' => 'Share a portfolio of logo work you are proud of.',
            'skills' => ['Logo Design', 'Adobe Illustrator'],
            'files' => [['name' => 'bakeshop-brief.pdf', 'size' => '180 KB', 'type' => 'pdf']],
            'client' => ['name' => 'Joy Bautista', 'company' => 'Bautista Bakeshop', 'rating' => 4.6, 'reviews' => 3,
                'location' => 'Pasig City', 'projects' => 1, 'since' => 'Jun 2026', 'bg' => '#FEF9C3', 'hair' => '#1E293B', 'style' => 'bun'],
        ],
        4 => [
            'title' => 'Appointment Booking App for a Dental Clinic',
            'category' => 'Mobile App Development', 'status' => 'Open', 'type' => 'fixed',
            'budget' => 60000, 'deadline' => '2026-12-15', 'posted' => '2026-10-03',
            'proposals' => 6, 'ref' => 'TT-1041',
            'desc' => 'Android and iOS app where patients can book, reschedule and get reminders for dental appointments.',
            'intro' => 'We need an Android and iOS app where patients can book, reschedule and get reminders for their dental appointments. Clinic staff should see the schedule from an admin view.',
            'features' => [
                'Patient sign-up and login',
                'Book, reschedule and cancel appointments',
                'Push and SMS reminders',
                'Admin view of the clinic calendar',
            ],
            'closing' => 'Please include a published app or a link to a similar booking app.',
            'skills' => ['Flutter', 'Firebase'],
            'files' => [],
            'client' => ['name' => 'Grace Aquino', 'company' => 'Aquino Dental Clinic', 'rating' => 4.8, 'reviews' => 4,
                'location' => 'Quezon City', 'projects' => 2, 'since' => 'Jan 2026', 'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'bun'],
        ],
        5 => [
            'title' => '10 SEO Blog Articles for a Travel Agency',
            'category' => 'Writing and Content', 'status' => 'Open', 'type' => 'fixed',
            'budget' => 12000, 'deadline' => '2026-11-08', 'posted' => '2026-10-02',
            'proposals' => 21, 'ref' => 'TT-1042',
            'desc' => 'Ten 1,000-word articles about Palawan island-hopping tours, optimized for local search keywords.',
            'intro' => 'We need ten 1,000-word articles about Palawan island-hopping tours. Each article should target a local search keyword and read naturally for travelers.',
            'features' => [
                'Ten articles of about 1,000 words each',
                'Keyword research list for each article',
                'One round of revisions',
                'Meta titles and descriptions',
            ],
            'closing' => 'Send two sample articles with their target keywords.',
            'skills' => ['SEO', 'Copywriting'],
            'files' => [['name' => 'keyword-list.xlsx', 'size' => '40 KB', 'type' => 'sheet']],
            'client' => ['name' => 'Mark Francisco', 'company' => 'Palawan Tours Co.', 'rating' => 4.5, 'reviews' => 5,
                'location' => 'Puerto Princesa', 'projects' => 3, 'since' => 'Nov 2025', 'bg' => '#E0E7FF', 'hair' => '#1E293B', 'style' => 'short'],
        ],
        6 => [
            'title' => 'Clinic Website Redesign in Figma',
            'category' => 'UI/UX Design', 'status' => 'Open', 'type' => 'fixed',
            'budget' => 18000, 'deadline' => '2026-11-15', 'posted' => '2026-10-07',
            'proposals' => 4, 'ref' => 'TT-1043',
            'desc' => 'Redesign our clinic website (6 pages) in Figma with a mobile version and a clickable prototype.',
            'intro' => 'Redesign our clinic website (6 pages) in Figma. We need a mobile version of each page and a clickable prototype we can test with patients.',
            'features' => [
                'Six redesigned pages for desktop',
                'Mobile version of each page',
                'Clickable prototype with working links',
                'Style guide with colors and fonts',
            ],
            'closing' => 'Please share examples of past Figma redesigns.',
            'skills' => ['Figma', 'UI Design'],
            'files' => [['name' => 'current-site-screenshots.pdf', 'size' => '1.2 MB', 'type' => 'pdf']],
            'client' => ['name' => 'Grace Aquino', 'company' => 'Aquino Dental Clinic', 'rating' => 4.8, 'reviews' => 4,
                'location' => 'Quezon City', 'projects' => 2, 'since' => 'Jan 2026', 'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'bun'],
        ],
        7 => [
            'title' => 'Inventory Spreadsheet Cleanup',
            'category' => 'Data Entry and Admin', 'status' => 'Open', 'type' => 'hourly',
            'rate' => 300, 'max_hours' => 40, 'budget' => 12000,
            'deadline' => '2026-10-30', 'posted' => '2026-10-07',
            'proposals' => 9, 'ref' => 'TT-1044',
            'desc' => 'Clean up and merge our 6 inventory spreadsheets (about 4,000 items) into one organized file.',
            'intro' => 'Clean up and merge our 6 inventory spreadsheets (about 4,000 items) into one organized file that our staff can search and update.',
            'features' => [
                'Merge six inventory sheets into one file',
                'Remove duplicates and fix item codes',
                'Standardize names, units and prices',
                'Short notes on what changed',
            ],
            'closing' => 'Tell us how you would handle items that appear in two sheets with different prices.',
            'skills' => ['Data Entry', 'Microsoft Excel'],
            'files' => [['name' => 'inventory-sample.xlsx', 'size' => '120 KB', 'type' => 'sheet']],
            'client' => ['name' => 'Liza Ramos', 'company' => 'Ramos General Supplies', 'rating' => 4.9, 'reviews' => 7,
                'location' => 'Caloocan City', 'projects' => 4, 'since' => 'Sep 2025', 'bg' => '#DCFCE7', 'hair' => '#1E293B', 'style' => 'long'],
        ],
        8 => [
            'title' => 'Facebook Ads Setup for a Salon',
            'category' => 'Digital Marketing', 'status' => 'Open', 'type' => 'fixed',
            'budget' => 7500, 'deadline' => '2026-11-02', 'posted' => '2026-10-01',
            'proposals' => 11, 'ref' => 'TT-1045',
            'desc' => 'Set up and run a one-month Facebook and Instagram ad campaign to get more walk-in bookings.',
            'intro' => 'We want a one-month Facebook and Instagram ad campaign to bring more walk-in bookings to our salon in Makati.',
            'features' => [
                'Campaign setup for Facebook and Instagram',
                'Audience targeting around the salon area',
                'Weekly performance report',
                'Two rounds of ad copy and image changes',
            ],
            'closing' => 'Share a campaign you have run and the results you got.',
            'skills' => ['Facebook Ads', 'Social Media'],
            'files' => [],
            'client' => ['name' => 'Carla Mendoza', 'company' => 'Mendoza Hair Studio', 'rating' => 4.4, 'reviews' => 2,
                'location' => 'Makati City', 'projects' => 1, 'since' => 'Sep 2026', 'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'long'],
        ],
        9 => [
            'title' => 'Weekly Vlog Video Editing',
            'category' => 'Video and Animation', 'status' => 'Open', 'type' => 'hourly',
            'rate' => 250, 'max_hours' => 60, 'budget' => 15000,
            'deadline' => '2026-12-20', 'posted' => '2026-09-28',
            'proposals' => 14, 'ref' => 'TT-1046',
            'desc' => 'Edit four 8-minute travel vlogs per month with captions, background music and a simple intro.',
            'intro' => 'We publish travel vlogs every week and need a reliable editor to turn raw footage into finished videos.',
            'features' => [
                'Edit four vlogs of about 8 minutes each per month',
                'Captions and subtitles',
                'Background music and sound levels',
                'Simple title intro and end card',
            ],
            'closing' => 'Send a link to two travel edits you have done.',
            'skills' => ['Video Editing', 'Premiere Pro'],
            'files' => [['name' => 'vlog-style-guide.pdf', 'size' => '320 KB', 'type' => 'pdf']],
            'client' => ['name' => 'Paolo Dizon', 'company' => 'Dizon Travels', 'rating' => 4.7, 'reviews' => 5,
                'location' => 'Cebu City', 'projects' => 3, 'since' => 'Apr 2026', 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short'],
        ],
        10 => [
            'title' => 'Product Photo Retouching (50 Images)',
            'category' => 'Graphic Design', 'status' => 'Open', 'type' => 'fixed',
            'budget' => 5000, 'deadline' => '2026-10-28', 'posted' => '2026-09-18',
            'proposals' => 19, 'ref' => 'TT-1047',
            'desc' => 'Remove backgrounds and fix color on 50 product photos for an online shop.',
            'intro' => 'Our online shop needs 50 product photos cleaned up before we list them. Each photo needs a clean background and accurate color.',
            'features' => [
                'Remove backgrounds on 50 photos',
                'Correct white balance and color',
                'Export in web and print sizes',
                'Consistent file naming',
            ],
            'closing' => 'Include a before and after example from a past project.',
            'skills' => ['Photoshop', 'Retouching'],
            'files' => [['name' => 'product-list.xlsx', 'size' => '60 KB', 'type' => 'sheet']],
            'client' => ['name' => 'Nina Reyes', 'company' => 'Reyes Home Goods', 'rating' => 4.6, 'reviews' => 6,
                'location' => 'Pasig City', 'projects' => 4, 'since' => 'Jun 2025', 'bg' => '#FEF9C3', 'hair' => '#1E293B', 'style' => 'bun'],
        ],
        11 => [
            'title' => 'Explainer Animation for a Water Refilling Station',
            'category' => 'Video and Animation', 'status' => 'Open', 'type' => 'fixed',
            'budget' => 14000, 'deadline' => '2026-12-01', 'posted' => '2026-09-08',
            'proposals' => 7, 'ref' => 'TT-1048',
            'desc' => 'A 60-second animated explainer showing how our refilling and delivery service works.',
            'intro' => 'We need a 60-second animated explainer that shows how our refilling and delivery service works, for our website and social media.',
            'features' => [
                '60-second animated explainer video',
                'Storyboard for approval before animation',
                'Voiceover and background music',
                'Two rounds of revisions',
            ],
            'closing' => 'Share an animation sample with a similar length.',
            'skills' => ['Animation', 'After Effects'],
            'files' => [['name' => 'explainer-script.pdf', 'size' => '95 KB', 'type' => 'pdf']],
            'client' => ['name' => 'Ben Torres', 'company' => 'Torres Water Refilling', 'rating' => 4.3, 'reviews' => 2,
                'location' => 'Antipolo City', 'projects' => 1, 'since' => 'Aug 2026', 'bg' => '#E0E7FF', 'hair' => '#1E293B', 'style' => 'glasses'],
        ],
    ];
}

/** Remove just-uploaded files when the related form cannot be saved. */
function tt_discard_uploads($files)
{
    $dir = dirname(__DIR__) . '/storage/uploads/';
    foreach ($files as $file) {
        $stored = $file['stored'] ?? '';
        if ($stored !== '' && basename($stored) === $stored && is_file($dir . $stored) && !unlink($dir . $stored)) {
            error_log('TopTunity could not remove an uncommitted upload: ' . $stored);
        }
    }
}

/** Load a user's selected avatar, assigning and saving a random one for legacy accounts. */
function tt_user_avatar_asset($user_id)
{
    $stmt = db()->prepare('SELECT avatar, role FROM users WHERE id = ?');
    $stmt->execute([(int) $user_id]);
    $user = $stmt->fetch();
    if (!$user) { return null; }
    if ($user['role'] === 'admin') {
        $asset = tt_avatar_asset_for_name('TopTunity Admin');
        if (!$asset) { return null; }
        if ($user['avatar'] !== $asset) {
            db()->prepare('UPDATE users SET avatar = ? WHERE id = ?')->execute([$asset, (int) $user_id]);
        }
        return $asset;
    }
    $asset = tt_valid_avatar_asset($user['avatar']);
    if ($asset) { return $asset; }

    $asset = tt_random_avatar_asset();
    db()->prepare('UPDATE users SET avatar = ? WHERE id = ?')->execute([$asset, (int) $user_id]);
    return $asset;
}

/** Persist an avatar choice and switch from an uploaded profile photo if one exists. */
function tt_set_user_avatar($asset)
{
    $user = tt_current_user();
    $asset = tt_valid_avatar_asset($asset);
    if (!$user || !in_array($user['role'], ['client', 'freelancer'], true)) { return 'Sign in to update your profile avatar.'; }
    if (!$asset) { return 'Choose one of the available avatars.'; }

    $old_photo = tt_user_photo((int) $user['id'], $user['role']);
    $table = $user['role'] === 'freelancer' ? 'freelancer_profiles' : 'client_profiles';
    $pdo = db();
    $pdo->beginTransaction();
    try {
        $pdo->prepare('UPDATE users SET avatar = ? WHERE id = ? AND role = ?')
            ->execute([$asset, (int) $user['id'], $user['role']]);
        $pdo->prepare("UPDATE $table SET photo = NULL WHERE user_id = ?")->execute([(int) $user['id']]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        throw $e;
    }

    if ($old_photo) {
        $path = dirname(__DIR__) . '/storage/uploads/' . basename($old_photo);
        if (is_file($path) && !unlink($path)) { error_log('TopTunity could not remove replaced profile photo: ' . basename($old_photo)); }
    }
    return null;
}

/** One project by id, or null if it doesn't exist. */
function toptunity_project($id)
{
    $all = toptunity_projects();
    return isset($all[$id]) ? $all[$id] : null;
}

/** Flat list in the shape browse-projects.php expects. */
function toptunity_listing_sample()
{
    $rows = [];
    foreach (toptunity_projects() as $id => $p) {
        $is_hourly = $p['type'] === 'hourly';
        $rows[] = [
            'id'        => $id,
            'title'     => $p['title'],
            'category'  => $p['category'],
            'type'      => $p['type'],
            'amount'    => $is_hourly ? $p['rate'] : $p['budget'],
            'max_hours' => $is_hourly ? $p['max_hours'] : 0,
            'age_h'     => max(0, (int) floor((time() - strtotime($p['posted'])) / 3600)),
            'client'    => $p['client']['name'],
            'deadline'  => $p['deadline'],
            'proposals' => $p['proposals'],
            'desc'      => $p['desc'],
            'skills'    => $p['skills'],
        ];
    }
    return $rows;
}

/* ==========================================================================
   FREELANCERS
   Used by browse-freelancers.php and freelancer-profile.php.
   ========================================================================== */
function toptunity_freelancers_sample()
{
    return [
        1 => [
            'name' => 'Miguel Reyes', 'title' => 'Full-Stack PHP Developer', 'location' => 'Cebu City, Philippines',
            'completed' => 42, 'rating' => 4.9, 'reviews' => 38, 'rate' => 650, 'available' => true,
            'bio' => 'I build fast, secure web systems for small businesses: ordering sites, inventory systems and admin dashboards using PHP, MySQL and JavaScript.',
            'about' => [
                "Hi! I'm Miguel, a full-stack developer from Cebu with 5 years of experience building web systems for small businesses: online ordering sites, point-of-sale and inventory systems, and admin dashboards.",
                "I work mainly with PHP (Laravel and native), MySQL and vanilla JavaScript. I care about clean code, fast pages and clear communication. You will get progress updates every two days and a short video walkthrough when I submit the work.",
            ],
            'skills' => ['PHP', 'MySQL', 'JavaScript', 'Laravel', 'HTML/CSS', 'Bootstrap', 'REST API'],
            'languages' => 'English, Filipino, Cebuano', 'since' => 'March 2024', 'ontime' => '96%',
            'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short',
            'portfolio' => [
                ['title' => 'Sari-Sari Store POS System', 'category' => 'Web Development', 'tint' => '#CCFBF1'],
                ['title' => 'Resort Booking Website', 'category' => 'Web Development', 'tint' => '#FFEDD5'],
                ['title' => 'Clinic Inventory Dashboard', 'category' => 'Web Development', 'tint' => '#E0E7FF'],
                ['title' => 'Café Menu Landing Page', 'category' => 'Web Development', 'tint' => '#FEF9C3'],
            ],
            'feedback' => [
                ['by' => 'Grace Aquino', 'role' => 'Client', 'project' => 'Clinic Inventory Dashboard', 'date' => '2026-09-18', 'stars' => 5,
                    'text' => 'Miguel built our clinic inventory dashboard ahead of schedule. He explained every feature clearly and fixed small issues the same day.', 'style' => 'bun', 'bg' => '#FFEDD5'],
                ['by' => 'Mark Francisco', 'role' => 'Client', 'project' => 'Resort Booking Website', 'date' => '2026-08-02', 'stars' => 5,
                    'text' => 'Very professional and easy to talk to. The booking site works perfectly on mobile and our inquiries doubled.', 'style' => 'short', 'bg' => '#E0E7FF'],
                ['by' => 'Ramon Villanueva', 'role' => 'Client', 'project' => 'Tuition Payment Tracker', 'date' => '2026-06-21', 'stars' => 4,
                    'text' => 'Good work on the payment tracking module. A few revisions were needed, but he handled them quickly.', 'style' => 'short', 'bg' => '#CCFBF1'],
            ],
        ],
        2 => [
            'name' => 'Bea Lim', 'title' => 'UI/UX Designer', 'location' => 'Makati City, Philippines',
            'completed' => 31, 'rating' => 4.8, 'reviews' => 27, 'rate' => 600, 'available' => true,
            'bio' => 'I design simple, friendly app and web interfaces backed by user research and clickable Figma prototypes.',
            'about' => [
                'I am a UI/UX designer who helps small businesses turn rough ideas into clear, friendly apps and websites.',
                'My process starts with a short user review, then moves through wireframes, a clickable Figma prototype and one round of testing before handoff.',
            ],
            'skills' => ['Figma', 'UI Design', 'HTML/CSS', 'Prototyping'],
            'languages' => 'English, Filipino', 'since' => 'July 2024', 'ontime' => '94%',
            'bg' => '#DBEAFE', 'hair' => '#1E293B', 'style' => 'long',
            'portfolio' => [
                ['title' => 'Clinic Booking App', 'category' => 'Mobile App Development', 'tint' => '#DBEAFE'],
                ['title' => 'Coffee Shop Menu Website', 'category' => 'UI/UX Design', 'tint' => '#FFEDD5'],
                ['title' => 'Inventory Admin Panel', 'category' => 'UI/UX Design', 'tint' => '#CCFBF1'],
            ],
            'feedback' => [
                ['by' => 'Andrea Santos', 'role' => 'Client', 'project' => 'Coffee Shop Menu Website', 'date' => '2026-07-14', 'stars' => 5,
                    'text' => 'Bea turned our rough sketches into a clean menu site our customers actually use.', 'style' => 'long', 'bg' => '#FFEDD5'],
            ],
        ],
        3 => [
            'name' => 'Rhea Mendoza', 'title' => 'Content Writer and SEO Specialist', 'location' => 'Iloilo City, Philippines',
            'completed' => 53, 'rating' => 4.9, 'reviews' => 44, 'rate' => 400, 'available' => true,
            'bio' => 'I write search-friendly blog posts, product descriptions and website copy that sound human.',
            'about' => [
                'I write blog posts, product descriptions and website copy that rank well and still sound like a real person wrote them.',
                'Every project starts with keyword research and a short brief call, so the content fits your customers and your goals.',
            ],
            'skills' => ['Copywriting', 'SEO', 'WordPress'],
            'languages' => 'English, Filipino, Hiligaynon', 'since' => 'January 2024', 'ontime' => '98%',
            'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'long',
            'portfolio' => [
                ['title' => 'Travel Blog Series', 'category' => 'Writing and Content', 'tint' => '#CCFBF1'],
                ['title' => 'Bakery Product Descriptions', 'category' => 'Writing and Content', 'tint' => '#FEF9C3'],
                ['title' => 'Dental Clinic Website Copy', 'category' => 'Writing and Content', 'tint' => '#FFEDD5'],
            ],
            'feedback' => [
                ['by' => 'Grace Aquino', 'role' => 'Client', 'project' => 'Dental Clinic Website Copy', 'date' => '2026-06-02', 'stars' => 5,
                    'text' => 'Rhea wrote clear, friendly copy for every page and our appointment requests went up within a month.', 'style' => 'bun', 'bg' => '#FFEDD5'],
            ],
        ],
        4 => [
            'name' => 'Carlo Dizon', 'title' => 'Mobile App Developer', 'location' => 'Davao City, Philippines',
            'completed' => 21, 'rating' => 4.7, 'reviews' => 19, 'rate' => 700, 'available' => true,
            'bio' => 'Flutter developer building Android and iOS apps for clinics, shops and schools.',
            'about' => [
                'I build Android and iOS apps with Flutter, backed by Firebase, for clinics, shops and schools.',
                'I test on real devices and share a working build every week so you can see progress early.',
            ],
            'skills' => ['Flutter', 'Firebase', 'JavaScript'],
            'languages' => 'English, Filipino, Bisaya', 'since' => 'May 2025', 'ontime' => '93%',
            'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'short',
            'portfolio' => [
                ['title' => 'Clinic Queue App', 'category' => 'Mobile App Development', 'tint' => '#DBEAFE'],
                ['title' => 'Shop Loyalty App', 'category' => 'Mobile App Development', 'tint' => '#CCFBF1'],
                ['title' => 'School Attendance App', 'category' => 'Mobile App Development', 'tint' => '#FFEDD5'],
            ],
            'feedback' => [
                ['by' => 'Nina Reyes', 'role' => 'Client', 'project' => 'Shop Loyalty App', 'date' => '2026-07-09', 'stars' => 4,
                    'text' => 'Carlo delivered a stable app. Push notifications took a couple of tries to get right.', 'style' => 'bun', 'bg' => '#FEF9C3'],
            ],
        ],
        5 => [
            'name' => 'Paolo Garcia', 'title' => 'Graphic Designer', 'location' => 'Quezon City, Philippines',
            'completed' => 36, 'rating' => 4.6, 'reviews' => 31, 'rate' => 450, 'available' => true,
            'bio' => 'Brand identities, logos and social media graphics for local food and retail brands.',
            'about' => [
                'I design brand identities, logos and social media graphics for local food and retail businesses.',
                'You get source files, a color palette and a simple usage guide with every brand kit.',
            ],
            'skills' => ['Logo Design', 'Adobe Illustrator', 'Social Media Marketing'],
            'languages' => 'English, Filipino', 'since' => 'August 2024', 'ontime' => '95%',
            'bg' => '#FEF9C3', 'hair' => '#1E293B', 'style' => 'short',
            'portfolio' => [
                ['title' => 'Bakeshop Brand Kit', 'category' => 'Graphic Design', 'tint' => '#FEF9C3'],
                ['title' => 'Food Cart Logo', 'category' => 'Graphic Design', 'tint' => '#FFEDD5'],
                ['title' => 'Retail Social Campaign', 'category' => 'Graphic Design', 'tint' => '#CCFBF1'],
            ],
            'feedback' => [
                ['by' => 'Joy Bautista', 'role' => 'Client', 'project' => 'Bakeshop Brand Kit', 'date' => '2026-04-11', 'stars' => 5,
                    'text' => 'Paolo understood our brand right away. The sticker and Facebook cover look great together.', 'style' => 'bun', 'bg' => '#FEF9C3'],
            ],
        ],
        6 => [
            'name' => 'Jerome Castillo', 'title' => 'Backend Developer', 'location' => 'Manila, Philippines',
            'completed' => 18, 'rating' => 4.7, 'reviews' => 10, 'rate' => 700, 'available' => true,
            'bio' => 'Backend developer focused on PHP APIs, payment flows and reliable databases.',
            'about' => [
                'I build the backend parts of web apps: APIs, payment flows, user accounts and reliable databases.',
                'I write clear documentation for every endpoint so your frontend team can start right away.',
            ],
            'skills' => ['PHP', 'REST API', 'MySQL'],
            'languages' => 'English, Filipino', 'since' => 'February 2025', 'ontime' => '92%',
            'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'glasses',
            'portfolio' => [
                ['title' => 'Payment API', 'category' => 'Web Development', 'tint' => '#CCFBF1'],
                ['title' => 'Booking Backend', 'category' => 'Web Development', 'tint' => '#DBEAFE'],
                ['title' => 'Reporting Service', 'category' => 'Web Development', 'tint' => '#FFEDD5'],
            ],
            'feedback' => [
                ['by' => 'Ramon Villanueva', 'role' => 'Client', 'project' => 'Booking Backend', 'date' => '2026-05-30', 'stars' => 5,
                    'text' => 'Jerome designed clean endpoints and documented everything. Our integration took two days.', 'style' => 'short', 'bg' => '#CCFBF1'],
            ],
        ],
        7 => [
            'name' => 'Janelle Cruz', 'title' => 'Web and Database Developer', 'location' => 'Bacolod City, Philippines',
            'completed' => 9, 'rating' => 4.7, 'reviews' => 3, 'rate' => 450, 'available' => false,
            'bio' => 'Web and database developer who builds clean forms, reports and data cleanup tools for small offices.',
            'about' => [
                'I build forms, reports and data tools for small offices that need their records in order.',
                'I focus on simple screens that staff can learn in one session.',
            ],
            'skills' => ['HTML/CSS', 'JavaScript', 'MySQL'],
            'languages' => 'English, Filipino, Ilonggo', 'since' => 'October 2025', 'ontime' => '100%',
            'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'bun',
            'portfolio' => [
                ['title' => 'Inventory Database', 'category' => 'Data Entry and Admin', 'tint' => '#DCFCE7'],
                ['title' => 'Clinic Records Form', 'category' => 'Web Development', 'tint' => '#FFEDD5'],
                ['title' => 'Sales Report Dashboard', 'category' => 'Web Development', 'tint' => '#E0E7FF'],
            ],
            'feedback' => [
                ['by' => 'Nina Reyes', 'role' => 'Client', 'project' => 'Sales Report Dashboard', 'date' => '2026-06-12', 'stars' => 5,
                    'text' => 'Janelle made our sales report simple to read. Our staff learned it in one session.', 'style' => 'bun', 'bg' => '#FEF9C3'],
            ],
        ],
    ];
}

/** One freelancer by id, or null. */
function toptunity_freelancer_unused_old($id)
{
    $all = toptunity_freelancers_sample();
    return isset($all[$id]) ? $all[$id] : null;
}

/** Find a freelancer by full name (used by links from the homepage). */
function toptunity_freelancer_by_name($name)
{
    foreach (toptunity_freelancers() as $id => $f) {
        if (strcasecmp($f['name'], $name) === 0) {
            return ['id' => $id] + $f;
        }
    }
    return null;
}

/* ==========================================================================
   TESTIMONIALS
   role: 'client' | 'freelancer'
   ========================================================================== */
function toptunity_testimonials()
{
    $testimonials = [
        ['quote' => 'I posted our ordering website project on a Monday and had twelve solid proposals by Wednesday. The match percentage helped me shortlist fast, and holding the payment until I approved the work gave me peace of mind.',
         'name' => 'Andrea Santos', 'role' => 'client', 'context' => 'Kapé Lokal Coffee Co.', 'stars' => 5, 'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'long'],
        ['quote' => 'The proposal process is clear and the 10% fee is shown upfront, so I always know my net earnings before I send an offer. Withdrawing to GCash is simple.',
         'name' => 'Rhea Mendoza', 'role' => 'freelancer', 'context' => 'Content Writer', 'stars' => 5, 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'long'],
        ['quote' => 'Tracking the project from contract to completion was easy. I could see the status history and every submitted file in one place.',
         'name' => 'Grace Aquino', 'role' => 'client', 'context' => 'Aquino Dental Clinic', 'stars' => 5, 'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'bun'],
        ['quote' => 'Recommended Projects shows me jobs that actually match my PHP and MySQL skills. Most of my repeat clients found me through TopTunity.',
         'name' => 'Miguel Reyes', 'role' => 'freelancer', 'context' => 'Full-Stack PHP Developer', 'stars' => 5, 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short'],
        ['quote' => 'Found a talented designer for our logo within a week. Some filters for budget, but overall a great experience.',
         'name' => 'Joy Bautista', 'role' => 'client', 'context' => 'Bautista Bakeshop', 'stars' => 4, 'bg' => '#FEF9C3', 'hair' => '#1E293B', 'style' => 'bun'],
        ['quote' => 'Contracts are agreed before any work starts, so there are no surprises about scope or deadlines. That alone makes it worth it.',
         'name' => 'Carlo Dizon', 'role' => 'freelancer', 'context' => 'Mobile App Developer', 'stars' => 5, 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short'],
        ['quote' => 'The hourly log made it easy to approve hours every week. Billing on the deadline was automatic and the unused deposit came back right away.',
         'name' => 'Ramon Villanueva', 'role' => 'client', 'context' => 'BrightPath Tutorial Center', 'stars' => 5, 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short'],
        ['quote' => 'My portfolio and reviews do the selling for me. Clients can see my Figma work before they even message me.',
         'name' => 'Bea Lim', 'role' => 'freelancer', 'context' => 'UI/UX Designer', 'stars' => 5, 'bg' => '#DBEAFE', 'hair' => '#1E293B', 'style' => 'long'],
        ['quote' => 'Great for small, steady projects. Hours are logged per day, and I can see which ones the client already approved.',
         'name' => 'Kevin Tan', 'role' => 'freelancer', 'context' => 'Data Entry Specialist', 'stars' => 4, 'bg' => '#DCFCE7', 'hair' => '#1E293B', 'style' => 'short'],
    ];
    $demo_ids = tt_demo_ids();
    $sql = "SELECT pr.rating, pr.body, u.name, u.role,
                   COALESCE(NULLIF(cp.company, ''), NULLIF(fp.title, ''), '') AS context
            FROM platform_reviews pr
            JOIN users u ON u.id = pr.user_id
            LEFT JOIN client_profiles cp ON cp.user_id = u.id
            LEFT JOIN freelancer_profiles fp ON fp.user_id = u.id
            WHERE pr.status = 'published' AND u.role IN ('client', 'freelancer')
              AND pr.body IS NOT NULL AND TRIM(pr.body) <> ''";
    if ($demo_ids) {
        $sql .= ' AND pr.user_id NOT IN (' . implode(',', array_map('intval', $demo_ids)) . ')';
    }
    foreach (db()->query($sql . ' ORDER BY pr.created_at DESC')->fetchAll() as $review) {
        $testimonials[] = [
            'quote' => $review['body'], 'name' => $review['name'], 'role' => $review['role'],
            'context' => $review['context'] ?: ucfirst($review['role']) . ' on TopTunity',
            'stars' => (int) $review['rating'], 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short',
        ];
    }
    return $testimonials;
}

/* ==========================================================================
   FAQS
   category: 'clients' | 'freelancers' | 'payments'
   ========================================================================== */
function toptunity_faqs()
{
    return [
        ['cat' => 'clients', 'q' => 'How do I post a project?',
         'a' => 'Log in as a client and click Post a Project. Enter the project title, description, category and required skills, then choose Fixed Price (one budget) or Hourly (hourly rate and maximum hours) and set the deadline. Your project appears in My Projects and is published after administrator moderation.'],
        ['cat' => 'freelancers', 'q' => 'How do I submit a proposal?',
         'a' => 'Open a project from Find Projects, click Submit a Proposal, then enter your rate, estimated completion time and a cover letter. You can send only one proposal per project.'],
        ['cat' => 'freelancers', 'q' => 'How is the match percentage computed?',
         'a' => 'The match percentage compares the skills on your profile with the skills a project requires. The more required skills you have, the higher your match. Clients see it when they review proposals.'],
        ['cat' => 'payments', 'q' => 'When is the service fee deducted?',
         'a' => 'A 10% service fee is deducted from the amount released to the freelancer. For Fixed Price projects this happens on approval; for Hourly projects it happens on the End Date.'],
        ['cat' => 'payments', 'q' => 'How does escrow payment work?',
         'a' => 'When you deposit the project amount, TopTunity holds it until you approve the work. Approval releases the payment to the freelancer minus the service fee. All payments are simulated, so no real money is used.'],
        ['cat' => 'clients', 'q' => 'How does an Hourly project work?',
         'a' => 'You set an hourly rate and a maximum number of hours. The freelancer logs hours, you approve them, and you pay only for approved hours. Any unused deposit is refunded on the End Date.'],
        ['cat' => 'clients', 'q' => 'What happens when a project passes its deadline?',
         'a' => 'The project is flagged as Overdue. You can extend the deadline, cancel the project, or message your freelancer to agree on next steps.'],
        ['cat' => 'clients', 'q' => 'Can I select more than one freelancer?',
         'a' => 'No. You can select only one freelancer per project. The other proposals are marked Not Selected.'],
        ['cat' => 'payments', 'q' => 'How do I withdraw my earnings?',
         'a' => 'Go to Earnings, enter the amount, and choose GCash or a bank account. The administrator reviews each withdrawal request and marks it as processed.'],
        ['cat' => 'payments', 'q' => 'How do I report a user or file a dispute?',
         'a' => 'Open the project or conversation and choose Report. For a payment problem, choose Report a Dispute. The administrator reviews the case and can release the payment, refund the client or split the amount.'],
        ['cat' => 'freelancers', 'q' => 'Can I review the platform?',
         'a' => 'Yes. Clients and freelancers can both send platform feedback from the Platform Review page in their account.'],
    ];
}


/** True when the signed-in account is the demo client (Andrea). Other accounts start empty. */
function tt_is_demo_account()
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'client'
        && strcasecmp($_SESSION['user']['email'], 'andrea.santos@kapelokal.ph') === 0;
}

/* ==========================================================================
   CLIENT AREA (logged-in client: Andrea Santos)
   ========================================================================== */
function toptunity_current_client_default()
{
    return [
        'name' => 'Andrea Santos', 'company' => 'Kapé Lokal Coffee Co.',
        'role' => 'Client', 'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'long',
    ];
}

/**
 * Projects posted by the current client.
 * status: open | ongoing | overdue | completed | past | cancelled
 * note:   optional extra line (e.g. closed by administrator)
 */
function toptunity_client_projects_sample()
{
    return [
        1 => ['title' => 'Online Ordering Website for a Coffee Shop', 'category' => 'Web Development', 'status' => 'open',
              'type' => 'fixed', 'budget' => 45000, 'deadline' => '2026-11-20', 'proposals' => 12, 'freelancer' => null, 'posted' => '2026-10-06'],
        2 => ['title' => 'Point-of-Sale and Inventory Dashboard', 'category' => 'Web Development', 'status' => 'ongoing',
              'type' => 'hourly', 'rate' => 600, 'max_hours' => 60, 'budget' => 36000, 'deadline' => '2026-10-31', 'proposals' => 9, 'freelancer' => 'Janelle Cruz', 'posted' => '2026-09-08'],
        3 => ['title' => 'Monthly Social Media Content Calendar', 'category' => 'Digital Marketing', 'status' => 'ongoing',
              'type' => 'hourly', 'rate' => 350, 'max_hours' => 40, 'budget' => 14000, 'deadline' => '2026-11-30', 'proposals' => 9, 'freelancer' => 'Liza Navarro', 'posted' => '2026-09-20'],
        4 => ['title' => 'Menu Board and Cup Sleeve Design', 'category' => 'Graphic Design', 'status' => 'overdue',
              'type' => 'fixed', 'budget' => 8500, 'deadline' => '2026-10-01', 'proposals' => 15, 'freelancer' => 'Paolo Garcia', 'posted' => '2026-08-25'],
        5 => ['title' => '30-Second Promo Video for Opening Week', 'category' => 'Video and Animation', 'status' => 'past',
              'type' => 'fixed', 'budget' => 9000, 'deadline' => '2026-09-25', 'proposals' => 4, 'freelancer' => null, 'posted' => '2026-08-10',
              'note' => 'Closed by administrator'],
        6 => ['title' => 'Product Photo Retouching', 'category' => 'Graphic Design', 'status' => 'completed',
              'type' => 'fixed', 'budget' => 5000, 'deadline' => '2026-09-05', 'proposals' => 11, 'freelancer' => 'Liza Navarro', 'posted' => '2026-08-01'],
        7 => ['title' => 'Weekly Menu Social Posts (July)', 'category' => 'Digital Marketing', 'status' => 'completed',
              'type' => 'hourly', 'rate' => 350, 'max_hours' => 24, 'budget' => 8400, 'deadline' => '2026-07-31', 'proposals' => 8, 'freelancer' => 'Liza Navarro', 'posted' => '2026-06-28'],
        8 => ['title' => 'Barista Training Manual Layout', 'category' => 'Graphic Design', 'status' => 'cancelled',
              'type' => 'fixed', 'budget' => 4000, 'deadline' => '2026-08-30', 'proposals' => 6, 'freelancer' => null, 'posted' => '2026-07-20'],
        9 => ['title' => 'Loyalty Points Web App', 'category' => 'Web Development', 'status' => 'open',
              'type' => 'hourly', 'rate' => 550, 'max_hours' => 50, 'budget' => 27500, 'deadline' => '2026-12-12', 'proposals' => 2, 'freelancer' => null, 'posted' => '2026-10-02'],
    ];
}

/** Human labels for each project status (used by pills and filter tabs). */
function toptunity_status_label($status)
{
    $labels = [
        'open' => 'Open', 'ongoing' => 'Ongoing', 'overdue' => 'Overdue',
        'completed' => 'Completed', 'past' => 'Past Deadline', 'closed' => 'Closed',
        'suspended' => 'Suspended', 'cancelled' => 'Cancelled',
    ];
    return isset($labels[$status]) ? $labels[$status] : ucfirst($status);
}


/** Recent notifications for the dashboard and notifications page. */
function toptunity_client_notifications()
{
    if (!tt_is_demo_account()) { return []; }
    return [
        ['icon' => 'file', 'tint' => 'blue', 'title' => 'New proposals', 'text' => '3 new proposals on Online Ordering Website.', 'time' => '2h', 'new' => true],
        ['icon' => 'message', 'tint' => 'blue', 'title' => 'New messages', 'text' => 'Janelle Cruz sent you a message.', 'time' => '3h', 'new' => true],
        ['icon' => 'wallet', 'tint' => 'orange', 'title' => 'Hours logged', 'text' => 'Janelle logged 3.0 hrs on POS Dashboard.', 'time' => '5h', 'new' => false],
        ['icon' => 'check-circle', 'tint' => 'teal', 'title' => 'Payment confirmations', 'text' => 'Deposit of ₱30,000 is now held.', 'time' => '1d', 'new' => false],
    ];
}

/** Recent conversations for the dashboard and messages page. */
function toptunity_client_messages()
{
    if (!tt_is_demo_account()) { return []; }
    return [
        ['name' => 'Janelle Cruz', 'project' => 'POS and Inventory Dashboard', 'text' => 'I pushed the low-stock alerts — can you test it today?', 'time' => '5m', 'unread' => true,
         'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'bun'],
        ['name' => 'Liza Navarro', 'project' => 'Social Media Calendar', 'text' => 'Here are the captions for week 1, po!', 'time' => '1h', 'unread' => true,
         'bg' => '#DBEAFE', 'hair' => '#1E293B', 'style' => 'long'],
        ['name' => 'Paolo Garcia', 'project' => 'Menu Board Design', 'text' => 'Sorry for the delay, sending the files tonight.', 'time' => '1d', 'unread' => false,
         'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short'],
    ];
}

/* ==========================================================================
   CLIENT PROJECT DETAILS: proposals, contract and tracking
   ========================================================================== */

/** Proposals received on a client project. Each: freelancer_id, offer, days, letter. */
function toptunity_project_proposals($id)
{
    $projects = toptunity_client_projects();
    if (!isset($projects[$id])) { return []; }
    $p = $projects[$id];

    if ($id === 1) {
        return [
            ['freelancer_id' => 1, 'offer' => 42000, 'days' => 21,
             'letter' => 'I have built several ordering systems for cafés in Cebu. I can deliver the menu, cart, pick-up scheduling and a staff dashboard in three weeks, including a short training video for your team.'],
            ['freelancer_id' => 7, 'offer' => 45000, 'days' => 25,
             'letter' => 'Front-end focused developer. I will make the ordering flow fast and mobile-friendly, with a simple PHP backend your staff can manage. Sample: kape-no-lola.ph ordering page.'],
            ['freelancer_id' => 6, 'offer' => 32000, 'days' => 30,
             'letter' => 'I can build your ordering website in native PHP with MySQL, with an admin page for updating menu items and order status. Affordable rate and weekly progress updates.'],
        ];
    }

    // Other projects: generated from the freelancer list so every project has proposals
    $ids    = array_keys(toptunity_freelancers());
    $base   = $p['type'] === 'hourly' ? $p['rate'] * max(1, (int) round($p['max_hours'] * 0.8)) : $p['budget'];
    $count  = min(3, (int) $p['proposals']);
    $out    = [];
    for ($i = 0; $i < $count; $i++) {
        $out[] = [
            'freelancer_id' => $ids[($id + $i) % count($ids)],
            'offer'         => (int) round($base * (0.92 + 0.04 * $i) / 100) * 100,
            'days'          => 14 + $i * 5 + $id,
            'letter'        => 'I can deliver this project on time, with clear weekly progress updates and a short video walkthrough when the work is submitted.',
        ];
    }
    return $out;
}

/** Contract terms for a project once a freelancer has been selected (sample for project 2). */
function toptunity_project_tracking($id)
{
    if ($id !== 2 && $id < 1000) { return null; }
    $tracking = $id === 2 ? [
        'current_step' => 5,
        'start'        => '2026-09-14',
        'deposit'      => 36000,
        'deposit_status' => 'held',
        'worklog' => [
            ['date' => '2026-10-03', 'hours' => 3.0, 'task' => 'Low-stock alert emails for 25 ingredients', 'status' => 'pending'],
            ['date' => '2026-10-02', 'hours' => 5.5, 'task' => 'Daily sales report page with totals per cashier', 'status' => 'approved'],
            ['date' => '2026-10-01', 'hours' => 4.0, 'task' => 'Product and stock tables, CRUD screens', 'status' => 'approved'],
            ['date' => '2026-09-30', 'hours' => 2.0, 'task' => 'Duplicate test data cleanup (not in scope)', 'status' => 'rejected'],
        ],
        'max_hours' => 60,
        'files' => [
            ['name' => 'pos-dashboard-v2.zip', 'size' => '4.8 MB', 'type' => 'doc'],
            ['name' => 'sales-report-preview.png', 'size' => '560 KB', 'type' => 'pdf'],
        ],
        'message' => 'Hi Andrea! Version 2 of the dashboard is ready for testing: stock levels, low-stock alerts and the daily sales report. Login details are in the README.',
        'history' => [
            ['date' => '2026-10-03 18:42', 'status' => 'Hours Logged (3.0 h)', 'by' => 'Freelancer'],
            ['date' => '2026-10-02 09:15', 'status' => 'Hours Approved (5.5 h)', 'by' => 'Client'],
            ['date' => '2026-09-14 10:03', 'status' => 'Project Started (payment held)', 'by' => 'Client'],
            ['date' => '2026-09-14 08:30', 'status' => 'Contract Accepted · Start Date set', 'by' => 'Freelancer'],
            ['date' => '2026-09-13 16:12', 'status' => 'Contract Sent', 'by' => 'Client'],
            ['date' => '2026-09-13 16:05', 'status' => 'Freelancer Selected', 'by' => 'Client'],
            ['date' => '2026-09-08 11:20', 'status' => 'Project Posted', 'by' => 'Client'],
        ],
    ] : ['current_step' => 5, 'start' => date('Y-m-d'), 'deposit' => 0, 'deposit_status' => 'held',
         'worklog' => [], 'hours_approved' => 0, 'hours_pending' => 0, 'max_hours' => 0,
         'files' => [], 'message' => '', 'history' => []];
    if ($id >= 1000) {
        $tracking['worklog'] = tt_project_work_logs($id);
        $tracking['hours_approved'] = array_sum(array_map(function ($entry) {
            return $entry['status'] === 'approved' ? (float) $entry['hours'] : 0;
        }, $tracking['worklog']));
        $tracking['hours_pending'] = array_sum(array_map(function ($entry) {
            return $entry['status'] === 'pending' ? (float) $entry['hours'] : 0;
        }, $tracking['worklog']));
        $submission = tt_project_submission($id);
        $tracking['message'] = $submission ? $submission['message'] : '';
        $tracking['submission_status'] = $submission ? $submission['status'] : null;
        $tracking['submission_review_note'] = $submission ? $submission['review_note'] : null;
        $tracking['files'] = tt_attachments('deliverable', $id);
        $tracking['deposit'] = (int) (tt_db_project($id)['agreed_amount'] ?? 0);
    }
    return $tracking;
}

/**
 * Details for a CLIENT project. Client IDs don't always match public IDs,
 * so match by title first; otherwise build the details from the client project itself.
 */
function toptunity_client_detail($id)
{
    $saved_here = tt_saved_projects_for_current_user();
    if (isset($saved_here[$id])) {
        $r = $saved_here[$id];
        return ['title' => $r['title'], 'category' => $r['category'], 'desc' => $r['intro'], 'intro' => $r['intro'],
                'features' => [], 'closing' => '', 'skills' => $r['skills'], 'files' => $r['files']];
    }
    $cp = toptunity_client_projects()[$id] ?? null;
    if (!$cp) { return null; }

    foreach (toptunity_projects() as $pub) {
        if ($pub['title'] === $cp['title']) { return $pub; }
    }

    $intros = [
        2 => 'Build a point-of-sale and inventory dashboard with stock levels, low-stock alerts and a daily sales report for each cashier.',
        3 => 'Plan and create a monthly social media content calendar with captions, visuals and posting dates for each week.',
        4 => 'Design a menu board and cup sleeve set in print-ready files for the café, with clear pricing and brand colors.',
        5 => 'Edit a 30-second promo video for our opening week, with captions, background music and a clear call to action.',
        6 => 'Retouch product photos for the online shop: clean backgrounds, accurate color and consistent sizing.',
        7 => 'Write weekly social media posts for the menu, with captions, hashtags and photo suggestions.',
        8 => 'Lay out a barista training manual with clear sections, diagrams and printable pages.',
        9 => 'Build a loyalty points web app where customers earn and redeem points, with an admin page for managing rewards.',
    ];
    $skills = [
        2 => ['PHP', 'MySQL', 'JavaScript'], 3 => ['Copywriting', 'Social Media Marketing', 'Canva'],
        4 => ['Adobe Illustrator', 'Photoshop'], 5 => ['Premiere Pro', 'Video Editing'],
        6 => ['Photoshop', 'Retouching'], 7 => ['Copywriting', 'SEO'],
        8 => ['Adobe Illustrator', 'Layout Design'], 9 => ['PHP', 'MySQL', 'HTML/CSS'],
    ];

    return [
        'title'    => $cp['title'],
        'category' => $cp['category'],
        'desc'     => isset($intros[$id]) ? $intros[$id] : $cp['title'],
        'intro'    => isset($intros[$id]) ? $intros[$id] : $cp['title'],
        'features' => [],
        'closing'  => '',
        'skills'   => isset($skills[$id]) ? $skills[$id] : [],
        'files'    => [],
    ];
}

/* ==========================================================================
   CLIENT: SAVED FREELANCERS, NOTIFICATIONS (full list), MESSAGES, BILLING
   ========================================================================== */


/** Full notification list. cat is used by the filter tabs. */
function toptunity_client_notifications_all_demo()
{
    if (!tt_is_demo_account()) { return []; }
    return [
        ['cat' => 'proposals', 'icon' => 'file', 'tint' => 'blue', 'new' => true,
         'title' => 'New Proposals', 'text' => 'Jerome Castillo submitted a proposal on Online Ordering Website for a Coffee Shop.', 'time' => '2h ago'],
        ['cat' => 'responses', 'icon' => 'users', 'tint' => 'teal', 'new' => true,
         'title' => "Freelancer's Response", 'text' => 'Liza Navarro accepted your contract for Monthly Social Media Content Calendar. Please deposit the amount.', 'time' => '5h ago'],
        ['cat' => 'messages', 'icon' => 'message', 'tint' => 'blue', 'new' => true,
         'title' => 'New Messages', 'text' => 'Janelle Cruz: "I pushed the low-stock alerts — can you test it today?"', 'time' => '5h ago'],
        ['cat' => 'work', 'icon' => 'upload', 'tint' => 'teal', 'new' => false,
         'title' => 'Work Submissions', 'text' => 'Janelle Cruz submitted work on Point-of-Sale and Inventory Dashboard.', 'time' => 'Yesterday'],
        ['cat' => 'hours', 'icon' => 'clock', 'tint' => 'orange', 'new' => false,
         'title' => 'Hours Logged', 'text' => 'Janelle Cruz logged 3.0 hours on Oct 03. Review them before Oct 31.', 'time' => 'Yesterday'],
        ['cat' => 'deadline', 'icon' => 'alert', 'tint' => 'orange', 'new' => false,
         'title' => 'Deadline and Overdue Alerts', 'text' => 'Menu Board and Cup Sleeve Design is now Overdue. Extend the deadline or accept late work.', 'time' => 'Oct 02'],
        ['cat' => 'payments', 'icon' => 'check-circle', 'tint' => 'teal', 'new' => false,
         'title' => 'Payment Confirmations', 'text' => 'Your deposit of ₱36,000 for Point-of-Sale and Inventory Dashboard is now held.', 'time' => 'Sep 14'],
        ['cat' => 'refunds', 'icon' => 'refresh', 'tint' => 'orange', 'new' => false,
         'title' => 'Refunds', 'text' => '₱4,000 was refunded for the cancelled project Barista Training Manual Layout.', 'time' => 'Aug 31'],
    ];
}

/** Message threads. Each has a list of messages: from = 'me' | 'them'. */
function toptunity_client_threads_demo_base()
{
    if (!tt_is_demo_account()) { return []; }
    return [
        [
            'name' => 'Miguel Reyes', 'project' => 'Online Ordering Website', 'project_id' => 1,
            'preview' => 'Sure — here are the details you asked for...', 'time' => '5m', 'unread' => true,
            'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short',
            'messages' => [
                ['from' => 'them', 'text' => 'Hello po! I have a question about the project requirements — do you also need a delivery option, or pick-up only for now?', 'time' => 'Oct 04, 9:12 AM'],
                ['from' => 'me',   'text' => 'Sure — here are the details you asked for. Pick-up only for now, but please make it easy to add delivery next year.', 'time' => 'Oct 04, 9:30 AM · Seen'],
                ['from' => 'them', 'file' => ['name' => 'ordering-flow-draft.pdf', 'size' => '620 KB'], 'text' => 'Attached the ordering flow for your review.', 'time' => 'Oct 04, 9:41 AM'],
                ['from' => 'me',   'text' => 'Thanks, I will check it today.', 'time' => 'Oct 04, 9:45 AM · Seen'],
            ],
        ],
        [
            'name' => 'Janelle Cruz', 'project' => 'POS and Inventory Dashboard', 'project_id' => 2,
            'preview' => 'I pushed the low-stock alerts — can you test it...', 'time' => '1h', 'unread' => true,
            'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'bun',
            'messages' => [
                ['from' => 'them', 'text' => 'Hi Andrea! I pushed the low-stock alerts. Can you test it today?', 'time' => 'Oct 07, 3:10 PM'],
                ['from' => 'me',   'text' => 'Will do. I will test the daily report first.', 'time' => 'Oct 07, 3:20 PM · Seen'],
            ],
        ],
        [
            'name' => 'Liza Navarro', 'project' => 'Social Media Calendar', 'project_id' => 3,
            'preview' => 'Here are the captions for week 1, po!', 'time' => '1h', 'unread' => true,
            'bg' => '#DBEAFE', 'hair' => '#1E293B', 'style' => 'long',
            'messages' => [
                ['from' => 'them', 'text' => 'Here are the captions for week 1, po!', 'time' => 'Oct 07, 2:05 PM'],
            ],
        ],
        [
            'name' => 'Paolo Garcia', 'project' => 'Menu Board Design', 'project_id' => 4,
            'preview' => 'Sorry for the delay, sending the files tonight.', 'time' => '3d', 'unread' => false,
            'bg' => '#FEF9C3', 'hair' => '#1E293B', 'style' => 'short',
            'messages' => [
                ['from' => 'them', 'text' => 'Sorry for the delay, sending the files tonight.', 'time' => 'Oct 05, 6:40 PM'],
            ],
        ],
        [
            'name' => 'Jerome Castillo', 'project' => 'Online Ordering Website', 'project_id' => 1,
            'preview' => 'Thank you for considering my proposal!', 'time' => '1d', 'unread' => false,
            'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'glasses',
            'messages' => [
                ['from' => 'them', 'text' => 'Thank you for considering my proposal!', 'time' => 'Oct 06, 4:02 PM'],
            ],
        ],
    ];
}

/** Hourly billing rows for the billing page. */
function toptunity_client_hourly_billing()
{
    if (!tt_is_demo_account()) { return []; }
    return [
        ['end' => '2026-07-31', 'project' => 'Weekly Menu Social Posts (July)', 'approved' => 24.0, 'rate' => 350, 'billed' => 8400, 'unused' => 1400, 'status' => 'paid'],
        ['end' => '2026-10-31', 'project' => 'Point-of-Sale and Inventory Dashboard', 'approved' => 32.5, 'rate' => 600, 'billed' => null, 'unused' => null, 'status' => 'upcoming'],
    ];
}

/* ==========================================================================
   CLIENT: REVIEWS RECEIVED (My Profile > My Reviews)
   ========================================================================== */
function toptunity_client_reviews()
{
    if (!tt_is_demo_account()) { return []; }
    return [
        ['by' => 'Miguel Reyes', 'project' => 'Cafe Menu Landing Page', 'date' => '2026-09-02', 'stars' => 5,
         'text' => 'Clear requirements and very quick to reply. Andrea approved the work on the same day I submitted it. Would gladly work with Kapé Lokal again!', 'bg' => '#CCFBF1', 'style' => 'short'],
        ['by' => 'Liza Navarro', 'project' => 'Product Photo Retouching', 'date' => '2026-09-05', 'stars' => 5,
         'text' => 'Friendly client and the photos were well organized. Payment was released right after approval.', 'bg' => '#DBEAFE', 'style' => 'long'],
        ['by' => 'Paolo Garcia', 'project' => 'Loyalty Card Design', 'date' => '2026-07-18', 'stars' => 4,
         'text' => 'Good communication. The brief changed once mid-project but we sorted it out quickly.', 'bg' => '#FEF9C3', 'style' => 'short'],
        ['by' => 'Janelle Cruz', 'project' => 'POS Dashboard (Phase 1)', 'date' => '2026-06-12', 'stars' => 5,
         'text' => 'Andrea gave clear feedback every week and paid on time.', 'bg' => '#FFEDD5', 'style' => 'bun'],
        ['by' => 'Carla Mendoza', 'project' => 'Salon Flyer Set', 'date' => '2026-05-30', 'stars' => 5,
         'text' => 'Very organized and easy to work with.', 'bg' => '#FFEDD5', 'style' => 'long'],
        ['by' => 'Nina Reyes', 'project' => 'Retail Banner Design', 'date' => '2026-05-14', 'stars' => 5,
         'text' => 'Quick decisions and fair scope. Would hire again.', 'bg' => '#FEF9C3', 'style' => 'bun'],
        ['by' => 'Rhea Mendoza', 'project' => 'Brand Voice Guide', 'date' => '2026-04-22', 'stars' => 5,
         'text' => 'Gave me the context I needed and approved the drafts promptly.', 'bg' => '#CCFBF1', 'style' => 'long'],
        ['by' => 'Kevin Tan', 'project' => 'Inventory Clean-up', 'date' => '2026-03-09', 'stars' => 4,
         'text' => 'Payment flow was smooth. The scope grew a little, but we agreed on the changes.', 'bg' => '#DCFCE7', 'style' => 'short'],
        ['by' => 'Bea Lim', 'project' => 'Menu App Mockups', 'date' => '2026-02-18', 'stars' => 5,
         'text' => 'Great client. Clear about what she wanted and responsive on chat.', 'bg' => '#DBEAFE', 'style' => 'long'],
    ];
}


/**
 * The signed-in client (name from the account; styling from the default profile).
 */
function toptunity_current_client()
{
    $me = toptunity_current_client_default();
    if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'client') {
        $me['name'] = $_SESSION['user']['name'];
        $me['avatar'] = tt_user_avatar_asset((int) $_SESSION['user']['id']);
        if (!tt_is_demo_account()) {
            $me['company'] = '';
            $me['bg'] = '#CCFBF1';
        }
    }
    return $me;
}


/* ==========================================================================
   POSTED PROJECTS (saved to storage/projects.json, per client account)
   ========================================================================== */

/** Every project the signed-in client can see: the demo projects (demo account only) plus their own. */
function toptunity_client_projects()
{
    $saved  = tt_saved_projects_for_current_user();
    $sample = tt_is_demo_account() ? toptunity_client_projects_sample() : [];
    // Your own projects first, newest at the top, then the sample projects
    return array_reverse($saved, true) + $sample;
}








function tt_human_size($bytes)
{
    return $bytes >= 1048576 ? number_format($bytes / 1048576, 1) . ' MB' : max(1, round($bytes / 1024)) . ' KB';
}

/**
 * Save uploaded attachments (PDF, JPG, PNG, DOCX, up to 10 MB each) into storage/uploads.
 * Returns ['files' => [...], 'errors' => [...]].
 */
function tt_handle_uploads($field)
{
    $files = []; $errors = [];
    if (!isset($_FILES[$field]) || empty($_FILES[$field]['name'][0])) {
        return ['files' => $files, 'errors' => $errors];
    }
    $allowed = ['pdf' => 'pdf', 'jpg' => 'image', 'jpeg' => 'image', 'png' => 'image', 'docx' => 'doc'];
    $dir = dirname(__DIR__) . '/storage/uploads';
    if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
    if (!is_dir($dir) || !is_writable($dir)) { return ['files' => [], 'errors' => [tt_storage_message($dir)]]; }

    foreach ($_FILES[$field]['name'] as $i => $name) {
        $code = $_FILES[$field]['error'][$i];
        if ($name === '' || $code === UPLOAD_ERR_NO_FILE) { continue; }
        if ($code === UPLOAD_ERR_INI_SIZE || $code === UPLOAD_ERR_FORM_SIZE) { $errors[] = "$name is larger than the server allows (" . ini_get('upload_max_filesize') . ")."; continue; }
        if ($code !== UPLOAD_ERR_OK) { $errors[] = "Could not upload $name."; continue; }
        $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $size = (int) $_FILES[$field]['size'][$i];
        if (!isset($allowed[$ext])) { $errors[] = "$name: only PDF, JPG, PNG or DOCX files are allowed."; continue; }
        if ($size > 10 * 1024 * 1024) { $errors[] = "$name is larger than 10 MB."; continue; }
        $stored = bin2hex(random_bytes(8)) . '.' . $ext;
        if (!move_uploaded_file($_FILES[$field]['tmp_name'][$i], $dir . '/' . $stored)) { $errors[] = "Could not save $name."; continue; }
        $files[] = ['name' => basename($name), 'stored' => $stored, 'size' => tt_human_size($size), 'type' => $allowed[$ext]];
    }
    return ['files' => $files, 'errors' => $errors];
}

/* ==========================================================================
   FREELANCER AREA
   The demo freelancer is Miguel Reyes (miguel.reyes@example.com). Other accounts start empty.
   ========================================================================== */

function tt_is_demo_freelancer()
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'freelancer'
        && strcasecmp($_SESSION['user']['email'], 'miguel.reyes@example.com') === 0;
}

/** The signed-in freelancer, for the sidebar and profile. */
function toptunity_current_freelancer()
{
    $me = ['name' => '', 'title' => 'Freelancer', 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short'];
    if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'freelancer') {
        $me['name'] = $_SESSION['user']['name'];
        $me['avatar'] = tt_user_avatar_asset((int) $_SESSION['user']['id']);
    }
    if (tt_is_demo_freelancer()) {
        $f = toptunity_freelancer(1);
        $me['title'] = $f['title'];
        $me['bg']    = $f['bg'];
        $me['hair']  = $f['hair'];
        $me['style'] = $f['style'];
    }
    return $me;
}

/**
 * Proposals the freelancer has sent.
 * status: pending | selected | not_selected | withdrawn
 */


/** Skill match (0-100) between a freelancer's skills and a project's required skills. */
function tt_skill_match($required, $skills)
{
    if (!$required) { return 0; }
    $have = array_map('strtolower', $skills);
    $hit = 0;
    foreach ($required as $r) { if (in_array(strtolower($r), $have, true)) { $hit++; } }
    return (int) round($hit / count($required) * 100);
}

/* ==========================================================================
   FREELANCER: PROJECT DETAILS, EARNINGS, MESSAGES, NOTIFICATIONS, SAVED
   ========================================================================== */







/** Reviews the freelancer has received (for My Reviews and the dashboard rating). */
function toptunity_freelancer_reviews()
{
    if (!tt_is_demo_freelancer()) {
        return ['avg' => 0, 'total' => 0, 'dist' => [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0], 'items' => []];
    }
    return [
        'avg'   => 4.9,
        'total' => 38,
        'dist'  => [5 => 33, 4 => 4, 3 => 1, 2 => 0, 1 => 0],
        'items' => [
            ['by' => 'Grace Aquino', 'project' => 'Clinic Inventory Dashboard', 'date' => '2026-09-18', 'stars' => 5,
             'text' => 'Miguel built our clinic inventory dashboard ahead of schedule. He explained every feature clearly and fixed small issues the same day.',
             'bg' => '#FFEDD5', 'style' => 'bun'],
            ['by' => 'Joy Bautista', 'project' => 'Sari-Sari Store POS System', 'date' => '2026-08-16', 'stars' => 5,
             'text' => 'Our sari-sari store POS is so easy to use. Even my Lola can record sales now!',
             'bg' => '#FEF9C3', 'style' => 'bun'],
            ['by' => 'Ramon Villanueva', 'project' => 'Tuition Payment Tracker', 'date' => '2026-06-21', 'stars' => 4,
             'text' => 'Good work on the payment tracking module. A few revisions were needed, but he handled them quickly.',
             'bg' => '#CCFBF1', 'style' => 'short'],
        ],
    ];
}

/** Skills a freelancer can add (set by the administrator). */
function toptunity_skill_catalog()
{
    $defaults = [
        'Laravel' => 'Web Development', 'Laravel Livewire' => 'Web Development', 'PHP' => 'Web Development',
        'MySQL' => 'Web Development', 'JavaScript' => 'Web Development', 'React' => 'Web Development',
        'HTML/CSS' => 'Web Development', 'Bootstrap' => 'Web Development', 'REST API' => 'Web Development',
        'WordPress' => 'Web Development', 'Flutter' => 'Mobile App Development', 'Firebase' => 'Mobile App Development',
        'Figma' => 'UI/UX Design', 'UI Design' => 'UI/UX Design', 'Logo Design' => 'Graphic Design',
        'Adobe Illustrator' => 'Graphic Design', 'Photoshop' => 'Graphic Design', 'Copywriting' => 'Writing and Content',
        'SEO' => 'Digital Marketing', 'Social Media Marketing' => 'Digital Marketing', 'Data Entry' => 'Data Entry and Admin',
        'Microsoft Excel' => 'Data Entry and Admin', 'Premiere Pro' => 'Video and Animation',
    ];
    $seeded = db()->prepare("SELECT value FROM settings WHERE name = 'catalog_defaults_seeded'");
    $seeded->execute();
    if (!$seeded->fetchColumn()) {
        foreach (array_unique(array_values($defaults)) as $category) {
            db()->prepare('INSERT IGNORE INTO categories (name) VALUES (?)')->execute([$category]);
        }
        foreach ($defaults as $skill => $category) {
            $category_id = db()->prepare('SELECT id FROM categories WHERE name = ?');
            $category_id->execute([$category]);
            db()->prepare('INSERT IGNORE INTO skills (name, category_id) VALUES (?, ?)')
                ->execute([$skill, (int) $category_id->fetchColumn()]);
        }
        db()->prepare("INSERT INTO settings (name, value) VALUES ('catalog_defaults_seeded', '1')
                       ON DUPLICATE KEY UPDATE value = '1'")->execute();
    }
    if (tt_is_demo_admin()) {
        return tt_demo_admin_catalog_state()['skills'];
    }
    $rows = db()->query('SELECT s.name AS skill, c.name AS category FROM skills s LEFT JOIN categories c ON c.id = s.category_id ORDER BY s.name')->fetchAll();
    if (!$rows) { return $defaults; }
    $catalog = [];
    foreach ($rows as $row) { $catalog[$row['skill']] = $row['category'] ?: 'Other'; }
    return $catalog;
}

/* ==========================================================================
   FREELANCER SAMPLE DATA (matches the freelancer designs; demo freelancer = Miguel Reyes)
   ========================================================================== */

/** Proposals sent. status: pending | selected | not_selected | withdrawn. project_id is the public project id when there is one. */
function toptunity_freelancer_proposals()
{
    if (!tt_is_demo_freelancer()) { return []; }
    return [
        ['id' => 1, 'project_id' => 1, 'title' => 'Online Ordering Website for a Coffee Shop', 'client' => 'Andrea Santos',
         'category' => 'Web Development', 'type' => 'fixed', 'rate' => 0, 'offer' => 42000, 'days' => 21, 'status' => 'selected', 'sent' => '2026-10-02', 'match' => 95],
        ['id' => 2, 'project_id' => 2, 'title' => 'Student Enrollment System for a Tutorial Center', 'client' => 'Ramon Villanueva',
         'category' => 'Web Development', 'type' => 'hourly', 'rate' => 500, 'offer' => 500, 'days' => 30, 'status' => 'pending', 'sent' => '2026-10-02', 'match' => 95],
        ['id' => 3, 'project_id' => 0, 'title' => 'Hotel Room Reservation Module', 'client' => 'Mark Francisco',
         'category' => 'Web Development', 'type' => 'fixed', 'rate' => 0, 'offer' => 28000, 'days' => 18, 'status' => 'not_selected', 'sent' => '2026-09-24', 'match' => 80],
        ['id' => 4, 'project_id' => 0, 'title' => 'Laravel API for a Delivery App', 'client' => 'Grace Aquino',
         'category' => 'Web Development', 'type' => 'hourly', 'rate' => 700, 'offer' => 700, 'days' => 25, 'status' => 'pending', 'sent' => '2026-09-20', 'match' => 88],
        ['id' => 5, 'project_id' => 0, 'title' => 'School Library Management System', 'client' => 'Ramon Villanueva',
         'category' => 'Web Development', 'type' => 'fixed', 'rate' => 0, 'offer' => 35000, 'days' => 30, 'status' => 'withdrawn', 'sent' => '2026-09-12', 'match' => 90],
    ];
}

/**
 * Your projects. status: offer (client selected you, not accepted yet) | ongoing | overdue | completed.
 * Hourly projects also have rate, max_hours and worklog.
 */
function toptunity_freelancer_projects()
{
    $sample = tt_is_demo_freelancer() ? [
        ['id' => 201, 'project_id' => 1, 'title' => 'Online Ordering Website for a Coffee Shop', 'client' => 'Andrea Santos',
         'client_company' => 'Kapé Lokal Coffee Co.', 'category' => 'Web Development', 'status' => 'offer', 'type' => 'fixed',
         'budget' => 42000, 'start' => '2026-10-08', 'deadline' => '2026-11-20', 'progress' => 0],
        ['id' => 202, 'project_id' => 0, 'title' => 'Clinic Inventory Dashboard v2', 'client' => 'Grace Aquino',
         'client_company' => 'Aquino Dental Clinic', 'category' => 'Web Development', 'status' => 'ongoing', 'type' => 'hourly',
         'rate' => 650, 'max_hours' => 50, 'budget' => 32500, 'start' => '2026-09-21', 'deadline' => '2026-10-28', 'progress' => 63],
        ['id' => 203, 'project_id' => 0, 'title' => 'Resort Booking Website Revamp', 'client' => 'Mark Francisco',
         'client_company' => 'Resort Booking Co.', 'category' => 'Web Development', 'status' => 'ongoing', 'type' => 'fixed',
         'budget' => 38000, 'start' => '2026-09-15', 'deadline' => '2026-10-18', 'progress' => 70],
        ['id' => 204, 'project_id' => 0, 'title' => 'Tuition Payment Tracker', 'client' => 'Ramon Villanueva',
         'client_company' => 'BrightPath Tutorial Center', 'category' => 'Web Development', 'status' => 'overdue', 'type' => 'fixed',
         'budget' => 22000, 'start' => '2026-08-25', 'deadline' => '2026-09-30', 'progress' => 90],
        ['id' => 205, 'project_id' => 0, 'title' => 'Sari-Sari Store POS System', 'client' => 'Joy Bautista',
         'client_company' => 'Bautista Bakeshop', 'category' => 'Web Development', 'status' => 'completed', 'type' => 'fixed',
         'budget' => 18000, 'start' => '2026-07-20', 'deadline' => '2026-08-15', 'progress' => 100],
    ] : [];
    return array_merge($sample, tt_freelancer_db_project_rows());
}

/** One project with its details: work log, revision request, submitted work and history. */
function toptunity_freelancer_project($id)
{
    foreach (toptunity_freelancer_projects() as $p) {
        if ((int) $p['id'] !== (int) $id) { continue; }
        $p['worklog'] = [];
        $p['revision'] = null;
        $p['submitted'] = null;
        $p['history'] = [];
        $p['hours_logged'] = 0; $p['hours_approved'] = 0;
        if ($id === 202) {
            $p['worklog'] = [
                ['date' => '2026-10-04', 'hours' => 4.0, 'task' => 'Monthly stock report export to Excel', 'status' => 'pending'],
                ['date' => '2026-10-02', 'hours' => 5.5, 'task' => 'Supplier list and purchase order screens', 'status' => 'approved'],
                ['date' => '2026-09-30', 'hours' => 6.0, 'task' => 'Batch and expiry date tracking for medicines', 'status' => 'approved'],
                ['date' => '2026-09-28', 'hours' => 1.5, 'task' => 'Fixing unrelated printer driver issue', 'status' => 'rejected', 'note' => 'Outside the project requirements'],
            ];
            $p['hours_logged'] = 31.5; $p['hours_approved'] = 27.5;
            $p['revision'] = ['date' => 'Oct 03, 2026', 'message' => 'Please add an Export to Excel button on the monthly stock report so our pharmacist can print it.'];
            $p['submitted'] = ['message' => "Hi Ma'am Grace! I added the Export to Excel button on the monthly stock report. The file follows your pharmacy's template. Please check and let me know.",
                               'files' => [['name' => 'clinic-inventory-v2.3.zip', 'size' => '5.1 MB']]];
            $p['history'] = [
                ['date' => 'Oct 04, 2026', 'status' => 'Hours logged', 'note' => '4.0 h · Pending'],
                ['date' => 'Oct 03, 2026', 'status' => 'Revision requested', 'note' => 'Client'],
                ['date' => 'Oct 02, 2026', 'status' => 'Hours approved', 'note' => '5.5 h · Client'],
                ['date' => 'Sep 21, 2026', 'status' => 'Project started', 'note' => 'Payment held'],
                ['date' => 'Sep 21, 2026', 'status' => 'Contract accepted', 'note' => 'Start date set'],
                ['date' => 'Sep 20, 2026', 'status' => 'Freelancer selected', 'note' => 'Client'],
            ];
        }
        if ($id === 201) {
            $p['history'] = [['date' => 'Oct 07, 2026', 'status' => 'Freelancer selected', 'note' => 'Client']];
        }
        if (!empty($p['real']) && $p['type'] === 'hourly') {
            $p['worklog'] = tt_project_work_logs($id);
            $p['hours_logged'] = array_sum(array_column($p['worklog'], 'hours'));
            $p['hours_approved'] = array_sum(array_map(function ($entry) {
                return $entry['status'] === 'approved' ? (float) $entry['hours'] : 0;
            }, $p['worklog']));
        }
        if (!empty($p['real'])) {
            $submission = tt_project_submission($id);
            $p['submitted'] = $submission ? ['message' => $submission['message'], 'status' => $submission['status'],
                                              'review_note' => $submission['review_note'],
                                              'files' => tt_attachments('deliverable', $id)] : null;
            if ($submission && $submission['status'] === 'revision') {
                $p['revision'] = ['date' => tt_date_label($submission['created_at']), 'message' => $submission['review_note']];
            }
        }
        return $p;
    }
    return null;
}

/** Message threads. Each has messages with from = 'me' | 'them'. */
function toptunity_freelancer_threads_demo_base()
{
    if (!tt_is_demo_freelancer()) { return []; }
    return [
        ['name' => 'Andrea Santos', 'project' => 'Online Ordering Website for a Coffee Shop', 'time' => '5m', 'unread' => true,
         'preview' => 'Thanks, I will check it today.', 'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'long',
         'messages' => [
            ['from' => 'them', 'text' => 'Hi Miguel! Your proposal looks great. Before I send the contract, can you include a short training video for my staff?', 'time' => 'Oct 04, 9:12 AM'],
            ['from' => 'me', 'text' => 'Hello po! Yes, I always include a 5-minute walkthrough video. I also attached the ordering flow draft.', 'time' => 'Oct 04, 9:20 AM · Seen'],
            ['from' => 'me', 'file' => ['name' => 'ordering-flow-draft.pdf', 'size' => '820 KB'], 'text' => 'Attached the ordering flow for your review.', 'time' => 'Oct 04, 9:41 AM · Seen'],
            ['from' => 'them', 'text' => 'Thanks, I will check it today.', 'time' => 'Oct 04, 9:45 AM'],
         ]],
        ['name' => 'Grace Aquino', 'project' => 'Clinic Inventory Dashboard v2', 'time' => '1h', 'unread' => true,
         'preview' => 'Approved 5.5 hours for Oct 2. Thank you!', 'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'bun',
         'messages' => [
            ['from' => 'them', 'text' => 'Approved 5.5 hours for Oct 2. Thank you!', 'time' => 'Oct 04, 10:02 AM'],
         ]],
        ['name' => 'Mark Francisco', 'project' => 'Resort Booking Website Revamp', 'time' => '1d', 'unread' => false,
         'preview' => 'Can we add a GCash reference field?', 'bg' => '#DBEAFE', 'hair' => '#1E293B', 'style' => 'short',
         'messages' => [
            ['from' => 'them', 'text' => 'Can we add a GCash reference field?', 'time' => 'Oct 03, 4:15 PM'],
         ]],
        ['name' => 'Ramon Villanueva', 'project' => 'Tuition Payment Tracker', 'time' => '2d', 'unread' => false,
         'preview' => 'Please send the final build when ready.', 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'glasses',
         'messages' => [
            ['from' => 'them', 'text' => 'Please send the final build when ready.', 'time' => 'Oct 02, 1:30 PM'],
         ]],
        ['name' => 'Joy Bautista', 'project' => 'Sari-Sari Store POS System', 'time' => '1w', 'unread' => false,
         'preview' => 'The POS is working great, thank you!', 'bg' => '#FEF9C3', 'hair' => '#1E293B', 'style' => 'bun',
         'messages' => [
            ['from' => 'them', 'text' => 'The POS is working great, thank you!', 'time' => 'Sep 28, 8:00 AM'],
         ]],
    ];
}

/** Notifications. cat is used by the filter tabs. */
function toptunity_freelancer_notifications_demo()
{
    if (!tt_is_demo_freelancer()) { return []; }
    return [
        ['cat' => 'offers', 'icon' => 'briefcase', 'tint' => 'orange', 'new' => true,
         'title' => 'Project Offers', 'text' => 'Andrea Santos selected you and sent a contract for Online Ordering Website for a Coffee Shop.', 'time' => '1h ago'],
        ['cat' => 'worklog', 'icon' => 'check-circle', 'tint' => 'teal', 'new' => true,
         'title' => 'Work Log Updates', 'text' => 'Grace Aquino approved 5.5 hours on Clinic Inventory Dashboard v2.', 'time' => '3h ago'],
        ['cat' => 'messages', 'icon' => 'message', 'tint' => 'blue', 'new' => true,
         'title' => 'New Messages', 'text' => 'Mark Francisco: "Can we add a GCash reference field?"', 'time' => 'Yesterday'],
        ['cat' => 'proposals', 'icon' => 'x-circle', 'tint' => 'slate', 'new' => false,
         'title' => 'Proposal Results', 'text' => 'Your proposal for Hotel Room Reservation Module was not selected.', 'time' => 'Sep 26'],
        ['cat' => 'revisions', 'icon' => 'refresh', 'tint' => 'orange', 'new' => false,
         'title' => 'Revision Requests', 'text' => 'Mark Francisco requested a revision on Resort Booking Website Revamp.', 'time' => 'Sep 27'],
        ['cat' => 'deadlines', 'icon' => 'alert', 'tint' => 'orange', 'new' => false,
         'title' => 'Deadline Extensions and Overdue Alerts', 'text' => 'Tuition Payment Tracker passed its End Date and is now Overdue.', 'time' => 'Oct 01'],
        ['cat' => 'payments', 'icon' => 'wallet', 'tint' => 'teal', 'new' => false,
         'title' => 'Payments', 'text' => '₱16,200 (₱18,000 minus 10% fee) was released for Sari-Sari Store POS System.', 'time' => 'Aug 16'],
        ['cat' => 'withdrawals', 'icon' => 'bank', 'tint' => 'blue', 'new' => false,
         'title' => 'Withdrawal Updates', 'text' => 'Your withdrawal of ₱15,000 to GCash •••• 4821 was processed.', 'time' => 'Aug 18'],
    ];
}


/* ==========================================================================
   ADMIN AREA
   Admin pages show the whole platform: real accounts (storage/users.json),
   posted projects (storage/projects.json) and the sample data below.
   ========================================================================== */

function toptunity_current_admin()
{
    $me = ['name' => 'Administrator', 'bg' => '#E2E8F0', 'hair' => '#1E293B', 'style' => 'short'];
    if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
        $me['name'] = $_SESSION['user']['name'];
    }
    return $me;
}





/** Recent activity for the audit log. */
function toptunity_admin_audit()
{
    if (!tt_is_demo_admin()) { return []; }
    return [
        ['when' => 'Oct 08, 2026 · 9:12 AM', 'who' => 'Andrea Santos', 'role' => 'client', 'action' => 'Posted a project', 'target' => 'Online Ordering Website for a Coffee Shop'],
        ['when' => 'Oct 07, 2026 · 3:24 PM', 'who' => 'Miguel Reyes', 'role' => 'freelancer', 'action' => 'Submitted a proposal', 'target' => 'Online Ordering Website for a Coffee Shop'],
        ['when' => 'Oct 06, 2026 · 4:40 PM', 'who' => 'Ramon Villanueva', 'role' => 'client', 'action' => 'Approved logged hours', 'target' => 'Tuition Payment Tracker'],
        ['when' => 'Oct 04, 2026 · 6:42 PM', 'who' => 'Miguel Reyes', 'role' => 'freelancer', 'action' => 'Logged 3.0 hours', 'target' => 'Clinic Inventory Dashboard v2'],
        ['when' => 'Oct 03, 2026 · 10:15 AM', 'who' => 'Admin', 'role' => 'admin', 'action' => 'Rejected a withdrawal', 'target' => 'W-2170 · Carlo Dizon'],
        ['when' => 'Oct 02, 2026 · 9:02 AM', 'who' => 'Grace Aquino', 'role' => 'client', 'action' => 'Requested a revision', 'target' => 'Clinic Inventory Dashboard v2'],
    ];
}


/* ==========================================================================
   ADMIN AREA (matches the admin designs)
   ========================================================================== */

/** Every user: real accounts plus the sample users shown in the design. */
function toptunity_admin_users()
{
    $rows = [];
    foreach (tt_load_users() as $u) {
        if (tt_is_demo_admin() && !tt_is_demo_user($u)) { continue; }
        if (!tt_is_demo_admin() && (tt_is_demo_user($u) || tt_is_demo_admin($u))) { continue; }
        $rows[] = ['id' => (int) $u['id'], 'name' => $u['name'], 'email' => $u['email'], 'role' => $u['role'],
                   'status' => ucfirst($u['status']), 'joined' => date('M d, Y', strtotime($u['created_at']))];
    }
    if (!tt_is_demo_admin()) { return $rows; }
    $sample = [
        ['id' => 2001, 'name' => 'Ramon Villanueva', 'email' => 'ramon@brightpath.edu.ph', 'role' => 'client', 'status' => 'Active', 'joined' => 'Feb 20, 2025'],
        ['id' => 2002, 'name' => 'Rico Manalastas', 'email' => 'rico.manalastas@gmail.com', 'role' => 'client', 'status' => 'Suspended', 'joined' => 'Sep 14, 2026'],
        ['id' => 2003, 'name' => 'Grace Aquino', 'email' => 'grace@aquinodental.ph', 'role' => 'client', 'status' => 'Active', 'joined' => 'Mar 03, 2025'],
        ['id' => 2004, 'name' => 'Mark Francisco', 'email' => 'mark@islatravel.ph', 'role' => 'client', 'status' => 'Deactivated', 'joined' => 'Apr 18, 2025'],
        ['id' => 2005, 'name' => 'Joy Bautista', 'email' => 'joy.bautista@gmail.com', 'role' => 'freelancer', 'status' => 'Active', 'joined' => 'Jun 09, 2026'],
        ['id' => 2006, 'name' => 'Paolo Garcia', 'email' => 'paolo.garcia@gmail.com', 'role' => 'freelancer', 'status' => 'Active', 'joined' => 'Mar 11, 2025'],
        ['id' => 2007, 'name' => 'Kevin Tan', 'email' => 'kevin.tan@gmail.com', 'role' => 'freelancer', 'status' => 'Active', 'joined' => 'Jul 22, 2026'],
        ['id' => 2008, 'name' => 'Daniel Ocampo', 'email' => 'daniel.ocampo@example.com', 'role' => 'freelancer', 'status' => 'Active', 'joined' => 'Oct 02, 2026'],
    ];
    foreach (toptunity_freelancers() as $fid => $f) {
        $sample[] = ['id' => 3000 + $fid, 'name' => $f['name'], 'email' => strtolower(str_replace(' ', '.', $f['name'])) . '@example.com',
                     'role' => 'freelancer', 'status' => $f['available'] ? 'Active' : 'Inactive', 'joined' => $f['since']];
    }
    $names = array_map(function ($r) { return strtolower($r['name']); }, $rows);
    foreach ($sample as $r) { if (!in_array(strtolower($r['name']), $names, true)) { $rows[] = $r; } }
    foreach ($rows as &$row) {
        if (isset($_SESSION['demo_admin_user_status'][(string) $row['id']])) {
            $row['status'] = $_SESSION['demo_admin_user_status'][(string) $row['id']];
        }
        $row['warnings'] = count($_SESSION['demo_admin_user_warnings'][(string) $row['id']] ?? []);
    }
    unset($row);
    return $rows;
}

/** Change a client or freelancer status. Demo changes are isolated to the admin session. */
function tt_admin_change_user_status($id, $action)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'admin') { return 'Administrator access is required.'; }
    $statuses = ['suspend' => 'Suspended', 'reactivate' => 'Active', 'deactivate' => 'Deactivated'];
    if (!isset($statuses[$action])) { return 'Choose a valid user action.'; }

    if (tt_is_demo_admin($user)) {
        $target = null;
        foreach (toptunity_admin_users() as $candidate) {
            if ((int) $candidate['id'] === (int) $id && in_array($candidate['role'], ['client', 'freelancer'], true)) {
                $target = $candidate;
                break;
            }
        }
        if (!$target) { return 'That demo user could not be found.'; }
        $_SESSION['demo_admin_user_status'][(string) $id] = $statuses[$action];
        return null;
    }

    $status = ['suspend' => 'suspended', 'reactivate' => 'active', 'deactivate' => 'deactivated'][$action];
    $stmt = db()->prepare("UPDATE users SET status = ? WHERE id = ? AND role IN ('client', 'freelancer')");
    $stmt->execute([$status, (int) $id]);
    if ($stmt->rowCount()) { return null; }
    $check = db()->prepare("SELECT status FROM users WHERE id = ? AND role IN ('client', 'freelancer')");
    $check->execute([(int) $id]);
    return $check->fetchColumn() === $status ? null : 'That user could not be updated.';
}

/** Reports. status: pending | resolved | dismissed. type: User | Project | Review | Message */
function toptunity_admin_reports()
{
    if (!tt_is_demo_admin()) {
        $demo_ids = tt_demo_ids();
        $sql = 'SELECT r.id, r.type, r.reason, r.details, r.status, r.created_at, r.reported_user_id,
                       reporter.name AS reporter, reported.name AS reported_user
                FROM reports r
                JOIN users reporter ON reporter.id = r.reporter_id
                LEFT JOIN users reported ON reported.id = r.reported_user_id';
        if ($demo_ids) {
            $ids = implode(',', array_map('intval', $demo_ids));
            $sql .= " WHERE r.reporter_id NOT IN ($ids) AND (r.reported_user_id IS NULL OR r.reported_user_id NOT IN ($ids))";
        }
        $rows = [];
        foreach (db()->query($sql . ' ORDER BY r.id DESC')->fetchAll() as $report) {
            $reported = $report['reported_user'] ?: ucfirst($report['type']) . ' report #' . (int) $report['id'];
            $rows[] = [
                'id' => 'DB-' . (int) $report['id'],
                'date' => tt_date_label($report['created_at']),
                'reported' => $reported,
                'type' => ucfirst($report['type']),
                'reason' => $report['reason'],
                'reporter' => $report['reporter'],
                'status' => $report['status'],
                'quote' => $report['details'],
                'when' => date('M d, Y · g:i A', strtotime($report['created_at'])),
                'reported_user_id' => $report['reported_user_id'] ? (int) $report['reported_user_id'] : null,
                'real' => true,
            ];
        }
        return $rows;
    }
    $rows = [
        ['id' => 'R-311', 'date' => 'Oct 03', 'reported' => 'Rico Manalastas', 'type' => 'User', 'reason' => 'Scam / off-platform payment',
         'reporter' => 'Miguel Reyes', 'status' => 'pending',
         'quote' => 'Before I send the contract, please pay a ₱500 registration fee to my GCash 0998•••• so I know you\'re serious.', 'when' => 'Sep 30, 2026 · 3:14 PM'],
        ['id' => 'R-310', 'date' => 'Oct 02', 'reported' => 'Daniel Ocampo', 'type' => 'User', 'reason' => 'Abusive messages',
         'reporter' => 'Andrea Santos', 'status' => 'pending',
         'quote' => 'After I chose another freelancer, this user sent me several rude messages and demanded I cancel my project.', 'when' => 'Oct 02, 2026 · 8:40 AM'],
        ['id' => 'R-306', 'date' => 'Sep 30', 'reported' => 'Earn ₱5k Daily — Easy Typing Job', 'type' => 'Project', 'reason' => 'Fake or misleading posting',
         'reporter' => 'Kevin Tan', 'status' => 'pending',
         'quote' => 'The posting promises daily income for typing and asks for a registration fee.', 'when' => 'Sep 30, 2026 · 10:02 AM'],
        ['id' => 'R-301', 'date' => 'Sep 27', 'reported' => 'Review on Paolo Garcia', 'type' => 'Review', 'reason' => 'Fake review',
         'reporter' => 'Paolo Garcia', 'status' => 'resolved',
         'quote' => 'The review was removed after checking the contract history.', 'when' => 'Sep 27, 2026 · 1:20 PM'],
        ['id' => 'R-296', 'date' => 'Sep 25', 'reported' => 'Leo Santiago', 'type' => 'User', 'reason' => 'Spam proposals',
         'reporter' => 'Grace Aquino', 'status' => 'dismissed',
         'quote' => 'Several identical proposals were sent to unrelated projects.', 'when' => 'Sep 25, 2026 · 4:45 PM'],
    ];
    foreach ($rows as &$row) {
        $state = $_SESSION['demo_admin_report_actions'][$row['id']] ?? null;
        if ($state) { $row['status'] = $state['status']; }
    }
    unset($row);
    return $rows;
}

/** Record report review actions against live records or session-only demo fixtures. */
function tt_admin_review_report($report_id, $action)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'admin') { return 'Administrator access is required.'; }
    if (!in_array($action, ['dismiss', 'warn', 'remove', 'suspend'], true)) { return 'Choose a valid report action.'; }
    $status = $action === 'dismiss' ? 'dismissed' : 'resolved';

    if (tt_is_demo_admin($user)) {
        $report = null;
        foreach (toptunity_admin_reports() as $candidate) {
            if ($candidate['id'] === $report_id) { $report = $candidate; break; }
        }
        if (!$report || $report['status'] !== 'pending') { return 'That report is no longer pending.'; }
        if (in_array($action, ['warn', 'suspend'], true) && strcasecmp($report['type'], 'User') !== 0) {
            return 'Warnings and account suspensions are only available for user reports.';
        }
        if (in_array($action, ['warn', 'suspend'], true) && strcasecmp($report['type'], 'User') === 0) {
            $target_user = null;
            foreach (toptunity_admin_users() as $target) {
                if (strcasecmp($target['name'], $report['reported']) === 0) {
                    $target_user = $target;
                    break;
                }
            }
            if (!$target_user) { return 'The reported demo user could not be found.'; }
            if ($action === 'suspend') {
                $_SESSION['demo_admin_user_status'][(string) $target_user['id']] = 'Suspended';
            } else {
                $_SESSION['demo_admin_user_warnings'][(string) $target_user['id']][] = $report_id;
            }
        }
        $_SESSION['demo_admin_report_actions'][$report_id] = ['status' => $status, 'action' => $action];
        return null;
    }

    if (!preg_match('/^DB-(\d+)$/', (string) $report_id, $match)) { return 'That report could not be found.'; }
    $pdo = db();
    $stmt = $pdo->prepare('SELECT reported_user_id, status FROM reports WHERE id = ?');
    $stmt->execute([(int) $match[1]]);
    $report = $stmt->fetch();
    if (!$report || $report['status'] !== 'pending') { return 'That report is no longer pending.'; }
    if (in_array($action, ['warn', 'suspend'], true)) {
        if (strcasecmp($report['type'], 'user') !== 0) { return 'Warnings and account suspensions are only available for user reports.'; }
        if (!$report['reported_user_id']) { return 'This report is not linked to a user account.'; }
        if ($action === 'suspend') {
            $pdo->prepare("UPDATE users SET status = 'suspended' WHERE id = ? AND role IN ('client', 'freelancer')")
                ->execute([(int) $report['reported_user_id']]);
        } else {
            tt_notify((int) $report['reported_user_id'], 'reports', 'Account warning',
                      'An administrator reviewed a report about your account. Please review the platform rules.');
        }
    }
    $pdo->prepare('UPDATE reports SET status = ? WHERE id = ?')->execute([$status, (int) $match[1]]);
    return null;
}

/** Projects for moderation. status: open | ongoing | overdue | completed | past | closed | cancelled */
function toptunity_admin_projects()
{
    $rows = tt_is_demo_admin() ? [
        ['id' => 'P-1', 'title' => 'Point-of-Sale and Inventory Dashboard', 'client' => 'Andrea Santos', 'type' => 'hourly', 'amount' => 600,
         'deadline' => '2026-10-31', 'status' => 'ongoing', 'proposals' => 9, 'freelancer' => 'Janelle Cruz', 'billing' => 'Hourly ₱600/hr'],
        ['id' => 'P-2', 'title' => '30-Second Promo Video for Opening Week', 'client' => 'Andrea Santos', 'type' => 'fixed', 'amount' => 9000,
         'deadline' => '2026-09-25', 'status' => 'past', 'proposals' => 4, 'freelancer' => '', 'billing' => 'Fixed · ₱9,000'],
        ['id' => 'P-3', 'title' => 'Student Enrollment System for a Tutorial Center', 'client' => 'Ramon Villanueva', 'type' => 'hourly', 'amount' => 500,
         'deadline' => '2026-12-05', 'status' => 'open', 'proposals' => 8, 'freelancer' => '', 'billing' => 'Hourly ₱500/hr'],
        ['id' => 'P-4', 'title' => 'Tuition Payment Tracker', 'client' => 'Ramon Villanueva', 'type' => 'fixed', 'amount' => 22000,
         'deadline' => '2026-09-30', 'status' => 'overdue', 'proposals' => 5, 'freelancer' => 'Miguel Reyes', 'billing' => 'Fixed · ₱22,000'],
        ['id' => 'P-5', 'title' => 'Product Data Encoding for 1,200 Items', 'client' => 'Grace Aquino', 'type' => 'hourly', 'amount' => 200,
         'deadline' => '2026-10-30', 'status' => 'completed', 'proposals' => 14, 'freelancer' => 'Kevin Tan', 'billing' => 'Hourly ₱200/hr'],
        ['id' => 'P-6', 'title' => 'Barista Training Manual Layout', 'client' => 'Andrea Santos', 'type' => 'fixed', 'amount' => 4000,
         'deadline' => '2026-08-30', 'status' => 'cancelled', 'proposals' => 6, 'freelancer' => '', 'billing' => 'Fixed · ₱4,000'],
    ] : [];
    $client_name = db()->prepare('SELECT name FROM users WHERE id = ?');
    $demo_ids = tt_demo_ids();
    foreach (tt_load_saved_projects() as $p) {
        if (tt_is_demo_admin() && !in_array((int) $p['owner'], $demo_ids, true)) { continue; }
        if (!tt_is_demo_admin() && (in_array((int) $p['owner'], $demo_ids, true)
            || in_array((int) ($p['freelancer_id'] ?? 0), $demo_ids, true))) { continue; }
        $client_name->execute([(int) $p['owner']]);
        $display_status = $p['status'] === 'open' && $p['deadline'] < date('Y-m-d') ? 'past' : $p['status'];
        $rows[] = ['id' => 'DB-' . $p['id'], 'site_id' => (int) $p['id'], 'real' => true,
                   'title' => $p['title'], 'client' => $client_name->fetchColumn() ?: 'Client',
                   'type' => $p['type'], 'amount' => $p['type'] === 'hourly' ? $p['rate'] : $p['budget'],
                   'deadline' => $p['deadline'], 'status' => $display_status, 'proposals' => (int) $p['proposals'],
                   'contract_status' => $p['contract_status'], 'freelancer' => $p['freelancer'] ?: '', 'billing' => $p['type'] === 'hourly'
                       ? 'Hourly ₱' . number_format($p['rate']) . '/hr' : 'Fixed · ₱' . number_format($p['budget'])];
    }
    if (tt_is_demo_admin()) {
        foreach ($rows as $index => &$row) {
            if (!empty($row['real'])) { continue; }
            $state = $_SESSION['demo_admin_project_actions'][$row['id']] ?? null;
            if (!empty($state['removed'])) {
                unset($rows[$index]);
                continue;
            }
            if (!empty($state['status'])) { $row['status'] = $state['status']; }
            $row['contract_status'] = 'none';
        }
        unset($row);
        $rows = array_values($rows);
    }
    return $rows;
}

/** Apply a moderation action to an isolated demo project fixture. */
function tt_admin_moderate_demo_project($project_id, $action)
{
    if (!tt_is_demo_admin()) { return 'This action is only available to the demo administrator.'; }
    $project = null;
    foreach (toptunity_admin_projects() as $candidate) {
        if ($candidate['id'] === $project_id && empty($candidate['real'])) { $project = $candidate; break; }
    }
    if (!$project) { return 'This sample project could not be found.'; }
    $allowed = [
        'close' => ['from' => ['open', 'past', 'overdue'], 'to' => 'closed'],
        'suspend' => ['from' => ['open', 'past'], 'to' => 'suspended'],
        'reopen' => ['from' => ['closed', 'suspended'], 'to' => 'open'],
        'remove' => ['from' => ['open', 'past', 'closed', 'suspended', 'cancelled'], 'to' => null],
    ];
    if (!isset($allowed[$action]) || !in_array($project['status'], $allowed[$action]['from'], true)) {
        return 'This project is not eligible for that action.';
    }
    if ($action === 'reopen' && $project['deadline'] < date('Y-m-d')) {
        return 'A project with a past deadline cannot be reopened.';
    }
    if ($action === 'remove') {
        $_SESSION['demo_admin_project_actions'][$project_id] = ['removed' => true];
    } else {
        $_SESSION['demo_admin_project_actions'][$project_id] = ['status' => $allowed[$action]['to']];
    }
    return null;
}

/** Apply a moderation action to a real database project. */
function tt_admin_moderate_project($site_id, $action)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'admin') { return 'Administrator access is required.'; }
    $project = tt_db_project($site_id);
    if (!$project) { return 'This project could not be found.'; }
    if (tt_is_demo_admin($user) && !in_array((int) $project['client_id'], tt_demo_ids(), true)) {
        return 'The demo administrator can only moderate projects belonging to demo accounts.';
    }
    $pdo = db();

    if ($action === 'remove') {
        if (!in_array($project['status'], ['open', 'past', 'closed', 'suspended', 'cancelled'], true)
            || !in_array($project['contract_status'], ['none', 'declined'], true)) {
            return 'Active projects cannot be removed. Close or resolve the contract first.';
        }
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM payments WHERE project_id = ?');
        $stmt->execute([(int) $project['id']]);
        if ((int) $stmt->fetchColumn() > 0) { return 'Projects with payment history cannot be removed.'; }
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM disputes WHERE project_id = ?');
        $stmt->execute([(int) $project['id']]);
        if ((int) $stmt->fetchColumn() > 0) { return 'Projects with dispute history cannot be removed.'; }
        $stmt = $pdo->prepare("SELECT stored_name FROM attachments WHERE owner_type IN ('project','deliverable') AND owner_id = ?");
        $stmt->execute([(int) $site_id]);
        $files = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $pdo->beginTransaction();
        $pdo->prepare("DELETE FROM attachments WHERE owner_type IN ('project','deliverable') AND owner_id = ?")->execute([(int) $site_id]);
        $pdo->prepare('DELETE FROM work_logs WHERE project_id = ?')->execute([(int) $site_id]);
        $pdo->prepare('DELETE FROM project_submissions WHERE project_id = ?')->execute([(int) $site_id]);
        $pdo->prepare('DELETE FROM projects WHERE id = ?')->execute([(int) $project['id']]);
        $pdo->commit();
        $upload_dir = dirname(__DIR__) . '/storage/uploads/';
        foreach ($files as $file) {
            if (basename($file) === $file && is_file($upload_dir . $file) && !unlink($upload_dir . $file)) {
                error_log('TopTunity could not remove uploaded project file: ' . $file);
            }
        }
        tt_notify((int) $project['client_id'], 'project', 'Project removed',
                  'Your project "' . $project['title'] . '" was removed by an administrator.');
        return null;
    }

    $actions = [
        'close' => ['from' => ['open', 'past', 'overdue'], 'to' => 'closed'],
        'suspend' => ['from' => ['open', 'past'], 'to' => 'suspended'],
        'reopen' => ['from' => ['closed', 'suspended'], 'to' => 'open'],
    ];
    if (!isset($actions[$action])) { return 'Choose a valid moderation action.'; }
    if (!in_array($project['status'], $actions[$action]['from'], true) || $project['contract_status'] !== 'none') {
        return 'This project is not eligible for that moderation action.';
    }
    if ($action === 'reopen' && $project['deadline'] < date('Y-m-d')) {
        return 'A project with a past deadline cannot be reopened.';
    }
    $pdo->prepare('UPDATE projects SET status = ? WHERE id = ?')
        ->execute([$actions[$action]['to'], (int) $project['id']]);
    tt_notify((int) $project['client_id'], 'project', 'Project moderation update',
              'Your project "' . $project['title'] . '" was ' . $actions[$action]['to'] . ' by an administrator.');
    return null;
}

/** Resolve a dispute in the live database or record the decision in demo session state. */
function tt_admin_resolve_dispute($dispute_id, $decision, $to_freelancer, $to_client, $notes)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'admin') { return 'Administrator access is required.'; }
    if (!in_array($decision, ['release', 'refund', 'split'], true)) { return 'Choose a decision.'; }
    $notes = trim($notes);
    if (mb_strlen($notes) < 20 || mb_strlen($notes) > 2000) { return 'Write decision notes between 20 and 2,000 characters.'; }

    $dispute = null;
    foreach (toptunity_admin_disputes() as $candidate) {
        if ($candidate['id'] === $dispute_id && $candidate['status'] === 'open') { $dispute = $candidate; break; }
    }
    if (!$dispute) { return 'That open dispute could not be found.'; }
    if ($decision === 'split' && ((int) $to_freelancer + (int) $to_client) !== (int) $dispute['held']) {
        return 'The two amounts must add up to ₱' . number_format($dispute['held']) . '.';
    }

    if (tt_is_demo_admin($user)) {
        $_SESSION['demo_admin_dispute_decisions'][$dispute_id] = [
            'decision' => $decision, 'notes' => $notes, 'to_freelancer' => (int) $to_freelancer,
            'to_client' => (int) $to_client,
        ];
        return null;
    }

    if (!preg_match('/^DB-(\d+)$/', (string) $dispute_id, $match)) { return 'That dispute could not be found.'; }
    $result = $decision === 'split'
        ? 'split:' . (int) $to_freelancer . ':' . (int) $to_client
        : $decision;
    $stmt = db()->prepare("UPDATE disputes SET status = 'resolved', decision = ?, details = CONCAT(details, '\\n\\nAdmin decision: ', ?)
                           WHERE id = ? AND status = 'open'");
    $stmt->execute([$result, $notes, (int) $match[1]]);
    return $stmt->rowCount() ? null : 'That dispute was already resolved.';
}

/** Catalog snapshot used only by the demo administrator's session. */
function tt_demo_admin_catalog_state()
{
    if (!tt_is_demo_admin()) { return ['skills' => [], 'categories' => []]; }
    if (!isset($_SESSION['demo_admin_catalog'])) {
        $rows = db()->query('SELECT s.name AS skill, c.name AS category FROM skills s LEFT JOIN categories c ON c.id = s.category_id ORDER BY s.name')->fetchAll();
        $skills = [];
        foreach ($rows as $row) { $skills[$row['skill']] = $row['category'] ?: 'Other'; }
        $categories = db()->query('SELECT name FROM categories ORDER BY name')->fetchAll(PDO::FETCH_COLUMN);
        $_SESSION['demo_admin_catalog'] = ['skills' => $skills, 'categories' => $categories];
    }
    return $_SESSION['demo_admin_catalog'];
}

/** Add, rename, or remove an administrator-managed catalog item. */
function tt_admin_catalog_change($action, $kind, $name, $new_name = '')
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'admin') { return 'Administrator access is required.'; }
    if (!in_array($kind, ['skill', 'category'], true)) { return 'Choose a valid catalog type.'; }
    $name = trim($name);
    $new_name = trim($new_name);
    $limit = $kind === 'skill' ? 80 : 120;

    if ($action === 'add' || $action === 'rename') {
        $value = $action === 'add' ? $name : $new_name;
        if (mb_strlen($value) < 2 || mb_strlen($value) > $limit) {
            return 'Enter a name within the allowed length.';
        }
    }
    if (!in_array($action, ['add', 'rename', 'remove'], true)) { return 'Choose a valid catalog action.'; }

    if (tt_is_demo_admin($user)) {
        $state = tt_demo_admin_catalog_state();
        $items = $kind === 'skill' ? $state['skills'] : array_fill_keys($state['categories'], true);
        $exists = array_key_exists($name, $items);
        $matches = static function ($candidate, $items) {
            foreach ($items as $item => $_) {
                if (strcasecmp($item, $candidate) === 0) { return true; }
            }
            return false;
        };
        if ($action === 'add') {
            if ($matches($name, $items)) { return 'That name already exists.'; }
            if ($kind === 'skill') { $state['skills'][$name] = 'Other'; }
            else { $state['categories'][] = $name; }
        } elseif (!$exists) {
            return 'That catalog item could not be found.';
        } elseif ($action === 'rename') {
            if ($name !== $new_name && $matches($new_name, $items)) { return 'That name already exists.'; }
            if ($kind === 'skill') {
                $state['skills'][$new_name] = $state['skills'][$name];
                unset($state['skills'][$name]);
            } else {
                $state['categories'] = array_map(static function ($category) use ($name, $new_name) {
                    return $category === $name ? $new_name : $category;
                }, $state['categories']);
                foreach ($state['skills'] as &$category) {
                    if ($category === $name) { $category = $new_name; }
                }
                unset($category);
            }
        } else {
            if ($kind === 'skill') { unset($state['skills'][$name]); }
            else {
                $state['categories'] = array_values(array_filter($state['categories'], static function ($category) use ($name) {
                    return $category !== $name;
                }));
                foreach ($state['skills'] as &$category) {
                    if ($category === $name) { $category = 'Other'; }
                }
                unset($category);
            }
        }
        $_SESSION['demo_admin_catalog'] = $state;
        return null;
    }

    $table = $kind === 'skill' ? 'skills' : 'categories';
    if ($action === 'add') {
        try {
            db()->prepare("INSERT INTO $table (name) VALUES (?)")->execute([$name]);
        } catch (PDOException $e) {
            if ((int) $e->getCode() === 23000) { return 'That name already exists.'; }
            throw $e;
        }
        return null;
    }
    if ($action === 'rename') {
        try {
            $stmt = db()->prepare("UPDATE $table SET name = ? WHERE name = ?");
            $stmt->execute([$new_name, $name]);
        } catch (PDOException $e) {
            if ((int) $e->getCode() === 23000) { return 'That name already exists.'; }
            throw $e;
        }
        if ($stmt->rowCount()) { return null; }
        $exists = db()->prepare("SELECT 1 FROM $table WHERE name = ?");
        $exists->execute([$name]);
        return $exists->fetchColumn() ? null : 'That catalog item could not be found.';
    }
    $stmt = db()->prepare("DELETE FROM $table WHERE name = ?");
    $stmt->execute([$name]);
    return $stmt->rowCount() ? null : 'That catalog item could not be found.';
}

/** Disputes. status: open | resolved. */
function toptunity_admin_disputes()
{
    if (!tt_is_demo_admin()) {
        $demo_ids = tt_demo_ids();
        $sql = "SELECT d.id, d.filed_by, d.reason, d.details, d.status, d.created_at,
                       p.title, p.deadline, p.billing_type, p.hourly_rate, p.max_hours, p.budget,
                       p.agreed_amount, p.start_date, p.client_id, p.freelancer_id,
                       client.name AS client, freelancer.name AS freelancer,
                       (SELECT COALESCE(SUM(pay.amount), 0) FROM payments pay
                        WHERE pay.project_id = p.id AND pay.status = 'held') AS held,
                       (SELECT COALESCE(SUM(pay.service_fee), 0) FROM payments pay
                        WHERE pay.project_id = p.id AND pay.status = 'held') AS fee
                FROM disputes d
                JOIN projects p ON p.id = d.project_id
                JOIN users client ON client.id = p.client_id
                LEFT JOIN users freelancer ON freelancer.id = p.freelancer_id
                JOIN users filer ON filer.id = d.filed_by";
        if ($demo_ids) {
            $ids = implode(',', array_map('intval', $demo_ids));
            $sql .= " WHERE d.filed_by NOT IN ($ids) AND p.client_id NOT IN ($ids)
                      AND (p.freelancer_id IS NULL OR p.freelancer_id NOT IN ($ids))";
        }
        $rows = [];
        foreach (db()->query($sql . ' ORDER BY d.id DESC')->fetchAll() as $dispute) {
            $billing = $dispute['billing_type'] === 'hourly'
                ? 'Hourly · ₱' . number_format((int) $dispute['hourly_rate']) . '/hr · max ' . (int) $dispute['max_hours'] . ' h'
                : 'Fixed · ₱' . number_format((int) ($dispute['agreed_amount'] ?: $dispute['budget']));
            $rows[] = [
                'id' => 'DB-' . (int) $dispute['id'],
                'date' => tt_date_label($dispute['created_at']),
                'project' => $dispute['title'],
                'billing' => $dispute['billing_type'] === 'hourly' ? 'Hourly' : 'Fixed Price',
                'filed_by' => (int) $dispute['filed_by'] === (int) $dispute['client_id'] ? 'Client' : 'Freelancer',
                'reason' => $dispute['reason'],
                'status' => $dispute['status'],
                'held' => (int) $dispute['held'],
                'fee' => (int) $dispute['fee'],
                'deadline' => $dispute['deadline'],
                'client' => $dispute['client'],
                'freelancer' => $dispute['freelancer'] ?: 'Unassigned',
                'contract' => $billing,
                'dates' => ($dispute['start_date'] ?: 'Not started') . ' – ' . $dispute['deadline'],
                'history' => [tt_date_label($dispute['created_at']) . ' · Dispute filed: ' . $dispute['details']],
                'files' => [],
                'chat' => [],
                'real' => true,
            ];
        }
        return $rows;
    }
    $rows = [
        ['id' => 'D-1041', 'date' => 'Oct 03, 2026', 'project' => 'Clinic Inventory Dashboard v2', 'billing' => 'Hourly', 'filed_by' => 'Freelancer',
         'reason' => 'Hours rejected unfairly', 'status' => 'open', 'held' => 32500, 'fee' => 3250, 'deadline' => 'Oct 28, 2026',
         'client' => 'Grace Aquino', 'freelancer' => 'Miguel Reyes', 'contract' => 'Hourly · ₱650/hr · max 50 h', 'dates' => 'Sep 21 – Oct 28',
         'history' => ['Sep 21 · Project started (payment held)', 'Oct 01 · Hours logged 4.0', 'Oct 02 · Hours partly rejected', 'Oct 03 · Dispute filed'],
         'files' => [['name' => 'clinic-inventory-v2.3.zip', 'size' => '5.1 MB']],
         'chat' => [['from' => 'Grace', 'text' => 'Please reject the printer driver hours; that was outside scope.'], ['from' => 'Miguel', 'text' => 'The driver issue blocked the report export, so I logged it.']]],
        ['id' => 'D-1038', 'date' => 'Oct 02, 2026', 'project' => 'Menu Board and Cup Sleeve Design', 'billing' => 'Fixed Price', 'filed_by' => 'Client',
         'reason' => 'Work not delivered', 'status' => 'open', 'held' => 6500, 'fee' => 650, 'deadline' => 'Oct 01, 2026',
         'client' => 'Andrea Santos', 'freelancer' => 'Paolo Garcia', 'contract' => 'Fixed · ₱6,500', 'dates' => 'Sep 10 – Oct 01',
         'history' => ['Sep 10 · Project started (payment held)', 'Sep 24 · Draft submitted', 'Sep 26 · Revision requested', 'Oct 01 · Marked overdue', 'Oct 02 · Dispute filed'],
         'files' => [['name' => 'menu-board-draft.pdf', 'size' => '1.2 MB'], ['name' => 'cup-sleeve-v1.ai', 'size' => '3.4 MB']],
         'chat' => [['from' => 'Andrea', 'text' => 'The final files were due Oct 1. Any update?'], ['from' => 'Paolo', 'text' => 'Sorry for the delay, sending the files tonight.'], ['from' => 'Andrea', 'text' => 'Still nothing received as of Oct 2, 6 PM.']]],
        ['id' => 'D-1029', 'date' => 'Sep 21, 2026', 'project' => 'Hotel Room Reservation Module', 'billing' => 'Fixed Price', 'filed_by' => 'Client',
         'reason' => 'Work does not match requirements', 'status' => 'resolved', 'held' => 28000, 'fee' => 2800, 'deadline' => 'Sep 30, 2026',
         'client' => 'Mark Francisco', 'freelancer' => 'Miguel Reyes', 'contract' => 'Fixed · ₱28,000', 'dates' => 'Aug 25 – Sep 30',
         'history' => ['Aug 25 · Project started', 'Sep 21 · Dispute filed', 'Sep 22 · Resolved: split 50/50'],
         'files' => [], 'chat' => [['from' => 'Mark', 'text' => 'The booking calendar does not match the agreed spec.']]],
    ];
    foreach ($rows as &$row) {
        $decision = $_SESSION['demo_admin_dispute_decisions'][$row['id']] ?? null;
        if ($decision) {
            $row['status'] = 'resolved';
            $split = $decision['decision'] === 'split'
                ? ' · ₱' . number_format($decision['to_freelancer']) . ' to freelancer / ₱' . number_format($decision['to_client']) . ' to client'
                : '';
            $row['history'][] = 'Resolved: ' . $decision['decision'] . $split . ' · ' . $decision['notes'];
        }
    }
    unset($row);
    return $rows;
}



/** Platform reviews. status: new | published | hidden */
function toptunity_admin_reviews()
{
    if (!tt_is_demo_admin()) {
        $demo_ids = tt_demo_ids();
        $sql = 'SELECT pr.id, pr.rating, pr.body, pr.status, pr.created_at, u.name, u.role
                FROM platform_reviews pr JOIN users u ON u.id = pr.user_id';
        if ($demo_ids) {
            $sql .= ' WHERE pr.user_id NOT IN (' . implode(',', array_map('intval', $demo_ids)) . ')';
        }
        $rows = [];
        foreach (db()->query($sql . ' ORDER BY pr.id DESC')->fetchAll() as $review) {
            $rows[] = ['id' => 'DB-' . (int) $review['id'], 'date' => tt_date_label($review['created_at']),
                       'user' => $review['name'], 'role' => ucfirst($review['role']),
                       'rating' => (int) $review['rating'], 'status' => $review['status'],
                       'text' => $review['body'], 'real' => true];
        }
        return $rows;
    }
    $rows = [
        ['id' => 'V-1', 'date' => 'Oct 03, 2026', 'user' => 'Kevin Tan', 'role' => 'Freelancer', 'rating' => 4, 'status' => 'new',
         'text' => 'Great for small, steady projects. Hours are logged per day, and I can see which ones the client already approved.'],
        ['id' => 'V-2', 'date' => 'Sep 28, 2026', 'user' => 'Andrea Santos', 'role' => 'Client', 'rating' => 5, 'status' => 'published',
         'text' => 'The proposal process is clear and the 10% fee is shown upfront. Withdrawing to GCash is simple.'],
        ['id' => 'V-3', 'date' => 'Sep 25, 2026', 'user' => 'Rhea Mendoza', 'role' => 'Freelancer', 'rating' => 5, 'status' => 'published',
         'text' => 'Recommended Projects shows me jobs that actually match my skills. Most of my repeat clients found me here.'],
        ['id' => 'V-4', 'date' => 'Sep 19, 2026', 'user' => 'Leo Santiago', 'role' => 'Freelancer', 'rating' => 1, 'status' => 'hidden',
         'text' => 'The site was slow and I could not submit my proposal on time.'],
    ];
    foreach ($rows as &$row) {
        if (isset($_SESSION['demo_admin_review_status'][$row['id']])) {
            $row['status'] = $_SESSION['demo_admin_review_status'][$row['id']];
        }
    }
    unset($row);
    return $rows;
}

/** Publish or hide a platform review. */
function tt_admin_set_review_status($review_id, $action)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'admin') { return 'Administrator access is required.'; }
    $status = ['publish' => 'published', 'hide' => 'hidden'][$action] ?? null;
    if (!$status) { return 'Choose a valid review action.'; }
    $review = null;
    foreach (toptunity_admin_reviews() as $candidate) {
        if ($candidate['id'] === $review_id) { $review = $candidate; break; }
    }
    if (!$review) { return 'That review could not be found.'; }

    if (tt_is_demo_admin($user)) {
        $_SESSION['demo_admin_review_status'][$review_id] = $status;
        return null;
    }
    if (!preg_match('/^DB-(\d+)$/', (string) $review_id, $match)) { return 'That review could not be found.'; }
    $stmt = db()->prepare('UPDATE platform_reviews SET status = ? WHERE id = ?');
    $stmt->execute([$status, (int) $match[1]]);
    if ($stmt->rowCount()) { return null; }
    $check = db()->prepare('SELECT status FROM platform_reviews WHERE id = ?');
    $check->execute([(int) $match[1]]);
    return $check->fetchColumn() === $status ? null : 'That review could not be updated.';
}

/** Contact messages. status: new | responded */
function toptunity_admin_inquiries()
{
    $rows = tt_is_demo_admin() ? [
        ['id' => 'I-1', 'date' => 'Oct 04, 2026', 'name' => 'Joy Bautista', 'email' => 'joy.bautista@gmail.com', 'subject' => 'Question about payments and refunds', 'status' => 'new',
         'message' => 'Hi! If I cancel my project before a freelancer accepts the contract, will my deposit be refunded automatically? Thank you.'],
        ['id' => 'I-2', 'date' => 'Oct 01, 2026', 'name' => 'Carmela Reyes', 'email' => 'carmela@school.edu.ph', 'subject' => 'Partnership with our school', 'status' => 'responded',
         'message' => 'We would like to talk about a partnership for our students\' internship projects.'],
        ['id' => 'I-3', 'date' => 'Sep 29, 2026', 'name' => 'Arnel Dizon', 'email' => 'arnel.dizon@gmail.com', 'subject' => 'Cannot reset my password', 'status' => 'new',
         'message' => 'The reset link does not arrive in my email. Please help.'],
    ] : [];
    $real = tt_is_demo_admin()
        ? []
        : db()->query('SELECT id, name, email, subject, message, reply, status, created_at
                       FROM contact_inquiries ORDER BY id DESC')->fetchAll();
    foreach ($real as $inquiry) {
        $rows[] = ['id' => 'R-' . (int) $inquiry['id'], 'date' => tt_date_label($inquiry['created_at']),
                   'name' => $inquiry['name'], 'email' => $inquiry['email'], 'subject' => $inquiry['subject'],
                   'message' => $inquiry['message'], 'reply' => $inquiry['reply'], 'status' => $inquiry['status'],
                   'real' => true];
    }
    if (tt_is_demo_admin()) {
        foreach ($rows as &$row) {
            $reply = $_SESSION['demo_admin_inquiry_replies'][$row['id']] ?? null;
            if ($reply !== null) { $row['reply'] = $reply; $row['status'] = 'responded'; }
        }
        unset($row);
    }
    return $rows;
}

/** Save a public contact inquiry. Returns null on success or an error message. */
function tt_save_contact_inquiry($name, $email, $subject, $message)
{
    $name = trim($name);
    $email = trim($email);
    $message = trim($message);
    if (mb_strlen($name) < 2 || mb_strlen($name) > 120) { return 'Enter a name between 2 and 120 characters.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 190) { return 'Enter a valid email address.'; }
    if (mb_strlen($subject) > 160 || trim($subject) === '') { return 'Choose a subject.'; }
    if (mb_strlen($message) < 10 || mb_strlen($message) > 3000) { return 'Your message must be between 10 and 3,000 characters.'; }
    db()->prepare('INSERT INTO contact_inquiries (name, email, subject, message) VALUES (?, ?, ?, ?)')
        ->execute([$name, $email, trim($subject), $message]);
    return null;
}

/** Save an administrator's response to a real contact inquiry. */
function tt_reply_contact_inquiry($id, $reply)
{
    if (tt_is_demo_admin()) { return 'The demo administrator can only reply to sample inquiries.'; }
    $reply = trim($reply);
    if (mb_strlen($reply) < 10 || mb_strlen($reply) > 3000) { return 'Write a reply between 10 and 3,000 characters.'; }
    $stmt = db()->prepare("UPDATE contact_inquiries SET reply = ?, status = 'responded', responded_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$reply, (int) $id]);
    $check = db()->prepare('SELECT 1 FROM contact_inquiries WHERE id = ?');
    $check->execute([(int) $id]);
    return $check->fetchColumn() ? null : 'This inquiry could not be updated.';
}

/** Admin notifications. cat is used by the filter tabs. */
function toptunity_admin_notifications_base()
{
    if (!tt_is_demo_admin()) { return []; }
    return [
        ['cat' => 'past', 'icon' => 'calendar', 'tint' => 'orange', 'new' => true, 'title' => 'Projects Past Deadline',
         'text' => '30-Second Promo Video for Opening Week reached its deadline with no freelancer selected.', 'time' => '1h ago'],
        ['cat' => 'reports', 'icon' => 'flag', 'tint' => 'orange', 'new' => true, 'title' => 'New Reports',
         'text' => 'Miguel Reyes reported Rico Manalastas for an off-platform payment request.', 'time' => '3h ago'],
        ['cat' => 'disputes', 'icon' => 'alert', 'tint' => 'orange', 'new' => true, 'title' => 'Disputes',
         'text' => 'Andrea Santos filed a dispute on Menu Board and Cup Sleeve Design.', 'time' => 'Yesterday'],
        ['cat' => 'withdrawals', 'icon' => 'wallet', 'tint' => 'teal', 'new' => false, 'title' => 'Withdrawal Requests',
         'text' => 'Miguel Reyes requested a ₱5,000 withdrawal to GCash.', 'time' => 'Yesterday'],
        ['cat' => 'inquiries', 'icon' => 'message', 'tint' => 'blue', 'new' => false, 'title' => 'Inquiries',
         'text' => 'New inquiry from Joy Bautista: Question about payments and refunds.', 'time' => 'Oct 04'],
        ['cat' => 'reviews', 'icon' => 'star', 'tint' => 'orange', 'new' => false, 'title' => 'New Platform Reviews',
         'text' => 'Kevin Tan submitted a 4-star platform review.', 'time' => 'Oct 03'],
    ];
}

/** The service fee (percent), saved in storage/settings.json. Default 10. */
function tt_settings_file() { return dirname(__DIR__) . '/storage/settings.json'; }

function tt_service_fee()
{
    if (tt_is_demo_admin()) {
        return isset($_SESSION['demo_admin_service_fee']) ? (int) $_SESSION['demo_admin_service_fee'] : 10;
    }
    $f = tt_settings_file();
    $d = file_exists($f) ? json_decode((string) file_get_contents($f), true) : null;
    return isset($d['service_fee']) ? (int) $d['service_fee'] : 10;
}

function tt_save_service_fee($pct)
{
    if (tt_is_demo_admin()) {
        $_SESSION['demo_admin_service_fee'] = (int) $pct;
        return;
    }
    if (!is_dir(dirname(tt_settings_file()))) { mkdir(dirname(tt_settings_file()), 0775, true); }
    file_put_contents(tt_settings_file(), json_encode(['service_fee' => (int) $pct, 'since' => date('Y-m-d')]), LOCK_EX);
}


/* ==========================================================================
   POSTED PROJECTS (MySQL "projects" table). Ids shown in the site are the
   database id + 1000, so they never clash with the sample project ids.
   ========================================================================== */

/** Converts a database row (plus its skill names) to the shape the pages use. */
function tt_project_from_row($r, $skills)
{
    $is_hourly = $r['billing_type'] === 'hourly';
    return [
        'id'        => 1000 + (int) $r['id'],
        'owner'     => (int) $r['client_id'],
        'title'     => $r['title'],
        'category'  => $r['category'] ?: 'Web Development',
        'type'      => $r['billing_type'],
        'budget'    => (int) $r['budget'],
        'rate'      => (int) $r['hourly_rate'],
        'max_hours' => (int) $r['max_hours'],
        'deadline'  => $r['deadline'],
        'status'    => $r['status'],
        'posted'    => substr($r['created_at'], 0, 10),
        'proposals' => (int) $r['proposals'],
        'freelancer'=> $r['freelancer_name'] ?? null,
        'freelancer_id' => isset($r['freelancer_id']) ? (int) $r['freelancer_id'] : null,
        'contract_status' => $r['contract_status'] ?? 'none',
        'agreed_amount' => (int) ($r['agreed_amount'] ?? 0),
        'start_date' => $r['start_date'] ?? null,
        'intro'     => $r['description'],
        'skills'    => $skills,
        'files'     => [],
    ];
}

/** Every posted project, keyed by the site id. */
function tt_load_saved_projects()
{
    $sql = 'SELECT p.id, p.client_id, p.title, p.description, p.billing_type, p.budget, p.hourly_rate, p.max_hours,
                   p.deadline, p.status, p.created_at, p.freelancer_id, p.contract_status, p.agreed_amount, p.start_date,
                   c.name AS category, f.name AS freelancer_name,
                   (SELECT COUNT(*) FROM proposals pr WHERE pr.project_id = p.id) AS proposals
            FROM projects p
            LEFT JOIN categories c ON c.id = p.category_id
            LEFT JOIN users f ON f.id = p.freelancer_id
            ORDER BY p.id';
    $out = [];
    $skill_stmt = db()->prepare('SELECT s.name FROM project_skills ps JOIN skills s ON s.id = ps.skill_id WHERE ps.project_id = ? ORDER BY s.name');
    foreach (db()->query($sql)->fetchAll() as $r) {
        $skill_stmt->execute([$r['id']]);
        $skills = array_column($skill_stmt->fetchAll(), 'name');
        $project = tt_project_from_row($r, $skills);
        $project['files'] = tt_project_files_map()[$project['id']] ?? [];
        $out[$project['id']] = $project;
    }
    return $out;
}

/** The signed-in client's own projects, keyed by the site id. */
function tt_saved_projects_for_current_user()
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'client') { return []; }
    return array_filter(tt_load_saved_projects(), function ($p) use ($user) {
        return $p['owner'] === (int) $user['id'];
    });
}

/** Writes a project's category and skills, returns nothing. */
function tt_write_project_details($project_id, $fields)
{
    $pdo = db();
    $cat_name = trim($fields['category']);
    $cat = $pdo->prepare('SELECT id FROM categories WHERE name = ?');
    $cat->execute([$cat_name]);
    $category_id = (int) $cat->fetchColumn();
    if (!$category_id) { throw new RuntimeException('The selected category is no longer active. Choose an available category and try again.'); }
    $pdo->prepare('UPDATE projects SET category_id = ? WHERE id = ?')->execute([$category_id, $project_id]);

    $pdo->prepare('DELETE FROM project_skills WHERE project_id = ?')->execute([$project_id]);
    $skill_lookup = $pdo->prepare('SELECT id FROM skills WHERE name = ?');
    foreach ($fields['skills'] as $skill) {
        $skill = trim($skill);
        if ($skill === '') { continue; }
        $skill_lookup->execute([$skill]);
        $skill_id = (int) $skill_lookup->fetchColumn();
        if (!$skill_id) { throw new RuntimeException('One of the selected skills is no longer active. Review the required skills and try again.'); }
        $pdo->prepare('INSERT IGNORE INTO project_skills (project_id, skill_id) VALUES (?, ?)')->execute([$project_id, $skill_id]);
    }
}

/** Saves a new project for the signed-in client. Returns the site id. */
function tt_add_saved_project($fields)
{
    $user = tt_current_user();
    $pdo  = db();
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('INSERT INTO projects (client_id, title, description, billing_type, budget, hourly_rate, max_hours, deadline, status)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([(int) $user['id'], $fields['title'], $fields['intro'], $fields['type'], (int) $fields['budget'],
                    (int) $fields['rate'], (int) $fields['max_hours'], $fields['deadline'], 'open']);
    $id = (int) $pdo->lastInsertId();
    tt_write_project_details($id, $fields);
    $pdo->commit();
    tt_audit('post project', (string) ($fields['title'] ?? ''));
    return 1000 + $id;
}

/** Updates one of the signed-in client's own projects. Returns false if it isn't theirs. */
function tt_update_saved_project($site_id, $fields)
{
    $user = tt_current_user();
    $id   = (int) $site_id - 1000;
    $pdo  = db();
    $own  = $pdo->prepare('SELECT id FROM projects WHERE id = ? AND client_id = ?');
    $own->execute([$id, (int) $user['id']]);
    if (!$own->fetch()) { return false; }
    $pdo->beginTransaction();
    $pdo->prepare('UPDATE projects SET title = ?, description = ?, billing_type = ?, budget = ?, hourly_rate = ?,
                   max_hours = ?, deadline = ? WHERE id = ?')
        ->execute([$fields['title'], $fields['intro'], $fields['type'], (int) $fields['budget'], (int) $fields['rate'],
                   (int) $fields['max_hours'], $fields['deadline'], $id]);
    tt_write_project_details($id, $fields);
    $pdo->commit();
    return true;
}


/* ==========================================================================
   PROPOSALS AND CONTRACTS (database)
   Site project id = database id + 1000.
   ========================================================================== */

/** Saves a notification for a user. */
function tt_notify($user_id, $category, $title, $body)
{
    db()->prepare('INSERT INTO notifications (user_id, category, title, body) VALUES (?, ?, ?, ?)')
        ->execute([(int) $user_id, $category, $title, mb_substr($body, 0, 400)]);
}

/** Loads a posted project row by site id, or null. */
function tt_db_project($site_id)
{
    $stmt = db()->prepare('SELECT * FROM projects WHERE id = ?');
    $stmt->execute([(int) $site_id - 1000]);
    $r = $stmt->fetch();
    return $r ?: null;
}

/** Work logs for a project, newest first. */
function tt_project_work_logs($site_id)
{
    $stmt = db()->prepare('SELECT id, work_date AS date, hours, task, status, review_note AS note
                           FROM work_logs WHERE project_id = ? ORDER BY work_date DESC, id DESC');
    $stmt->execute([(int) $site_id]);
    return array_map(function ($row) {
        $row['hours'] = (float) $row['hours'];
        return $row;
    }, $stmt->fetchAll());
}

/** Save a freelancer work log after checking project assignment and contract status. */
function tt_db_log_hours($site_id, $work_date, $hours, $task)
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    $past_deadline = $project && $project['deadline'] < date('Y-m-d');
    if (!$user || $user['role'] !== 'freelancer' || !$project
        || (int) $project['freelancer_id'] !== (int) $user['id']
        || $project['billing_type'] !== 'hourly' || $project['contract_status'] !== 'active'
        || !in_array($project['status'], ['ongoing', 'overdue'], true)
        || (($project['status'] === 'overdue' || $past_deadline) && empty($project['late_work_allowed']))) {
        return 'This hourly project is not available for logging.';
    }
    $latest_work_date = !empty($project['late_work_allowed']) ? date('Y-m-d') : (string) $project['deadline'];
    if ($work_date < (string) $project['start_date'] || $work_date > $latest_work_date) {
        return 'Hours can only be logged between the project start date and the allowed work date.';
    }
    $stmt = db()->prepare("SELECT COALESCE(SUM(hours), 0) FROM work_logs WHERE project_id = ? AND status <> 'rejected'");
    $stmt->execute([(int) $site_id]);
    if ((float) $stmt->fetchColumn() + (float) $hours > (int) $project['max_hours']) {
        return 'Logging these hours would exceed the project maximum.';
    }
    db()->prepare('INSERT INTO work_logs (project_id, freelancer_id, work_date, hours, task) VALUES (?, ?, ?, ?, ?)')
        ->execute([(int) $site_id, (int) $user['id'], $work_date, (float) $hours, $task]);
    tt_notify((int) $project['client_id'], 'worklog', 'Hours submitted', $user['name'] . ' logged ' . number_format((float) $hours, 1) . ' hours for ' . $project['title'] . '.');
    return null;
}

/** Client approves or rejects a pending work log on their project. */
function tt_db_review_work_log($site_id, $log_id, $decision, $note = '')
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    if (!$user || $user['role'] !== 'client' || !$project || (int) $project['client_id'] !== (int) $user['id']) {
        return 'This project is not yours.';
    }
    if (!in_array($decision, ['approved', 'rejected'], true)) { return 'Choose a valid review action.'; }
    if ($decision === 'rejected' && mb_strlen(trim($note)) < 10) { return 'Give a reason for rejecting (at least 10 characters).'; }
    $stmt = db()->prepare("UPDATE work_logs SET status = ?, review_note = ?
                           WHERE id = ? AND project_id = ? AND status = 'pending'");
    $stmt->execute([$decision, $decision === 'rejected' ? trim($note) : null, (int) $log_id, (int) $site_id]);
    if (!$stmt->rowCount()) { return 'That pending work log was not found.'; }
    tt_notify((int) $project['freelancer_id'], 'worklog', $decision === 'approved' ? 'Hours approved' : 'Hours rejected',
              $user['name'] . ' ' . $decision . ' a work log for ' . $project['title'] . '.');
    return null;
}

/** Most recent submitted work for a project. */
function tt_project_submission($site_id)
{
    $stmt = db()->prepare('SELECT id, message, status, review_note, created_at FROM project_submissions WHERE project_id = ? ORDER BY id DESC LIMIT 1');
    $stmt->execute([(int) $site_id]);
    return $stmt->fetch() ?: null;
}

/** Save a freelancer's delivery message. */
function tt_db_submit_work($site_id, $message)
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    $message = trim($message);
    $past_deadline = $project && $project['deadline'] < date('Y-m-d');
    if (!$user || $user['role'] !== 'freelancer' || !$project
        || (int) $project['freelancer_id'] !== (int) $user['id']
        || $project['contract_status'] !== 'active'
        || !in_array($project['status'], ['ongoing', 'overdue'], true)
        || (($project['status'] === 'overdue' || $past_deadline) && empty($project['late_work_allowed']))) {
        return 'This project is not available for work submission.';
    }
    if (mb_strlen($message) > 2000) { return 'The delivery message can be at most 2,000 characters.'; }
    $latest = tt_project_submission($site_id);
    if ($latest && $latest['status'] === 'pending') { return 'Your latest submission is still waiting for client review.'; }
    db()->prepare('INSERT INTO project_submissions (project_id, freelancer_id, message) VALUES (?, ?, ?)')
        ->execute([(int) $site_id, (int) $user['id'], $message]);
    tt_notify((int) $project['client_id'], 'work', 'Work submitted', $user['name'] . ' submitted work for ' . $project['title'] . '.');
    tt_audit('submit work', 'project #' . $site_id);
    return null;
}

/** Client approves a delivery or requests a revision. */
function tt_db_review_submission($site_id, $decision, $note = '')
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    if (!$user || $user['role'] !== 'client' || !$project || (int) $project['client_id'] !== (int) $user['id']) {
        return 'This project is not yours.';
    }
    if (!in_array($decision, ['approved', 'revision'], true)) { return 'Choose a valid review action.'; }
    if ($decision === 'revision' && mb_strlen(trim($note)) < 10) { return 'Give revision instructions (at least 10 characters).'; }
    $submission = tt_project_submission($site_id);
    if (!$submission || $submission['status'] !== 'pending') { return 'There is no pending work submission to review.'; }
    if ($decision === 'approved' && $project['billing_type'] === 'fixed') {
        $error = tt_db_release($site_id);
        if ($error) { return $error; }
    }
    $stmt = db()->prepare("UPDATE project_submissions SET status = ?, review_note = ? WHERE id = ? AND status = 'pending'");
    $stmt->execute([$decision, $decision === 'revision' ? trim($note) : null, (int) $submission['id']]);
    if ($stmt->rowCount()) {
        tt_notify((int) $project['freelancer_id'], 'revisions', $decision === 'approved' ? 'Work approved' : 'Revision requested',
                  $decision === 'approved' ? $user['name'] . ' approved your work for ' . $project['title'] . '.'
                                           : $user['name'] . ' requested a revision for ' . $project['title'] . ': ' . trim($note));
    }
    return null;
}

/** Extend the deadline for a client's active project. */
function tt_db_extend_deadline($site_id, $deadline)
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    $date = DateTime::createFromFormat('Y-m-d', $deadline);
    if (!$user || $user['role'] !== 'client' || !$project || (int) $project['client_id'] !== (int) $user['id']) {
        return 'This project is not yours.';
    }
    if ($project['contract_status'] !== 'active' || !in_array($project['status'], ['ongoing', 'overdue'], true)) {
        return 'Only active projects can have their deadline extended.';
    }
    if (!$date || $date->format('Y-m-d') !== $deadline || $deadline <= $project['deadline']) {
        return 'Choose a valid date later than the current deadline.';
    }
    db()->prepare('UPDATE projects SET deadline = ?, status = ? WHERE id = ?')
        ->execute([$deadline, $deadline < date('Y-m-d') ? 'overdue' : 'ongoing', (int) $project['id']]);
    return null;
}

/** Allow a freelancer to submit after the deadline without changing the date. */
function tt_db_allow_late_work($site_id)
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    if (!$user || $user['role'] !== 'client' || !$project || (int) $project['client_id'] !== (int) $user['id']) {
        return 'This project is not yours.';
    }
    if (($project['status'] !== 'overdue' && $project['deadline'] >= date('Y-m-d'))
        || $project['contract_status'] !== 'active') {
        return 'Late work can only be accepted for an overdue active project.';
    }
    db()->prepare("UPDATE projects SET late_work_allowed = 1, status = 'overdue' WHERE id = ?")->execute([(int) $project['id']]);
    return null;
}

/** Proposals for one posted project. */
function tt_db_proposals($site_id)
{
    $stmt = db()->prepare('SELECT pr.id, pr.freelancer_id, pr.offer, pr.days, pr.cover_letter, pr.status, pr.created_at,
                                  u.name AS freelancer_name
                           FROM proposals pr JOIN users u ON u.id = pr.freelancer_id
                           WHERE pr.project_id = ? ORDER BY pr.id');
    $stmt->execute([(int) $site_id - 1000]);
    return $stmt->fetchAll();
}

/** Freelancer sends a proposal. Returns null on success or an error message. */
function tt_db_submit_proposal($site_id, $offer, $days, $letter)
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    if (!$project)                              { return 'This project is not available.'; }
    if ($project['status'] !== 'open')          { return 'This project is no longer accepting proposals.'; }
    if ($project['deadline'] < date('Y-m-d'))   { return 'The deadline for this project has passed.'; }
    try {
        db()->prepare('INSERT INTO proposals (project_id, freelancer_id, offer, days, cover_letter) VALUES (?, ?, ?, ?, ?)')
            ->execute([(int) $project['id'], (int) $user['id'], (int) $offer, (int) $days, $letter]);
    } catch (PDOException $e) {
        if ((int) $e->getCode() === 23000) { return 'You already sent a proposal for this project.'; }
        throw $e;
    }
    tt_notify($project['client_id'], 'proposals', 'New proposal',
              $user['name'] . ' sent a proposal for ' . $project['title'] . '.');
    tt_audit('submit proposal', 'project #' . $site_id . ' ₱' . number_format((int) $offer));
    return null;
}

/** Client selects one freelancer. Others are marked not selected. Returns null or an error. */
function tt_db_select_freelancer($site_id, $proposal_id)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'client') { return 'Only clients can select a freelancer.'; }
    $project = tt_db_project($site_id);
    if (!$project || (int) $project['client_id'] !== (int) ($user['id'] ?? 0)) { return 'This project is not yours.'; }
    if ($project['status'] !== 'open') { return 'This project is no longer accepting contracts.'; }
    if ($project['contract_status'] !== 'none') { return 'A contract is already in progress for this project.'; }
    $stmt = db()->prepare('SELECT * FROM proposals WHERE id = ? AND project_id = ?');
    $stmt->execute([(int) $proposal_id, (int) $project['id']]);
    $prop = $stmt->fetch();
    if (!$prop || !in_array($prop['status'], ['pending', 'not_selected'], true)) { return 'That proposal is no longer available.'; }
    $pdo = db();
    $pdo->beginTransaction();
    $guard = $pdo->prepare("UPDATE projects SET freelancer_id = ?, agreed_amount = ?
                            WHERE id = ? AND status = 'open' AND contract_status = 'none' AND freelancer_id IS NULL");
    $guard->execute([(int) $prop['freelancer_id'], (int) $prop['offer'], (int) $project['id']]);
    if (!$guard->rowCount()) {
        $pdo->rollBack();
        return 'This project is no longer accepting contracts.';
    }
    $pdo->prepare("UPDATE proposals SET status = 'not_selected' WHERE project_id = ? AND id <> ? AND status = 'pending'")
        ->execute([(int) $project['id'], (int) $prop['id']]);
    $pdo->prepare("UPDATE proposals SET status = 'selected' WHERE id = ?")->execute([(int) $prop['id']]);
    $pdo->commit();
    tt_notify($prop['freelancer_id'], 'responses', 'You were selected',
              $user['name'] . ' selected you for ' . $project['title'] . '. Waiting for the contract.');
    tt_audit('select freelancer', 'project #' . ($project['id'] ?? $site_id) . ' proposal #' . $proposal_id);
    return null;
}

/** Client directly hires a freelancer without using the proposal-selection flow. Returns null or an error. */
function tt_db_hire_freelancer($site_id, $freelancer_id, $agreed_amount)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'client') { return 'Only clients can hire freelancers.'; }
    if ((int) $agreed_amount < 1) { return 'Enter a valid agreed amount.'; }

    $project_id = (int) $site_id - 1000;
    $freelancer_user_id = (int) $freelancer_id - 5000;
    if ($project_id < 1 || $freelancer_user_id < 1) { return 'This project or freelancer is not available.'; }

    $pdo = db();
    $pdo->beginTransaction();
    try {
        $project_stmt = $pdo->prepare('SELECT * FROM projects WHERE id = ? FOR UPDATE');
        $project_stmt->execute([$project_id]);
        $project = $project_stmt->fetch();
        if (!$project || (int) $project['client_id'] !== (int) $user['id']) {
            $pdo->rollBack();
            return 'This project is not yours.';
        }
        if ($project['status'] !== 'open' || $project['contract_status'] !== 'none' || !empty($project['freelancer_id'])) {
            $pdo->rollBack();
            return 'This project is no longer available for direct hiring.';
        }
        if ($project['deadline'] < date('Y-m-d')) {
            $pdo->rollBack();
            return 'The deadline for this project has passed.';
        }
        if ($project['billing_type'] === 'hourly'
            && (int) $agreed_amount !== (int) $project['hourly_rate'] * (int) $project['max_hours']) {
            $pdo->rollBack();
            return 'For hourly projects, the agreed amount must match the hourly rate multiplied by maximum hours.';
        }

        $freelancer_stmt = $pdo->prepare("SELECT id, name FROM users WHERE id = ? AND role = 'freelancer' AND status = 'active'");
        $freelancer_stmt->execute([$freelancer_user_id]);
        $freelancer = $freelancer_stmt->fetch();
        if (!$freelancer) {
            $pdo->rollBack();
            return 'This freelancer is not available.';
        }

        $pdo->prepare("UPDATE proposals SET status = 'not_selected' WHERE project_id = ? AND status = 'pending'")
            ->execute([$project_id]);
        $pdo->prepare("UPDATE proposals SET status = 'selected' WHERE project_id = ? AND freelancer_id = ? AND status = 'not_selected'")
            ->execute([$project_id, $freelancer_user_id]);
        $pdo->prepare("UPDATE projects SET freelancer_id = ?, agreed_amount = ?, contract_status = 'pending', contract_sent_at = NOW() WHERE id = ?")
            ->execute([$freelancer_user_id, (int) $agreed_amount, $project_id]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        throw $e;
    }

    tt_notify($freelancer_user_id, 'offers', 'Direct project offer',
              $user['name'] . ' sent you a direct contract for ' . $project['title'] . '.');
    return null;
}

/** Client sends the contract. Returns null or an error. */
function tt_db_send_contract($site_id, $agreed_amount)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'client') { return 'Only clients can send contracts.'; }
    $project = tt_db_project($site_id);
    if (!$project || (int) $project['client_id'] !== (int) ($user['id'] ?? 0)) { return 'This project is not yours.'; }
    if ($project['status'] !== 'open') { return 'This project is no longer accepting contracts.'; }
    if (empty($project['freelancer_id']))                             { return 'Select a freelancer before sending the contract.'; }
    if ($project['contract_status'] !== 'none')                       { return 'The contract has already been sent.'; }
    if ((int) $agreed_amount < 1)                                     { return 'Enter the agreed amount.'; }
    if ($project['billing_type'] === 'hourly'
        && (int) $agreed_amount !== (int) $project['hourly_rate'] * (int) $project['max_hours']) {
        return 'For hourly projects, the agreed amount must match the hourly rate multiplied by maximum hours.';
    }
    $stmt = db()->prepare("UPDATE projects SET contract_status = 'pending', agreed_amount = ?, contract_sent_at = NOW()
                           WHERE id = ? AND status = 'open' AND contract_status = 'none' AND freelancer_id IS NOT NULL");
    $stmt->execute([(int) $agreed_amount, (int) $project['id']]);
    if (!$stmt->rowCount()) { return 'This project is no longer accepting contracts.'; }
    tt_notify($project['freelancer_id'], 'offers', 'Project offer',
              $user['name'] . ' sent you a contract for ' . $project['title'] . '.');
    tt_audit('send contract', 'project #' . $project['id'] . ' ₱' . number_format((int) $agreed_amount));
    return null;
}

/** Freelancer accepts (true) or declines (false) the contract. Returns null or an error. */
function tt_db_respond_contract($site_id, $accept)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'freelancer') { return 'Only freelancers can respond to contracts.'; }
    $project = tt_db_project($site_id);
    if (!$project || (int) $project['freelancer_id'] !== (int) ($user['id'] ?? 0)) { return 'This offer is not yours.'; }
    if ($project['status'] !== 'open') { return 'This project is closed or suspended and cannot be contracted.'; }
    if ($project['contract_status'] !== 'pending') { return 'There is no open contract to respond to.'; }
    $pdo = db();
    $pdo->beginTransaction();
    if ($accept) {
        $stmt = $pdo->prepare("UPDATE projects SET contract_status = 'active', status = 'ongoing', start_date = CURDATE()
                               WHERE id = ? AND status = 'open' AND contract_status = 'pending'");
        $stmt->execute([(int) $project['id']]);
        if (!$stmt->rowCount()) {
            $pdo->rollBack();
            return 'This project is closed or suspended and cannot be contracted.';
        }
        tt_notify($project['client_id'], 'responses', 'Contract accepted',
                  $user['name'] . ' accepted the contract for ' . $project['title'] . '. Please deposit the amount.');
    } else {
        $pdo->prepare("UPDATE projects SET contract_status = 'none', freelancer_id = NULL, agreed_amount = 0 WHERE id = ?")
            ->execute([(int) $project['id']]);
        $pdo->prepare("UPDATE proposals SET status = 'withdrawn' WHERE project_id = ? AND freelancer_id = ? AND status = 'selected'")
            ->execute([(int) $project['id'], (int) $user['id']]);
        tt_notify($project['client_id'], 'responses', 'Contract declined',
                  $user['name'] . ' declined the contract for ' . $project['title'] . '. The project is open again.');
    }
    $pdo->commit();
    tt_audit($accept ? 'accept contract' : 'decline contract', 'project #' . $site_id);
    return null;
}

/** Contracts waiting for the signed-in freelancer to accept or decline. */
function tt_db_freelancer_offers()
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'freelancer') { return []; }
    $stmt = db()->prepare("SELECT p.*, c.name AS category, u.name AS client_name, cp.company AS client_company FROM projects p
                           LEFT JOIN categories c ON c.id = p.category_id
                           JOIN users u ON u.id = p.client_id
                           LEFT JOIN client_profiles cp ON cp.user_id = u.id
                           WHERE p.freelancer_id = ? AND p.contract_status = 'pending' ORDER BY p.id");
    $stmt->execute([(int) $user['id']]);
    return $stmt->fetchAll();
}

/* ==========================================================================
   SAMPLE PROJECT CONTRACT STATE
   Sample projects are not database rows, so their selected freelancer and
   contract are stored in the settings table (one entry per sample project).
   ========================================================================== */
function tt_sample_state($site_id)
{
    $stmt = db()->prepare('SELECT value FROM settings WHERE name = ?');
    $stmt->execute(['sample_project_' . (int) $site_id]);
    $v = $stmt->fetchColumn();
    $d = $v ? json_decode($v, true) : null;
    return is_array($d) ? $d + ['freelancer_id' => null, 'contract_status' => 'none', 'agreed' => 0, 'sent_at' => null]
                        : ['freelancer_id' => null, 'contract_status' => 'none', 'agreed' => 0, 'sent_at' => null];
}

function tt_save_sample_state($site_id, $state)
{
    db()->prepare('INSERT INTO settings (name, value) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)')
        ->execute(['sample_project_' . (int) $site_id, json_encode($state)]);
}


/* ==========================================================================
   SAVED FREELANCERS AND PROJECTS (the heart and Save buttons)
   ========================================================================== */

/** Ids saved by the signed-in user. kind: 'freelancer' or 'project'. */
function tt_saved_ids($kind)
{
    $u = tt_current_user();
    if (!$u) { return []; }
    $stmt = db()->prepare('SELECT item_id FROM saved_items WHERE user_id = ? AND kind = ? ORDER BY created_at DESC, item_id DESC');
    $stmt->execute([(int) $u['id'], $kind]);
    return array_map('intval', array_column($stmt->fetchAll(), 'item_id'));
}

/** Adds the item if it isn't saved, removes it if it is. */
function tt_toggle_favourite($kind, $item_id)
{
    $u = tt_current_user();
    if (!$u) { return; }
    $pdo = db();
    $check = $pdo->prepare('SELECT 1 FROM saved_items WHERE user_id = ? AND kind = ? AND item_id = ?');
    $check->execute([(int) $u['id'], $kind, (int) $item_id]);
    if ($check->fetchColumn()) {
        $pdo->prepare('DELETE FROM saved_items WHERE user_id = ? AND kind = ? AND item_id = ?')
            ->execute([(int) $u['id'], $kind, (int) $item_id]);
    } else {
        $pdo->prepare('INSERT INTO saved_items (user_id, kind, item_id) VALUES (?, ?, ?)')
            ->execute([(int) $u['id'], $kind, (int) $item_id]);
    }
}

/** Handles a heart or Save button press on any page. Clients save freelancers; freelancers save projects. */
function tt_handle_favourite()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['favourite'])) { return; }
    $u = tt_current_user();
    $kind = $_POST['favourite'];
    $ok = ($kind === 'freelancer' && $u && $u['role'] === 'client')
       || ($kind === 'project' && $u && $u['role'] === 'freelancer');
    if ($ok) { tt_toggle_favourite($kind, (int) ($_POST['item'] ?? 0)); }
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

/** Freelancer ids the client has saved. */
function toptunity_saved_freelancer_ids()
{
    return tt_saved_ids('freelancer');
}

/** Project ids the freelancer has saved (sample ids and posted project ids). */
function toptunity_freelancer_saved_ids()
{
    return tt_saved_ids('project');
}

/* ==========================================================================
   BILLING AND PAYMENTS (database)
   Flow: client deposits (held) -> client releases on approval (freelancer
   earns amount minus the service fee) -> freelancer withdraws -> admin
   processes or rejects. Balances are always calculated from these records.
   ========================================================================== */

/** The service fee in pesos for an amount. */
function tt_fee_for($amount)
{
    return (int) round($amount * tt_service_fee() / 100);
}

/** Active categories managed by the administrator. */
function toptunity_category_catalog()
{
    if (in_array(tt_current_user()['role'] ?? '', ['client', 'freelancer'], true)
        && !empty($_SESSION['demo_admin_catalog'])
        && (tt_is_demo_account() || tt_is_demo_freelancer())) {
        return array_values(array_unique($_SESSION['demo_admin_catalog']['categories']));
    }
    if (tt_is_demo_admin()) {
        return array_values(array_unique(tt_demo_admin_catalog_state()['categories']));
    }
    toptunity_skill_catalog();
    return db()->query('SELECT name FROM categories ORDER BY name')->fetchAll(PDO::FETCH_COLUMN);
}

/** Posted projects of the signed-in client with their payment state. */
function tt_client_billing_projects()
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'client') { return []; }
    $stmt = db()->prepare("SELECT p.id, p.title, p.deadline, p.status, p.contract_status, p.agreed_amount,
                                  p.billing_type, p.hourly_rate, p.max_hours,
                                  p.freelancer_id, f.name AS freelancer_name,
                                  (SELECT e.status FROM payments e WHERE e.project_id = p.id AND e.type = 'escrow' ORDER BY e.id DESC LIMIT 1) AS escrow_status,
                                  (SELECT e.amount FROM payments e WHERE e.project_id = p.id AND e.type = 'escrow' ORDER BY e.id DESC LIMIT 1) AS escrow_amount
                           FROM projects p LEFT JOIN users f ON f.id = p.freelancer_id
                           WHERE p.client_id = ? ORDER BY p.id DESC");
    $stmt->execute([(int) $u['id']]);
    return $stmt->fetchAll();
}

/** Client deposits the agreed amount for an active contract. Returns null or an error. */
function tt_db_deposit($site_id)
{
    $u = tt_current_user();
    $pdo = db();
    $pdo->beginTransaction();
    try {
        // lock the project row so two deposits cannot run at the same time
        $lock = $pdo->prepare("SELECT * FROM projects WHERE id = ? FOR UPDATE");
        $lock->execute([(int) (tt_db_project($site_id)['id'] ?? 0)]);
        $project = $lock->fetch();
        if (!$project || (int) $project['client_id'] !== (int) $u['id']) { $pdo->rollBack(); return 'This project is not yours.'; }
        if ($project['contract_status'] !== 'active')                    { $pdo->rollBack(); return 'The contract must be accepted before you deposit.'; }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM payments WHERE project_id = ? AND type = 'escrow'");
        $stmt->execute([(int) $project['id']]);
        if ((int) $stmt->fetchColumn() > 0)                              { $pdo->rollBack(); return 'This project has already been deposited.'; }
        $amount = (int) $project['agreed_amount'];
        if ($amount < 1) { $pdo->rollBack(); return 'The contract amount is invalid.'; }
        $pdo->prepare("INSERT INTO payments (project_id, type, amount, service_fee, status) VALUES (?, 'escrow', ?, ?, 'held')")
            ->execute([(int) $project['id'], $amount, tt_fee_for($amount)]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        return 'The deposit could not be saved. Please try again.';
    }
    tt_notify($project['freelancer_id'], 'payments', 'Payment held',
              '₱' . number_format($amount) . ' was deposited for ' . $project['title'] . '. It is released when the client approves the work.');
    tt_audit('deposit', 'project #' . $project['id'] . ' ₱' . number_format($amount), $u['id']);
    return null;
}

/** Client approves the work and releases the held payment. Returns null or an error. */
function tt_db_release($site_id)
{
    $u = tt_current_user();
    $project = tt_db_project($site_id);
    if (!$project || (int) $project['client_id'] !== (int) $u['id']) { return 'This project is not yours.'; }
    if ($project['billing_type'] === 'hourly') {
        return 'Hourly projects are settled on the End Date using approved hours; the unused deposit is refunded.';
    }
    $pdo = db();
    $pdo->beginTransaction();
    try {
        // lock the held payment so it can only be released once
        $stmt = $pdo->prepare("SELECT * FROM payments WHERE project_id = ? AND type = 'escrow' AND status = 'held' ORDER BY id DESC LIMIT 1 FOR UPDATE");
        $stmt->execute([(int) $project['id']]);
        $escrow = $stmt->fetch();
        if (!$escrow) { $pdo->rollBack(); return 'There is no held payment to release.'; }
        $pdo->prepare("UPDATE payments SET status = 'released' WHERE id = ?")->execute([(int) $escrow['id']]);
        $pdo->prepare("UPDATE projects SET status = 'completed', contract_status = 'completed' WHERE id = ?")->execute([(int) $project['id']]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        return 'The payment could not be released. Please try again.';
    }
    $net = (int) $escrow['amount'] - (int) $escrow['service_fee'];
    tt_notify($project['freelancer_id'], 'payments', 'Payment released',
              '₱' . number_format($net) . ' was released to you for ' . $project['title'] . ' (after the service fee).');
    tt_audit('release payment', 'project #' . $project['id'] . ' ₱' . number_format($net), $u['id']);
    return null;
}

/** Settle an hourly escrow on or after the project deadline. */
function tt_db_settle_hourly_project($site_id)
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    if (!$project || (int) $project['client_id'] !== (int) ($user['id'] ?? 0)) { return 'This project is not yours.'; }
    if ($project['billing_type'] !== 'hourly') { return 'This is not an hourly project.'; }
    if ($project['deadline'] > date('Y-m-d')) { return 'Hourly billing is due on the project End Date.'; }

    $pdo = db();
    $pdo->beginTransaction();
    try {
        $lock = $pdo->prepare("SELECT * FROM payments WHERE project_id = ? AND type = 'escrow' AND status = 'held' ORDER BY id DESC LIMIT 1 FOR UPDATE");
        $lock->execute([(int) $project['id']]);
        $escrow = $lock->fetch();
        if (!$escrow) {
            $pdo->commit();
            return null;
        }

        $logs = $pdo->prepare("UPDATE work_logs SET status = 'approved', review_note = NULL
                               WHERE project_id = ? AND status = 'pending'");
        $logs->execute([(int) $site_id]);
        $hours = $pdo->prepare("SELECT COALESCE(SUM(hours), 0) FROM work_logs
                                WHERE project_id = ? AND status = 'approved'");
        $hours->execute([(int) $site_id]);
        $approved_hours = min((float) $project['max_hours'], (float) $hours->fetchColumn());
        $gross = min((int) $escrow['amount'], (int) round($approved_hours * (int) $project['hourly_rate']));
        $fee = tt_fee_for($gross);
        $unused = (int) $escrow['amount'] - $gross;

        $pdo->prepare("UPDATE payments SET status = 'paid' WHERE id = ?")->execute([(int) $escrow['id']]);
        if ($gross > 0) {
            $pdo->prepare("INSERT INTO payments (project_id, type, amount, service_fee, status)
                           VALUES (?, 'release', ?, ?, 'released')")
                ->execute([(int) $project['id'], $gross, $fee]);
        }
        if ($unused > 0) {
            $pdo->prepare("INSERT INTO payments (project_id, type, amount, service_fee, status)
                           VALUES (?, 'refund', ?, 0, 'refunded')")
                ->execute([(int) $project['id'], $unused]);
        }
        $pdo->prepare("UPDATE projects SET status = 'completed', contract_status = 'completed' WHERE id = ?")
            ->execute([(int) $project['id']]);
        $pdo->commit();

        if ($gross > 0 && !empty($project['freelancer_id'])) {
            tt_notify((int) $project['freelancer_id'], 'payments', 'Hourly payment released',
                      '₱' . number_format($gross - $fee) . ' was released for approved hours on ' . $project['title'] . '.');
        }
        if ($unused > 0) {
            tt_notify((int) $project['client_id'], 'payments', 'Hourly deposit refunded',
                      '₱' . number_format($unused) . ' unused from ' . $project['title'] . ' was refunded.');
        }
        return null;
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        throw $e;
    }
}

/** Settle all due hourly projects belonging to the signed-in client. */
function tt_settle_due_hourly_projects()
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'client') { return; }
    $stmt = db()->prepare("SELECT p.id FROM projects p
                           JOIN payments e ON e.project_id = p.id AND e.type = 'escrow' AND e.status = 'held'
                           WHERE p.client_id = ? AND p.billing_type = 'hourly' AND p.deadline <= CURDATE()");
    $stmt->execute([(int) $user['id']]);
    foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $project_id) {
        $error = tt_db_settle_hourly_project(1000 + (int) $project_id);
        if ($error) { error_log('TopTunity hourly settlement failed: ' . $error); }
    }
}

/** Client payment history (deposits and releases on their projects). */
function tt_client_payment_history()
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'client') { return []; }
    $stmt = db()->prepare("SELECT pay.*, p.title FROM payments pay JOIN projects p ON p.id = pay.project_id
                           WHERE p.client_id = ? ORDER BY pay.id DESC");
    $stmt->execute([(int) $u['id']]);
    return $stmt->fetchAll();
}

/** Money for the signed-in freelancer. */
function tt_freelancer_money()
{
    $u = tt_current_user();
    $money = ['earned' => 0, 'on_hold' => 0, 'withdrawn' => 0, 'available' => 0, 'withdrawals' => [], 'escrow' => []];
    if (!$u || $u['role'] !== 'freelancer') { return $money; }
    $pdo = db(); $me = (int) $u['id'];

    $stmt = $pdo->prepare("SELECT pay.type, pay.amount, pay.service_fee, pay.status, pay.created_at, p.title, p.id AS project_id, p.billing_type, p.hourly_rate
                           FROM payments pay JOIN projects p ON p.id = pay.project_id
                           WHERE p.freelancer_id = ? AND pay.type IN ('escrow', 'release') ORDER BY pay.id DESC");
    $stmt->execute([$me]);
    foreach ($stmt->fetchAll() as $row) {
        if ($row['type'] === 'escrow' && $row['status'] === 'paid') { continue; }
        if ($row['type'] === 'release' && $row['status'] !== 'released') { continue; }
        $net = (int) $row['amount'] - (int) $row['service_fee'];
        if ($row['status'] === 'released') { $money['earned'] += $net; }
        if ($row['type'] === 'escrow' && $row['status'] === 'held') { $money['on_hold'] += (int) $row['amount']; }
        if ($row['type'] === 'release') { $row['status'] = 'released'; }
        $money['escrow'][] = $row + ['net' => $net];
    }

    $stmt = $pdo->prepare("SELECT * FROM withdrawals WHERE freelancer_id = ? ORDER BY id DESC");
    $stmt->execute([$me]);
    $money['withdrawals'] = $stmt->fetchAll();
    foreach ($money['withdrawals'] as $w) {
        if ($w['status'] !== 'rejected') { $money['withdrawn'] += (int) $w['amount']; }
    }
    $money['available'] = max(0, $money['earned'] - $money['withdrawn']);
    return $money;
}

/** Freelancer requests a withdrawal. Returns null or an error. */
function tt_db_withdraw($amount, $method, $account)
{
    $u = tt_current_user();
    if ((int) $amount < 500)                         { return 'The minimum withdrawal is ₱500.'; }
    if (!in_array($method, ['gcash', 'bank'], true)) { return 'Choose a withdrawal method.'; }
    if (trim($account) === '')                       { return 'Enter the account number.'; }
    $pdo = db();
    $pdo->beginTransaction();
    try {
        // lock the freelancer's row, then check the balance, so two requests cannot both spend the same money
        $pdo->prepare('SELECT id FROM users WHERE id = ? FOR UPDATE')->execute([(int) $u['id']]);
        $money = tt_freelancer_money();
        if ((int) $amount > $money['available']) {
            $pdo->rollBack();
            return 'You can withdraw at most ₱' . number_format($money['available']) . '.';
        }
        $pdo->prepare('INSERT INTO withdrawals (freelancer_id, method, account, amount) VALUES (?, ?, ?, ?)')
            ->execute([(int) $u['id'], $method, trim($account), (int) $amount]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        return 'The withdrawal could not be saved. Please try again.';
    }
    tt_audit('withdrawal requested', '₱' . number_format((int) $amount) . ' via ' . $method, $u['id']);
    return null;
}

/** Admin withdrawals, newest first. */
function tt_admin_withdrawals_db()
{
    $sql = "SELECT w.*, u.name AS freelancer FROM withdrawals w JOIN users u ON u.id = w.freelancer_id";
    $demo_ids = tt_demo_ids();
    if (tt_is_demo_admin()) {
        if (!$demo_ids) { return []; }
        $sql .= ' WHERE w.freelancer_id IN (' . implode(',', array_map('intval', $demo_ids)) . ')';
    } elseif ($demo_ids) {
        $sql .= ' WHERE w.freelancer_id NOT IN (' . implode(',', array_map('intval', $demo_ids)) . ')';
    }
    return db()->query($sql . ' ORDER BY w.id DESC')->fetchAll();
}

/** Admin marks a withdrawal processed or rejected. Returns null or an error. */
function tt_db_process_withdrawal($id, $action, $reason = '')
{
    $pdo = db();
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("SELECT * FROM withdrawals WHERE id = ? FOR UPDATE");
        $stmt->execute([(int) $id]);
        $w = $stmt->fetch();
        if (!$w)                            { $pdo->rollBack(); return 'That request was not found.'; }
        if (tt_is_demo_admin() && !in_array((int) $w['freelancer_id'], tt_demo_ids(), true)) {
            $pdo->rollBack();
            return 'The demo administrator can only process withdrawals for demo accounts.';
        }
        if ($w['status'] !== 'pending')     { $pdo->rollBack(); return 'This request has already been handled.'; }
        if ($action === 'reject' && mb_strlen(trim($reason)) < 10) { $pdo->rollBack(); return 'Give a reason for rejecting (at least 10 characters).'; }
        $new = $action === 'process' ? 'processed' : 'rejected';
        $pdo->prepare('UPDATE withdrawals SET status = ? WHERE id = ?')->execute([$new, (int) $w['id']]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        return 'The request could not be updated. Please try again.';
    }
    tt_notify($w['freelancer_id'], 'payments', $new === 'processed' ? 'Withdrawal sent' : 'Withdrawal rejected',
              $new === 'processed' ? '₱' . number_format($w['amount']) . ' was sent to your ' . $w['method'] . ' account.'
                                   : '₱' . number_format($w['amount']) . ' was returned to your balance. Reason: ' . $reason);
    tt_audit('withdrawal ' . $new, 'request #' . $w['id'] . ' ₱' . number_format($w['amount']));
    return null;
}

/** Admin payments list with totals. */
function tt_admin_payments_db()
{
    $sql = "SELECT pay.*, p.title, p.billing_type, p.client_id, p.freelancer_id
            FROM payments pay JOIN projects p ON p.id = pay.project_id";
    if (tt_is_demo_admin()) {
        $demo_ids = tt_demo_ids();
        if (!$demo_ids) { return [[], ['held' => 0, 'released' => 0, 'fees' => 0]]; }
        $ids = implode(',', array_map('intval', $demo_ids));
        $sql .= " WHERE p.client_id IN ($ids) OR p.freelancer_id IN ($ids)";
    } else {
        $demo_ids = tt_demo_ids();
        if ($demo_ids) {
            $ids = implode(',', array_map('intval', $demo_ids));
            $sql .= " WHERE p.client_id NOT IN ($ids) AND (p.freelancer_id IS NULL OR p.freelancer_id NOT IN ($ids))";
        }
    }
    $rows = db()->query($sql . ' ORDER BY pay.id DESC')->fetchAll();
    $totals = ['held' => 0, 'released' => 0, 'fees' => 0];
    foreach ($rows as $r) {
        if ($r['status'] === 'held')     { $totals['held'] += (int) $r['amount']; }
        if ($r['status'] === 'released') { $totals['released'] += (int) $r['amount']; $totals['fees'] += (int) $r['service_fee']; }
    }
    return [$rows, $totals];
}


/* ==========================================================================
   DEMO + REAL. These functions return the demo sample rows (for the demo
   accounts) followed by the real records from the database. Sample rows are
   marked 'sample' => true and cannot be changed.
   ========================================================================== */

/** Date text the way the sample data writes it (for example "Oct 03, 2026"). */
function tt_date_label($datetime)
{
    return date('M d, Y', strtotime($datetime));
}

/** Freelancer money: demo sample figures plus real balances and records. */
function toptunity_freelancer_earnings()
{
    $sample = [
        'available' => 10400, 'on_hold' => 5000, 'net' => 50400, 'fee' => 5600,
        'completed' => [
            ['date' => 'Sep 18, 2026', 'project' => 'Clinic Inventory Dashboard', 'billing' => 'Hourly · ₱650/hr', 'payment' => 26000, 'fee' => 2600, 'net' => 23400, 'sample' => true],
            ['date' => 'Sep 02, 2026', 'project' => 'Café Menu Landing Page', 'billing' => 'Fixed Price', 'payment' => 12000, 'fee' => 1200, 'net' => 10800, 'sample' => true],
            ['date' => 'Aug 15, 2026', 'project' => 'Sari-Sari Store POS System', 'billing' => 'Fixed Price', 'payment' => 18000, 'fee' => 1800, 'net' => 16200, 'sample' => true],
        ],
        'withdrawals' => [
            ['date' => 'Oct 03, 2026', 'method' => 'GCash •••• 4821', 'amount' => 5000, 'status' => 'pending', 'sample' => true],
            ['date' => 'Sep 20, 2026', 'method' => 'BPI •••• 0937', 'amount' => 20000, 'status' => 'processed', 'sample' => true],
            ['date' => 'Sep 05, 2026', 'method' => 'BPI •••• 0937', 'amount' => 3000, 'status' => 'rejected', 'sample' => true],
            ['date' => 'Aug 18, 2026', 'method' => 'GCash •••• 4821', 'amount' => 15000, 'status' => 'processed', 'sample' => true],
        ],
    ];
    if (!tt_is_demo_freelancer()) {
        $sample = ['available' => 0, 'on_hold' => 0, 'net' => 0, 'fee' => 0, 'completed' => [], 'withdrawals' => []];
    }
    $real = tt_freelancer_money();

    $completed = [];
    $real_fee = 0;
    foreach ($real['escrow'] as $e) {
        if ($e['status'] !== 'released') { continue; }
        $billing = $e['billing_type'] === 'hourly' ? 'Hourly · ₱' . number_format($e['hourly_rate']) . '/hr' : 'Fixed Price';
        $completed[] = ['date' => tt_date_label($e['created_at']), 'project' => $e['title'], 'billing' => $billing,
                        'payment' => (int) $e['amount'], 'fee' => (int) $e['service_fee'], 'net' => (int) $e['net'], 'sample' => false];
        $real_fee += (int) $e['service_fee'];
    }
    $withdrawals = [];
    foreach ($real['withdrawals'] as $w) {
        $withdrawals[] = ['id' => (int) $w['id'], 'date' => tt_date_label($w['created_at']),
                          'method' => ($w['method'] === 'gcash' ? 'GCash' : 'Bank Account') . ' · ' . $w['account'],
                          'amount' => (int) $w['amount'], 'status' => $w['status'], 'sample' => false];
    }

    return [
        'available'   => $sample['available'] + $real['available'],
        'on_hold'     => $sample['on_hold'] + $real['on_hold'],
        'net'         => $sample['net'] + $real['earned'],
        'fee'         => $sample['fee'] + $real_fee,
        'completed'   => array_merge($completed, $sample['completed']),
        'withdrawals' => array_merge($withdrawals, $sample['withdrawals']),
        'real_available' => $real['available'],
    ];
}

/** Client payments: demo sample rows plus the real deposits and releases. */
function toptunity_client_payments()
{
    $sample = [];
    if (tt_is_demo_account()) {
        $sample = [
            ['date' => '2026-10-02', 'project' => 'Monthly Social Media Content Calendar', 'type' => 'Deposit', 'amount' => 14000, 'fee' => 0, 'status' => 'pending', 'sample' => true],
            ['date' => '2026-09-14', 'project' => 'Point-of-Sale and Inventory Dashboard', 'type' => 'Deposit', 'amount' => 36000, 'fee' => 0, 'status' => 'held', 'sample' => true],
            ['date' => '2026-09-10', 'project' => 'Menu Board and Cup Sleeve Design', 'type' => 'Deposit', 'amount' => 6500, 'fee' => 0, 'status' => 'held', 'sample' => true],
            ['date' => '2026-09-04', 'project' => 'Product Photo Retouching', 'type' => 'Deposit', 'amount' => 5000, 'fee' => 500, 'status' => 'released', 'sample' => true],
            ['date' => '2026-08-31', 'project' => 'Barista Training Manual Layout', 'type' => 'Refund', 'amount' => 4000, 'fee' => 0, 'status' => 'refunded', 'sample' => true],
            ['date' => '2026-07-31', 'project' => 'Weekly Menu Social Posts (July)', 'type' => 'Hourly Billing', 'amount' => 8400, 'fee' => 0, 'status' => 'paid', 'sample' => true],
        ];
    }
    $real = [];
    foreach (tt_client_payment_history() as $h) {
        if ($h['type'] === 'escrow' && $h['status'] === 'paid') { continue; }
        $type = ['escrow' => 'Deposit', 'release' => 'Release', 'refund' => 'Refund',
                 'hourly_billing' => 'Hourly Billing'][$h['type']] ?? 'Deposit';
        $real[] = ['id' => (int) $h['id'], 'date' => date('Y-m-d', strtotime($h['created_at'])), 'project' => $h['title'],
                   'type' => $type, 'amount' => (int) $h['amount'],
                   'fee' => (int) $h['service_fee'], 'status' => $h['status'], 'sample' => false];
    }
    return array_merge($real, $sample);
}

/** Admin payments: demo sample rows plus the real records. */
function toptunity_admin_payments()
{
    $real = [];
    [$rows] = tt_admin_payments_db();
    foreach ($rows as $r) {
        $real[] = ['date' => tt_date_label($r['created_at']), 'project' => $r['title'],
                   'billing' => $r['billing_type'] === 'hourly' ? 'Hourly' : 'Fixed Price',
                   'type' => $r['status'] === 'released' ? 'Release' : 'Escrow',
                   'amount' => (int) $r['amount'], 'fee' => (int) $r['service_fee'], 'status' => $r['status'], 'sample' => false];
    }
    $sample = tt_is_demo_admin() ? [
        ['date' => 'Oct 03, 2026', 'project' => 'Monthly Social Media Content Calendar', 'billing' => 'Hourly', 'type' => 'Escrow', 'amount' => 14000, 'fee' => 1400, 'status' => 'held', 'sample' => true],
        ['date' => 'Oct 02, 2026', 'project' => 'Clinic Inventory Dashboard', 'billing' => 'Hourly · 40 h × ₱650', 'type' => 'Hourly Billing', 'amount' => 26000, 'fee' => 2000, 'status' => 'paid', 'sample' => true],
        ['date' => 'Sep 04, 2026', 'project' => 'Product Photo Retouching', 'billing' => 'Fixed Price', 'type' => 'Release', 'amount' => 5000, 'fee' => 500, 'status' => 'released', 'sample' => true],
        ['date' => 'Aug 31, 2026', 'project' => 'Weekly Menu Social Posts (July)', 'billing' => 'Hourly', 'type' => 'Refund', 'amount' => 1400, 'fee' => 0, 'status' => 'refunded', 'sample' => true],
        ['date' => 'Aug 31, 2026', 'project' => 'Barista Training Manual Layout', 'billing' => 'Fixed Price', 'type' => 'Refund', 'amount' => 4000, 'fee' => 0, 'status' => 'refunded', 'sample' => true],
    ] : [];
    return array_merge($real, $sample);
}

/** Platform totals for the admin dashboard: demo figures plus the real records. */
function toptunity_admin_money_totals()
{
    [$rows, $real] = tt_admin_payments_db();
    $held_projects = 0;
    foreach ($rows as $r) { if ($r['status'] === 'held') { $held_projects++; } }
    $pending_withdrawals = count(array_filter(tt_admin_withdrawals_db(), function ($w) { return $w['status'] === 'pending'; }));
    $sample = tt_is_demo_admin();
    return [
        'held'         => ($sample ? 486500 : 0) + $real['held'],
        'released'     => ($sample ? 1284300 : 0) + $real['released'],
        'fees'         => ($sample ? 142700 : 0) + $real['fees'],
        'held_projects'=> ($sample ? 96 : 0) + $held_projects,
        'pending_withdrawals' => $pending_withdrawals,
    ];
}

/** Withdrawal requests: real requests first, then the demo sample rows. */
function toptunity_admin_withdrawals()
{
    $real = [];
    foreach (tt_admin_withdrawals_db() as $w) {
        $real[] = ['id' => (int) $w['id'], 'date' => tt_date_label($w['created_at']), 'freelancer' => $w['freelancer'],
                   'method' => $w['method'] === 'gcash' ? 'GCash' : 'Bank Account', 'account' => $w['account'],
                   'amount' => (int) $w['amount'], 'balance_after' => null, 'status' => $w['status'], 'sample' => false];
    }
    $sample = tt_is_demo_admin() ? [
        ['id' => 'W-2201', 'date' => 'Oct 03, 2026', 'freelancer' => 'Miguel Reyes', 'method' => 'GCash', 'account' => '0917 •••• 4821', 'amount' => 5000, 'balance_after' => 10400, 'status' => 'pending', 'sample' => true],
        ['id' => 'W-2200', 'date' => 'Oct 03, 2026', 'freelancer' => 'Rhea Mendoza', 'method' => 'Bank Account', 'account' => 'BPI •••• 0937', 'amount' => 12500, 'balance_after' => 8200, 'status' => 'pending', 'sample' => true],
        ['id' => 'W-2196', 'date' => 'Oct 02, 2026', 'freelancer' => 'Kevin Tan', 'method' => 'GCash', 'account' => '0918 •••• 1190', 'amount' => 3800, 'balance_after' => 4100, 'status' => 'pending', 'sample' => true],
        ['id' => 'W-2188', 'date' => 'Sep 20, 2026', 'freelancer' => 'Miguel Reyes', 'method' => 'Bank Account', 'account' => 'BPI •••• 0937', 'amount' => 20000, 'balance_after' => 15400, 'status' => 'processed', 'sample' => true],
    ] : [];
    foreach ($sample as &$row) {
        if (isset($_SESSION['demo_admin_withdrawal_status'][$row['id']])) {
            $row['status'] = $_SESSION['demo_admin_withdrawal_status'][$row['id']];
        }
    }
    unset($row);
    return array_merge($real, $sample);
}

/** Process a sample withdrawal without changing real balances or database rows. */
function tt_admin_process_demo_withdrawal($id, $action, $reason = '')
{
    if (!tt_is_demo_admin()) { return 'This action is only available to the demo administrator.'; }
    if (!in_array($action, ['process', 'reject'], true)) { return 'Choose a valid withdrawal action.'; }
    $request = null;
    foreach (toptunity_admin_withdrawals() as $candidate) {
        if ($candidate['id'] === $id && !empty($candidate['sample'])) { $request = $candidate; break; }
    }
    if (!$request) { return 'That sample withdrawal could not be found.'; }
    if ($request['status'] !== 'pending') { return 'This request has already been handled.'; }
    if ($action === 'reject' && mb_strlen(trim($reason)) < 10) { return 'Give a reason for rejecting (at least 10 characters).'; }
    $_SESSION['demo_admin_withdrawal_status'][$id] = $action === 'process' ? 'processed' : 'rejected';
    return null;
}

/** Real proposal statuses for the signed-in freelancer (used by the dashboard counts). */
function tt_freelancer_db_proposal_statuses()
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'freelancer') { return []; }
    $stmt = db()->prepare('SELECT status FROM proposals WHERE freelancer_id = ?');
    $stmt->execute([(int) $u['id']]);
    return array_column($stmt->fetchAll(), 'status');
}

/** Real ongoing projects for the signed-in freelancer. */
function tt_freelancer_db_ongoing_count()
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'freelancer') { return 0; }
    $stmt = db()->prepare("SELECT COUNT(*) FROM projects WHERE freelancer_id = ? AND status IN ('ongoing', 'overdue')");
    $stmt->execute([(int) $u['id']]);
    return (int) $stmt->fetchColumn();
}

/* ==========================================================================
   CLIENT ACCOUNT FORMS: profile, account, platform review, report, dispute
   Saved values override the demo defaults only after someone saves.
   ========================================================================== */

/** The saved client profile (or null). */
function tt_client_profile()
{
    $u = tt_current_user();
    if (!$u) { return null; }
    $stmt = db()->prepare('SELECT * FROM client_profiles WHERE user_id = ?');
    $stmt->execute([(int) $u['id']]);
    return $stmt->fetch() ?: null;
}

/** A profile value: the saved one if it has been saved, otherwise the default. */
function tt_pv($key, $default)
{
    $p = tt_client_profile();
    if ($p && array_key_exists($key, $p) && $p[$key] !== null) { return $p[$key]; }
    return $default;
}

/** Saves the personal and business details. Returns null or an error. */
function tt_save_client_profile($data)
{
    $u = tt_current_user();
    $name = trim($data['full_name'] ?? '');
    if ($name === '') { return 'Enter your full name.'; }
    if (!tt_is_demo_user($u)) { db()->prepare('UPDATE users SET name = ? WHERE id = ?')->execute([$name, (int) $u['id']]); }
    $_SESSION['user']['name'] = $name;
    db()->prepare('INSERT INTO client_profiles (user_id, company, location, phone, about, address, tin)
                   VALUES (?, ?, ?, ?, ?, ?, ?)
                   ON DUPLICATE KEY UPDATE company = VALUES(company), location = VALUES(location), phone = VALUES(phone),
                                           about = VALUES(about), address = VALUES(address), tin = VALUES(tin)')
        ->execute([(int) $u['id'], trim($data['company'] ?? ''), trim($data['location'] ?? ''), trim($data['contact'] ?? ''),
                   trim($data['about'] ?? ''), trim($data['address'] ?? ''), trim($data['tin'] ?? '')]);
    return null;
}

/** Changes the name and email. Demo accounts keep their email. Returns null or an error. */
function tt_update_account($name, $email)
{
    $u = tt_current_user();
    $name = trim($name); $email = trim($email);
    if ($name === '')                                   { return 'Enter your name.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))     { return 'Enter a valid email address.'; }
    if (tt_is_demo_account() && strcasecmp($email, $u['email']) !== 0) { return 'The demo account email cannot be changed.'; }
    $other = tt_find_user_by_email($email);
    if ($other && (int) $other['id'] !== (int) $u['id']) { return 'Another account already uses that email.'; }
    if (!tt_is_demo_user($u)) { db()->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?')->execute([$name, $email, (int) $u['id']]); }
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    return null;
}

/** Changes the password. Returns null or an error. */
function tt_change_password($current, $new, $confirm)
{
    $u = tt_current_user();
    $stmt = db()->prepare('SELECT password_hash FROM users WHERE id = ?');
    $stmt->execute([(int) $u['id']]);
    $hash = $stmt->fetchColumn();
    if (!password_verify($current, $hash))                 { return 'Your current password is not correct.'; }
    if (strlen($new) < 8 || !preg_match('/\d/', $new))     { return 'The new password must be at least 8 characters and include a number.'; }
    if ($new !== $confirm)                                 { return 'The new passwords do not match.'; }
    if (!tt_is_demo_user($u)) { db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?')->execute([password_hash($new, PASSWORD_DEFAULT), (int) $u['id']]); }
    return null;
}

/** The signed-in user's platform review (or null). */
function tt_my_platform_review()
{
    $u = tt_current_user();
    if (!$u) { return null; }
    $stmt = db()->prepare('SELECT rating, body, status FROM platform_reviews WHERE user_id = ?');
    $stmt->execute([(int) $u['id']]);
    return $stmt->fetch() ?: null;
}

/** Saves (or updates) the platform review. Returns null or an error. */
function tt_save_platform_review($rating, $body)
{
    $u = tt_current_user();
    $body = trim($body);
    if ($rating < 1 || $rating > 5) { return 'Choose a rating from 1 to 5.'; }
    if (mb_strlen($body) < 20)      { return 'Write at least 20 characters.'; }
    db()->prepare("INSERT INTO platform_reviews (user_id, rating, body, status) VALUES (?, ?, ?, 'new')
                   ON DUPLICATE KEY UPDATE rating = VALUES(rating), body = VALUES(body), status = 'new'")
        ->execute([(int) $u['id'], (int) $rating, $body]);
    return null;
}

/** Saves a report about a user, a message or a project. */
function tt_db_report($type, $reason, $details, $reported_user_id = null)
{
    $u = tt_current_user();
    $type = in_array(strtolower($type), ['user', 'project', 'message', 'review'], true) ? strtolower($type) : 'user';
    $details = trim($details);
    if (mb_strlen($details) < 10) { return 'Describe what happened (at least 10 characters).'; }
    $reported_user_id = (int) $reported_user_id;
    if ($type === 'user' && $reported_user_id > 0) {
        $target = db()->prepare("SELECT id FROM users WHERE id = ? AND role <> ? AND status = 'active'");
        $target->execute([$reported_user_id, $u['role']]);
        if (!$target->fetchColumn()) { return 'Choose an active user to report.'; }
    } else {
        $reported_user_id = null;
    }
    db()->prepare('INSERT INTO reports (reporter_id, reported_user_id, type, reason, details) VALUES (?, ?, ?, ?, ?)')
        ->execute([(int) $u['id'], $reported_user_id, $type, $reason, $details]);
    $GLOBALS['tt_last'] = ['type' => 'report', 'id' => (int) db()->lastInsertId()];
    return null;
}

/** Files a dispute. Posted projects are stored as disputes; sample projects are stored as project reports. */
function tt_db_dispute($site_id, $sample_title, $reason, $details)
{
    $u = tt_current_user();
    if (mb_strlen(trim($details)) < 10) { return 'Describe what happened (at least 10 characters).'; }
    $project = $site_id >= 1000 ? tt_db_project($site_id) : null;
    if ($project) {
        $mine = (int) $project['client_id'] === (int) $u['id'] || (int) $project['freelancer_id'] === (int) $u['id'];
        if (!$mine) { return 'This project is not yours.'; }
        db()->prepare('INSERT INTO disputes (project_id, filed_by, reason, details) VALUES (?, ?, ?, ?)')
            ->execute([(int) $project['id'], (int) $u['id'], $reason, trim($details)]);
        $GLOBALS['tt_last'] = ['type' => 'dispute', 'id' => (int) db()->lastInsertId()];
        return null;
    }
    db()->prepare("INSERT INTO reports (reporter_id, type, reason, details) VALUES (?, 'project', ?, ?)")
        ->execute([(int) $u['id'], 'Dispute: ' . $reason, '[' . $sample_title . '] ' . trim($details)]);
    $GLOBALS['tt_last'] = ['type' => 'report', 'id' => (int) db()->lastInsertId()];
    return null;
}


/* ==========================================================================
   FILE UPLOADS: attachments, profile photos and access checks
   ========================================================================== */

/** Saves the files from tt_handle_uploads() against an owner (project, report, dispute, deliverable, portfolio). */
function tt_save_attachments($type, $owner_id, $files, $label = null, $category = null)
{
    if (!$files) { return; }
    $u = tt_current_user();
    $stmt = db()->prepare('INSERT INTO attachments (owner_type, owner_id, user_id, label, category, original_name, stored_name, size_label, file_type)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    foreach ($files as $f) {
        $stmt->execute([$type, (int) $owner_id, (int) $u['id'], $label, $category, $f['name'], $f['stored'], $f['size'], $f['type']]);
    }
}

/** The files of one owner, oldest first. */
function tt_attachments($type, $owner_id)
{
    $stmt = db()->prepare('SELECT id, original_name AS name, stored_name AS stored, size_label AS size, file_type AS type, label, category
                           FROM attachments WHERE owner_type = ? AND owner_id = ? ORDER BY id');
    $stmt->execute([$type, (int) $owner_id]);
    return $stmt->fetchAll();
}

/** Project files for every project, keyed by the site project id. */
function tt_project_files_map()
{
    static $map = null;
    if ($map !== null) { return $map; }
    $map = [];
    foreach (db()->query("SELECT id, owner_id, original_name AS name, stored_name AS stored, size_label AS size, file_type AS type
                          FROM attachments WHERE owner_type = 'project' ORDER BY id")->fetchAll() as $f) {
        $map[(int) $f['owner_id']][] = $f;
    }
    return $map;
}

/** Whether the signed-in user may open a stored file. */
function tt_can_download($file_id)
{
    $u = tt_current_user();
    if (!$u) { return null; }
    $stmt = db()->prepare('SELECT * FROM attachments WHERE id = ?');
    $stmt->execute([(int) $file_id]);
    $f = $stmt->fetch();
    if (!$f) { return null; }
    $me = (int) $u['id'];
    if ($u['role'] === 'admin' || (int) $f['user_id'] === $me) { return $f; }
    if ($f['owner_type'] === 'portfolio') { return $f; }                 // portfolio samples are shown to signed-in users
    if (in_array($f['owner_type'], ['project', 'deliverable'], true)) {
        $project = tt_db_project((int) $f['owner_id']);
        if ($project && ((int) $project['client_id'] === $me || (int) $project['freelancer_id'] === $me)) { return $f; }
        if ($project && $f['owner_type'] === 'project' && $u['role'] === 'freelancer' && $project['status'] === 'open') { return $f; }
    }
    if ($f['owner_type'] === 'dispute') {
        $stmt = db()->prepare('SELECT p.client_id, p.freelancer_id FROM disputes d JOIN projects p ON p.id = d.project_id WHERE d.id = ?');
        $stmt->execute([(int) $f['owner_id']]);
        $row = $stmt->fetch();
        if ($row && ((int) $row['client_id'] === $me || (int) $row['freelancer_id'] === $me)) { return $f; }
    }
    return null;
}

/** Saves a profile photo (JPG or PNG, up to 5 MB) for the signed-in user. Returns null or an error. */
function tt_save_photo()
{
    $u = tt_current_user();
    if (empty($_FILES['photo']['name']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) { return 'Choose a JPG or PNG photo.'; }
    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png'], true)) { return 'The photo must be a JPG or PNG file.'; }
    if ((int) $_FILES['photo']['size'] > 5 * 1024 * 1024) { return 'The photo is larger than 5 MB.'; }
    $info = @getimagesize($_FILES['photo']['tmp_name']);
    if (!$info) { return 'That file is not a valid image.'; }
    $dir = dirname(__DIR__) . '/storage/uploads';
    if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
    if (!is_dir($dir) || !is_writable($dir)) { return tt_storage_message($dir); }
    $stored = 'photo-' . bin2hex(random_bytes(8)) . '.' . ($ext === 'png' ? 'png' : 'jpg');
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $dir . '/' . $stored)) { return 'Could not save the photo.'; }
    if ($u['role'] === 'freelancer') {
        db()->prepare('INSERT INTO freelancer_profiles (user_id, photo) VALUES (?, ?) ON DUPLICATE KEY UPDATE photo = VALUES(photo)')
            ->execute([(int) $u['id'], $stored]);
    } else {
        db()->prepare('INSERT INTO client_profiles (user_id, photo) VALUES (?, ?) ON DUPLICATE KEY UPDATE photo = VALUES(photo)')
            ->execute([(int) $u['id'], $stored]);
    }
    return null;
}

/** The stored photo name for a user, or null. */
function tt_user_photo($user_id, $role)
{
    $table = $role === 'freelancer' ? 'freelancer_profiles' : 'client_profiles';
    $stmt = db()->prepare("SELECT photo FROM $table WHERE user_id = ?");
    $stmt->execute([(int) $user_id]);
    $v = $stmt->fetchColumn();
    return $v ?: null;
}

/** A file name that links to the download page (real uploads), or plain text (sample files). */
function tt_file_name_html($f, $base)
{
    if (!empty($f['id'])) {
        return '<a href="' . e($base) . 'download.php?file=' . (int) $f['id'] . '">' . e($f['name']) . '</a>';
    }
    return '<span>' . e($f['name']) . '</span>';
}


/** The message shown when the uploads folder cannot be written to. */
function tt_storage_message($dir)
{
    return 'The uploads folder cannot be written to: ' . $dir . '. Give Apache permission to write there (see the setup note), then try again.';
}

/** Removes the signed-in user's profile photo (the default avatar comes back). */
function tt_remove_photo()
{
    $u = tt_current_user();
    $photo = tt_user_photo((int) $u['id'], $u['role']);
    if ($photo) {
        $path = dirname(__DIR__) . '/storage/uploads/' . basename($photo);
        if (is_file($path)) { @unlink($path); }
    }
    $table = $u['role'] === 'freelancer' ? 'freelancer_profiles' : 'client_profiles';
    db()->prepare("UPDATE $table SET photo = NULL WHERE user_id = ?")->execute([(int) $u['id']]);
}


/* ==========================================================================
   MESSAGES AND NOTIFICATIONS (demo + real). The demo lists come first
   unchanged; real conversations and notifications from the database are added.
   ========================================================================== */

function toptunity_client_threads()
{
    return array_merge(tt_apply_demo_thread_read(toptunity_client_threads_demo()), tt_real_threads('client'));
}

function toptunity_freelancer_threads()
{
    return array_merge(tt_apply_demo_thread_read(toptunity_freelancer_threads_demo()), tt_real_threads('freelancer'));
}

function toptunity_client_notifications_all()
{
    return array_merge(tt_real_notifications(), tt_apply_demo_notification_read(tt_is_demo_account() ? toptunity_client_notifications_all_demo() : []));
}

function toptunity_freelancer_notifications()
{
    return array_merge(tt_real_notifications(), tt_apply_demo_notification_read(tt_is_demo_freelancer() ? toptunity_freelancer_notifications_demo() : []));
}

/** Read state of the demo conversations for this session (not saved to the database). */
function tt_thread_key($t)
{
    return ($t['name'] ?? '') . '|' . ($t['project_id'] ?? 0);
}

function tt_demo_session_key()
{
    $u = tt_current_user();
    return 'demo_' . (int) ($u['id'] ?? 0);
}

function tt_apply_demo_thread_read($list)
{
    $read = $_SESSION[tt_demo_session_key()]['read'] ?? [];
    foreach ($list as $i => $t) {
        if (!empty($read[tt_thread_key($t)])) { $list[$i]['unread'] = false; }
    }
    return $list;
}

function tt_mark_demo_thread_read($thread)
{
    $_SESSION[tt_demo_session_key()]['read'][tt_thread_key($thread)] = true;
}

/** Demo notifications become read after "Mark all as read" in this session. */
function tt_apply_demo_notification_read($list)
{
    $sess = $_SESSION[tt_demo_session_key()] ?? [];
    foreach ($list as $i => $n) {
        $key = tt_notification_key($n);
        $list[$i]['key'] = $key;
        if (empty($list[$i]['real']) && (!empty($sess['notif_all']) || !empty($sess['notif_read'][$key]))) {
            $list[$i]['new'] = false;
        }
    }
    return $list;
}

function tt_mark_demo_notifications_read()
{
    $_SESSION[tt_demo_session_key()]['notif_all'] = time();
}

/** Real conversations for the signed-in user (partners they have messaged, or the one in ?with=). */
function tt_real_threads($role)
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== $role) { return []; }
    $me = (int) $u['id'];
    $pdo = db();
    $partners = [];
    $stmt = $pdo->prepare('SELECT DISTINCT IF(sender_id = ?, receiver_id, sender_id) AS partner FROM messages WHERE sender_id = ? OR receiver_id = ?');
    $stmt->execute([$me, $me, $me]);
    foreach ($stmt->fetchAll() as $r) { $partners[] = (int) $r['partner']; }
    if (isset($_GET['with']) && (int) $_GET['with'] > 0 && !in_array((int) $_GET['with'], $partners, true)) {
        $partners[] = (int) $_GET['with'];
    }
    $threads = [];
    foreach ($partners as $pid) {
        $pu = $pdo->prepare('SELECT id, name, role FROM users WHERE id = ?');
        $pu->execute([$pid]);
        $other = $pu->fetch();
        if (!$other || $other['role'] === $role) { continue; }
        $ms = $pdo->prepare('SELECT m.*, p.title FROM messages m LEFT JOIN projects p ON p.id = m.project_id
                             WHERE (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?)
                             ORDER BY m.id');
        $ms->execute([$me, $pid, $pid, $me]);
        $rows = $ms->fetchAll();
        $messages = [];
        $unread = 0; $project = ''; $project_id = 0;
        foreach ($rows as $r) {
            $messages[] = ['from' => (int) $r['sender_id'] === $me ? 'me' : 'them', 'text' => $r['body'],
                           'time' => date('M d, g:i A', strtotime($r['created_at']))];
            if ((int) $r['receiver_id'] === $me && !(int) $r['is_read']) { $unread++; }
            if (!empty($r['title'])) { $project = $r['title']; $project_id = 1000 + (int) $r['project_id']; }
        }
        $last = $rows ? end($rows) : null;
        $threads[] = [
            'name' => $other['name'], 'project' => $project ?: 'Direct message', 'project_id' => $project_id,
            'preview' => $last ? $last['body'] : 'Start the conversation.',
            'time' => $last ? date('M d', strtotime($last['created_at'])) : 'Now',
            'unread' => $unread > 0, 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short',
            'messages' => $messages, 'real' => true, 'with' => $pid,
        ];
    }
    return $threads;
}

/** Sends a message to another user. Returns null or an error. */
function tt_send_message($receiver_id, $body)
{
    $u = tt_current_user();
    $body = trim($body);
    if ($body === '')          { return 'Write a message first.'; }
    if (mb_strlen($body) > 2000) { return 'Messages can be up to 2000 characters.'; }
    db()->prepare('INSERT INTO messages (sender_id, receiver_id, body) VALUES (?, ?, ?)')
        ->execute([(int) $u['id'], (int) $receiver_id, $body]);
    tt_notify($receiver_id, 'messages', 'New message', $u['name'] . ' sent you a message.');
    return null;
}

/** Marks the messages from one partner as read. */
function tt_mark_thread_read($partner_id)
{
    $u = tt_current_user();
    db()->prepare('UPDATE messages SET is_read = 1 WHERE receiver_id = ? AND sender_id = ?')
        ->execute([(int) $u['id'], (int) $partner_id]);
}

/** Real notifications for the signed-in user, newest first. */
function tt_real_notifications()
{
    $u = tt_current_user();
    if (!$u) { return []; }
    $icons = ['proposals' => ['file', 'blue'], 'responses' => ['users', 'teal'], 'offers' => ['briefcase', 'orange'],
              'payments' => ['wallet', 'teal'], 'messages' => ['message', 'blue'], 'worklog' => ['check-circle', 'teal']];
    $stmt = db()->prepare('SELECT * FROM notifications WHERE user_id = ? ORDER BY id DESC LIMIT 50');
    $stmt->execute([(int) $u['id']]);
    $out = [];
    foreach ($stmt->fetchAll() as $n) {
        $ic = $icons[$n['category']] ?? ['bell', 'slate'];
        $out[] = ['cat' => $n['category'], 'icon' => $ic[0], 'tint' => $ic[1], 'new' => !(int) $n['is_read'],
                  'title' => $n['title'], 'text' => $n['body'], 'time' => date('M d, g:i A', strtotime($n['created_at'])), 'real' => true,
                  'id' => (int) $n['id'], 'key' => tt_notification_key(['cat' => $n['category'], 'title' => $n['title']])];
    }
    return $out;
}

/** Marks all of the signed-in user's notifications as read. */
function tt_mark_all_read()
{
    $u = tt_current_user();
    db()->prepare('UPDATE notifications SET is_read = 1 WHERE user_id = ?')->execute([(int) $u['id']]);
}

/** The page a notification opens, by the role and the notification category. Empty = not clickable. */
function tt_notification_link($role, $cat)
{
    $map = [
        'client' => [
            'proposals' => 'my-projects.php', 'responses' => 'my-projects.php', 'messages' => 'messages.php',
            'payments' => 'billing.php', 'refunds' => 'billing.php', 'deadline' => 'my-projects.php',
            'deadlines' => 'my-projects.php', 'hours' => 'my-projects.php', 'work' => 'my-projects.php',
        ],
        'freelancer' => [
            'offers' => 'my-projects.php', 'worklog' => 'my-projects.php', 'revisions' => 'my-projects.php',
            'deadlines' => 'my-projects.php', 'messages' => 'messages.php', 'payments' => 'earnings.php',
            'withdrawals' => 'earnings.php', 'proposals' => 'my-proposals.php', 'responses' => 'my-proposals.php',
        ],
        'admin' => [
            'past' => 'project-moderation.php', 'reports' => 'reported-content.php', 'disputes' => 'dispute-management.php',
            'withdrawals' => 'withdrawal-requests.php', 'inquiries' => 'contact-inquiries.php', 'reviews' => 'platform-reviews.php',
        ],
    ];
    return $map[$role][$cat] ?? '';
}


/** A stable key for a notification (used by the links that open it). */
function tt_notification_key($n)
{
    return md5(($n['cat'] ?? '') . '|' . ($n['title'] ?? ''));
}

function toptunity_admin_notifications()
{
    $demo_notifications = tt_is_demo_admin() ? toptunity_admin_notifications_base() : [];
    return tt_apply_demo_notification_read(array_merge(tt_real_notifications(), $demo_notifications));
}

/** Opens a notification: marks it read (saved for real ones, this session for demo ones) and returns the page to open. */
function tt_open_notification($key, $role)
{
    $items = $role === 'client' ? toptunity_client_notifications_all()
           : ($role === 'freelancer' ? toptunity_freelancer_notifications() : toptunity_admin_notifications());
    foreach ($items as $n) {
        if (tt_notification_key($n) !== $key) { continue; }
        if (!empty($n['real']) && isset($n['id'])) {
            db()->prepare('UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?')
                ->execute([(int) $n['id'], (int) tt_current_user()['id']]);
        } else {
            $_SESSION[tt_demo_session_key()]['notif_read'][$key] = true;
        }
        return tt_notification_link($role, $n['cat']);
    }
    return '';
}

/** Real proposals of the signed-in freelancer, in the shape the dashboard table uses. */
function tt_freelancer_db_proposal_rows()
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'freelancer') { return []; }
    $stmt = db()->prepare("SELECT pr.id, pr.days, pr.offer, pr.status, pr.created_at, p.id AS pid, p.title, p.billing_type,
                                  p.client_id, u.name AS client
                           FROM proposals pr JOIN projects p ON p.id = pr.project_id JOIN users u ON u.id = p.client_id
                           WHERE pr.freelancer_id = ? ORDER BY pr.id DESC");
    $stmt->execute([(int) $u['id']]);
    $out = [];
    foreach ($stmt->fetchAll() as $r) {
        $out[] = ['key' => 'r' . $r['id'], 'id' => (int) $r['id'], 'project_id' => 1000 + (int) $r['pid'], 'client_id' => (int) $r['client_id'],
                  'title' => $r['title'], 'client' => $r['client'], 'type' => $r['billing_type'], 'offer' => (int) $r['offer'],
                  'days' => (int) $r['days'], 'status' => $r['status'], 'sent' => $r['created_at'], 'real' => true];
    }
    return $out;
}

/** Real ongoing projects of the signed-in freelancer, in the shape the dashboard list uses. */
function tt_freelancer_db_ongoing_rows()
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'freelancer') { return []; }
    $stmt = db()->prepare("SELECT p.title, p.deadline, p.status, u.name AS client
                           FROM projects p JOIN users u ON u.id = p.client_id
                           WHERE p.freelancer_id = ? AND p.status IN ('ongoing', 'overdue') ORDER BY p.id DESC");
    $stmt->execute([(int) $u['id']]);
    $out = [];
    foreach ($stmt->fetchAll() as $r) {
        $out[] = ['title' => $r['title'], 'client' => $r['client'], 'deadline' => $r['deadline'], 'status' => $r['status'], 'progress' => 0];
    }
    return $out;
}

/** Accepted database projects of the signed-in freelancer, in the My Projects shape. */
function tt_freelancer_db_project_rows()
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'freelancer') { return []; }
    $stmt = db()->prepare("SELECT p.id, p.title, p.description, p.billing_type, p.budget, p.hourly_rate, p.max_hours,
                                  p.deadline, p.status, p.start_date, p.created_at, c.name AS category, client.name AS client,
                                  cp.company AS client_company
                           FROM projects p
                           JOIN users client ON client.id = p.client_id
                           LEFT JOIN client_profiles cp ON cp.user_id = client.id
                           LEFT JOIN categories c ON c.id = p.category_id
                           WHERE p.freelancer_id = ? AND p.contract_status IN ('active', 'completed')
                           ORDER BY p.id DESC");
    $stmt->execute([(int) $u['id']]);
    $out = [];
    foreach ($stmt->fetchAll() as $r) {
        $out[] = [
            'id' => 1000 + (int) $r['id'],
            'project_id' => 1000 + (int) $r['id'],
            'title' => $r['title'],
            'client' => $r['client'],
            'client_company' => $r['client_company'] ?: '',
            'category' => $r['category'] ?: 'Web Development',
            'status' => $r['status'],
            'type' => $r['billing_type'],
            'budget' => (int) $r['budget'],
            'rate' => (int) $r['hourly_rate'],
            'max_hours' => (int) $r['max_hours'],
            'start' => $r['start_date'] ?: substr($r['created_at'], 0, 10),
            'deadline' => $r['deadline'],
            'progress' => $r['status'] === 'completed' ? 100 : 0,
            'intro' => $r['description'],
            'real' => true,
        ];
    }
    return $out;
}

/* ==========================================================================
   FREELANCER ACCOUNT FORMS: profile, skills, platform review, account
   Saved values replace the demo defaults only after someone saves.
   ========================================================================== */

/** The saved freelancer profile (or null). */
function tt_freelancer_profile()
{
    $u = tt_current_user();
    if (!$u) { return null; }
    $stmt = db()->prepare('SELECT * FROM freelancer_profiles WHERE user_id = ?');
    $stmt->execute([(int) $u['id']]);
    return $stmt->fetch() ?: null;
}

/** Puts the saved profile values over the form defaults (only the ones that were saved). */
function tt_apply_profile_form($form)
{
    $fp = tt_freelancer_profile();
    if (!$fp) { return $form; }
    $map = ['title' => 'title', 'location' => 'location', 'contact' => 'phone', 'rate' => 'hourly_rate',
            'languages' => 'languages', 'about' => 'about'];
    foreach ($map as $key => $col) {
        if (isset($fp[$col]) && $fp[$col] !== null) { $form[$key] = (string) $fp[$col]; }
    }
    return $form;
}

/** Saves the freelancer profile and the name. */
function tt_save_freelancer_profile($d)
{
    $u = tt_current_user();
    $name = trim($d['name'] ?? '');
    if ($name !== '') {
        if (!tt_is_demo_user($u)) { db()->prepare('UPDATE users SET name = ? WHERE id = ?')->execute([$name, (int) $u['id']]); }
        $_SESSION['user']['name'] = $name;
    }
    db()->prepare('INSERT INTO freelancer_profiles (user_id, title, location, phone, hourly_rate, languages, about)
                   VALUES (?, ?, ?, ?, ?, ?, ?)
                   ON DUPLICATE KEY UPDATE title = VALUES(title), location = VALUES(location), phone = VALUES(phone),
                                           hourly_rate = VALUES(hourly_rate), languages = VALUES(languages), about = VALUES(about)')
        ->execute([(int) $u['id'], trim($d['title'] ?? ''), trim($d['location'] ?? ''), trim($d['contact'] ?? ''),
                   (int) ($d['rate'] ?? 0), trim($d['languages'] ?? ''), trim($d['about'] ?? '')]);
}

/** The saved skills of the signed-in freelancer, or null if none were saved yet. */
function tt_freelancer_saved_skills()
{
    $u = tt_current_user();
    if (!$u) { return null; }
    $stmt = db()->prepare('SELECT s.name FROM freelancer_skills fs JOIN skills s ON s.id = fs.skill_id WHERE fs.freelancer_id = ? ORDER BY s.name');
    $stmt->execute([(int) $u['id']]);
    $rows = $stmt->fetchAll();
    return $rows ? array_column($rows, 'name') : null;
}

/** Saves the freelancer's skills (replaces the previous list). */
function tt_save_freelancer_skills($names)
{
    $u = tt_current_user();
    $pdo = db();
    $pdo->beginTransaction();
    $pdo->prepare('DELETE FROM freelancer_skills WHERE freelancer_id = ?')->execute([(int) $u['id']]);
    foreach ($names as $name) {
        $name = trim($name);
        if ($name === '') { continue; }
        $pdo->prepare('INSERT IGNORE INTO skills (name) VALUES (?)')->execute([$name]);
        $sk = $pdo->prepare('SELECT id FROM skills WHERE name = ?');
        $sk->execute([$name]);
        $pdo->prepare('INSERT IGNORE INTO freelancer_skills (freelancer_id, skill_id) VALUES (?, ?)')
            ->execute([(int) $u['id'], (int) $sk->fetchColumn()]);
    }
    $pdo->commit();
}


/** Removes one of the signed-in freelancer's real portfolio samples (row and file). */
function tt_portfolio_remove_real($id)
{
    $u = tt_current_user();
    $stmt = db()->prepare("SELECT stored_name FROM attachments WHERE id = ? AND user_id = ? AND owner_type = 'portfolio'");
    $stmt->execute([(int) $id, (int) $u['id']]);
    $stored = $stmt->fetchColumn();
    if ($stored === false) { return; }
    db()->prepare('DELETE FROM attachments WHERE id = ?')->execute([(int) $id]);
    $path = dirname(__DIR__) . '/storage/uploads/' . basename($stored);
    if (is_file($path)) { @unlink($path); }
}

/** Changes the title and category of one of the signed-in freelancer's real portfolio samples. */
function tt_portfolio_update_real($id, $title, $category)
{
    $u = tt_current_user();
    db()->prepare("UPDATE attachments SET label = ?, category = ? WHERE id = ? AND user_id = ? AND owner_type = 'portfolio'")
        ->execute([trim($title), $category, (int) $id, (int) $u['id']]);
}


/* ==========================================================================
   SAMPLE vs REAL. Signed-in real accounts see only real records.
   Visitors and the demo accounts also see the sample data.
   ========================================================================== */

/** True when the sample data may be shown: visitors and the demo accounts. */
function tt_show_sample()
{
    $u = tt_current_user();
    return !$u || tt_is_demo_user($u);
}

/** Real freelancers (keys are 5000 + user id so they never clash with the sample ids). */
function tt_real_freelancers()
{
    $palette = [['#CCFBF1', '#1E293B', 'short'], ['#FFEDD5', '#1E293B', 'long'], ['#E0E7FF', '#1E293B', 'short'], ['#FEF9C3', '#1E293B', 'long']];
    // the demo accounts are shown only to the demo accounts
    $demo_mail = "'andrea.santos@kapelokal.ph','miguel.reyes@example.com'";
    $hide = tt_is_demo_user(tt_current_user()) || !tt_current_user() ? '' : " AND u.email NOT IN ($demo_mail)";
    $rows = db()->query("SELECT u.id, u.name, u.avatar, fp.title, fp.location, fp.hourly_rate, fp.about, fp.languages, fp.photo,
                                (SELECT COUNT(*) FROM projects p WHERE p.freelancer_id = u.id AND p.status = 'completed') AS completed
                         FROM users u LEFT JOIN freelancer_profiles fp ON fp.user_id = u.id
                         WHERE u.role = 'freelancer' AND u.status = 'active'$hide ORDER BY u.id")->fetchAll();
    $out = [];
    foreach ($rows as $r) {
        $skills = db()->prepare('SELECT s.name FROM freelancer_skills fs JOIN skills s ON s.id = fs.skill_id WHERE fs.freelancer_id = ? ORDER BY s.name');
        $skills->execute([(int) $r['id']]);
        $pal = $palette[((int) $r['id']) % 4];
        $key = 5000 + (int) $r['id'];
        $portfolio = [];
        foreach (tt_attachments('portfolio', (int) $r['id']) as $i => $item) {
            $portfolio[] = [
                'id' => (int) $item['id'],
                'title' => $item['label'] ?: $item['name'],
                'category' => $item['category'] ?: 'Web Development',
                'tint' => ['#CCFBF1', '#FFEDD5', '#E0E7FF', '#FEF9C3'][$i % 4],
                'image' => $item['type'] === 'image',
            ];
        }
        $out[$key] = ['id' => $key, 'user_id' => (int) $r['id'], 'name' => $r['name'], 'title' => $r['title'] ?: 'Freelancer',
                      'location' => $r['location'] ?: '', 'rating' => 0, 'reviews' => 0,
                      'completed' => (int) $r['completed'], 'ontime' => 'Not rated',
                      'rate' => (int) ($r['hourly_rate'] ?: 0),
                      'skills' => array_column($skills->fetchAll(), 'name'),
                      'about' => preg_split('/\R+/', trim((string) $r['about']), -1, PREG_SPLIT_NO_EMPTY),
                      'bio' => trim((string) $r['about']), 'portfolio' => $portfolio, 'reviews' => [], 'feedback' => [], 'available' => true,
                      'since' => 'Registered', 'bg' => $pal[0], 'hair' => $pal[1], 'style' => $pal[2],
                      'photo' => $r['photo'] ?: null, 'avatar' => $r['avatar'] ?: null, 'real' => true];
    }
    return $out;
}

/** Freelancers shown across the site: sample (visitors and demo accounts) plus the real ones. */
function toptunity_freelancers()
{
    return (tt_show_sample() ? toptunity_freelancers_sample() : []) + tt_real_freelancers();
}

/** Real open projects in the listing shape. */
function tt_real_listing()
{
    $out = [];
    foreach (tt_load_saved_projects() as $sp) {
        if ($sp['status'] !== 'open') { continue; }
        $out[$sp['id']] = ['id' => $sp['id'], 'title' => $sp['title'], 'category' => $sp['category'], 'client' => 'Client',
                           'type' => $sp['type'], 'amount' => $sp['type'] === 'hourly' ? $sp['rate'] : $sp['budget'],
                           'deadline' => $sp['deadline'], 'proposals' => $sp['proposals'], 'status' => 'open', 'age_h' => 0,
                           'match' => 0, 'skills' => $sp['skills'], 'desc' => $sp['intro'], 'real' => true];
    }
    return $out;
}

/** Projects shown in the listings: sample (visitors and demo accounts) plus the real open ones. */
function toptunity_listing()
{
    return array_reverse(tt_real_listing(), true) + (tt_show_sample() ? toptunity_listing_sample() : []);
}

/** Sample threads only for the demo accounts; real accounts get their real conversations only. */
function toptunity_client_threads_demo()
{
    return tt_is_demo_account() ? toptunity_client_threads_demo_base() : [];
}

function toptunity_freelancer_threads_demo()
{
    return tt_is_demo_freelancer() ? toptunity_freelancer_threads_demo_base() : [];
}

/** A single freelancer: sample ids, or a real one (5000 + user id). */
function toptunity_freelancer($id)
{
    $all = toptunity_freelancers();
    return isset($all[$id]) ? $all[$id] : null;
}

/** Real clients a freelancer has a contract with (for the report and dispute pages). */
function tt_contracted_clients_for_freelancer()
{
    $u = tt_current_user();
    if (!$u) { return []; }
    $stmt = db()->prepare('SELECT DISTINCT u.id, u.name FROM projects p JOIN users u ON u.id = p.client_id
                           WHERE p.freelancer_id = ? ORDER BY u.name');
    $stmt->execute([(int) $u['id']]);
    return $stmt->fetchAll();
}

/** Real freelancers a client has a contract with (for the report and dispute pages). */
function tt_contracted_freelancers_for_client()
{
    $u = tt_current_user();
    if (!$u) { return []; }
    $stmt = db()->prepare('SELECT DISTINCT u.id, u.name FROM projects p JOIN users u ON u.id = p.freelancer_id
                           WHERE p.client_id = ? AND p.freelancer_id IS NOT NULL ORDER BY u.name');
    $stmt->execute([(int) $u['id']]);
    return $stmt->fetchAll();
}

/** The profile photo or the default avatar for the signed-in user (used in the top bar). */
function tt_avatar_html($me, $size, $base)
{
    $u = tt_current_user();
    if ($u) {
        if ($u['role'] === 'admin') {
            $asset = tt_user_avatar_asset((int) $u['id']);
            if ($asset) {
                return tt_avatar_image_html($asset, $size, $base, $me['name'] ?? 'Administrator avatar', true);
            }
        }
        $photo = tt_user_photo((int) $u['id'], $u['role']);
        if ($photo) {
            return '<img src="' . e($base) . 'download.php?photo=' . (int) $u['id'] . '" alt="" style="width:' . (int) $size . 'px; height:' . (int) $size . 'px; border-radius:50%; object-fit:cover; flex-shrink:0;">';
        }
        $asset = tt_user_avatar_asset((int) $u['id']);
        if ($asset) {
            return tt_avatar_image_html($asset, $size, $base, $me['name'] ?? 'User avatar', $u['role'] === 'admin');
        }
    }
    return avatar($me['bg'], $me['hair'], $me['style'], $size);
}

/** A freelancer's uploaded photo or illustrated avatar for profile and listing views. */
function tt_freelancer_avatar_html($freelancer, $size, $base)
{
    $freelancer = array_merge(['bg' => '#E0E7FF', 'hair' => '#1E293B', 'style' => 'short', 'name' => ''], (array) $freelancer);
    if (!empty($freelancer['real']) && !empty($freelancer['photo']) && !empty($freelancer['user_id'])) {
        return '<img src="' . e($base) . 'download.php?photo=' . (int) $freelancer['user_id']
            . '&amp;v=' . rawurlencode((string) $freelancer['photo'])
            . '" alt="' . e($freelancer['name']) . '" style="width:' . (int) $size . 'px; height:' . (int) $size
            . 'px; border-radius:50%; object-fit:cover; flex-shrink:0;">';
    }
    $asset = !empty($freelancer['avatar']) ? tt_valid_avatar_asset($freelancer['avatar']) : null;
    $asset = $asset ?: tt_avatar_asset_for_name($freelancer['name'] ?? '');
    if ($asset) { return tt_avatar_image_html($asset, $size, $base, $freelancer['name'] ?? 'Freelancer avatar'); }
    return avatar($freelancer['bg'], $freelancer['hair'], $freelancer['style'], $size);
}

/** Checks a withdrawal account for its method. Returns null or an error. */
function tt_check_withdrawal_account($method, $account)
{
    if ($method === 'gcash') {
        if (!preg_match('/^09\d{9}$/', $account)) { return 'Enter a valid GCash number: 11 digits starting with 09.'; }
        return null;
    }
    $parts = explode(' · ', $account, 2);
    if (count($parts) !== 2 || trim($parts[0]) === '') { return 'Choose the bank.'; }
    if (!preg_match('/^\d{10,16}$/', $parts[1])) { return 'Enter the bank account number: 10 to 16 digits.'; }
    return null;
}

/** The signed-in user's own reports and disputes, in the shape the My Submissions table uses. */
function tt_my_submissions()
{
    $u = tt_current_user();
    if (!$u) { return []; }
    $out = [];
    $r = db()->prepare('SELECT details, reason, status, created_at FROM reports WHERE reporter_id = ? ORDER BY id DESC');
    $r->execute([(int) $u['id']]);
    foreach ($r->fetchAll() as $row) {
        $out[] = ['type' => 'Report', 'about' => mb_substr($row['details'], 0, 60), 'reason' => $row['reason'],
                  'date' => date('M d, Y', strtotime($row['created_at'])), 'status' => $row['status'] === 'pending' ? 'pending' : 'released'];
    }
    $d = db()->prepare('SELECT p.title, d.reason, d.status, d.created_at FROM disputes d JOIN projects p ON p.id = d.project_id
                        WHERE d.filed_by = ? ORDER BY d.id DESC');
    $d->execute([(int) $u['id']]);
    foreach ($d->fetchAll() as $row) {
        $out[] = ['type' => 'Dispute', 'about' => $row['title'], 'reason' => $row['reason'],
                  'date' => date('M d, Y', strtotime($row['created_at'])), 'status' => $row['status'] === 'open' ? 'pending' : 'released'];
    }
    return $out;
}

/** The real project a freelancer can review its client for (completed and theirs), or null. */
function tt_review_target($site_id)
{
    $u = tt_current_user();
    $p = tt_db_project($site_id);
    if (!$u || !$p || (int) $p['freelancer_id'] !== (int) $u['id'] || $p['status'] !== 'completed') { return null; }
    $stmt = db()->prepare('SELECT name FROM users WHERE id = ?');
    $stmt->execute([(int) $p['client_id']]);
    return ['project' => $p, 'client_id' => (int) $p['client_id'], 'client_name' => $stmt->fetchColumn()];
}

/** Saves the freelancer's review of a client (once per project). Returns null or an error. */
function tt_save_client_review($site_id, $rating, $body)
{
    $u = tt_current_user();
    $t = tt_review_target($site_id);
    if (!$t)                              { return 'This project cannot be reviewed.'; }
    if ($rating < 1 || $rating > 5)       { return 'Choose a rating from 1 to 5.'; }
    if (mb_strlen(trim($body)) < 10)      { return 'Write a review of at least 10 characters.'; }
    $check = db()->prepare('SELECT COUNT(*) FROM reviews WHERE reviewer_id = ? AND project_id = ? AND reviewee_id = ?');
    $check->execute([(int) $u['id'], (int) $t['project']['id'], $t['client_id']]);
    if ((int) $check->fetchColumn() > 0) { return 'You already reviewed this client for this project.'; }
    db()->prepare('INSERT INTO reviews (reviewer_id, reviewee_id, project_id, rating, body) VALUES (?, ?, ?, ?, ?)')
        ->execute([(int) $u['id'], $t['client_id'], (int) $t['project']['id'], (int) $rating, trim($body)]);
    return null;
}


/** Withdraws one of the signed-in freelancer's pending proposals (real ones are saved). */
function tt_withdraw_real_proposal($id)
{
    $u = tt_current_user();
    db()->prepare("UPDATE proposals SET status = 'withdrawn' WHERE id = ? AND freelancer_id = ? AND status = 'pending'")
        ->execute([(int) $id, (int) $u['id']]);
}