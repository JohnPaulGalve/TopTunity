<?php
/**
 * client/account-settings.php - Update account information and password (matches the Account Settings design).
 * Saving is not connected to a database yet.
 */
$user_role     = "client";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['current'])) {
        $err = tt_change_password($_POST['current'], $_POST['new'] ?? '', $_POST['confirm'] ?? ($_POST['new'] ?? ''));
        $ok  = 'Your password was updated.';
    } else {
        $err = tt_update_account($_POST['name'] ?? '', $_POST['email'] ?? '');
        $ok  = 'Your account details were saved.';
    }
    tt_flash($err ? 'Could not save: ' . $err : $ok);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}
$me = toptunity_current_client();

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

<div class="two-col" style="margin-top:1.25rem; grid-template-columns:1fr 1fr;">
  <section class="box" style="margin-top:0;">
    <div class="box-head" style="margin-bottom:1.1rem;">
      <h2 style="display:flex; align-items:center; gap:0.5rem; margin:0;"><span class="icon-box icon-box--teal"><?= icon('user', 16) ?></span> Update Account Information</h2>
    </div>
    <form method="post" action="">
      <div class="field" style="margin-top:0;">
        <label for="acc-name">Full Name</label>
        <div class="input-wrap"><?= icon('user', 16) ?><input id="acc-name" name="name" value="<?= e($me['name']) ?>"></div>
      </div>
      <div class="field">
        <label for="acc-email">Email Address</label>
        <div class="input-wrap"><?= icon('mail', 16) ?><input id="acc-email" name="email" type="email" value="<?= e(tt_current_user()['email'] ?? '') ?>"></div>
      </div>
      <div class="form-actions--plain">
        <button type="submit" class="btn btn--deep" style="background:var(--color-deep-slate); color:#FFFFFF;">Save Changes</button>
      </div>
    </form>
  </section>

  <section class="box" style="margin-top:0;">
    <div class="box-head" style="margin-bottom:1.1rem;">
      <h2 style="display:flex; align-items:center; gap:0.5rem; margin:0;"><span class="icon-box icon-box--orange"><?= icon('lock', 16) ?></span> Change Password</h2>
    </div>
    <form method="post" action="">
      <div class="field" style="margin-top:0;">
        <label for="cur-pass">Current Password</label>
        <div class="input-wrap"><?= icon('lock', 16) ?><input id="cur-pass" name="current" type="password" autocomplete="current-password"><span class="input-eye" role="button" tabindex="0" aria-label="Show password" aria-pressed="false"><span class="eye-icon eye-icon--open"><?= icon('eye', 16) ?></span><span class="eye-icon eye-icon--off"><?= icon('eye-off', 16) ?></span></span></div>
      </div>
      <div class="field">
        <label for="new-pass">New Password</label>
        <div class="input-wrap" style="box-shadow:0 0 0 3px rgba(0,148,136,0.12); border-radius:var(--radius-sm);"><?= icon('lock', 16) ?><input id="new-pass" name="new" type="password" minlength="8" autocomplete="new-password" style="border-color:var(--color-vibrant-teal);"><span class="input-eye" role="button" tabindex="0" aria-label="Show password" aria-pressed="false"><span class="eye-icon eye-icon--open"><?= icon('eye', 16) ?></span><span class="eye-icon eye-icon--off"><?= icon('eye-off', 16) ?></span></span></div>
        <p class="hint">At least 8 characters with a number.</p>
      </div>
      <div class="form-actions--plain">
        <button type="submit" class="btn btn--primary">Update Password</button>
      </div>
    </form>
  </section>
</div>

</main>

<script>
/* Show / hide password (self-contained on this page) */
(function () {
  document.querySelectorAll('.input-eye').forEach(function (eye) {
    function toggle() {
      var wrap = eye.closest('.input-wrap');
      var input = wrap ? wrap.querySelector('input') : null;   // the field itself (its type changes on each click)
      if (!input) { return; }
      var show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      eye.setAttribute('aria-pressed', show ? 'true' : 'false');
      eye.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    }
    eye.addEventListener('click', toggle);
    eye.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggle(); }
    });
  });
})();
</script>
<?php include '../includes/footer.php'; ?>