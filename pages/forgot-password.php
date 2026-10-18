<?php
/**
 * pages/forgot-password.php - Request and complete a one-time password reset.
 */
$user_role = "public";
$base_url  = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');

require_once __DIR__ . '/../includes/auth.php';

$token = (string) ($_GET['token'] ?? $_POST['token'] ?? '');
$token_valid = $token !== '' && tt_password_reset_token_valid($token);
$errors = [];
$email = '';
$reset_requested = isset($_GET['sent']);
$reset_complete = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_reset'])) {
    $email = trim((string) ($_POST['email'] ?? ''));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    } else {
        tt_request_password_reset($email, $base_url);
        header('Location: ' . $base_url . 'pages/forgot-password.php?sent=1');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_password'])) {
    if (!$token_valid) {
        $errors[] = 'This reset link is invalid or expired. Request a new one.';
    } else {
        $error = tt_complete_password_reset($token, (string) ($_POST['password'] ?? ''), (string) ($_POST['confirm'] ?? ''));
        if ($error) { $errors[] = $error; }
        else {
            $reset_complete = true;
            $token_valid = false;
        }
    }
}

$page_title = "Forgot Password";
include '../includes/header.php';
include '../includes/nav.php';
?>

<main class="page-browse">
  <div class="container">
    <header class="page-head">
      <h1>Forgot Password</h1>
      <p>Request a secure link to reset your password.</p>
    </header>

    <?php if ($errors): ?>
      <div class="form-alert" role="alert"><?= icon('alert', 15) ?><div><?php foreach ($errors as $error): ?><div><?= e($error) ?></div><?php endforeach; ?></div></div>
    <?php endif; ?>

    <div class="forgot-grid">
      <section class="step-card">
        <div class="step-tag"><b>1</b> Step 1</div>
        <h2>Enter Email Address</h2>
        <p>We'll send a one-time reset link if an account exists for that email.</p>
        <?php if ($reset_requested): ?>
          <p class="note-box" role="status">If the address belongs to an account, and email delivery is configured, a reset link will arrive within a few minutes. The link expires after 30 minutes.</p>
        <?php else: ?>
          <form method="post" action="forgot-password.php">
            <div class="field">
              <label for="reset-email">Email Address</label>
              <div class="input-wrap">
                <?= icon('mail', 16) ?>
                <input type="email" id="reset-email" name="email" value="<?= e($email) ?>" placeholder="you@example.com" autocomplete="email" required>
              </div>
            </div>
            <button type="submit" name="request_reset" value="1" class="btn btn--primary btn--full">Send Reset Link</button>
          </form>
        <?php endif; ?>
        <a href="login.php" class="auth-back">← Back to Login</a>
      </section>

      <section class="step-card">
        <div class="step-tag"><b>2</b> Step 2</div>
        <h2>Check Your Email</h2>
        <p>Open the reset link from your email. For security, this page does not reveal whether an account exists.</p>
        <div class="reset-art" aria-hidden="true"><div class="reset-art__icon"><?= icon('mail', 30) ?></div></div>
        <a href="forgot-password.php" class="btn btn--outline">Request Another Link</a>
        <a href="login.php" class="auth-back">← Back to Login</a>
      </section>

      <section class="step-card <?= $token_valid ? 'is-current' : '' ?>">
        <div class="step-tag"><b>3</b> Step 3</div>
        <?php if ($reset_complete): ?>
          <h2>Password Updated</h2>
          <p>Your password was changed. You can now sign in with the new password.</p>
          <a href="login.php" class="btn btn--primary btn--full">Go to Login</a>
        <?php elseif ($token_valid): ?>
          <h2>Set New Password</h2>
          <p>Choose a password with at least 8 characters and one number.</p>
          <form method="post" action="forgot-password.php?token=<?= e(urlencode($token)) ?>">
            <input type="hidden" name="token" value="<?= e($token) ?>">
            <div class="field">
              <label for="new-pass">New Password</label>
              <div class="input-wrap"><?= icon('lock', 16) ?><input type="password" id="new-pass" name="password" minlength="8" autocomplete="new-password" required></div>
            </div>
            <div class="field">
              <label for="confirm-pass">Confirm Password</label>
              <div class="input-wrap"><?= icon('lock', 16) ?><input type="password" id="confirm-pass" name="confirm" minlength="8" autocomplete="new-password" required></div>
            </div>
            <button type="submit" name="set_password" value="1" class="btn btn--primary btn--full">Set New Password</button>
          </form>
        <?php else: ?>
          <h2>Set New Password</h2>
          <p>Open a valid, unexpired reset link from your email to choose a new password.</p>
          <a href="forgot-password.php" class="btn btn--outline">Request a Reset Link</a>
        <?php endif; ?>
      </section>
    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>
