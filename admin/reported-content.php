<?php
/**
 * admin/reported-content.php - Reports from users, with details and actions (matches the Reported Content design).
 * Report actions update the live report records or the demo session fixture state.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "reported";

require_once __DIR__ . '/../includes/data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $report_id = (string) ($_POST['report_id'] ?? '');
    $act = (string) ($_POST['action'] ?? '');
    $error = tt_admin_review_report($report_id, $act);
    tt_flash($error ? 'Could not update report: ' . $error : 'Report action completed.');
    $query = http_build_query(array_filter([
        'tab' => $_GET['tab'] ?? '',
        'id' => $report_id,
    ], static function ($value) { return $value !== ''; }));
    header('Location: ' . $base_url . 'admin/reported-content.php?' . $query);
    exit;
}

$all   = toptunity_admin_reports();
$tab   = isset($_GET['tab']) && in_array($_GET['tab'], ['pending', 'resolved'], true) ? $_GET['tab'] : 'all';
$counts = ['all' => count($all), 'pending' => 0, 'resolved' => 0];
foreach ($all as $r) { if ($r['status'] === 'pending') { $counts['pending']++; } if ($r['status'] === 'resolved') { $counts['resolved']++; } }
$rows = array_values(array_filter($all, function ($r) use ($tab) { return $tab === 'all' || $r['status'] === $tab; }));

$sel  = null;
$want = isset($_GET['id']) ? $_GET['id'] : '';
foreach ($rows as $r) { if ($r['id'] === $want) { $sel = $r; } }
if (!$sel && $rows) { $sel = $rows[0]; }

$page_title = "Reported Content";
$flash = tt_flash();
include '../includes/header.php';
include '../includes/client-nav.php';

$status_class = ['pending' => 'pending', 'resolved' => 'released', 'dismissed' => 'cancelled'];
?>

<div class="welcome-row">
  <div>
    <h1>Reported Content</h1>
    <p class="subtle">Review content and users reported by clients and freelancers.</p>
  </div>
</div>

<?php if ($flash): ?><div class="note-soft" role="status" style="margin-top:1rem;"><?= e($flash) ?></div><?php endif; ?>

<div class="admin-layout">
  <section class="admin-list">
    <div style="display:flex; align-items:center; justify-content:space-between; padding:0.9rem 1rem; gap:0.6rem; flex-wrap:wrap;">
      <p class="section-tag" style="margin:0;">Report list</p>
      <nav class="filter-tabs">
        <a href="reported-content.php?tab=all" class="filter-tab <?= $tab === 'all' ? 'is-active' : '' ?>">All <small><?= (int) $counts['all'] ?></small></a>
        <a href="reported-content.php?tab=pending" class="filter-tab <?= $tab === 'pending' ? 'is-active' : '' ?>">Pending <small><?= (int) $counts['pending'] ?></small></a>
        <a href="reported-content.php?tab=resolved" class="filter-tab <?= $tab === 'resolved' ? 'is-active' : '' ?>">Resolved <small><?= (int) $counts['resolved'] ?></small></a>
      </nav>
    </div>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead><tr><th>Date</th><th>Reported · Type</th><th>Reason</th><th>Reported by</th><th>Status</th></tr></thead>
        <tbody>
          <?php if (!$rows): ?><tr><td colspan="5" class="muted" style="text-align:center; padding:1.2rem;">No reports here.</td></tr><?php endif; ?>
          <?php foreach ($rows as $r): ?>
            <tr class="<?= $sel && $sel['id'] === $r['id'] ? 'is-selected' : '' ?>">
              <td><?= e($r['date']) ?></td>
              <td><a href="reported-content.php?tab=<?= e($tab) ?>&amp;id=<?= e($r['id']) ?>"><strong><?= e($r['reported']) ?></strong></a><small><?= e($r['type']) ?></small></td>
              <td><?= e($r['reason']) ?></td>
              <td><?= e($r['reporter']) ?></td>
              <td><span class="status status--<?= e($status_class[$r['status']]) ?>"><?= e(ucfirst($r['status'])) ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <aside class="admin-side">
    <?php if (!$sel): ?>
      <h2>Report Details</h2><p class="muted">No report selected.</p>
    <?php else: ?>
      <h2>Report Details</h2>
      <div class="kv"><span>Reported</span><strong><?= e($sel['reported']) ?></strong></div>
      <div class="kv"><span>Type</span><strong><?= e($sel['type']) ?></strong></div>
      <div class="kv"><span>Reported by</span><strong><?= e($sel['reporter']) ?></strong></div>
      <p class="muted" style="margin:0.8rem 0 0.4rem; font-size:0.72rem;">Reported messages</p>
      <div class="quote-box">“<?= e($sel['quote']) ?>”<time><?= e($sel['when']) ?></time></div>

      <?php if ($sel['status'] === 'pending'): ?>
        <div style="display:flex; flex-direction:column; gap:0.5rem; margin-top:1rem;">
          <?php foreach (['dismiss' => 'Dismiss Report', 'remove' => 'Resolve Report'] as $action => $label): ?>
            <form method="post" action="reported-content.php?tab=<?= e($tab) ?>&amp;id=<?= e($sel['id']) ?>">
              <input type="hidden" name="report_id" value="<?= e($sel['id']) ?>">
              <button type="submit" name="action" value="<?= e($action) ?>" class="btn btn--row-outline btn--block"><?= e($label) ?></button>
            </form>
          <?php endforeach; ?>
          <?php if (strcasecmp($sel['type'], 'User') === 0 && (tt_is_demo_admin() || !empty($sel['reported_user_id']))): ?>
            <form method="post" action="reported-content.php?tab=<?= e($tab) ?>&amp;id=<?= e($sel['id']) ?>">
              <input type="hidden" name="report_id" value="<?= e($sel['id']) ?>">
              <button type="submit" name="action" value="warn" class="btn btn--amber btn--block">⚠ Warn User</button>
            </form>
            <form method="post" action="reported-content.php?tab=<?= e($tab) ?>&amp;id=<?= e($sel['id']) ?>">
              <input type="hidden" name="report_id" value="<?= e($sel['id']) ?>">
              <button type="submit" name="action" value="suspend" class="btn btn--red btn--block">⊘ Suspend Account</button>
            </form>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>