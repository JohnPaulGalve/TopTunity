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
    return [];
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
    return [];
}

/* ==========================================================================
   FREELANCERS
   Used by browse-freelancers.php and freelancer-profile.php.
   ========================================================================== */
function toptunity_freelancers_sample()
{
    return [];
}


/** Find a freelancer by full name (used by links from the homepage). */
function toptunity_freelancer_by_name($name)
{
    return [];
}

/* ==========================================================================
   TESTIMONIALS
   role: 'client' | 'freelancer'
   ========================================================================== */
function toptunity_testimonials()
{
    $tpal = [['#FFEDD5', '#1E293B', 'long'], ['#CCFBF1', '#1E293B', 'short'], ['#DBEAFE', '#1E293B', 'bun']];
    $out = [];
    foreach (db()->query("SELECT pr.rating, pr.body, u.name, u.role FROM platform_reviews pr JOIN users u ON u.id = pr.user_id WHERE pr.status = 'published' ORDER BY pr.created_at DESC LIMIT 3")->fetchAll() as $k => $t) {
        $out[] = ['quote' => $t['body'], 'name' => $t['name'], 'role' => ucfirst($t['role']), 'context' => 'Verified TopTunity member', 'stars' => (int) $t['rating'],
                  'bg' => $tpal[$k % 3][0], 'hair' => $tpal[$k % 3][1], 'style' => $tpal[$k % 3][2]];
    }
    return $out;
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
   CLIENT AREA (no sample data)
   ========================================================================== */
function toptunity_current_client_default()
{
    $me = ['name' => '', 'company' => '', 'role' => 'Client', 'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'long'];
    if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'client') { $me['name'] = $_SESSION['user']['name']; }
    return $me;
}

/**
 * Projects posted by the current client.
 * status: open | ongoing | overdue | completed | past | cancelled
 * note:   optional extra line (e.g. closed by administrator)
 */
function toptunity_client_projects_sample()
{
    return [];
}

/** Human labels for each project status (used by pills and filter tabs). */
function toptunity_status_label($status)
{
    $labels = [
        'open' => 'Open', 'ongoing' => 'Ongoing', 'overdue' => 'Overdue',
        'completed' => 'Completed', 'past' => 'Past Deadline', 'closed' => 'Closed',
        'suspended' => 'Suspended', 'cancelled' => 'Cancelled', 'removed' => 'Removed', 'waiting' => 'Waiting for contract',
    ];
    return isset($labels[$status]) ? $labels[$status] : ucfirst($status);
}



/** Recent conversations for the dashboard and messages page. */
function toptunity_client_messages()
{
    return [];
}

/* ==========================================================================
   CLIENT PROJECT DETAILS: proposals, contract and tracking
   ========================================================================== */

/** Proposals received on a client project. Each: freelancer_id, offer, days, letter. */
function toptunity_project_proposals($id)
{
    return [];
}

/** Contract terms for a project once a freelancer has been selected (sample for project 2). */
function toptunity_project_tracking($id)
{
    if ((int) $id < 1000) { return null; }
    $r = db()->prepare("SELECT status, contract_status, start_date, created_at, deadline, max_hours FROM projects WHERE id = ?");
    $r->execute([(int) $id - 1000]);
    $p = $r->fetch();
    // Tracking starts only once the freelancer has accepted the contract (contract active or finished)
    if (!$p || !in_array($p['contract_status'], ['active', 'completed'], true)) { return null; }
    $sub  = tt_project_submission((int) $id);
    $dq = db()->prepare("SELECT COALESCE(SUM(amount),0) AS total FROM payments WHERE project_id = ? AND type = 'escrow'");
    $dq->execute([(int) $id - 1000]);
    $total = (int) $dq->fetchColumn();
    // The status is the latest deposit's status (held, paid or refunded)
    $lq = db()->prepare("SELECT status FROM payments WHERE project_id = ? AND type = 'escrow' ORDER BY id DESC LIMIT 1");
    $lq->execute([(int) $id - 1000]);
    $latest = $lq->fetchColumn();
    $dep = ['total' => $total, 'status' => $latest ?: 'none'];
    if ($p['contract_status'] === 'completed') { $step = 7; }
    elseif ($sub && $sub['status'] === 'pending') { $step = 6; }
    elseif ($sub) { $step = 5; }
    else { $step = 4; }
    return [
        'current_step'           => $step,
        'start'                  => $p['start_date'] ?: substr($p['created_at'], 0, 10),
        'max_hours'              => (int) $p['max_hours'],
        'message'                => $sub ? (string) $sub['message'] : '',
        'files'                  => [],
        'submission_status'      => $sub ? $sub['status'] : 'none',
        'submission_review_note' => $sub ? (string) $sub['review_note'] : '',
        'history'                => [],
        'worklog'                => [],
        'deposit'                => $dep ? (int) $dep['total'] : 0,
        'deposit_status'         => $dep ? $dep['status'] : 'none',
    ];
}


/* ==========================================================================
   CLIENT: SAVED FREELANCERS, NOTIFICATIONS (full list), MESSAGES, BILLING
   ========================================================================== */


/** Full notification list. cat is used by the filter tabs. */
function toptunity_client_notifications_all_demo()
{
    return [];
}

/** Message threads. Each has a list of messages: from = 'me' | 'them'. */
function toptunity_client_threads_demo_base()
{
    return [];
}

/** Hourly billing rows for the billing page. */
function toptunity_client_hourly_billing()
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'client') { return []; }
    $q = db()->prepare("SELECT p.id, p.title, p.hourly_rate, p.deadline, p.status,
                               (SELECT COALESCE(SUM(hours),0) FROM work_logs w WHERE w.project_id = p.id AND w.status = 'approved') AS approved,
                               (SELECT COALESCE(SUM(amount),0) FROM payments x WHERE x.project_id = p.id AND x.type = 'escrow') AS escrow,
                               (SELECT COUNT(*) FROM payments x WHERE x.project_id = p.id AND x.type = 'refund') AS refunded,
                               (SELECT COALESCE(SUM(amount),0) FROM payments x WHERE x.project_id = p.id AND x.type = 'refund') AS refund_amount
                        FROM projects p
                        WHERE p.client_id = ? AND p.billing_type = 'hourly' AND p.contract_status IN ('active','completed')
                        ORDER BY p.deadline");
    $q->execute([(int) $u['id']]);
    $out = [];
    foreach ($q->fetchAll() as $r) {
        $approved = (float) $r['approved'];
        $rate     = (int) $r['hourly_rate'];
        $billed   = (int) round($approved * $rate);
        $settled  = $r['status'] === 'completed';
        $out[] = [
            'end'      => date('M j, Y', strtotime($r['deadline'])),
            'project'  => $r['title'],
            'approved' => $approved,
            'rate'     => $rate,
            'billed'   => $settled ? $billed : 0,
            'unused'   => $settled ? max(0, (int) $r['escrow'] - $billed) : null,
        ];
    }
    return $out;
}

/* ==========================================================================
   CLIENT: REVIEWS RECEIVED (My Profile > My Reviews)
   ========================================================================== */
