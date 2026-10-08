<?php
/**
 * pages/forgot-password.php - Password reset in three steps.
 * Shows all three steps at once, as in the design. Wire each step to a backend later.
 */
$user_role = "public";
$base_url  = "/Webdev/";

$page_title = "Forgot Password";
include '../includes/header.php';
include '../includes/nav.php';

// Demo values shown in the design
$demo_email = 'andrea.santos@kapelokal.ph';
?>

<main class="page-browse">
  <div class="container">

    <header class="page-head">
      <h1>Forgot Password</h1>
      <p>Reset your password in three quick steps.</p>
    </header>

    <div class="forgot-grid">

      <!-- Step 1 -->
      <section class="step-card">
        <div class="step-tag"><b>1</b> Step 1</div>
        <h2>Enter Email Address</h2>
        <p>Enter the email address you registered with and we'll send you a reset link.</p>
        <form method="post" action="">
          <div class="field">
            <label for="reset-email">Email Address</label>
            <div class="input-wrap">
              <?= icon('mail', 16) ?>
              <input type="email" id="reset-email" name="email" value="<?= e($demo_email) ?>" placeholder="you@example.com">
            </div>
          </div>
          <button type="submit" class="btn btn--primary btn--full">Send Reset Link</button>
        </form>
        <a href="login.php" class="auth-back">← Back to Login</a>
      </section>

      <!-- Step 2 -->
      <section class="step-card">
        <div class="step-tag"><b>2</b> Step 2</div>
        <h2>Reset Link Sent</h2>
        <p>We sent a password reset link to <strong><?= e($demo_email) ?></strong>. The link expires in 30 minutes.</p>
        <div class="reset-art" aria-hidden="true">
          <div class="reset-art__icon"><?= icon('mail', 30) ?></div>
        </div>
        <button type="button" class="btn btn--outline">Resend Link</button>
        <a href="login.php" class="auth-back">← Back to Login</a>
      </section>

      <!-- Step 3 (current) -->
      <section class="step-card is-current">
        <div class="step-tag"><b>3</b> Step 3</div>
        <h2>Set New Password</h2>
        <p>Opened from the link in your email. Use at least 8 characters.</p>
        <form method="post" action="">
          <div class="field">
            <label for="new-pass">New Password</label>
            <div class="input-wrap">
              <?= icon('lock', 16) ?>
              <input type="password" id="new-pass" name="password" value="Password123" autocomplete="new-password">
            </div>
          </div>
          <div class="field">
            <label for="confirm-pass">Confirm Password</label>
            <div class="input-wrap">
              <?= icon('lock', 16) ?>
              <input type="password" id="confirm-pass" name="confirm" value="Password123" autocomplete="new-password">
            </div>
          </div>
          <div class="strength" aria-hidden="true">
            <span class="on"></span><span class="on"></span><span class="on"></span><span></span>
          </div>
          <p class="strength-label">Strong password</p>
          <button type="submit" class="btn btn--primary btn--full">Set New Password</button>
        </form>
      </section>

    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>