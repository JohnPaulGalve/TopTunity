<?php
/**
 * admin/risk-alerts.php - Contracts, proposals and projects that look unusual
 * (very high amounts, very long hours, far-off offers or long timelines).
 * The platform does not block them; the administrator reviews and marks them.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "alerts";

require_once __DIR__ . '/../includes/data.php';

$status = isset($_GET['status']) && in_array($_GET['status'], ['new', 'reviewed'], true) ? $_GET['status'] : 'new';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alert_id'])) {
    $error = tt_admin_mark_alert((int) $_POST['alert_id']);
    tt_flash($error ? 'Could not update: ' . $error : 'Alert marked as reviewed.');
    header('Location: ' . $base_url . 'admin/risk-alerts.php?status=' . urlencode($status));
    exit;
}

$alerts = tt_admin_risk_alerts($status);
$new_count = (int) db()->query("SELECT COUNT(*) FROM risk_alerts WHERE status = 'new'")->fetchColumn();

$page_title = "Risk Alerts";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<nav class="crumbs" aria-label="Breadcrumb"><a href="dashboard.php">Admin Dashboard</a><span>/</span><span aria-current="page">Risk Alerts</span></nav>

<div class="welcome-row">
  <div>
    <h1>Risk Alerts</h1>
    <p class="subtle">Projects, proposals and contracts that go beyond the normal limits. <?= $new_count ?> waiting for review.</p>
  </div>
</div>

<div style="display:flex; gap:0.5rem; flex-wrap:wrap; margin:1rem 0;">
  <a class="btn <?= $status === 'new' ? 'btn--primary' : 'btn--outline' ?> btn--sm" href="risk-alerts.php?status=new">New</a>
  <a class="btn <?= $status === 'reviewed' ? 'btn--primary' : 'btn--outline' ?> btn--sm" href="risk-alerts.php?status=reviewed">Reviewed</a>
</div>

<?php if (!$alerts): ?>
  <p class="muted">No <?= e($status) ?> alerts.</p>
<?php else: ?>
<?php foreach ($alerts as $a): ?>
<section class="box" style="margin-bottom:1rem;">
  <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:0.6rem;">
    <h2 style="margin:0; font-size:1rem;"><?= e($a['source']) ?> flagged · <?= e($a['project']) ?></h2>
    <div style="display:flex; gap:0.5rem; align-items:center; flex-wrap:wrap;">
      <?php if ($a['site_id']): ?>
        <a href="project-moderation.php?id=<?= (int) $a['site_id'] ?>" class="btn btn--row-outline btn--sm">View project</a>
      <?php endif; ?>
      <?php if ($a['status'] === 'new'): ?>
      <form method="post" action="risk-alerts.php?status=<?= e($status) ?>" style="margin:0;">
        <input type="hidden" name="alert_id" value="<?= (int) $a['id'] ?>">
        <button type="submit" class="btn btn--row-outline btn--sm">Mark reviewed</button>
      </form>
      <?php else: ?>
        <span class="muted">Reviewed</span>
      <?php endif; ?>
    </div>
  </div>
  <div class="kv"><span>Date</span><strong><?= e($a['date']) ?></strong></div>
  <div class="kv"><span>User</span><strong><?= e($a['user']) ?> <small class="muted">(<?= e($a['role']) ?>)</small></strong></div>
  <div class="kv"><span>Project</span><strong><?= $a['site_id'] ? '<a href="project-moderation.php?id=' . (int) $a['site_id'] . '">' . e($a['project']) . '</a>' : e($a['project']) ?></strong></div>
  <div class="kv"><span>Amount</span><strong>₱<?= number_format($a['amount']) ?></strong></div>
  <div class="kv" style="align-items:flex-start;">
    <span>Why it was flagged</span>
    <ul style="margin:0; padding-left:1.1rem; text-align:right;">
      <?php foreach (array_filter(array_map('trim', explode(';', $a['reason']))) as $reason): ?>
        <li><?= e($reason) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<?php endforeach; ?>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>