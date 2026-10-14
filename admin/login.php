<?php
/**
 * admin/login.php - Administrator sign-in (matches the Admin Login design).
 * Not linked from the public site. Only accounts with the admin role can sign in here.
 */
$user_role = "public";
$base_url  = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');

require_once __DIR__ . '/../includes/auth.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    tt_logout();
    session_start();
    header('Location: ' . $base_url . 'admin/login.php');
    exit;
}

$u = tt_current_user();
if ($u && $u['role'] === 'admin') {
    header('Location: ' . $base_url . 'admin/dashboard.php');
    exit;
}

$error = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $user = tt_find_user_by_email($email);
    if (!$user || !password_verify($password, $user['password'])) {
        $error = 'The email or password is incorrect.';
    } elseif ($user['role'] !== 'admin') {
        $error = 'This sign-in is for administrators only.';
    } else {
        tt_login($user);
        header('Location: ' . $base_url . 'admin/dashboard.php');
        exit;
    }
}

$page_title = "Admin Login";
include '../includes/header.php';
include '../includes/nav.php';
?>

<main class="page-browse" style="padding:3rem 0 4rem;">
  <div class="container" style="max-width:420px;">
    <div style="padding:2.2rem 2rem; background:#FFFFFF; border:1px solid var(--color-border-gray); border-radius:var(--radius-lg); box-shadow:0 10px 30px rgba(15,23,42,0.06);">
      <div style="text-align:center;">
        <a href="<?= e($base_url) ?>pages/index.php" class="brand-logo" style="justify-content:center; font-size:1.7rem;">TopTunity<span class="logo-star" aria-hidden="true">&#10022;</span></a>
        <h1 style="font-size:1.4rem; font-weight:700; margin-top:1rem;">Admin Login</h1>
        <p style="font-size:0.78rem; color:var(--color-muted-gray); margin-top:0.25rem;">For the platform administrator only.</p>
      </div>

      <?php if ($error): ?>
        <div class="form-alert" role="alert"><?= icon('alert', 15) ?> <?= e($error) ?></div>
      <?php endif; ?>

      <form method="post" action="login.php" style="margin-top:1.2rem;">
        <div class="field" style="margin-top:0;">
          <label for="email">Email Address</label>
          <div class="input-wrap"><?= icon('mail', 16) ?><input type="email" id="email" name="email" value="<?= e($email) ?>" required></div>
        </div>
        <div class="field">
          <label for="password">Password</label>
          <div class="input-wrap"><?= icon('lock', 16) ?><input type="password" id="password" name="password" required></div>
        </div>
        <button type="submit" class="btn" style="width:100%; height:44px; margin-top:1.2rem; background:var(--color-deep-slate); color:#FFFFFF; border-radius:8px;"><?= icon('shield', 15) ?> Login</button>
      </form>

      <div class="info-callout" style="margin-top:1.2rem;">
        <?= icon('info', 15) ?>
        <span>This page is not linked from public pages. The single admin account is set up directly in the database.</span>
      </div>
    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>