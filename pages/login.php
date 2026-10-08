<?php
/**
 * pages/login.php - Shared client/freelancer login
 * Pass ?next=page.php?id=N to return the user there after login.
 * Form submission is not wired to a backend yet.
 */
$user_role = "public";
$base_url  = "/Webdev/";
$next      = isset($_GET['next']) ? $_GET['next'] : '';

$page_title = "Login";
include '../includes/header.php';
include '../includes/nav.php';
?>

<main class="page-browse">
  <div class="container">
    <div class="auth-wrap">

      <!-- Left: welcome panel -->
      <div class="auth-art">
        <span class="auth-art__blob auth-art__blob--a"></span>
        <span class="auth-art__blob auth-art__blob--b"></span>
        <div class="auth-art__content">
          <p class="auth-art__eyebrow">Welcome back</p>
          <h2>Your next project is waiting for you.</h2>
        </div>
      </div>

      <!-- Right: form -->
      <div class="auth-form">
        <h2>Login</h2>
        <p>Welcome back. Log in to your client or freelancer account.</p>

        <form method="post" action="">
          <input type="hidden" name="next" value="<?= e($next) ?>">

          <div class="field">
            <label for="email">Email Address</label>
            <div class="input-wrap">
              <?= icon('mail', 16) ?>
              <input type="email" id="email" name="email" placeholder="you@example.com" autocomplete="email" required>
            </div>
          </div>

          <div class="field">
            <label for="password">Password</label>
            <div class="input-wrap">
              <?= icon('lock', 16) ?>
              <input type="password" id="password" name="password" placeholder="Your password" autocomplete="current-password" required>
              <span class="input-eye"><?= icon('eye', 16) ?></span>
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
      </div>

    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>