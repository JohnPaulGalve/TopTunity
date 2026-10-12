<?php
/**
 * includes/auth.php - sign in, sign up, sessions and access rules.
 * NEW FILE. Accounts are kept in storage/users.json until a database is connected.
 * Demo accounts are created the first time the file is needed.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('TT_USERS_FILE', dirname(__DIR__) . '/storage/users.json');

/** The demo accounts that must always exist. */
function tt_demo_accounts()
{
    return [
        ['id' => 1, 'name' => 'Andrea Santos',   'email' => 'andrea.santos@kapelokal.ph', 'role' => 'client',     'password' => password_hash('password123', PASSWORD_DEFAULT)],
        ['id' => 2, 'name' => 'Miguel Reyes',    'email' => 'miguel.reyes@example.com',   'role' => 'freelancer', 'password' => password_hash('password123', PASSWORD_DEFAULT)],
        ['id' => 3, 'name' => 'TopTunity Admin', 'email' => 'admin@toptunity.ph',         'role' => 'admin',      'password' => password_hash('admin123', PASSWORD_DEFAULT)],
    ];
}

/**
 * Load all accounts. Creates the file if needed, and re-adds any missing demo accounts,
 * so a damaged or empty file can never let a new account take a demo account's place.
 */
function tt_load_users()
{
    if (!is_dir(dirname(TT_USERS_FILE))) {
        mkdir(dirname(TT_USERS_FILE), 0775, true);
    }
    $data  = file_exists(TT_USERS_FILE) ? json_decode((string) file_get_contents(TT_USERS_FILE), true) : [];
    $users = is_array($data) ? array_values($data) : [];

    $changed = false;
    foreach (tt_demo_accounts() as $demo) {
        $present = false;
        foreach ($users as $u) {
            if (strcasecmp($u['email'], $demo['email']) === 0) { $present = true; break; }
        }
        if (!$present) {
            // Never reuse an ID that another account already has
            $taken = array_map(function ($u) { return (int) $u['id']; }, $users);
            if (in_array((int) $demo['id'], $taken, true)) {
                $demo['id'] = max(array_merge([0], $taken)) + 1;
            }
            $users[] = $demo;
            $changed = true;
        }
    }
    if ($changed || !file_exists(TT_USERS_FILE)) {
        tt_save_users($users);
    }
    return $users;
}

function tt_save_users($users)
{
    file_put_contents(TT_USERS_FILE, json_encode(array_values($users), JSON_PRETTY_PRINT), LOCK_EX);
}

function tt_find_user_by_email($email)
{
    foreach (tt_load_users() as $u) {
        if (strcasecmp($u['email'], $email) === 0) {
            return $u;
        }
    }
    return null;
}

/** Create an account. Returns the new user, or an error message string. */
function tt_register_user($name, $email, $password, $role)
{
    if (tt_find_user_by_email($email)) {
        return 'An account with this email already exists.';
    }
    $users = tt_load_users();
    $next_id = 100;
    foreach ($users as $u) { $next_id = max($next_id, (int) $u['id'] + 1); }
    $user = ['id' => $next_id, 'name' => $name, 'email' => $email, 'role' => $role,
             'password' => password_hash($password, PASSWORD_DEFAULT)];
    $users[] = $user;
    tt_save_users($users);
    return $user;
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
    return $role === 'client' ? 'client/dashboard.php' : 'pages/index.php';
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
    if ($user['role'] === 'client') {
        header('Location: ' . $base . 'client/dashboard.php');
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
    $target = $next !== '' ? $next : tt_home_for($user['role']);
    header('Location: ' . $base . $target);
    exit;
}