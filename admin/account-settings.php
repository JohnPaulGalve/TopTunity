<?php
/**
 * admin/account-settings.php - Administrator account details and password (matches the Account Settings design).
 * NOTE: this page is in the design but not in the original sitemap, so it is an extra file.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';
$me    = toptunity_current_admin();
$email = tt_current_user() ? tt_current_user()['email'] : '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['current']) || isset($_POST['new']) || isset($_POST['confirm'])) {
        $error = tt_change_password(
            (string) ($_POST['current'] ?? ''),
            (string) ($_POST['new'] ?? ''),
            (string) ($_POST['confirm'] ?? '')
        );
        if ($error) {
            $errors[] = $error;
        } else {
            unset($_SESSION['admin_password_change_required']);
            $_SESSION['admin_password_verified'] = true;
            tt_flash('Your password was updated.');
            header('Location: ' . $base_url . 'admin/account-settings.php');
            exit;
        }
    } else {
        $error = tt_update_account((string) ($_POST['name'] ?? ''), (string) ($_POST['email'] ?? ''));
        if ($error) {
            $errors[] = $error;
        } else {
            tt_flash('Your account settings were saved.');
            header('Location: ' . $base_url . 'admin/account-settings.php');
            exit;
        }
    }
}

$page_title = "Account Settings";
$flash = tt_flash();
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Account Settings</h1>
    <p class="subtle">Update your account information and password.</p>
    <?php if (!empty($_SESSION['admin_password_change_required'])): ?>
      <p class="note-soft" role="status" style="margin-top:0.8rem;">For account security, replace the real administrator's previous demo password before continuing.</p>
    <?php endif; ?>
  </div>
</div>

<?php if ($flash): ?><div class="note-soft" role="status" style="margin-top:1rem;"><?= e($flash) ?></div><?php endif; ?>

<?php if ($errors): ?>
  <div class="form-alert" role="alert" style="margin-top:1.25rem;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
<?php endif; ?>

<div class="two-col" style="margin-top:1.25rem; grid-template-columns:1fr 1fr;">
  <section class="box" style="margin-top:0;">
    <h2 style="display:flex; align-items:center; gap:0.5rem;"><span class="icon-box icon-box--teal"><?= icon('mail', 16) ?></span> Update Account Information</h2>
    <form method="post" action="account-settings.php" style="margin-top:0.8rem;">
      <div class="field" style="margin-top:0;"><label for="acc-name">Full Name</label><div class="input-wrap"><?= icon('user', 16) ?><input id="acc-name" name="name" value="<?= e($me['name']) ?>"></div></div>
      <div class="field"><label for="acc-email">Email Address</label><div class="input-wrap"><?= icon('mail', 16) ?><input id="acc-email" name="email" type="email" value="<?= e($email) ?>"></div></div>
      <div class="form-actions--plain"><button type="submit" class="btn" style="background:var(--color-deep-slate); color:#FFFFFF;">Save Changes</button></div>
    </form>
  </section>

  <section class="box" style="margin-top:0;">
    <h2 style="display:flex; align-items:center; gap:0.5rem;"><span class="icon-box icon-box--orange"><?= icon('lock', 16) ?></span> Change Password</h2>
    <form method="post" action="account-settings.php" style="margin-top:0.8rem;">
      <div class="field" style="margin-top:0;"><label for="cur-pass">Current Password</label><div class="input-wrap"><?= icon('lock', 16) ?><input id="cur-pass" name="current" type="password" autocomplete="current-password"></div></div>
      <div class="field"><label for="new-pass">New Password</label><div class="input-wrap"><?= icon('lock', 16) ?><input id="new-pass" name="new" type="password" minlength="8" autocomplete="new-password"></div><p class="hint">At least 8 characters with a number.</p></div>
      <div class="field"><label for="conf-pass">Confirm New Password</label><div class="input-wrap"><?= icon('lock', 16) ?><input id="conf-pass" name="confirm" type="password" autocomplete="new-password"></div></div>
      <div class="form-actions--plain"><button type="submit" class="btn btn--primary">Update Password</button></div>
    </form>
  </section>
</div>

</main>

<?php include '../includes/footer.php'; ?>