function toptunity_client_reviews()
{
    return tt_review_items((int) ((tt_current_user()['id'] ?? 0) ?? 0));
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
        if (!false) {
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
    $saved = tt_saved_projects_for_current_user();
    // Keep only the real projects for the current signed-in client.
    return array_reverse($saved, true);
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

    // Accept one file sent as a plain field as well as several sent as an array
    $fields = $_FILES[$field];
    if (!is_array($fields['name'])) { $fields = ['name' => [$fields['name']], 'tmp_name' => [$fields['tmp_name']], 'error' => [$fields['error']], 'size' => [$fields['size']]]; }
    foreach ($fields['name'] as $i => $name) {
        $code = $fields['error'][$i];
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
   The demo freelancer is Miguel Reyes (no sample data)
   ========================================================================== */

/** The signed-in freelancer, for the sidebar and profile. */
function toptunity_current_freelancer()
{
    $me = ['name' => '', 'title' => 'Freelancer', 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short'];
    if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'freelancer') {
        $me['name'] = $_SESSION['user']['name'];
        $me['avatar'] = tt_user_avatar_asset((int) $_SESSION['user']['id']);
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
    $items = tt_review_items((int) ((tt_current_user()['id'] ?? 0) ?? 0));
    $total = count($items);
    $dist  = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    foreach ($items as $i) { $dist[$i['stars']] = ($dist[$i['stars']] ?? 0) + 1; }
    $avg = $total ? round(array_sum(array_column($items, 'stars')) / $total, 1) : 0;
    return ['avg' => $avg, 'total' => $total, 'dist' => $dist, 'items' => $items];
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
    $rows = db()->query('SELECT s.name AS skill, c.name AS category FROM skills s LEFT JOIN categories c ON c.id = s.category_id ORDER BY s.name')->fetchAll();
    if (!$rows) { return $defaults; }
    $catalog = [];
    foreach ($rows as $row) { $catalog[$row['skill']] = $row['category'] ?: 'Other'; }
    return $catalog;
}

/* ==========================================================================
   FREELANCER SAMPLE DATA (no sample data)
   ========================================================================== */

/** Proposals sent. status: pending | selected | not_selected | withdrawn. project_id is the public project id when there is one. */
function toptunity_freelancer_proposals()
{
    return [];
}

/**
 * Your projects. status: offer (client selected you, not accepted yet) | ongoing | overdue | completed.
 * Hourly projects also have rate, max_hours and worklog.
 */
function toptunity_freelancer_projects()
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'freelancer') { return []; }
    $stmt = db()->prepare("SELECT p.id, p.title, p.billing_type, p.budget, p.hourly_rate, p.max_hours, p.deadline, p.status, p.contract_status,
                                  p.created_at, p.agreed_amount, c.name AS category, cl.name AS client
                           FROM projects p
                           JOIN users cl ON cl.id = p.client_id
                           LEFT JOIN categories c ON c.id = p.category_id
                           WHERE p.freelancer_id = ? ORDER BY p.id DESC");
    $stmt->execute([(int) $u['id']]);
    $out = [];
    foreach ($stmt->fetchAll() as $r) {
        if ($r['contract_status'] === 'pending')                       { $st = 'offer'; }
        elseif (in_array($r['status'], ['completed'], true))            { $st = 'completed'; }
        elseif (in_array($r['status'], ['ongoing', 'overdue'], true))  { $st = $r['status']; }
        elseif ($r['contract_status'] === 'active')                     { $st = 'ongoing'; }
        else                                                            { $st = 'waiting'; } // selected, contract not sent yet
        $out[] = ['id' => 1000 + (int) $r['id'], 'project_id' => (int) $r['id'], 'title' => $r['title'], 'client' => $r['client'],
                  'client_company' => '', 'category' => $r['category'] ?: 'Other', 'status' => $st,
                  'type' => $r['billing_type'], 'rate' => (int) $r['hourly_rate'], 'max_hours' => (int) $r['max_hours'],
                  'budget' => (int) ($r['agreed_amount'] ?: $r['budget']),
                  'start' => date('Y-m-d', strtotime($r['created_at'])), 'deadline' => $r['deadline'],
                  'contract_status' => $r['contract_status'], 'progress' => tt_project_progress((int) $r['id'], $r['contract_status'])];
    }
    return $out;
}

/** One project with its details: work log, revision request, submitted work and history. */
function toptunity_freelancer_project($id)
{
    foreach (toptunity_freelancer_projects() as $p) {
        if ((int) $p['id'] !== (int) $id) { continue; }
        $pr = db()->prepare('SELECT hourly_rate, max_hours FROM projects WHERE id = ?');
        $pr->execute([(int) $p['project_id']]);
        $row = $pr->fetch() ?: ['hourly_rate' => 0, 'max_hours' => 0];
        $sum = db()->prepare("SELECT COALESCE(SUM(CASE WHEN status <> 'rejected' THEN hours ELSE 0 END), 0) AS logged,
                                     COALESCE(SUM(CASE WHEN status = 'approved' THEN hours ELSE 0 END), 0) AS approved
                              FROM work_logs WHERE project_id = ?");
        $sum->execute([(int) $p['project_id']]);
        $tot = $sum->fetch();
        $p['rate'] = (int) $row['hourly_rate'];
        $p['max_hours'] = (int) $row['max_hours'];
        $p['hours_logged'] = (float) $tot['logged'];
        $p['hours_approved'] = (float) $tot['approved'];
        $p['worklog'] = tt_project_work_logs($p['id']);
        $p['revision'] = null;
        $p['submitted'] = null;
        $rq = db()->prepare("SELECT COALESCE(SUM(amount),0) FROM payments WHERE project_id = ? AND type = 'release' AND status = 'released'");
        $rq->execute([(int) $p['project_id']]);
        $p['released'] = (int) $rq->fetchColumn();
        $p['history'] = array_map(function ($h) { return ['date' => $h['when'], 'status' => $h['text'], 'note' => '']; },
                                  tt_project_history((int) $p['project_id'], $p['start'] . ' 00:00:00', $p['deadline'], $p['status']));
        return $p;
    }
    return null;
}

/** Message threads. Each has messages with from = 'me' | 'them'. */
function toptunity_freelancer_threads_demo_base()
{
    return [];
}

/** Notifications. cat is used by the filter tabs. */
function toptunity_freelancer_notifications_demo()
{
    return [];
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







/* ==========================================================================
   ADMIN AREA (matches the admin designs)
   ========================================================================== */

/** Every user: real accounts plus the sample users shown in the design. */
function toptunity_admin_users()
{
    $rows = db()->query("SELECT u.id, u.name, u.email, u.role, u.status, u.created_at, u.status_changed_at,
                                (SELECT COUNT(*) FROM reports r WHERE r.reported_user_id = u.id) AS reported,
                                (SELECT COUNT(*) FROM notifications n WHERE n.user_id = u.id AND n.title = 'Account warning') AS warnings
                         FROM users u WHERE u.role <> 'admin' ORDER BY u.created_at DESC")->fetchAll();
    $out = [];
    foreach ($rows as $r) {
        $out[] = ['id' => (int) $r['id'], 'name' => $r['name'], 'email' => $r['email'], 'role' => $r['role'],
                  'status' => ucfirst($r['status']), 'joined' => date('M j, Y', strtotime($r['created_at'])),
                  'suspended_on' => ($r['status'] === 'suspended' && $r['status_changed_at']) ? date('M d, Y', strtotime($r['status_changed_at'])) : '',
                  'reported' => (int) $r['reported'], 'warnings' => (int) $r['warnings']];
    }
    return $out;
}

/** Change a client or freelancer status. Demo changes are isolated to the admin session. */
function tt_admin_change_user_status($id, $action)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'admin') { return 'Administrator access is required.'; }
    $statuses = ['suspend' => 'Suspended', 'reactivate' => 'Active', 'deactivate' => 'Deactivated'];
    if (!isset($statuses[$action])) { return 'Choose a valid user action.'; }


    $status = ['suspend' => 'suspended', 'reactivate' => 'active', 'deactivate' => 'deactivated'][$action];
    $stmt = db()->prepare("UPDATE users SET status = ?, status_changed_at = NOW() WHERE id = ? AND role IN ('client', 'freelancer')");
    $stmt->execute([$status, (int) $id]);
    if ($stmt->rowCount()) { return null; }
    $check = db()->prepare("SELECT status FROM users WHERE id = ? AND role IN ('client', 'freelancer')");
    $check->execute([(int) $id]);
    return $check->fetchColumn() === $status ? null : 'That user could not be updated.';
}

/** Reports. status: pending | resolved | dismissed. type: User | Project | Review | Message */
function toptunity_admin_reports()
{
    $rows = db()->query("SELECT r.id, r.type, r.reason, r.details, r.status, r.created_at, r.reported_user_id,
                                ru.name AS reporter, cu.name AS reported
                         FROM reports r
                         JOIN users ru ON ru.id = r.reporter_id
                         LEFT JOIN users cu ON cu.id = r.reported_user_id
                         ORDER BY r.created_at DESC")->fetchAll();
    $out = [];
    foreach ($rows as $r) {
        $out[] = ['id' => 'DB-' . $r['id'], 'reported_user_id' => $r['reported_user_id'] ? (int) $r['reported_user_id'] : null, 'date' => date('M j', strtotime($r['created_at'])),
                  'reported' => $r['reported'] ?: '—', 'reporter' => $r['reporter'], 'type' => ucfirst($r['type']),
                  'reason' => $r['reason'], 'status' => $r['status'], 'quote' => $r['details'],
                  'when' => date('M j, Y · g:i A', strtotime($r['created_at']))];
    }
    return $out;
}

/** Record report review actions against live records or session-only demo fixtures. */
function tt_admin_review_report($report_id, $action)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'admin') { return 'Administrator access is required.'; }
    if (!in_array($action, ['dismiss', 'warn', 'remove', 'suspend'], true)) { return 'Choose a valid report action.'; }
    $status = $action === 'dismiss' ? 'dismissed' : 'resolved';


    if (!preg_match('/^DB-(\d+)$/', (string) $report_id, $match)) { return 'That report could not be found.'; }
    $pdo = db();
    $stmt = $pdo->prepare('SELECT reported_user_id, status, type FROM reports WHERE id = ?');
    $stmt->execute([(int) $match[1]]);
    $report = $stmt->fetch();
    if (!$report || $report['status'] !== 'pending') { return 'That report is no longer pending.'; }
    if (in_array($action, ['warn', 'suspend'], true)) {
        if (strcasecmp($report['type'], 'user') !== 0) { return 'Warnings and account suspensions are only available for user reports.'; }
        if (!$report['reported_user_id']) { return 'This report is not linked to a user account.'; }
        if ($action === 'suspend') {
            $pdo->prepare("UPDATE users SET status = 'suspended', status_changed_at = NOW() WHERE id = ? AND role IN ('client', 'freelancer')")
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
    $rows = db()->query("SELECT p.id, p.title, p.status, p.billing_type, p.budget, p.hourly_rate, p.deadline, p.contract_status, p.created_at,
                                c.name AS client, f.name AS freelancer,
                                (SELECT COUNT(*) FROM proposals pr WHERE pr.project_id = p.id) AS proposals
                         FROM projects p
                         JOIN users c ON c.id = p.client_id
                         LEFT JOIN users f ON f.id = p.freelancer_id
                         ORDER BY p.created_at DESC")->fetchAll();
    $out = [];
    foreach ($rows as $r) {
        $hourly = $r['billing_type'] === 'hourly';
        $out[] = ['id' => 1000 + (int) $r['id'], 'site_id' => 1000 + (int) $r['id'], 'title' => $r['title'], 'client' => $r['client'],
                  'freelancer' => $r['freelancer'] ?: '—', 'status' => $r['status'], 'contract_status' => $r['contract_status'], 'has_freelancer' => !empty($r['freelancer']), 'deadline' => $r['deadline'],
                  'type' => $r['billing_type'], 'billing' => $hourly ? 'Hourly ₱' . number_format((int) $r['hourly_rate']) . '/hr' : 'Fixed · ₱' . number_format((int) $r['budget']),
                  'proposals' => (int) $r['proposals'], 'contract_status' => $r['contract_status'], 'real' => true,
                  'history' => tt_project_history((int) $r['id'], $r['created_at'], $r['deadline'], $r['status'])];
    }
    return $out;
}

/**
 * Real history of one project, newest first: posted, proposals, freelancer selection, contract steps,
 * payments and an overdue deadline. Built from the database only; nothing is typed in.
 */
function tt_project_history($project_id, $created_at, $deadline, $status)
{
    $events = [];
    $site = 1000 + (int) $project_id;
    $events[] = ['when' => $created_at, 'text' => 'Project posted (client)'];

    $pq = db()->prepare("SELECT pr.offer, pr.created_at, u.name FROM proposals pr JOIN users u ON u.id = pr.freelancer_id WHERE pr.project_id = ?");
    $pq->execute([(int) $project_id]);
    foreach ($pq->fetchAll() as $pr) {
        $events[] = ['when' => $pr['created_at'], 'text' => 'Proposal from ' . $pr['name'] . ' · ₱' . number_format((int) $pr['offer'])];
    }

    // Audit entries store the project as "project #<db id>" or "project #<site id>"
    $aq = db()->prepare("SELECT action, target, created_at FROM audit_logs
                         WHERE target REGEXP ? AND action NOT IN ('submit proposal')
                         ORDER BY created_at");
    $aq->execute(['^project #(' . (int) $project_id . '|' . $site . ')(\\s|$)']);
    $labels = ['select freelancer' => 'Freelancer selected', 'send contract' => 'Contract sent',
               'accept contract' => 'Freelancer accepted the contract', 'decline contract' => 'Freelancer declined the contract',
               'post project' => null];
    foreach ($aq->fetchAll() as $a) {
        $label = array_key_exists($a['action'], $labels) ? $labels[$a['action']] : ucfirst($a['action']);
        if ($label === null) { continue; }
        $events[] = ['when' => $a['created_at'], 'text' => $label . ' · ' . trim(preg_replace('/^project #\d+\s*/', '', $a['target']))];
    }

    $sq = db()->prepare("SELECT status, created_at FROM project_submissions WHERE project_id = ? ORDER BY id");
    $sq->execute([(int) $project_id]);
    $sub_labels = ['pending' => 'Work submitted for review', 'approved' => 'Work approved by client', 'rejected' => 'Revision requested'];
    foreach ($sq->fetchAll() as $sb) {
        $events[] = ['when' => $sb['created_at'], 'text' => $sub_labels[$sb['status']] ?? ucfirst($sb['status'])];
    }
    $pq2 = db()->prepare("SELECT type, amount, created_at FROM payments WHERE project_id = ? ORDER BY id");
    $pq2->execute([(int) $project_id]);
    foreach ($pq2->fetchAll() as $pm) {
        $events[] = ['when' => $pm['created_at'], 'text' => ($pm['type'] === 'release' ? 'Payment released' : 'Payment deposited') . ' · ₱' . number_format((int) $pm['amount'])];
    }

    if (!empty($deadline) && strtotime($deadline) < strtotime('today') && in_array($status, ['open', 'ongoing'], true)) {
        $events[] = ['when' => $deadline . ' 23:59:00', 'text' => 'Deadline passed (' . date('M j, Y', strtotime($deadline)) . ')'];
    }

    usort($events, function ($a, $b) { return strtotime($b['when']) <=> strtotime($a['when']); });
    return array_map(function ($e) {
        return ['when' => date('M j, Y', strtotime($e['when'])), 'text' => $e['text']];
    }, $events);
}

/** Apply a moderation action to an isolated demo project fixture. */
/** Apply a moderation action to a real database project. */
/** True when an administrator has removed the project. Removed projects keep their history but take no new actions. */
function tt_project_is_removed($project)
{
    return is_array($project) && ($project['status'] ?? '') === 'removed';
}

function tt_admin_moderate_project($site_id, $action)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'admin') { return 'Administrator access is required.'; }
    $project = tt_db_project($site_id);
    if (!$project) { return 'This project could not be found.'; }
    if (false && !in_array((int) $project['client_id'], tt_demo_ids(), true)) {
        return 'The demo administrator can only moderate projects belonging to demo accounts.';
    }
    $pdo = db();

    if ($action === 'remove') {
        if (!in_array($project['status'], ['open', 'past', 'closed', 'suspended', 'cancelled'], true)
            || !in_array($project['contract_status'], ['none', 'declined'], true)) {
            return 'Active projects cannot be removed. Close or resolve the contract first.';
        }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM payments WHERE project_id = ? AND status = 'held'");
        $stmt->execute([(int) $project['id']]);
        if ((int) $stmt->fetchColumn() > 0) { return 'Money is still held for this project. Resolve the payment first.'; }
        // Nothing is deleted: the project keeps its payments, proposals, work and history
        $pdo->prepare("UPDATE projects SET removed_from_status = status, removed_at = NOW(), status = 'removed' WHERE id = ?")
            ->execute([(int) $project['id']]);
        $note = 'Your project \"' . $project['title'] . '\" was removed by an administrator. It stays in your records, but no new actions can be taken on it.';
        tt_notify((int) $project['client_id'], 'project', 'Project removed', $note);
        if (!empty($project['freelancer_id'])) { tt_notify((int) $project['freelancer_id'], 'project', 'Project removed', $note); }
        tt_audit('remove project', 'project #' . $project['id'], $user['id']);
        return null;
    }

    if ($action === 'restore') {
        if ($project['status'] !== 'removed') { return 'Only a removed project can be restored.'; }
        $back = $project['removed_from_status'] ?: 'open';
        $pdo->prepare('UPDATE projects SET status = ?, removed_from_status = NULL, removed_at = NULL WHERE id = ?')
            ->execute([$back, (int) $project['id']]);
        $note = 'Your project \"' . $project['title'] . '\" was restored by an administrator.';
        tt_notify((int) $project['client_id'], 'project', 'Project restored', $note);
        if (!empty($project['freelancer_id'])) { tt_notify((int) $project['freelancer_id'], 'project', 'Project restored', $note); }
        tt_audit('restore project', 'project #' . $project['id'], $user['id']);
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
        if ((string) $candidate['id'] === (string) $dispute_id && $candidate['status'] === 'open') { $dispute = $candidate; break; }
    }
    if (!$dispute) { return 'That open dispute could not be found.'; }
    if ($decision === 'split' && ((int) $to_freelancer + (int) $to_client) !== (int) $dispute['held']) {
        return 'The two amounts must add up to ₱' . number_format($dispute['held']) . '.';
    }


    if (!preg_match('/^DB-(\d+)$/', (string) $dispute_id, $match)) { return 'That dispute could not be found.'; }
    $result = $decision === 'split'
        ? 'split:' . (int) $to_freelancer . ':' . (int) $to_client
        : $decision;
    $pdo = db();
    $pdo->beginTransaction();
    try {
        $d = $pdo->prepare("SELECT id, project_id FROM disputes WHERE id = ? AND status = 'open' FOR UPDATE");
        $d->execute([(int) $match[1]]);
        $row = $d->fetch();
        if (!$row) { $pdo->rollBack(); return 'That dispute was already resolved.'; }
        $project_id = (int) $row['project_id'];

        // Move the held money according to the decision
        $e = $pdo->prepare("SELECT id, amount FROM payments WHERE project_id = ? AND type = 'escrow' AND status = 'held' ORDER BY id DESC LIMIT 1 FOR UPDATE");
        $e->execute([$project_id]);
        $escrow = $e->fetch();
        $held = $escrow ? (int) $escrow['amount'] : 0;
        $to_free = $decision === 'release' ? $held : ($decision === 'split' ? (int) $to_freelancer : 0);
        $to_cli  = $decision === 'refund'  ? $held : ($decision === 'split' ? (int) $to_client : 0);
        if ($escrow) {
            if ($to_cli === 0 && $to_free === $held) {
                // Full release: the same record a normal approval creates, with the fee taken on it
                $pdo->prepare("UPDATE payments SET status = 'released', service_fee = ? WHERE id = ?")
                    ->execute([tt_fee_for($held), (int) $escrow['id']]);
            } else {
                // Split or refund: the deposit is settled, and each share is its own record
                $pdo->prepare("UPDATE payments SET status = 'refunded' WHERE id = ?")->execute([(int) $escrow['id']]);
                if ($to_free > 0) {
                    $pdo->prepare("INSERT INTO payments (project_id, type, amount, service_fee, status) VALUES (?, 'release', ?, ?, 'released')")
                        ->execute([$project_id, $to_free, tt_fee_for($to_free)]);
                }
                if ($to_cli > 0) {
                    $pdo->prepare("INSERT INTO payments (project_id, type, amount, service_fee, status) VALUES (?, 'refund', ?, 0, 'refunded')")
                        ->execute([$project_id, $to_cli]);
                }
            }
        }
        $pdo->prepare("UPDATE projects SET status = ? WHERE id = ?")->execute([$to_free > 0 ? 'completed' : 'cancelled', $project_id]);
        if ($to_free > 0) { $pdo->prepare("UPDATE projects SET contract_status = 'completed' WHERE id = ? AND contract_status = 'active'")->execute([$project_id]); }

        $pdo->prepare("UPDATE disputes SET status = 'resolved', decision = ?, details = CONCAT(details, '\\n\\nAdmin decision: ', ?) WHERE id = ?")
            ->execute([$result, $notes, (int) $row['id']]);
        $pdo->commit();
    } catch (Throwable $ex) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        error_log('TopTunity dispute decision failed: ' . $ex->getMessage());
        return 'The decision could not be saved. Please try again.';
    }
    $pr = tt_db_project(1000 + $project_id);
    if ($pr) {
        if (!empty($pr['freelancer_id'])) { tt_notify((int) $pr['freelancer_id'], 'disputes', 'Dispute decided', $pr['title'] . ': ' . ($to_free > 0 ? '₱' . number_format($to_free) . ' released to you (after the service fee).' : 'no amount released to you.')); }
        tt_notify((int) $pr['client_id'], 'disputes', 'Dispute decided', $pr['title'] . ': ' . ($to_cli > 0 ? '₱' . number_format($to_cli) . ' refunded to you.' : 'no amount refunded to you.'));
    }
    tt_audit('resolve dispute', 'dispute #' . $match[1] . ' ' . $result, $user['id']);
    return null;
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
    $rows = db()->query("SELECT d.id, d.project_id, d.reason, d.details, d.status, d.decision, d.created_at, d.filed_by,
                                p.title, p.budget, p.hourly_rate, p.max_hours, p.billing_type, p.deadline, p.created_at AS posted,
                                p.agreed_amount, p.freelancer_id,
                                fu.name AS filed_name, fu.role AS filed_role,
                                cu.name AS client_name, fl.name AS freelancer_name
                         FROM disputes d
                         JOIN projects p ON p.id = d.project_id
                         JOIN users fu ON fu.id = d.filed_by
                         JOIN users cu ON cu.id = p.client_id
                         LEFT JOIN users fl ON fl.id = p.freelancer_id
                         ORDER BY d.created_at DESC")->fetchAll();
    $out = [];
    foreach ($rows as $r) {
        $pid  = (int) $r['project_id'];
        $site = 1000 + $pid;
        $hold = db()->prepare("SELECT COALESCE(SUM(amount), 0) FROM payments WHERE project_id = ? AND type = 'escrow' AND status = 'held'");
        $hold->execute([$pid]);
        $held = (int) $hold->fetchColumn();
        $fq = db()->prepare("SELECT original_name, size_label FROM attachments WHERE owner_type = 'deliverable' AND owner_id = ? ORDER BY id");
        $fq->execute([$site]);
        $files = [];
        foreach ($fq->fetchAll() as $f) { $files[] = ['name' => $f['original_name'], 'size' => $f['size_label']]; }
        $cq = db()->prepare("SELECT u.name AS sender, m.body FROM messages m JOIN users u ON u.id = m.sender_id WHERE m.project_id = ? ORDER BY m.id DESC LIMIT 30");
        $cq->execute([$pid]);
        $chat = [];
        foreach (array_reverse($cq->fetchAll()) as $c) { $chat[] = ['from' => $c['sender'], 'text' => $c['body']]; }
        $hourly   = $r['billing_type'] === 'hourly';
        $deadline = $r['deadline'] ? date('M j, Y', strtotime($r['deadline'])) : '—';
        $history  = ['Filed by ' . $r['filed_name'] . ' on ' . date('M j, Y', strtotime($r['created_at'])) . ': ' . $r['reason']];
        if ($r['status'] === 'resolved') { $history[] = 'Decision: ' . ($r['decision'] ?: 'recorded'); }
        $out[] = [
            'id' => 'DB-' . $r['id'], 'project_id' => $site,
            'date' => date('M j, Y', strtotime($r['created_at'])), 'project' => $r['title'],
            'billing' => $hourly ? 'Hourly' : 'Fixed Price', 'filed_by' => ucfirst((string) $r['filed_role']),
            'reason' => $r['reason'], 'status' => $r['status'], 'details' => $r['details'], 'decision' => $r['decision'],
            'client' => $r['client_name'], 'freelancer' => $r['freelancer_name'] ?: '—',
            'contract' => $hourly ? 'Hourly ₱' . number_format((int) $r['hourly_rate']) . '/hr, up to ' . (int) $r['max_hours'] . ' hours'
                                  : 'Fixed ₱' . number_format((int) ($r['agreed_amount'] ?: $r['budget'])),
            'dates' => 'Posted ' . date('M j, Y', strtotime($r['posted'])) . ' · Deadline ' . $deadline,
            'deadline' => $deadline, 'held' => $held, 'fee' => tt_fee_for($held),
            'files' => $files, 'chat' => $chat, 'history' => $history,
        ];
    }
    return $out;
}



/** Platform reviews. status: new | published | hidden */
function toptunity_admin_reviews()
{
    $rows = db()->query("SELECT pr.id, pr.rating, pr.body, pr.status, pr.created_at, u.name, u.role
                         FROM platform_reviews pr JOIN users u ON u.id = pr.user_id ORDER BY pr.created_at DESC")->fetchAll();
    $out = [];
    foreach ($rows as $r) {
        $out[] = ['id' => 'DB-' . $r['id'], 'date' => date('M j, Y', strtotime($r['created_at'])), 'user' => $r['name'],
                  'role' => ucfirst($r['role']), 'rating' => (int) $r['rating'], 'status' => $r['status'], 'text' => $r['body']];
    }
    return $out;
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
        if ((string) $candidate['id'] === (string) $review_id) { $review = $candidate; break; }
    }
    if (!$review) { return 'That review could not be found.'; }

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
    $rows = db()->query("SELECT id, name, email, subject, message, status, reply, created_at FROM contact_inquiries ORDER BY created_at DESC")->fetchAll();
    $out = [];
    foreach ($rows as $r) {
        $out[] = ['id' => 'I-' . $r['id'], 'date' => date('M j, Y', strtotime($r['created_at'])), 'name' => $r['name'],
                  'email' => $r['email'], 'subject' => $r['subject'], 'message' => $r['message'], 'status' => $r['status'],
                  'reply' => (string) ($r['reply'] ?? ''), 'real' => true];
    }
    return $out;
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
    return [];
}

/** The service fee (percent), saved in storage/settings.json. Default 10. */
function tt_settings_file() { return dirname(__DIR__) . '/storage/settings.json'; }

function tt_service_fee()
{
    $f = tt_settings_file();
    $d = file_exists($f) ? json_decode((string) file_get_contents($f), true) : null;
    return isset($d['service_fee']) ? (int) $d['service_fee'] : 10;
}

function tt_save_service_fee($pct)
{
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
    $is_hourly = $fields['type'] === 'hourly';
    tt_risk_check('project', ['billing_type' => $fields['type'], 'budget' => (int) $fields['budget'], 'hourly_rate' => (int) $fields['rate'],
                              'max_hours' => (int) $fields['max_hours'], 'deadline' => $fields['deadline'], 'title' => $fields['title']],
                  $id, (int) $user['id'], $is_hourly ? (int) $fields['rate'] * (int) $fields['max_hours'] : (int) $fields['budget']);
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
    $stmt->execute([(int) $site_id - 1000]);
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
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
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
    $stmt->execute([(int) $site_id - 1000]);
    if ((float) $stmt->fetchColumn() + (float) $hours > (int) $project['max_hours']) {
        return 'Logging these hours would exceed the project maximum.';
    }
    db()->prepare('INSERT INTO work_logs (project_id, freelancer_id, work_date, hours, task) VALUES (?, ?, ?, ?, ?)')
        ->execute([(int) $site_id - 1000, (int) $user['id'], $work_date, (float) $hours, $task]);
    tt_notify((int) $project['client_id'], 'worklog', 'Hours submitted', $user['name'] . ' logged ' . number_format((float) $hours, 1) . ' hours for ' . $project['title'] . '.');
    return null;
}

/** Client approves or rejects a pending work log on their project. */
function tt_db_review_work_log($site_id, $log_id, $decision, $note = '')
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
    if (!$user || $user['role'] !== 'client' || !$project || (int) $project['client_id'] !== (int) $user['id']) {
        return 'This project is not yours.';
    }
    if (!in_array($decision, ['approved', 'rejected'], true)) { return 'Choose a valid review action.'; }
    if ($decision === 'rejected' && mb_strlen(trim($note)) < 10) { return 'Give a reason for rejecting (at least 10 characters).'; }
    $stmt = db()->prepare("UPDATE work_logs SET status = ?, review_note = ?
                           WHERE id = ? AND project_id = ? AND status = 'pending'");
    $stmt->execute([$decision, $decision === 'rejected' ? trim($note) : null, (int) $log_id, (int) $site_id - 1000]);
    if (!$stmt->rowCount()) { return 'That pending work log was not found.'; }
    tt_notify((int) $project['freelancer_id'], 'worklog', $decision === 'approved' ? 'Hours approved' : 'Hours rejected',
              $user['name'] . ' ' . $decision . ' a work log for ' . $project['title'] . '.');
    return null;
}

/** Most recent submitted work for a project. */
function tt_project_submission($site_id)
{
    $stmt = db()->prepare('SELECT id, message, status, review_note, created_at FROM project_submissions WHERE project_id = ? ORDER BY id DESC LIMIT 1');
    $stmt->execute([(int) $site_id - 1000]);
    return $stmt->fetch() ?: null;
}

/** Save a freelancer's delivery message. */
function tt_db_submit_work($site_id, $message)
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
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
        ->execute([(int) $site_id - 1000, (int) $user['id'], $message]);
    tt_notify((int) $project['client_id'], 'work', 'Work submitted', $user['name'] . ' submitted work for ' . $project['title'] . '.');
    tt_audit('submit work', 'project #' . $site_id);
    return null;
}

/** Client approves a delivery or requests a revision. */
function tt_db_review_submission($site_id, $decision, $note = '')
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
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
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
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
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
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
    tt_risk_check('proposal', $project, (int) $project['id'], (int) $user['id'], (int) $offer);
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
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
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
    if (tt_project_is_removed(tt_db_project($site_id))) { return 'This project was removed by an administrator, so it cannot be changed.'; }
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
function tt_db_send_contract($site_id, $agreed_amount, $hourly_rate = null, $max_hours = null)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'client') { return 'Only clients can send contracts.'; }
    $project = tt_db_project($site_id);
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
    if (!$project || (int) $project['client_id'] !== (int) ($user['id'] ?? 0)) { return 'This project is not yours.'; }
    if ($project['status'] !== 'open') { return 'This project is no longer accepting contracts.'; }
    if (empty($project['freelancer_id']))                             { return 'Select a freelancer before sending the contract.'; }
    if ($project['contract_status'] !== 'none')                       { return 'The contract has already been sent.'; }
    if ($project['billing_type'] === 'hourly' && $hourly_rate !== null && $max_hours !== null) {
        if ((int) $hourly_rate < 1)  { return 'Enter a valid hourly rate.'; }
        if ((int) $max_hours < 1)    { return 'Enter a valid number of maximum hours.'; }
        $agreed_amount = (int) $hourly_rate * (int) $max_hours;
        db()->prepare('UPDATE projects SET hourly_rate = ?, max_hours = ?, budget = ? WHERE id = ?')
             ->execute([(int) $hourly_rate, (int) $max_hours, $agreed_amount, (int) $project['id']]);
    }
    if ((int) $agreed_amount < 1) { return 'Enter the agreed amount.'; }
    $stmt = db()->prepare("UPDATE projects SET contract_status = 'pending', agreed_amount = ?, contract_sent_at = NOW()
                           WHERE id = ? AND status = 'open' AND contract_status = 'none' AND freelancer_id IS NOT NULL");
    $stmt->execute([(int) $agreed_amount, (int) $project['id']]);
    if (!$stmt->rowCount()) { return 'This project is no longer accepting contracts.'; }
    tt_notify($project['freelancer_id'], 'offers', 'Project offer',
              $user['name'] . ' sent you a contract for ' . $project['title'] . '.');
    tt_audit('send contract', 'project #' . $project['id'] . ' ₱' . number_format((int) $agreed_amount));
    tt_risk_check('contract', $project, (int) $project['id'], (int) $user['id'], (int) $agreed_amount, (int) $agreed_amount);
    return null;
}

/** Freelancer accepts (true) or declines (false) the contract. Returns null or an error. */
function tt_db_respond_contract($site_id, $accept)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'freelancer') { return 'Only freelancers can respond to contracts.'; }
    $project = tt_db_project($site_id);
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
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
        // The accepted state is shown from the project's contract status (the proposals table has no 'accepted' value)
        tt_notify($project['client_id'], 'responses', 'Contract accepted',
                  $user['name'] . ' accepted the contract for ' . $project['title'] . '. Please deposit the amount.');
    } else {
        $pdo->prepare("UPDATE projects SET contract_status = 'none', freelancer_id = NULL, agreed_amount = 0 WHERE id = ?")
            ->execute([(int) $project['id']]);
        $pdo->prepare("UPDATE proposals SET status = 'declined' WHERE project_id = ? AND freelancer_id = ? AND status = 'selected'")
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
        && (false || false)) {
        return array_values(array_unique($_SESSION['demo_admin_catalog']['categories']));
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
function tt_db_deposit($site_id, $method = '', $transfer_ref = '')
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
        if (tt_project_is_removed($project)) { $pdo->rollBack(); return 'This project was removed by an administrator, so it cannot be changed.'; }
        if ($project['contract_status'] !== 'active')                    { $pdo->rollBack(); return 'The contract must be accepted before you deposit.'; }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM payments WHERE project_id = ? AND type = 'escrow'");
        $stmt->execute([(int) $project['id']]);
        if ((int) $stmt->fetchColumn() > 0)                              { $pdo->rollBack(); return 'This project has already been deposited.'; }
        $amount = (int) $project['agreed_amount'];
        if ($amount < 1) { $pdo->rollBack(); return 'The contract amount is invalid.'; }
        if (!in_array($method, ['gcash', 'bank'], true)) { $pdo->rollBack(); return 'Choose how you paid: GCash or bank transfer.'; }
        $transfer_ref = strtoupper(trim($transfer_ref));
        if (mb_strlen($transfer_ref) < 4) { $pdo->rollBack(); return 'Enter the reference number from your GCash or bank transfer.'; }
        $dup = $pdo->prepare("SELECT COUNT(*) FROM payments WHERE transfer_ref = ?");
        $dup->execute([$transfer_ref]);
        if ((int) $dup->fetchColumn() > 0) { $pdo->rollBack(); return 'That payment reference was already used for another deposit.'; }
        // The fee is charged when the payment is released, so the deposit itself carries no fee
        $pdo->prepare("INSERT INTO payments (project_id, type, amount, service_fee, status, method, transfer_ref) VALUES (?, 'escrow', ?, 0, 'held', ?, ?)")
            ->execute([(int) $project['id'], $amount, $method, $transfer_ref]);
        $payment_id = (int) $pdo->lastInsertId();
        $reference = 'TTP-' . str_pad((string) $payment_id, 6, '0', STR_PAD_LEFT);
        $pdo->prepare("UPDATE payments SET reference = ? WHERE id = ?")->execute([$reference, $payment_id]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        return 'The deposit could not be saved. Please try again.';
    }
    tt_notify($project['freelancer_id'], 'payments', 'Payment held',
              '₱' . number_format($amount) . ' was deposited for ' . $project['title'] . '. Reference ' . $reference . '. It is released when the client approves the work.');
    tt_audit('deposit', 'project #' . $project['id'] . ' ₱' . number_format($amount), $u['id']);
    return null;
}

/** Client approves the work and releases the held payment. Returns null or an error. */
function tt_db_release($site_id)
{
    $u = tt_current_user();
    $project = tt_db_project($site_id);
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
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
        // The fee is worked out when the payment is released, from the current service fee setting
        $escrow['service_fee'] = tt_fee_for((int) $escrow['amount']);
        $pdo->prepare("UPDATE payments SET status = 'released', service_fee = ? WHERE id = ?")->execute([(int) $escrow['service_fee'], (int) $escrow['id']]);
        $pdo->prepare("UPDATE projects SET status = 'completed', contract_status = 'completed' WHERE id = ?")->execute([(int) $project['id']]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        return 'The payment could not be released. Please try again.';
    }
    $net = (int) $escrow['amount'] - (int) $escrow['service_fee'];
    if (!empty($project['freelancer_id'])) {
        tt_notify((int) $project['freelancer_id'], 'payments', 'Payment released',
                  '₱' . number_format($net) . ' was released to you for ' . $project['title'] . ' (after the service fee).');
    }
    tt_audit('release payment', 'project #' . $project['id'] . ' ₱' . number_format($net), $u['id']);
    return null;
}


/** Settles one hourly project on or after its End Date. Used by the client page and the scheduled job. */
function tt_settle_hourly_core($project)
{
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
        $logs->execute([(int) $project['id']]);
        $hours = $pdo->prepare("SELECT COALESCE(SUM(hours), 0) FROM work_logs
                                WHERE project_id = ? AND status = 'approved'");
        $hours->execute([(int) $project['id']]);
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
        $error = tt_settle_hourly_core(tt_db_project(1000 + (int) $project_id));
        if ($error) { error_log('TopTunity hourly settlement failed: ' . $error); }
    }
}

/** Settles every hourly project whose End Date has passed, for all clients. Run once a day by the scheduled job. */
function tt_settle_all_due_hourly()
{
    $stmt = db()->query("SELECT DISTINCT p.id FROM projects p
                         JOIN payments e ON e.project_id = p.id AND e.type = 'escrow' AND e.status = 'held'
                         WHERE p.billing_type = 'hourly' AND p.deadline <= CURDATE()");
    $done = 0;
    foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $project_id) {
        $error = tt_settle_hourly_core(tt_db_project(1000 + (int) $project_id));
        if ($error) { error_log('TopTunity hourly settlement failed: ' . $error); } else { $done++; }
    }
    return $done;
}

/**
 * Cancels a project the client owns. Allowed only before any work is submitted.
 * The held deposit is refunded in full; after work is submitted, the client must file a dispute.
 */
function tt_db_cancel_project($site_id)
{
    $user = tt_current_user();
    $project = tt_db_project($site_id);
    if (tt_project_is_removed($project)) { return 'This project was removed by an administrator, so it cannot be changed.'; }
    if (!$project || (int) $project['client_id'] !== (int) ($user['id'] ?? 0)) { return 'This project is not yours.'; }
    if (in_array($project['status'], ['completed', 'cancelled'], true)) { return 'This project can no longer be cancelled.'; }

    $pdo = db();
    $pdo->beginTransaction();
    try {
        $sub = $pdo->prepare('SELECT COUNT(*) FROM project_submissions WHERE project_id = ?');
        $sub->execute([(int) $project['id']]);
        if ((int) $sub->fetchColumn() > 0) { $pdo->rollBack(); return 'Work has already been submitted, so the project cannot be cancelled. File a dispute instead.'; }

        $lock = $pdo->prepare("SELECT * FROM payments WHERE project_id = ? AND type = 'escrow' AND status = 'held' ORDER BY id DESC LIMIT 1 FOR UPDATE");
        $lock->execute([(int) $project['id']]);
        $escrow = $lock->fetch();
        $refunded = 0;
        if ($escrow) {
            $pdo->prepare("UPDATE payments SET status = 'refunded' WHERE id = ?")->execute([(int) $escrow['id']]);
            $pdo->prepare("INSERT INTO payments (project_id, type, amount, service_fee, status) VALUES (?, 'refund', ?, 0, 'refunded')")
                ->execute([(int) $project['id'], (int) $escrow['amount']]);
            $refunded = (int) $escrow['amount'];
        }
        $pdo->prepare("UPDATE projects SET status = 'cancelled' WHERE id = ?")->execute([(int) $project['id']]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        error_log('TopTunity cancel project failed: ' . $e->getMessage());
        return 'The project could not be cancelled. Please try again.';
    }
    if (!empty($project['freelancer_id'])) {
        tt_notify((int) $project['freelancer_id'], 'projects', 'Project cancelled', $project['title'] . ' was cancelled by the client.');
    }
    tt_notify((int) $project['client_id'], 'payments', 'Project cancelled',
              $project['title'] . ($refunded > 0 ? ' was cancelled. ₱' . number_format($refunded) . ' was refunded.' : ' was cancelled.'));
    tt_audit('cancel project', 'project #' . $project['id'] . ($refunded > 0 ? ' refund ₱' . number_format($refunded) : ''), $user['id']);
    return null;
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
    return db()->query($sql . ' ORDER BY w.id DESC')->fetchAll();
}

/** Admin marks a withdrawal processed or rejected. Returns null or an error. */
function tt_db_process_withdrawal($id, $action, $reason = '', $reference = '')
{
    $pdo = db();
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("SELECT * FROM withdrawals WHERE id = ? FOR UPDATE");
        $stmt->execute([(int) $id]);
        $w = $stmt->fetch();
        if (!$w)                            { $pdo->rollBack(); return 'That request was not found.'; }
        if (false && !in_array((int) $w['freelancer_id'], tt_demo_ids(), true)) {
            $pdo->rollBack();
            return 'The demo administrator can only process withdrawals for demo accounts.';
        }
        if ($w['status'] !== 'pending')     { $pdo->rollBack(); return 'This request has already been handled.'; }
        if ($action === 'reject' && mb_strlen(trim($reason)) < 10) { $pdo->rollBack(); return 'Give a reason for rejecting (at least 10 characters).'; }
        $reference = strtoupper(trim($reference));
        if ($action === 'process') {
            if (mb_strlen($reference) < 4) { $pdo->rollBack(); return 'Enter the transfer reference from your GCash or bank transfer.'; }
            $dup = $pdo->prepare('SELECT COUNT(*) FROM withdrawals WHERE reference = ?');
            $dup->execute([$reference]);
            if ((int) $dup->fetchColumn() > 0) { $pdo->rollBack(); return 'That transfer reference was already used for another withdrawal.'; }
        }
        $new = $action === 'process' ? 'processed' : 'rejected';
        if ($new === 'processed') {
            $pdo->prepare('UPDATE withdrawals SET status = ?, processed_at = NOW(), reference = ? WHERE id = ?')->execute([$new, $reference, (int) $w['id']]);
        } else {
            $pdo->prepare('UPDATE withdrawals SET status = ? WHERE id = ?')->execute([$new, (int) $w['id']]);
        }
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        return 'The request could not be updated. Please try again.';
    }
    tt_notify($w['freelancer_id'], 'payments', $new === 'processed' ? 'Withdrawal sent' : 'Withdrawal rejected',
              $new === 'processed' ? '₱' . number_format($w['amount']) . ' was sent to your ' . $w['method'] . ' account. Reference ' . $reference . '.'
                                   : '₱' . number_format($w['amount']) . ' was returned to your balance. Reason: ' . $reason);
    tt_audit('withdrawal ' . $new, 'request #' . $w['id'] . ' ₱' . number_format($w['amount']));
    return null;
}

/** Admin payments list with totals. */
function tt_admin_payments_db()
{
    $sql = "SELECT pay.*, p.title, p.billing_type, p.client_id, p.freelancer_id
            FROM payments pay JOIN projects p ON p.id = pay.project_id";
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
    $money = tt_freelancer_money();
    $fee = 0; $completed = [];
    foreach ($money['escrow'] as $row) {
        if ($row['status'] === 'released') {
            $fee += (int) $row['service_fee'];
            $completed[] = ['date' => date('M j, Y', strtotime($row['created_at'])), 'project' => $row['title'],
                            'billing' => $row['billing_type'] === 'hourly' ? 'Hourly' : 'Fixed Price',
                            'payment' => (int) $row['amount'], 'fee' => (int) $row['service_fee'], 'net' => (int) $row['net'], 'sample' => false];
        }
    }
    return ['available' => $money['available'], 'on_hold' => $money['on_hold'], 'net' => $money['earned'], 'fee' => $fee,
            'completed' => $completed, 'sample' => false,
            'withdrawals' => array_map(function ($w) {
                return ['id' => (int) $w['id'], 'date' => date('M j, Y', strtotime($w['created_at'])),
                        'method' => $w['method'] === 'gcash' ? 'GCash' : 'Bank', 'account' => $w['account'],
                        'amount' => (int) $w['amount'], 'status' => $w['status'], 'sample' => false,
                        'processed' => $w['processed_at'] ? date('M j, Y · g:i A', strtotime($w['processed_at'])) : '',
                        'reference' => (string) ($w['reference'] ?? '')];
            }, $money['withdrawals'])];
}

/** Client payments: demo sample rows plus the real deposits and releases. */
function toptunity_client_payments()
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'client') { return []; }
    $stmt = db()->prepare("SELECT pay.id, pay.type, pay.amount, pay.service_fee, pay.status, pay.created_at, pay.reference, pay.method, pay.transfer_ref, p.title
                           FROM payments pay JOIN projects p ON p.id = pay.project_id
                           WHERE p.client_id = ? ORDER BY pay.id DESC");
    $stmt->execute([(int) $u['id']]);
    $out = [];
    foreach ($stmt->fetchAll() as $r) {
        $out[] = ['id' => (int) $r['id'], 'reference' => (string) $r['reference'], 'method' => (string) $r['method'], 'transfer_ref' => (string) $r['transfer_ref'], 'date' => date('Y-m-d', strtotime($r['created_at'])), 'project' => $r['title'],
                  'type' => ['release' => 'Release', 'refund' => 'Refund'][$r['type']] ?? 'Deposit', 'amount' => (int) $r['amount'],
                  'fee' => (int) $r['service_fee'], 'status' => $r['status'], 'sample' => false];
    }
    return $out;
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
                   'amount' => (int) $r['amount'], 'fee' => (int) $r['service_fee'], 'status' => $r['status'], 'sample' => false,
                   'reference' => (string) ($r['reference'] ?? ''), 'method' => (string) ($r['method'] ?? ''), 'transfer_ref' => (string) ($r['transfer_ref'] ?? '')];
    }
    $sample = [];
    return array_merge($real, $sample);
}

