<?php
/**
 * admin/activity-log.php - Activity and audit log: who did what and when.
 * Search, filter by action and date range, paged. Read-only for the administrator.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "activity";

require_once __DIR__ . '/../includes/data.php';

$q       = trim(isset($_GET['q']) ? $_GET['q'] : '');
$action  = isset($_GET['action']) ? $_GET['action'] : '';
$from    = isset($_GET['from']) ? $_GET['from'] : '';
$to      = isset($_GET['to']) ? $_GET['to'] : '';
$page    = max(1, (int) (isset($_GET['page']) ? $_GET['page'] : 1));
$per     = 25;
$errors  = [];
if ($from !== '' && $to !== '' && $from > $to) { $errors[] = 'The "from" date must be before the "to" date.'; }

$where  = [];
$params = [];
if ($q !== '') {
    $where[] = '(a.action LIKE ? OR a.target LIKE ? OR u.name LIKE ? OR u.email LIKE ?)';
    array_push($params, "%$q%", "%$q%", "%$q%", "%$q%");
}
if ($action !== '') { $where[] = 'a.action = ?'; $params[] = $action; }
if ($from !== '' && $errors === []) { $where[] = 'a.created_at >= ?'; $params[] = $from . ' 00:00:00'; }
if ($to !== '' && $errors === [])   { $where[] = 'a.created_at <= ?'; $params[] = $to . ' 23:59:59'; }
$sql_where = $where ? ' WHERE ' . implode(' AND ', $where) : '';

$count = db()->prepare("SELECT COUNT(*) FROM audit_logs a LEFT JOIN users u ON u.id = a.user_id" . $sql_where);
$count->execute($params);
$total = (int) $count->fetchColumn();
$pages = max(1, (int) ceil($total / $per));
$page  = min($page, $pages);

$stmt = db()->prepare("SELECT a.id, a.action, a.target, a.created_at, u.name, u.email, u.role
                       FROM audit_logs a LEFT JOIN users u ON u.id = a.user_id" . $sql_where .
                      " ORDER BY a.id DESC LIMIT " . (int) $per . " OFFSET " . (int) (($page - 1) * $per));
$stmt->execute($params);
$rows = $stmt->fetchAll();

$actions = db()->query("SELECT DISTINCT action FROM audit_logs ORDER BY action")->fetchAll(PDO::FETCH_COLUMN);

$qs = function ($extra) use ($q, $action, $from, $to) {
    return 'activity-log.php?' . http_build_query(array_filter(array_merge(['q' => $q, 'action' => $action, 'from' => $from, 'to' => $to], $extra), function ($v) { return $v !== '' && $v !== null; }));
};

$page_title = "Activity Log";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<nav class="crumbs" aria-label="Breadcrumb"><a href="dashboard.php">Admin Dashboard</a><span>/</span><span aria-current="page">Activity Log</span></nav>

<div class="welcome-row">
  <div>
    <h1>Activity Log</h1>
    <p class="subtle">Every sign-in, payment, withdrawal, contract and proposal is recorded here.</p>
  </div>
</div>

<?php foreach ($errors as $err): ?><div class="alert alert--error"><?= e($err) ?></div><?php endforeach; ?>

<form method="get" action="activity-log.php" class="filter-bar" style="display:flex; flex-wrap:wrap; gap:0.6rem; align-items:end; margin:1rem 0;">
  <label style="flex:2 1 220px;">Search
    <input class="input" type="search" name="q" value="<?= e($q) ?>" placeholder="Name, email, action or target">
  </label>
  <label style="flex:1 1 180px;">Action
    <select class="input" name="action">
      <option value="">All actions</option>
      <?php foreach ($actions as $a): ?><option value="<?= e($a) ?>" <?= $a === $action ? 'selected' : '' ?>><?= e($a) ?></option><?php endforeach; ?>
    </select>
  </label>
  <label style="flex:1 1 150px;">From
    <input class="input" type="date" name="from" value="<?= e($from) ?>">
  </label>
  <label style="flex:1 1 150px;">To
    <input class="input" type="date" name="to" value="<?= e($to) ?>">
  </label>
  <button class="btn btn--primary" type="submit">Apply</button>
  <a class="btn btn--row-outline" href="activity-log.php">Clear</a>
</form>

<p class="subtle"><?= (int) $total ?> record<?= $total === 1 ? '' : 's' ?> found.</p>

<div class="box" style="overflow-x:auto;">
  <table class="data-table">
    <thead><tr><th>Date and time</th><th>User</th><th>Role</th><th>Action</th><th>Target</th></tr></thead>
    <tbody>
    <?php if (!$rows): ?>
      <tr><td colspan="5" class="muted">No activity matches these filters.</td></tr>
    <?php endif; ?>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= e(date('M d, Y g:i A', strtotime($r['created_at']))) ?></td>
        <td><?= $r['name'] ? e($r['name']) . '<br><small class="muted">' . e($r['email']) . '</small>' : '<span class="muted">Guest</span>' ?></td>
        <td><?= $r['role'] ? e(ucfirst($r['role'])) : '—' ?></td>
        <td><?= e($r['action']) ?></td>
        <td><?= e($r['target'] ?? '') ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php if ($pages > 1): ?>
<nav class="pagination" aria-label="Activity pages" style="display:flex; gap:0.4rem; justify-content:center; margin-top:1rem; flex-wrap:wrap;">
  <?php if ($page > 1): ?><a class="btn btn--row-outline" href="<?= e($qs(['page' => $page - 1])) ?>">Previous</a><?php endif; ?>
  <span class="subtle">Page <?= (int) $page ?> of <?= (int) $pages ?></span>
  <?php if ($page < $pages): ?><a class="btn btn--row-outline" href="<?= e($qs(['page' => $page + 1])) ?>">Next</a><?php endif; ?>
</nav>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>