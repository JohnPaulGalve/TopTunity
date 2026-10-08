<?php
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

/** One project by id, or null if it doesn't exist. */
function toptunity_project($id)
{
    $all = toptunity_projects();
    return isset($all[$id]) ? $all[$id] : null;
}

/** Flat list in the shape browse-projects.php expects. */
function toptunity_listing()
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
function toptunity_freelancers()
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
function toptunity_freelancer($id)
{
    $all = toptunity_freelancers();
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