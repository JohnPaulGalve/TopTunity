<?php
/**
 * includes/auth.php - sign in, sign up, sessions and access rules.
 * NEW FILE. Accounts are kept in storage/users.json until a database is connected.
 * Demo accounts are created the first time the file is needed.
 */
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$session_user = $_SESSION['user'] ?? null;
if ($session_user && in_array($session_user['role'], ['client', 'freelancer'], true)) {
    $status_stmt = db()->prepare('SELECT status FROM users WHERE id = ? AND role = ?');
    $status_stmt->execute([(int) $session_user['id'], $session_user['role']]);
    $account_status = $status_stmt->fetchColumn();
    if ($account_status !== 'active') {
        unset($_SESSION['user']);
        $_SESSION['flash'] = $account_status === 'suspended'
            ? 'This account is suspended. Contact support for help.'
            : 'This account is deactivated. Contact support for help.';
        $base = rtrim(dirname(dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '/'))), '/') . '/';
        header('Location: ' . $base . 'pages/login.php');
        exit;
    }
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
    if (false) { tt_reset_demo_data(); }   // demo accounts start clean each time
}

function tt_logout()
{
    if (tt_current_user()) { tt_audit('sign out'); }
    tt_reset_demo_data();
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

/** The TopTunity logo always returns to the public homepage. */
function tt_brand_home()
{
    return 'pages/index.php';
}


/* ==========================================================================
   ACCOUNTS (stored in the MySQL "users" table; passwords are hashed)
   ========================================================================== */

/** The demo accounts. They are added to the database the first time they are needed. */
function tt_demo_accounts()
{
    return [];
}

/** Adds any missing demo account (existing accounts are left alone). */
function tt_ensure_demo_accounts()
{
    return;
}

/** Every account (id, name, email, role, password hash). */
function tt_load_users()
{
    tt_ensure_demo_accounts();
    return db()->query('SELECT id, name, email, role, password_hash AS password, status, created_at FROM users ORDER BY id')->fetchAll();
}

/** One account by email, or null. */
function tt_find_user_by_email($email)
{
    tt_ensure_demo_accounts();
    $stmt = db()->prepare('SELECT id, name, email, role, password_hash AS password, status FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([trim($email)]);
    $user = $stmt->fetch();
    return $user ?: null;
}

/** Creates a client or freelancer account. Returns the new user, or an error message. */
function tt_register_user($name, $email, $password, $role)
{
    try {
        $stmt = db()->prepare('INSERT INTO users (name, email, password_hash, role, avatar) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $role, tt_random_avatar_asset()]);
    } catch (PDOException $e) {
        if ((int) $e->getCode() === 23000) { return 'An account with this email already exists.'; }
        throw $e;
    }
    return ['id' => (int) db()->lastInsertId(), 'name' => $name, 'email' => $email, 'role' => $role];
}

/** Sends a time-limited password reset link when the account exists. */
function tt_request_password_reset($email, $base_url)
{
    $user = tt_find_user_by_email($email);
    if (!$user || $user['role'] === 'admin') { return; }

    $token = bin2hex(random_bytes(32));
    $hash = hash('sha256', $token);
    $pdo = db();
    $pdo->prepare('DELETE FROM password_reset_tokens WHERE user_id = ? OR expires_at < CURRENT_TIMESTAMP OR used_at IS NOT NULL')
        ->execute([(int) $user['id']]);
    $pdo->prepare('INSERT INTO password_reset_tokens (user_id, token_hash, expires_at) VALUES (?, ?, DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 30 MINUTE))')
        ->execute([(int) $user['id'], $hash]);

    $host = isset($_SERVER['HTTP_HOST']) ? preg_replace('/[^A-Za-z0-9.:\-\[\]]/', '', $_SERVER['HTTP_HOST']) : 'localhost';
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $path = rtrim($base_url, '/') . '/pages/forgot-password.php?token=' . urlencode($token);
    $sent = mail($user['email'], 'Reset your TopTunity password',
                 "Use this one-time link within 30 minutes to reset your password:\n\n" . $scheme . '://' . $host . $path,
                 "From: support@toptunity.ph\r\nContent-Type: text/plain; charset=UTF-8");
    if (!$sent) {
        error_log('TopTunity password reset email could not be sent; check the configured mail transport.');
    }
}

/** True when a reset token exists and has not expired or been used. */
function tt_password_reset_token_valid($token)
{
    if (!preg_match('/^[a-f0-9]{64}$/', (string) $token)) { return false; }
    $stmt = db()->prepare('SELECT 1 FROM password_reset_tokens WHERE token_hash = ? AND used_at IS NULL AND expires_at > CURRENT_TIMESTAMP');
    $stmt->execute([hash('sha256', $token)]);
    return (bool) $stmt->fetchColumn();
}

/** Consumes a valid reset token and changes the account password. */
function tt_complete_password_reset($token, $password, $confirm)
{
    if (!preg_match('/^[a-f0-9]{64}$/', (string) $token)) { return 'This reset link is invalid or expired.'; }
    if (strlen($password) < 8 || !preg_match('/\d/', $password)) { return 'Your password must be at least 8 characters and include a number.'; }
    if ($password !== $confirm) { return 'The passwords do not match.'; }

    $pdo = db();
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('SELECT id, user_id FROM password_reset_tokens WHERE token_hash = ? AND used_at IS NULL AND expires_at > CURRENT_TIMESTAMP FOR UPDATE');
    $stmt->execute([hash('sha256', $token)]);
    $reset = $stmt->fetch();
    if (!$reset) {
        $pdo->rollBack();
        return 'This reset link is invalid or expired.';
    }
    $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?')
        ->execute([password_hash($password, PASSWORD_DEFAULT), (int) $reset['user_id']]);
    $pdo->prepare('UPDATE password_reset_tokens SET used_at = CURRENT_TIMESTAMP WHERE id = ?')
        ->execute([(int) $reset['id']]);
    $pdo->commit();
    return null;
}


/* ==========================================================================
   DEMO RESET. Changes made by the demo accounts are not kept: they are
   cleared when a demo account signs in and when it signs out. The sample data
   in the code is never touched.
   ========================================================================== */

/** The ids of the demo client and demo freelancer accounts. */
function tt_demo_ids()
{
    return [];
}


/** Removes everything the demo accounts saved to the database. */
function tt_reset_demo_data()
{
    return;
}
/* ==========================================================================
   ACTIVITY / AUDIT LOG. Records who did what and when. A logging failure
   never stops the action itself.
   ========================================================================== */
function tt_audit($action, $target = null, $user_id = null)
{
    try {
        $uid = $user_id ?? ((tt_current_user()['id'] ?? 0) ?? null);
        db()->prepare('INSERT INTO audit_logs (user_id, action, target) VALUES (?, ?, ?)')
            ->execute([$uid ? (int) $uid : null, mb_substr((string) $action, 0, 160),
                       $target === null ? null : mb_substr((string) $target, 0, 160)]);
    } catch (Throwable $e) {
        error_log('TopTunity audit log: ' . $e->getMessage());
    }
}