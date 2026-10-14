<?php
/**
 * admin/platform-settings.php - Set the service fee percentage (matches the Platform Settings design).
 * Saved to storage/settings.json. New projects use the new rate; ongoing ones keep theirs.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "settings";

require_once __DIR__ . '/../includes/data.php';

$fee    = tt_service_fee();
$errors = [];
$value  = $fee;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = isset($_POST['fee']) ? (int) $_POST['fee'] : 0;
    if ($value < 1 || $value > 50) { $errors[] = 'The service fee must be between 1% and 50%.'; }
    if (!$errors) {
        tt_save_service_fee($value);
        tt_flash('The service fee was set to ' . $value . '%.');
        header('Location: ' . $base_url . 'admin/platform-settings.php');
        exit;
    }
}

$settings_file = tt_settings_file();
$since = 'January 15, 2026';
if (file_exists($settings_file)) {
    $d = json_decode((string) file_get_contents($settings_file), true);
    if (!empty($d['since'])) { $since = date('F j, Y', strtotime($d['since'])); }
}
$example = 10000;

$page_title = "Platform Settings";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Platform Settings</h1>
    <p class="subtle">Set the service fee used in all fee calculations.</p>
  </div>
</div>

<?php if ($errors): ?>
  <div class="form-alert" role="alert" style="margin-top:1.25rem;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
<?php endif; ?>

<div class="admin-layout" style="grid-template-columns: 1fr 260px;">
  <section class="admin-side" style="padding:1.5rem;">
    <h2>Service Fee Percentage</h2>
    <form method="post" action="platform-settings.php" style="display:flex; align-items:center; gap:0.6rem;">
      <input type="number" name="fee" min="1" max="50" step="1" value="<?= (int) $value ?>" style="width:110px; height:42px; padding:0 0.8rem; border:1px solid var(--color-vibrant-teal); border-radius:8px; font-size:0.9rem;">
      <span style="font-size:0.9rem; color:var(--color-slate-text);">%</span>
      <button type="submit" class="btn btn--primary" style="height:42px;">Save</button>
    </form>
    <p class="note-line" style="margin-top:0.8rem;">Used in all fee calculations. A new rate applies only to projects started after the change; ongoing projects keep the rate that applied when they started.</p>
    <div class="note-soft" style="margin-top:1.2rem;">
      <?= icon('dollar', 14) ?> Example: a ₱<?= number_format($example) ?> project → ₱<?= number_format($example * $fee / 100) ?> service fee → freelancer receives ₱<?= number_format($example - $example * $fee / 100) ?>.
    </div>
  </section>

  <aside class="admin-side" style="background:var(--color-deep-slate); border-color:var(--color-deep-slate); color:#FFFFFF;">
    <p style="font-size:0.72rem; color:#94A3B8;">Current rate</p>
    <p style="font-family:var(--font-heading); font-size:2.6rem; font-weight:700; color:var(--color-coral-orange); line-height:1.1;"><?= (int) $fee ?>%</p>
    <p style="font-size:0.7rem; color:#94A3B8;">Since <?= e($since) ?></p>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>