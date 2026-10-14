<?php
/**
 * freelancer/account-settings.php - Account information and password (matches the Account Settings design).
 * Saving is not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = "/TopTunity/";
$active_client = "";

require_once __DIR__ . '/../includes/data.php';
$me    = toptunity_current_freelancer();
$email = tt_current_user() ? tt_current_user()['email'] : '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new']) && $_POST['new'] !== '') {
        if (strlen($_POST['new']) < 8 || !preg_match('/\d/', $_POST['new'])) { $errors[] = 'Your new password must be at least 8 characters and include a number.'; }
        if (($_POST['confirm'] ?? '') !== $_POST['new'])                     { $errors[] = 'The new passwords do not match.'; }
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Please enter a valid email address.'; }
    if (!$errors) {
        tt_flash('Your account settings were saved.');
        header('Location: ' . $base_url . 'freelancer/account-settings.php');
        exit;
    }
}

$page_title = "Account Settings";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Account Settings</h1>
    <p class="subtle">Update your account information and password.</p>
  </div>
</div>

<?php if ($errors): ?>
  <div class="form-alert" role="alert" style="margin-top:1.25rem;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
<?php endif; ?>

<div class="two-col" style="margin-top:1.25rem; grid-template-columns:1fr 1fr;">
  <section class="box" style="margin-top:0;">
    <div class="box-head" style="margin-bottom:1.1rem;">
      <h2 style="display:flex; align-items:center; gap:0.5rem; margin:0;"><span class="icon-box icon-box--teal"><?= icon('mail', 16) ?></span> Update Account Information</h2>
    </div>
    <form method="post" action="account-settings.php">
      <div class="field" style="margin-top:0;">
        <label for="acc-name">Full Name</label>
        <div class="input-wrap"><?= icon('user', 16) ?><input id="acc-name" name="name" value="<?= e($me['name']) ?>"></div>
      </div>
      <div class="field">
        <label for="acc-email">Email Address</label>
        <div class="input-wrap"><?= icon('mail', 16) ?><input id="acc-email" name="email" type="email" value="<?= e($email) ?>"></div>
      </div>
      <div class="form-actions--plain"><button type="submit" class="btn" style="background:var(--color-deep-slate); color:#FFFFFF;">Save Changes</button></div>
    </form>
  </section>

  <section class="box" style="margin-top:0;">
    <div class="box-head" style="margin-bottom:1.1rem;">
      <h2 style="display:flex; align-items:center; gap:0.5rem; margin:0;"><span class="icon-box icon-box--orange"><?= icon('lock', 16) ?></span> Change Password</h2>
    </div>
    <form method="post" action="account-settings.php">
      <div class="field" style="margin-top:0;">
        <label for="cur-pass">Current Password</label>
        <div class="input-wrap"><?= icon('lock', 16) ?><input id="cur-pass" name="current" type="password" autocomplete="current-password"></div>
      </div>
      <div class="field">
        <label for="new-pass">New Password</label>
        <div class="input-wrap"><?= icon('lock', 16) ?><input id="new-pass" name="new" type="password" minlength="8" autocomplete="new-password"></div>
        <p class="hint">At least 8 characters with a number.</p>
      </div>
      <div class="field">
        <label for="conf-pass">Confirm New Password</label>
        <div class="input-wrap"><?= icon('lock', 16) ?><input id="conf-pass" name="confirm" type="password" autocomplete="new-password"></div>
      </div>
      <div class="form-actions--plain"><button type="submit" class="btn btn--primary">Update Password</button></div>
    </form>
  </section>
</div>

</main>

<?php include '../includes/footer.php'; ?>