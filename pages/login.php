<?php
/**
 * pages/login.php - Sign in for clients, freelancers and admins.
 * ?next=... returns the user to that page after signing in.
 * ?action=logout signs the user out.
 */
$user_role = "public";
$base_url  = "/Webdev/";

require_once __DIR__ . '/../includes/auth.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    tt_logout();
    session_start();
    tt_flash('You have been signed out.');
    header('Location: ' . $base_url . 'pages/login.php');
    exit;
}

$next  = tt_clean_next(isset($_POST['next']) ? $_POST['next'] : (isset($_GET['next']) ? $_GET['next'] : ''));

// Already signed in? Go straight to the home page.
tt_redirect_if_signed_in($base_url, $next);
$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $user = tt_find_user_by_email($email);
    if (!$user || !password_verify($password, $user['password'])) {
        $error = 'The email or password is incorrect.';
    } else {
        tt_login($user);
        tt_redirect_after_login($user, $next, $base_url);
    }
}

$page_title = "Login";
include '../includes/header.php';
include '../includes/nav.php';
?>

<main class="page-browse">
  <div class="container">
    <div class="auth-wrap">

      <div class="auth-art">
        <span class="auth-art__blob auth-art__blob--a"></span>
        <span class="auth-art__blob auth-art__blob--b"></span>
        <div class="auth-art__content">
          <p class="auth-art__eyebrow">Welcome back</p>
          <h2>Your next project is waiting for you.</h2>
        </div>
      </div>

      <div class="auth-form">
        <h2>Login</h2>
        <p>Welcome back. Log in to your client or freelancer account.</p>

        <?php if ($error): ?>
          <div class="form-alert" role="alert"><?= icon('alert', 15) ?> <?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" action="login.php">
          <input type="hidden" name="next" value="<?= e($next) ?>">

          <div class="field">
            <label for="email">Email Address</label>
            <div class="input-wrap">
              <?= icon('mail', 16) ?>
              <input type="email" id="email" name="email" value="<?= e($email) ?>" placeholder="you@example.com" autocomplete="email" required>
            </div>
          </div>

          <div class="field">
            <label for="password">Password</label>
            <div class="input-wrap">
              <?= icon('lock', 16) ?>
              <input type="password" id="password" name="password" placeholder="Your password" autocomplete="current-password" required>
            </div>
          </div>

          <div class="form-row">
            <label class="check-label"><input type="checkbox" name="remember"> Remember me</label>
            <a href="forgot-password.php" class="link-teal">Forgot Password?</a>
          </div>

          <button type="submit" class="btn btn--primary btn--full">Login</button>
        </form>

        <div class="or-divider">New to TopTunity?</div>
        <p class="auth-foot">Don't have an account? <a href="register.php" class="link-teal">Register</a></p>

        <p class="hint" style="margin-top:1.2rem;">Demo: andrea.santos@kapelokal.ph / password123 (client)</p>
      </div>

    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>