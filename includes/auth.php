<?php
/**
 * includes/auth.php - sign in, sign up, sessions and access rules.
 * NEW FILE. Accounts are kept in storage/users.json until a database is connected.
 * Demo accounts are created the first time the file is needed.
 */
require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Fallbacks so the site works even when PHP's mbstring extension is not installed. */
if (!function_exists('mb_strlen')) {
    function mb_strlen($str, $encoding = null)
    {
        return preg_match_all('/./su', (string) $str, $m) ?: strlen((string) $str);
    }
}
if (!function_exists('mb_substr')) {
    function mb_substr($str, $start, $length = null, $encoding = null)
    {
        preg_match_all('/./su', (string) $str, $m);
        return implode('', array_slice($m[0], $start, $length));
    }
}







/** Start a signed-in session for this user. */
function tt_login($user)
{
    session_regenerate_id(true);
    $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'role' => $user['role']];
}

function tt_logout()
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
}

function tt_current_user()
{
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

/** Set a one-time message (when $msg is given) or read and clear it. */
function tt_flash($msg = null)
{
    if ($msg !== null) {
        $_SESSION['flash'] = $msg;
        return null;
    }
    $m = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
    unset($_SESSION['flash']);
    return $m;
}

/** Where each role's home page is. */
function tt_home_for($role)
{
    if ($role === 'client')     { return 'client/dashboard.php'; }
    if ($role === 'freelancer') { return 'freelancer/dashboard.php'; }
    if ($role === 'admin')      { return 'admin/dashboard.php'; }
    return 'pages/index.php';
}

/**
 * Only allow a path relative to the site (no other websites).
 * Paths without a folder go to pages/, e.g. "freelancer-profile.php?id=2" -> "pages/freelancer-profile.php?id=2".
 */
function tt_clean_next($value)
{
    $value = trim((string) $value);
    if ($value === '' || preg_match('#^(https?:)?//#i', $value) || strpos($value, '\\') !== false || strpos($value, "\n") !== false) {
        return '';
    }
    if (!preg_match('#^(client|freelancer|admin|pages)/#', $value)) {
        $value = 'pages/' . $value;
    }
    return $value;
}

/** Send a signed-in user to the right place. */
function tt_redirect_after_login($user, $next, $base)
{
    if ($next !== '') {
        header('Location: ' . $base . $next);
        exit;
    }
    if (in_array($user['role'], ['client', 'freelancer', 'admin'], true)) {
        header('Location: ' . $base . tt_home_for($user['role']));
        exit;
    }
    tt_flash('Signed in as ' . $user['name'] . '. The ' . $user['role'] . ' area is coming next.');
    header('Location: ' . $base . 'pages/index.php');
    exit;
}

/** If someone is already signed in, send them to their home page instead of showing the form. */
function tt_redirect_if_signed_in($base, $next)
{
    $user = tt_current_user();
    if (!$user) {
        return;
    }
    // Only use the requested page if it belongs to this user's role (or is public), otherwise go home
    $allowed = $next !== '' && (strpos($next, $user['role'] . '/') === 0 || strpos($next, 'pages/') === 0);
    $target  = $allowed ? $next : tt_home_for($user['role']);
    header('Location: ' . $base . $target);
    exit;
}

/** Where the TopTunity logo should go: the user's dashboard if signed in as a client or freelancer, else the homepage. */
function tt_brand_home()
{
    $u = tt_current_user();
    return ($u && in_array($u['role'], ['client', 'freelancer', 'admin'], true)) ? tt_home_for($u['role']) : 'pages/index.php';
}


/* ==========================================================================
   ACCOUNTS (stored in the MySQL "users" table; passwords are hashed)
   ========================================================================== */

/** The demo accounts. They are added to the database the first time they are needed. */
function tt_demo_accounts()
{
    return [
        ['name' => 'Andrea Santos',   'email' => 'andrea.santos@kapelokal.ph', 'role' => 'client',     'password' => 'password123'],
        ['name' => 'Miguel Reyes',    'email' => 'miguel.reyes@example.com',   'role' => 'freelancer', 'password' => 'password123'],
        ['name' => 'TopTunity Admin', 'email' => 'admin@toptunity.ph',         'role' => 'admin',      'password' => 'admin123'],
    ];
}

/** Adds any missing demo account (existing accounts are left alone). */
function tt_ensure_demo_accounts()
{
    static $done = false;
    if ($done) { return; }
    $done = true;
    $stmt = db()->prepare('INSERT IGNORE INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)');
    foreach (tt_demo_accounts() as $d) {
        $stmt->execute([$d['name'], $d['email'], password_hash($d['password'], PASSWORD_DEFAULT), $d['role']]);
    }
}

/** Every account (id, name, email, role, password hash). */
function tt_load_users()
{
    tt_ensure_demo_accounts();
    return db()->query('SELECT id, name, email, role, password_hash AS password FROM users ORDER BY id')->fetchAll();
}

/** One account by email, or null. */
function tt_find_user_by_email($email)
{
    tt_ensure_demo_accounts();
    $stmt = db()->prepare('SELECT id, name, email, role, password_hash AS password FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([trim($email)]);
    $user = $stmt->fetch();
    return $user ?: null;
}

/** Creates a client or freelancer account. Returns the new user, or an error message. */
function tt_register_user($name, $email, $password, $role)
{
    try {
        $stmt = db()->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
    } catch (PDOException $e) {
        if ((int) $e->getCode() === 23000) { return 'An account with this email already exists.'; }
        throw $e;
    }
    return ['id' => (int) db()->lastInsertId(), 'name' => $name, 'email' => $email, 'role' => $role];
}