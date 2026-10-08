<?php
/**
 * pages/register.php - Account creation with role pre-selection
 * ?role=client or ?role=freelancer pre-selects the role (homepage buttons use this).
 * Form submission is not wired to a backend yet.
 */
$user_role = "public";
$base_url  = "/Webdev/";

$role = (isset($_GET['role']) && $_GET['role'] === 'freelancer') ? 'freelancer' : 'client';

$page_title = "Register";
include '../includes/header.php';
include '../includes/nav.php';
?>

<main class="page-browse">
  <div class="container">
    <div class="auth-wrap">

      <!-- Left: value panel -->
      <div class="auth-art">
        <span class="auth-art__blob auth-art__blob--a"></span>
        <span class="auth-art__blob auth-art__blob--b"></span>
        <div class="auth-art__content">
          <p class="auth-art__eyebrow">Join TopTunity</p>
          <h2>Hire top talent or find your best opportunity.</h2>
          <ul>
            <li><?= icon('check-circle', 16) ?> Free to join — no subscription</li>
            <li><?= icon('check-circle', 16) ?> Contracts agreed before work starts</li>
            <li><?= icon('check-circle', 16) ?> Payments held until the work is approved</li>
          </ul>
        </div>
      </div>

      <!-- Right: form -->
      <div class="auth-form">
        <h2>Register</h2>
        <p>Create your TopTunity account.</p>

        <form method="post" action="">
          <div class="field">
            <label for="name">Full Name</label>
            <div class="input-wrap">
              <?= icon('user', 16) ?>
              <input type="text" id="name" name="name" placeholder="Your full name" autocomplete="name" required>
            </div>
          </div>

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
              <input type="password" id="password" name="password" placeholder="Create a password" autocomplete="new-password" minlength="8" required>
            </div>
            <p class="hint">At least 8 characters with a number.</p>
          </div>

          <div class="field">
            <label>Choose Role</label>
            <div class="role-options">
              <label class="role-card">
                <input type="radio" name="role" value="client" <?= $role === 'client' ? 'checked' : '' ?>>
                <span class="role-card__body">
                  <span><strong>Client</strong><small>I want to hire</small></span>
                  <?= icon('briefcase', 16) ?>
                  <span class="role-card__dot" aria-hidden="true"></span>
                </span>
              </label>
              <label class="role-card">
                <input type="radio" name="role" value="freelancer" <?= $role === 'freelancer' ? 'checked' : '' ?>>
                <span class="role-card__body">
                  <span><strong>Freelancer</strong><small>I want to work</small></span>
                  <?= icon('laptop', 16) ?>
                  <span class="role-card__dot" aria-hidden="true"></span>
                </span>
              </label>
            </div>
          </div>

          <label class="check-label" style="margin-top:1rem;">
            <input type="checkbox" name="terms" required>
            I agree to the <a href="terms.php" class="link-teal">Terms and Privacy Policy</a>
          </label>

          <button type="submit" class="btn btn--primary btn--full">Register</button>
        </form>

        <p class="auth-foot" style="margin-top:1.2rem;">Already have an account? <a href="login.php" class="link-teal">Login</a></p>
      </div>

    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>