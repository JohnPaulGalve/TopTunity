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

/* ==========================================================================
   TESTIMONIALS
   role: 'client' | 'freelancer'
   ========================================================================== */
function toptunity_testimonials()
{
    return [
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

/* ==========================================================================
   CLIENT AREA (logged-in client: Andrea Santos)
   ========================================================================== */
function toptunity_current_client()
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
function toptunity_client_projects()
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
        'completed' => 'Completed', 'past' => 'Past Deadline', 'cancelled' => 'Cancelled',
    ];
    return isset($labels[$status]) ? $labels[$status] : ucfirst($status);
}

/** Payments and deposits for the current client. status: pending | held | released | refunded | paid */
function toptunity_client_payments()
{
    return [
        ['date' => '2026-10-02', 'project' => 'Monthly Social Media Content Calendar', 'type' => 'Deposit', 'amount' => 14000, 'status' => 'pending'],
        ['date' => '2026-09-14', 'project' => 'Point-of-Sale and Inventory Dashboard', 'type' => 'Deposit', 'amount' => 36000, 'status' => 'held'],
        ['date' => '2026-09-10', 'project' => 'Menu Board and Cup Sleeve Design', 'type' => 'Deposit', 'amount' => 6500, 'status' => 'held'],
        ['date' => '2026-09-04', 'project' => 'Product Photo Retouching', 'type' => 'Deposit', 'amount' => 5000, 'status' => 'released'],
        ['date' => '2026-08-31', 'project' => 'Barista Training Manual Layout', 'type' => 'Refund', 'amount' => 4000, 'status' => 'refunded'],
        ['date' => '2026-07-31', 'project' => 'Weekly Menu Social Posts (July)', 'type' => 'Hourly Billing', 'amount' => 8400, 'status' => 'paid'],
    ];
}

/** Recent notifications for the dashboard and notifications page. */
function toptunity_client_notifications()
{
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
    if ($id !== 2) { return null; }
    return [
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
    ];
}

/**
 * Details for a CLIENT project. Client IDs don't always match public IDs,
 * so match by title first; otherwise build the details from the client project itself.
 */
function toptunity_client_detail($id)
{
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

/** Freelancer ids the client has saved. */
function toptunity_saved_freelancer_ids()
{
    return [1, 2, 3, 5];
}

/** Full notification list. cat is used by the filter tabs. */
function toptunity_client_notifications_all()
{
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
function toptunity_client_threads()
{
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