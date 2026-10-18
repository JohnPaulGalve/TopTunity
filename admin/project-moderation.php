<?php
/**
 * admin/project-moderation.php - Every project, filtered by status, with details (matches the Project Moderation design).
 * Database-backed projects support moderation actions; sample records are read-only.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "projects";

require_once __DIR__ . '/../includes/data.php';

$all  = toptunity_admin_projects();
$tabs = ['all' => 'All', 'open' => 'Open', 'past' => 'Past Deadline', 'ongoing' => 'Ongoing', 'overdue' => 'Overdue',
         'completed' => 'Completed', 'closed' => 'Closed', 'suspended' => 'Suspended', 'cancelled' => 'Cancelled'];
$status = isset($_GET['status']) && isset($tabs[$_GET['status']]) ? $_GET['status'] : 'all';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['moderation_action'] ?? '');
    $sample_id = (string) ($_POST['sample_id'] ?? '');
    $error = $sample_id !== ''
        ? tt_admin_moderate_demo_project($sample_id, $action)
        : tt_admin_moderate_project((int) ($_POST['site_id'] ?? 0), $action);
    tt_flash($error ? 'Could not update project: ' . $error : 'Project moderation action completed.');
    header('Location: ' . $base_url . 'admin/project-moderation.php?status=' . urlencode($status));
    exit;
}
$rows = array_values(array_filter($all, function ($p) use ($status) { return $status === 'all' || $p['status'] === $status; }));

$sel  = null;
$want = isset($_GET['id']) ? $_GET['id'] : '';
foreach ($rows as $r) { if ($r['id'] === $want) { $sel = $r; } }
if (!$sel && $rows) { $sel = $rows[0]; }

$page_title = "Project Moderation";
$flash = tt_flash();
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Project Management and Moderation</h1>
    <p class="subtle">View all projects and moderate them.</p>
  </div>
</div>

<?php if ($flash): ?><div class="note-soft" role="status" style="margin-top:1rem;"><?= e($flash) ?></div><?php endif; ?>

<div class="filter-row" style="margin-top:1.25rem;">
  <p class="section-tag" style="margin:0;">Filter by status</p>
  <nav class="filter-tabs" aria-label="Filter by status">
    <?php foreach ($tabs as $key => $label): ?>
      <a href="project-moderation.php?status=<?= e($key) ?>" class="filter-tab <?= $status === $key ? 'is-active' : '' ?>"><?= e($label) ?></a>
    <?php endforeach; ?>
  </nav>
</div>

<div class="admin-layout">
  <section class="admin-list">
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead><tr><th>Project</th><th>Status</th><th>Deadline</th><th></th></tr></thead>
        <tbody>
          <?php if (!$rows): ?><tr><td colspan="4" class="muted" style="text-align:center; padding:1.2rem;">No projects in this group.</td></tr><?php endif; ?>
          <?php foreach ($rows as $p): ?>
            <tr class="<?= $sel && $sel['id'] === $p['id'] ? 'is-selected' : '' ?>">
              <td><strong><?= e($p['title']) ?></strong><small><?= e($p['client']) ?> · <?= e($p['billing']) ?></small></td>
              <td><span class="status status--<?= e($p['status']) ?>"><?= e(toptunity_status_label($p['status'])) ?></span></td>
              <td><?= e(date('M d, Y', strtotime($p['deadline']))) ?></td>
              <td><a class="view" href="project-moderation.php?status=<?= e($status) ?>&amp;id=<?= e($p['id']) ?>">View</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <aside class="admin-side">
    <?php if (!$sel): ?>
      <h2>Project Details</h2><p class="muted">No project selected.</p>
    <?php else: ?>
      <h2><?= e($sel['title']) ?></h2>
      <div style="display:flex; gap:0.4rem; flex-wrap:wrap; margin-bottom:0.6rem;">
        <span class="status status--<?= e($sel['status']) ?>"><?= e(toptunity_status_label($sel['status'])) ?></span>
        <span class="pill pill--cat"><?= $sel['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span>
      </div>
      <div class="kv"><span>Client</span><strong><?= e($sel['client']) ?></strong></div>
      <div class="kv"><span>Billing type</span><strong><?= e($sel['billing']) ?></strong></div>
      <div class="kv"><span>Proposals (one per freelancer)</span><strong><?= (int) $sel['proposals'] ?></strong></div>
      <div class="kv"><span>Selected freelancer</span><strong><?= $sel['freelancer'] ? e($sel['freelancer']) : '—' ?></strong></div>
      <div class="kv"><span>Deadline</span><strong><?= e(date('M d, Y', strtotime($sel['deadline']))) ?></strong></div>

      <div class="kv" style="align-items:center;">
        <span>Contract<br><small class="muted">No contract — no freelancer selected</small></span>
        <span class="status status--cancelled">None</span>
      </div>

      <p class="muted" style="margin:0.9rem 0 0.4rem; font-size:0.72rem; font-weight:600;">Project History</p>
      <div class="timeline">
        <div>Sep 26 · Flagged past deadline (system)</div>
        <div>Sep 25 · Deadline reached, no freelancer selected</div>
        <div>Sep 12 · <?= (int) $sel['proposals'] ?> proposals received</div>
        <div>Sep 05 · Project posted (client)</div>
      </div>

      <div style="display:flex; flex-direction:column; gap:0.5rem; margin-top:1rem;">
        <?php if (!empty($sel['real']) || tt_is_demo_admin()): ?>
          <?php
          $moderation_controls = [
              'close' => ['Close Project', 'btn btn--block', 'Close this project and notify its client?'],
              'suspend' => ['Suspend Project', 'btn btn--pale-red btn--block', 'Suspend this project and notify its client?'],
              'reopen' => ['Reopen Project', 'btn btn--row-outline btn--block', 'Reopen this project?'],
              'remove' => ['Remove Project', 'btn btn--row-outline btn--block', 'Permanently remove this project and its proposals? This cannot be undone.'],
          ];
          foreach ($moderation_controls as $action => $control):
              $no_contract = in_array($sel['contract_status'], ['none', 'declined'], true);
              $eligible = ($action === 'close' && $sel['contract_status'] === 'none' && in_array($sel['status'], ['open', 'past', 'overdue'], true))
                  || ($action === 'suspend' && $sel['contract_status'] === 'none' && in_array($sel['status'], ['open', 'past'], true))
                  || ($action === 'reopen' && $sel['contract_status'] === 'none' && in_array($sel['status'], ['closed', 'suspended'], true))
                  || ($action === 'remove' && $no_contract && in_array($sel['status'], ['open', 'past', 'closed', 'suspended', 'cancelled'], true));
              if (!$eligible) { continue; }
          ?>
            <form method="post" action="project-moderation.php?status=<?= e($status) ?>&amp;id=<?= e($sel['id']) ?>"
                  onsubmit="return confirm(<?= e(json_encode($control[2])) ?>);">
              <input type="hidden" name="site_id" value="<?= (int) ($sel['site_id'] ?? 0) ?>">
              <?php if (empty($sel['real'])): ?><input type="hidden" name="sample_id" value="<?= e($sel['id']) ?>"><?php endif; ?>
              <input type="hidden" name="moderation_action" value="<?= e($action) ?>">
              <button type="submit" class="<?= e($control[1]) ?>"><?= e($control[0]) ?></button>
            </form>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="note-line">Actions are enabled for database-backed projects. Sample projects are read-only previews.</p>
        <?php endif; ?>
      </div>
      <p class="note-line" style="margin-top:0.7rem;">Live project actions update the database and notify the client. Demo project changes are session-only. Active contracts and projects with payment or dispute history are protected from removal.</p>
    <?php endif; ?>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>