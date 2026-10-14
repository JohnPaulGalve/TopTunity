<?php
/**
 * pages/register.php - Create a client or freelancer account, then sign in.
 * ?role=client|freelancer pre-selects the role (homepage buttons use this).
 */
$user_role = "public";
$base_url  = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');

require_once __DIR__ . '/../includes/auth.php';

$role_in = isset($_POST['role']) ? $_POST['role'] : (isset($_GET['role']) ? $_GET['role'] : 'client');
$role    = $role_in === 'freelancer' ? 'freelancer' : 'client';
$next    = tt_clean_next(isset($_POST['next']) ? $_POST['next'] : (isset($_GET['next']) ? $_GET['next'] : ''));

// Already signed in? Go straight to the home page.
tt_redirect_if_signed_in($base_url, $next);

$errors = [];
$form   = ['name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name']  = trim(isset($_POST['name']) ? $_POST['name'] : '');
    $form['email'] = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $password      = isset($_POST['password']) ? $_POST['password'] : '';

    if ($form['name'] === '')                                   { $errors[] = 'Please enter your full name.'; }
    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL))     { $errors[] = 'Please enter a valid email address.'; }
    if (strlen($password) < 8 || !preg_match('/\d/', $password)) { $errors[] = 'Your password must be at least 8 characters and include a number.'; }
    if (empty($_POST['terms']))                                 { $errors[] = 'Please agree to the Terms and Privacy Policy.'; }

    if (!$errors) {
        $result = tt_register_user($form['name'], $form['email'], $password, $role);
        if (is_string($result)) {
            $errors[] = $result;
        } else {
            tt_login($result);
            tt_flash('Welcome to TopTunity, ' . $result['name'] . '!');
            tt_redirect_after_login($result, $next, $base_url);
        }
    }
}

$page_title = "Register";
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
          <p class="auth-art__eyebrow">Join TopTunity</p>
          <h2>Hire top talent or find your best opportunity.</h2>
          <ul>
            <li><?= icon('check-circle', 16) ?> Free to join — no subscription</li>
            <li><?= icon('check-circle', 16) ?> Contracts agreed before work starts</li>
            <li><?= icon('check-circle', 16) ?> Payments held until the work is approved</li>
          </ul>
        </div>
      </div>

      <div class="auth-form">
        <h2>Register</h2>
        <p>Create your TopTunity account.</p>

        <?php if ($errors): ?>
          <div class="form-alert" role="alert">
            <?= icon('alert', 15) ?>
            <div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div>
          </div>
        <?php endif; ?>

        <form method="post" action="register.php">
          <input type="hidden" name="next" value="<?= e($next) ?>">

          <div class="field">
            <label for="name">Full Name</label>
            <div class="input-wrap">
              <?= icon('user', 16) ?>
              <input type="text" id="name" name="name" value="<?= e($form['name']) ?>" placeholder="Your full name" autocomplete="name" required>
            </div>
          </div>

          <div class="field">
            <label for="email">Email Address</label>
            <div class="input-wrap">
              <?= icon('mail', 16) ?>
              <input type="email" id="email" name="email" value="<?= e($form['email']) ?>" placeholder="you@example.com" autocomplete="username" autocapitalize="none" spellcheck="false" required>
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
            <input type="checkbox" name="terms" value="1" required>
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