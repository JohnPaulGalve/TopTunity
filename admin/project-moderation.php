<?php
/**
 * admin/project-moderation.php - Every project, filtered by status, with details (matches the Project Moderation design).
 * Close, remove and suspend are not saved to a database yet.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "projects";

require_once __DIR__ . '/../includes/data.php';

$all  = toptunity_admin_projects();
$tabs = ['all' => 'All', 'open' => 'Open', 'past' => 'Past Deadline', 'ongoing' => 'Ongoing', 'overdue' => 'Overdue',
         'completed' => 'Completed', 'closed' => 'Closed', 'cancelled' => 'Cancelled'];
$status = isset($_GET['status']) && isset($tabs[$_GET['status']]) ? $_GET['status'] : 'all';
$rows = array_values(array_filter($all, function ($p) use ($status) { return $status === 'all' || $p['status'] === $status; }));

$sel  = null;
$want = isset($_GET['id']) ? $_GET['id'] : '';
foreach ($rows as $r) { if ($r['id'] === $want) { $sel = $r; } }
if (!$sel && $rows) { $sel = $rows[0]; }

$page_title = "Project Moderation";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Project Management and Moderation</h1>
    <p class="subtle">View all projects and moderate them.</p>
  </div>
</div>

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
        <button type="button" class="btn btn--block" style="background:var(--color-deep-slate); color:#FFFFFF;">Close Project</button>
        <button type="button" class="btn btn--row-outline btn--block">Remove Project</button>
        <button type="button" class="btn btn--pale-red btn--block">Suspend Project</button>
      </div>
      <p class="note-line" style="margin-top:0.7rem;">Close Project is for Past Deadline projects. The client is notified and every action is recorded in the project history.</p>
    <?php endif; ?>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>