/** Platform totals for the admin dashboard: demo figures plus the real records. */
function toptunity_admin_money_totals()
{
    [$rows, $real] = tt_admin_payments_db();
    $held_projects = 0;
    foreach ($rows as $r) { if ($r['status'] === 'held') { $held_projects++; } }
    $pending_withdrawals = count(array_filter(tt_admin_withdrawals_db(), function ($w) { return $w['status'] === 'pending'; }));
    $sample = false;
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
    $rows = db()->query("SELECT w.id, w.method, w.account, w.amount, w.status, w.created_at, w.processed_at, w.reference, u.name AS freelancer
                         FROM withdrawals w JOIN users u ON u.id = w.freelancer_id ORDER BY w.created_at DESC")->fetchAll();
    $out = [];
    foreach ($rows as $r) {
        $out[] = ['id' => 'W-' . $r['id'], 'date' => date('M j, Y', strtotime($r['created_at'])), 'freelancer' => $r['freelancer'],
                  'method' => $r['method'] === 'gcash' ? 'GCash' : 'Bank Account', 'account' => $r['account'],
                  'amount' => (int) $r['amount'], 'status' => $r['status'], 'sample' => false,
                  'processed' => $r['processed_at'] ? date('M j, Y · g:i A', strtotime($r['processed_at'])) : '', 'reference' => (string) ($r['reference'] ?? '')];
    }
    return $out;
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
    if (!false) { db()->prepare('UPDATE users SET name = ? WHERE id = ?')->execute([$name, (int) $u['id']]); }
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
    if (false && strcasecmp($email, $u['email']) !== 0) { return 'The demo account email cannot be changed.'; }
    $other = tt_find_user_by_email($email);
    if ($other && (int) $other['id'] !== (int) $u['id']) { return 'Another account already uses that email.'; }
    if (!false) { db()->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?')->execute([$name, $email, (int) $u['id']]); }
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
    if (!false) { db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?')->execute([password_hash($new, PASSWORD_DEFAULT), (int) $u['id']]); }
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
    return tt_real_notifications();
}

function toptunity_freelancer_notifications()
{
    return tt_real_notifications();
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
            'alert' => 'risk-alerts.php',
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
    return tt_real_notifications();
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
                ->execute([(int) $n['id'], (int) (tt_current_user()['id'] ?? 0)]);
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
                                  p.client_id, p.contract_status, u.name AS client
                           FROM proposals pr JOIN projects p ON p.id = pr.project_id JOIN users u ON u.id = p.client_id
                           WHERE pr.freelancer_id = ? ORDER BY pr.id DESC");
    $stmt->execute([(int) $u['id']]);
    $out = [];
    foreach ($stmt->fetchAll() as $r) {
        $out[] = ['key' => 'r' . $r['id'], 'id' => (int) $r['id'], 'project_id' => 1000 + (int) $r['pid'], 'client_id' => (int) $r['client_id'],
                  'title' => $r['title'], 'client' => $r['client'], 'type' => $r['billing_type'], 'offer' => (int) $r['offer'],
                  'days' => (int) $r['days'], 'status' => tt_proposal_stage($r['status'], $r['contract_status']), 'sent' => $r['created_at'], 'real' => true,
                  'contract_status' => $r['contract_status']];
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
        if (!false) { db()->prepare('UPDATE users SET name = ? WHERE id = ?')->execute([$name, (int) $u['id']]); }
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

/** Sample data is intentionally disabled for the live app. */
function tt_show_sample()
{
    return false;
}

/** Real freelancers (keys are 5000 + user id so they never clash with the sample ids). */
function tt_real_freelancers()
{
    $palette = [['#CCFBF1', '#1E293B', 'short'], ['#FFEDD5', '#1E293B', 'long'], ['#E0E7FF', '#1E293B', 'short'], ['#FEF9C3', '#1E293B', 'long']];
    // the demo accounts are shown only to the demo accounts
    $hide = '';
    $rows = db()->query("SELECT u.id, u.name, u.avatar, u.created_at, fp.title, fp.location, fp.hourly_rate, fp.about, fp.languages, fp.photo, fp.available,
                                (SELECT COUNT(*) FROM projects p WHERE p.freelancer_id = u.id AND p.status = 'completed') AS completed
                         FROM users u LEFT JOIN freelancer_profiles fp ON fp.user_id = u.id
                         WHERE u.role = 'freelancer' AND u.status = 'active'$hide ORDER BY u.id")->fetchAll();
    $out = [];
    foreach ($rows as $r) {
        $skills = db()->prepare('SELECT s.name FROM freelancer_skills fs JOIN skills s ON s.id = fs.skill_id WHERE fs.freelancer_id = ? ORDER BY s.name');
        $skills->execute([(int) $r['id']]);
        $grp = db()->prepare('SELECT DISTINCT c.work_group FROM freelancer_skills fs JOIN skills s ON s.id = fs.skill_id JOIN categories c ON c.id = s.category_id WHERE fs.freelancer_id = ? AND c.work_group IS NOT NULL');
        $grp->execute([(int) $r['id']]);
        $groups = $grp->fetchAll(PDO::FETCH_COLUMN);
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
        // Rating, review count and reviews come from the reviews table
        $reviews = tt_review_items((int) $r['id']);
        $rating  = $reviews ? round(array_sum(array_column($reviews, 'stars')) / count($reviews), 1) : 0;
        // On-time delivery: finished projects whose last submitted work was on or before the deadline
        $ot = db()->prepare("SELECT COUNT(*) AS total,
                                    SUM(CASE WHEN DATE(sub.last_sent) <= p.deadline THEN 1 ELSE 0 END) AS on_time
                             FROM projects p
                             JOIN (SELECT project_id, MAX(created_at) AS last_sent FROM project_submissions GROUP BY project_id) sub ON sub.project_id = p.id
                             WHERE p.freelancer_id = ? AND p.status = 'completed'");
        $ot->execute([(int) $r['id']]);
        $ot = $ot->fetch();
        $ontime = ($ot && (int) $ot['total'] > 0) ? round(((int) $ot['on_time'] / (int) $ot['total']) * 100) . '%' : 'Not rated';
        $out[$key] = ['id' => $key, 'user_id' => (int) $r['id'], 'name' => $r['name'], 'title' => $r['title'] ?: 'Freelancer',
                      'location' => $r['location'] ?: '', 'rating' => $rating, 'reviews' => count($reviews),
                      'completed' => (int) $r['completed'], 'ontime' => $ontime,
                      'rate' => (int) ($r['hourly_rate'] ?: 0),
                      'skills' => array_column($skills->fetchAll(), 'name'), 'groups' => $groups,
                      'about' => preg_split('/\R+/', trim((string) $r['about']), -1, PREG_SPLIT_NO_EMPTY),
                      'bio' => trim((string) $r['about']), 'portfolio' => $portfolio, 'feedback' => $reviews, 'available' => (bool) ($r['available'] ?? 1),
                      'languages' => (string) ($r['languages'] ?? ''),
                      'since' => $r['created_at'] ? date('M j, Y', strtotime($r['created_at'])) : '—',
                      'bg' => $pal[0], 'hair' => $pal[1], 'style' => $pal[2],
                      'photo' => $r['photo'] ?: null, 'avatar' => $r['avatar'] ?: null, 'real' => true];
    }
    return $out;
}

/** Freelancers shown across the site: real active freelancers only. */
function toptunity_freelancers()
{
    return tt_real_freelancers();
}

/** Real open projects in the listing shape. */
function tt_real_listing()
{
    // Open projects from the database, newest first, with the signals the ranking needs
    $rows = db()->query("SELECT p.id, p.title, p.description, p.billing_type, p.budget, p.hourly_rate, p.max_hours,
                                p.deadline, p.created_at, c.name AS category, c.work_group, u.name AS client_name,
                                (SELECT COUNT(*) FROM proposals pr WHERE pr.project_id = p.id) AS proposals,
                                (SELECT COUNT(*) FROM projects d WHERE d.client_id = p.client_id AND d.status = 'completed') AS client_done
                         FROM projects p
                         LEFT JOIN categories c ON c.id = p.category_id
                         JOIN users u ON u.id = p.client_id
                         WHERE p.status = 'open' AND p.freelancer_id IS NULL AND p.contract_status = 'none'
                         ORDER BY p.id DESC LIMIT 200")->fetchAll();
    $out = [];
    foreach ($rows as $r) {
        $sk = db()->prepare('SELECT s.name FROM project_skills ps JOIN skills s ON s.id = ps.skill_id WHERE ps.project_id = ?');
        $sk->execute([(int) $r['id']]);
        $out[1000 + (int) $r['id']] = [
            'id' => 1000 + (int) $r['id'], 'title' => $r['title'], 'category' => $r['category'] ?: 'Other',
            'group' => $r['work_group'] ?: 'Other',
            'client' => $r['client_name'], 'type' => $r['billing_type'],
            'amount' => $r['billing_type'] === 'hourly' ? (int) $r['hourly_rate'] : (int) $r['budget'],
            'max_hours' => (int) $r['max_hours'], 'deadline' => $r['deadline'], 'proposals' => (int) $r['proposals'],
            'status' => 'open', 'age_h' => max(0, (int) floor((time() - strtotime($r['created_at'])) / 3600)),
            'match' => 0, 'skills' => array_column($sk->fetchAll(), 'name'), 'desc' => (string) $r['description'],
            'client_done' => (int) $r['client_done'], 'real' => true,
        ];
    }
    return $out;
}

/** Projects shown in the listings: real active projects only. */
function toptunity_listing()
{
    return array_reverse(tt_real_listing(), true);
}

/** Demo-thread fallbacks are intentionally disabled. */
function toptunity_client_threads_demo()
{
    return [];
}

function toptunity_freelancer_threads_demo()
{
    return [];
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

/**
 * Project ranking score (0 to about 1). Higher = shown first.
 *  relevance   (0.30): how well the search words match the title (x3), skills (x2) and description (x1)
 *  skill match (0.25): neutral for visitors (no freelancer profile)
 *  freshness   (0.25): halves every 48 hours, so new projects rise and older ones drift down
 *  client trust(0.10): completed projects by the client, up to 5
 *  competition (0.10): fewer proposals scores higher
 *  penalty     (-0.10): description shorter than 20 characters
 */
function tt_project_score($p, $query = '')
{
    $rel = 0.5;
    $q = trim((string) $query);
    if ($q !== '') {
        $hits = 0; $max = 0;
        foreach (preg_split('/\s+/', mb_strtolower($q)) as $term) {
            if ($term === '') { continue; }
            $max += 6;
            if (mb_stripos((string) $p['title'], $term) !== false) { $hits += 3; }
            if (mb_stripos(implode(' ', (array) ($p['skills'] ?? [])), $term) !== false) { $hits += 2; }
            if (mb_stripos((string) ($p['desc'] ?? ''), $term) !== false) { $hits += 1; }
        }
        $rel = $max ? min(1, $hits / $max) : 0.5;
    }
    $skill   = 0.5;
    $fresh   = pow(0.5, max(0, (int) ($p['age_h'] ?? 0)) / 48);
    $trust   = isset($p['client_done']) ? min(1, $p['client_done'] / 5) : 0.5;
    $compete = 1 / (1 + max(0, (int) ($p['proposals'] ?? 0)));
    $score = 0.30 * $rel + 0.25 * $skill + 0.25 * $fresh + 0.10 * $trust + 0.10 * $compete;
    if (mb_strlen(trim((string) ($p['desc'] ?? ''))) < 20) { $score -= 0.10; }
    return round($score, 4);
}

/** Reviews a user has received, from the reviews table (newest first). */
function tt_review_items($user_id)
{
    $stmt = db()->prepare("SELECT r.rating, r.body, r.created_at, r.reviewer_id, u.name AS reviewer, p.title AS project
                           FROM reviews r
                           JOIN users u ON u.id = r.reviewer_id
                           LEFT JOIN projects p ON p.id = r.project_id
                           WHERE r.reviewee_id = ? ORDER BY r.created_at DESC");
    $stmt->execute([(int) $user_id]);
    $pal   = [['#CCFBF1', 'long'], ['#FFEDD5', 'short'], ['#DBEAFE', 'bun'], ['#FEF9C3', 'glasses']];
    $items = [];
    foreach ($stmt->fetchAll() as $r) {
        $c = $pal[((int) $r['reviewer_id']) % 4];
        $items[] = ['by' => $r['reviewer'], 'bg' => $c[0], 'style' => $c[1], 'stars' => (int) $r['rating'],
                    'date' => date('M j, Y', strtotime($r['created_at'])), 'project' => $r['project'] ?: '—', 'text' => (string) $r['body']];
    }
    return $items;
}

/** Limits that send an admin risk alert. They do not block anything; the contract still goes through. */
function tt_risk_limits()
{
    return ['fixed_amount' => 100000, 'hourly_rate' => 3000, 'max_hours' => 200, 'hourly_total' => 200000,
            'deadline_days' => 180, 'offer_high' => 1.5, 'offer_low' => 0.3, 'agreed_drift' => 0.5];
}

/** Reasons a project, proposal or contract looks unusual. Empty list = normal. */
function tt_risk_reasons($source, $project, $amount, $agreed = null)
{
    $L = tt_risk_limits();
    $reasons = [];
    $hourly = ($project['billing_type'] ?? '') === 'hourly';
    $budget = (int) ($project['budget'] ?? 0);
    if (!$hourly && $amount >= $L['fixed_amount']) {
        $reasons[] = 'High fixed amount (₱' . number_format($amount) . ')';
    }
    if ($hourly) {
        $rate  = (int) ($project['hourly_rate'] ?? 0);
        $hours = (int) ($project['max_hours'] ?? 0);
        if ($rate > $L['hourly_rate']) { $reasons[] = 'High hourly rate (₱' . number_format($rate) . '/hr)'; }
        if ($hours > $L['max_hours'])  { $reasons[] = 'Very long working hours (' . $hours . ' h)'; }
        if ($rate * $hours > $L['hourly_total']) { $reasons[] = 'High maximum total (₱' . number_format($rate * $hours) . ')'; }
    }
    if (!empty($project['deadline'])) {
        $days = (int) floor((strtotime($project['deadline']) - time()) / 86400);
        if ($days > $L['deadline_days']) { $reasons[] = 'Very long timeline (' . $days . ' days to the deadline)'; }
    }
    if ($source === 'proposal' && !$hourly && $budget > 0) {
        if ($amount > $budget * $L['offer_high']) { $reasons[] = 'Offer is more than 150% of the budget'; }
        if ($amount < $budget * $L['offer_low'])  { $reasons[] = 'Offer is below 30% of the budget'; }
    }
    if ($source === 'contract' && $agreed !== null && !$hourly && $budget > 0) {
        if (abs($agreed - $budget) > $budget * $L['agreed_drift']) { $reasons[] = 'Agreed amount differs from the budget by more than 50%'; }
    }
    return $reasons;
}

/** Records a risk alert and tells every active administrator. Never blocks the action. */
function tt_risk_check($source, $project, $project_id, $user_id, $amount, $agreed = null)
{
    $reasons = tt_risk_reasons($source, $project, (int) $amount, $agreed === null ? null : (int) $agreed);
    if (!$reasons) { return; }
    $text = implode('; ', $reasons);
    db()->prepare('INSERT INTO risk_alerts (source, project_id, user_id, amount, reason) VALUES (?, ?, ?, ?, ?)')
        ->execute([$source, (int) $project_id, (int) $user_id, (int) $amount, mb_substr($text, 0, 255)]);
    $label = ['project' => 'New project', 'proposal' => 'Proposal', 'contract' => 'Contract'][$source];
    $admins = db()->query("SELECT id FROM users WHERE role = 'admin' AND status = 'active'")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($admins as $admin_id) {
        tt_notify((int) $admin_id, 'alert', $label . ' flagged for review', $text . ' · ' . ($project['title'] ?? 'Project'));
    }
}

/** Risk alerts for the admin page (newest first). */
function tt_admin_risk_alerts($status = '')
{
    $sql = "SELECT ra.id, ra.source, ra.amount, ra.reason, ra.status, ra.created_at, u.name, u.role, p.title, p.id AS pid
            FROM risk_alerts ra
            LEFT JOIN users u ON u.id = ra.user_id
            LEFT JOIN projects p ON p.id = ra.project_id";
    $params = [];
    if ($status === 'new' || $status === 'reviewed') { $sql .= ' WHERE ra.status = ?'; $params[] = $status; }
    $stmt = db()->prepare($sql . ' ORDER BY ra.id DESC LIMIT 200');
    $stmt->execute($params);
    $out = [];
    foreach ($stmt->fetchAll() as $r) {
        $out[] = ['id' => (int) $r['id'], 'source' => ucfirst($r['source']), 'user' => $r['name'] ?: '—', 'role' => ucfirst((string) $r['role']),
                  'project' => $r['title'] ?: '—', 'site_id' => $r['pid'] ? 1000 + (int) $r['pid'] : null,
                  'amount' => (int) $r['amount'], 'reason' => $r['reason'], 'status' => $r['status'],
                  'date' => date('M j, Y · g:i A', strtotime($r['created_at']))];
    }
    return $out;
}

/** Marks an alert as reviewed by the administrator. */
function tt_admin_mark_alert($alert_id)
{
    $user = tt_current_user();
    if (!$user || $user['role'] !== 'admin') { return 'Administrator access is required.'; }
    db()->prepare("UPDATE risk_alerts SET status = 'reviewed' WHERE id = ?")->execute([(int) $alert_id]);
    tt_audit('review risk alert', 'alert #' . (int) $alert_id);
    return null;
}

/** Plain-language work groups (Programmer, Designer, ...) in a fixed display order. */
function tt_work_groups()
{
    $order = ['Programmer', 'Designer', 'Editor', 'Writer', 'Marketer', 'Admin Assistant'];
    $found = db()->query("SELECT DISTINCT work_group FROM categories WHERE work_group IS NOT NULL")->fetchAll(PDO::FETCH_COLUMN);
    $found = array_values(array_intersect($order, $found));
    return $found;
}

/**
 * Shows where a freelancer's proposal really is. A selected proposal becomes an offer when the
 * contract is sent, ongoing when accepted and completed when finished. Nothing is typed in.
 */
function tt_proposal_stage($proposal_status, $contract_status)
{
    if ($proposal_status !== 'selected') { return $proposal_status; }
    if ($contract_status === 'pending')   { return 'offer'; }
    if ($contract_status === 'active')    { return 'ongoing'; }
    if ($contract_status === 'completed') { return 'completed'; }
    return 'selected';
}

/** Progress from the real stage: 0 before a contract, then up to 100 once the work is approved and finished. */
function tt_project_progress($project_id, $contract_status)
{
    if ($contract_status === 'completed') { return 100; }
    if ($contract_status !== 'active')    { return 0; }
    $sub = tt_project_submission(1000 + (int) $project_id);
    if ($sub && $sub['status'] === 'pending') { return 86; }
    if ($sub) { return 71; }
    return 57;
}

/** True when this user has already written their review for the project (site id). */
function tt_review_done($project_id, $reviewer_id)
{
    // Accepts either the site project ID (1000 + database ID) or the plain database ID
    $db_id = (int) $project_id >= 1000 ? (int) $project_id - 1000 : (int) $project_id;
    $q = db()->prepare('SELECT COUNT(*) FROM reviews WHERE reviewer_id = ? AND project_id = ?');
    $q->execute([(int) $reviewer_id, $db_id]);
    return (int) $q->fetchColumn() > 0;
}

/**
 * The status a client, freelancer or admin sees for a project. It is worked out from the database
 * (status, contract and whether a freelancer is chosen), so every page shows the same status.
 * Returns [label, css class].
 */
function tt_project_status_view($status, $contract_status, $has_freelancer)
{
    if ($status === 'cancelled') { return ['Cancelled', 'cancelled']; }
    if ($status === 'removed')   { return ['Removed', 'cancelled']; }
    if ($status === 'completed') { return ['Completed', 'completed']; }
    if ($status === 'ongoing')   { return ['Ongoing', 'ongoing']; }
    if ($status === 'overdue')   { return ['Overdue', 'overdue']; }
    if ($status === 'open' && $has_freelancer) {
        if ($contract_status === 'pending') { return ['Contract Sent', 'open']; }
        if ($contract_status === 'active')  { return ['Ongoing', 'ongoing']; }
        return ['Freelancer Selected', 'open'];
    }
    return [toptunity_status_label($status), $status ?: 'open'];
}

/**
 * The client rates the freelancer after a project is completed. Once per project.
 * Saved to the same reviews table, so the rating shows on the freelancer's profile.
 */
function tt_save_freelancer_review($project_id, $rating, $body)
{
    $u = tt_current_user();
    if (!$u || $u['role'] !== 'client') { return 'Only the client can rate the freelancer.'; }
    $db_id = (int) $project_id >= 1000 ? (int) $project_id - 1000 : (int) $project_id;
    $q = db()->prepare("SELECT id, client_id, freelancer_id, status, title FROM projects WHERE id = ?");
    $q->execute([$db_id]);
    $project = $q->fetch();
    if (!$project || (int) $project['client_id'] !== (int) $u['id']) { return 'This project is not yours.'; }
    if ($project['status'] !== 'completed') { return 'You can rate the freelancer after the project is completed.'; }
    if (empty($project['freelancer_id'])) { return 'This project has no freelancer to rate.'; }
    if ($rating < 1 || $rating > 5) { return 'Choose a rating from 1 to 5.'; }
    if (mb_strlen(trim($body)) < 10) { return 'Write a review of at least 10 characters.'; }
    $check = db()->prepare('SELECT COUNT(*) FROM reviews WHERE reviewer_id = ? AND project_id = ? AND reviewee_id = ?');
    $check->execute([(int) $u['id'], $db_id, (int) $project['freelancer_id']]);
    if ((int) $check->fetchColumn() > 0) { return 'You already rated this freelancer for this project.'; }
    db()->prepare('INSERT INTO reviews (reviewer_id, reviewee_id, project_id, rating, body) VALUES (?, ?, ?, ?, ?)')
        ->execute([(int) $u['id'], (int) $project['freelancer_id'], $db_id, (int) $rating, trim($body)]);
    tt_notify((int) $project['freelancer_id'], 'feedback', 'New rating from a client', $project['title'] . ' was rated ' . (int) $rating . ' out of 5.');
    tt_audit('rate freelancer', 'project #' . $db_id . ' rating ' . (int) $rating, $u['id']);
    return null;
}

/**
 * Keeps the project status in step with the deadline, without anyone clicking anything:
 * an active fixed-price project past its deadline becomes Overdue, and goes back to Ongoing when the deadline is extended.
 * Runs on the dashboards and in the daily job.
 */
function tt_refresh_project_statuses()
{
    db()->exec("UPDATE projects SET status = 'overdue'
                WHERE status = 'ongoing' AND billing_type = 'fixed' AND contract_status = 'active' AND deadline < CURDATE()");
    db()->exec("UPDATE projects SET status = 'ongoing'
                WHERE status = 'overdue' AND contract_status = 'active' AND deadline >= CURDATE()");
}