<?php
/**
 * admin/reports-generation.php - Choose a report and date range, preview it, and download as CSV
 * (matches the Reports Generation design). The CSV is built from the data on this page.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "generate";

require_once __DIR__ . '/../includes/data.php';

$types = [
    'registrations' => 'User Registrations',
    'projects'      => 'Projects by Status',
    'transactions'  => 'Transactions (incl. Hourly Billing)',
    'fees'          => 'Service Fee Revenue',
];
$type = isset($_GET['type']) && isset($types[$_GET['type']]) ? $_GET['type'] : 'registrations';
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to   = isset($_GET['to']) ? $_GET['to'] : '';
$errors = [];
if ($from !== '' && $to !== '' && $from > $to) { $errors[] = 'The "from" date must be before the "to" date.'; }

/** Returns [headers, rows]. Dates are filtered where the report has a date. */
function rg_build($type, $from, $to)
{
    $ok = function ($date) use ($from, $to) {
        $t = strtotime($date);
        if ($t === false) { return true; }
        if ($from !== '' && $t < strtotime($from)) { return false; }
        if ($to !== '' && $t > strtotime($to . ' 23:59:59')) { return false; }
        return true;
    };
    if ($type === 'registrations') {
        $h = ['Date', 'Name', 'Role', 'Email', 'Status'];
        $r = [];
        foreach (toptunity_admin_users() as $u) { $r[] = [$u['joined'], $u['name'], ucfirst($u['role']), $u['email'], $u['status']]; }
        return [$h, $r];
    }
    if ($type === 'projects') {
        $h = ['Project', 'Client', 'Deadline', 'Status', 'Proposals'];
        $r = [];
        foreach (toptunity_admin_projects() as $p) { if ($ok($p['deadline'])) { $r[] = [$p['title'], $p['client'], $p['deadline'], toptunity_status_label($p['status']), $p['proposals']]; } }
        return [$h, $r];
    }
    if ($type === 'transactions') {
        $h = ['Date', 'Project', 'Billing', 'Type', 'Amount', 'Service fee', 'Status'];
        $r = [];
        foreach (toptunity_admin_payments() as $t) { if ($ok($t['date'])) { $r[] = [$t['date'], $t['project'], $t['billing'], $t['type'], $t['amount'], $t['fee'], ucfirst($t['status'])]; } }
        return [$h, $r];
    }
    $h = ['Date', 'Project', 'Service fee', 'Status'];
    $r = [];
    foreach (toptunity_admin_payments() as $t) { if ($t['fee'] > 0 && $ok($t['date'])) { $r[] = [$t['date'], $t['project'], $t['fee'], ucfirst($t['status'])]; } }
    return [$h, $r];
}

list($headers, $rows) = rg_build($type, $from, $to);

if (!$errors && isset($_GET['download'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $type . '-report-' . date('Y-m-d') . '.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, $headers);
    foreach ($rows as $row) { fputcsv($out, $row); }
    fclose($out);
    exit;
}

$qs = http_build_query(array_filter(['type' => $type, 'from' => $from, 'to' => $to]));
$clients   = count(array_filter(toptunity_admin_users(), function ($u) { return $u['role'] === 'client'; }));
$freelance = count(array_filter(toptunity_admin_users(), function ($u) { return $u['role'] === 'freelancer'; }));

$page_title = "Generate Reports";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<nav class="crumbs" aria-label="Breadcrumb"><a href="dashboard.php">Admin Dashboard</a><span>/</span><span aria-current="page">Reports Generation</span></nav>

<div class="welcome-row">
  <div>
    <h1>Reports Generation</h1>
    <p class="subtle">Generate reports for a selected date range.</p>
  </div>
</div>

<?php if ($errors): ?>
  <div class="form-alert" role="alert" style="margin-top:1.25rem;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
<?php endif; ?>

<form method="get" action="reports-generation.php" class="box" style="margin-top:1.25rem;" data-no-validate>
  <div style="display:grid; grid-template-columns: 1fr 1fr 1.4fr auto; gap:0.8rem; align-items:end;">
    <div class="field" style="margin-top:0;"><label for="rf">Select Date Range</label><input class="input" type="date" id="rf" name="from" value="<?= e($from) ?>"></div>
    <div class="field" style="margin-top:0;"><label for="rt">to</label><input class="input" type="date" id="rt" name="to" value="<?= e($to) ?>"></div>
    <div class="field" style="margin-top:0;"><label for="rty">Report Type</label>
      <select class="input" id="rty" name="type"><?php foreach ($types as $k => $l): ?><option value="<?= e($k) ?>" <?= $type === $k ? 'selected' : '' ?>><?= e($l) ?></option><?php endforeach; ?></select>
    </div>
    <button type="submit" class="btn btn--primary" style="height:42px;">Generate</button>
  </div>
  <div class="report-chips">
    <span class="muted" style="font-size:0.72rem; align-self:center;">Report types:</span>
    <?php foreach ($types as $k => $l): ?>
      <a href="reports-generation.php?type=<?= e($k) ?>" class="report-chip <?= $type === $k ? 'is-active' : '' ?>"><?= e($l) ?></a>
    <?php endforeach; ?>
  </div>
</form>

<section class="box" style="margin-top:1rem;">
  <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap;">
    <div>
      <h2>Report Preview: <?= e($types[$type]) ?></h2>
      <p class="muted"><?= $from !== '' || $to !== '' ? e($from ?: 'start') . ' – ' . e($to ?: 'today') : 'All dates' ?> · generated <?= e(date('M d, Y g:i A')) ?></p>
    </div>
    <div class="no-print" style="display:flex; gap:0.5rem;">
      <a class="btn btn--row-outline" href="reports-generation.php?<?= e($qs) ?>&amp;download=1"><?= icon('upload', 13) ?> Download</a>
      <button type="button" class="btn btn--row-outline" onclick="window.print()"><?= icon('file', 13) ?> Print</button>
    </div>
  </div>
  <div class="count-chip-row" style="display:flex; gap:0.6rem; flex-wrap:wrap; margin:0.9rem 0;">
    <span class="count-chip">Total rows <strong><?= count($rows) ?></strong></span>
    <?php if ($type === 'registrations'): ?>
      <span class="count-chip">Clients <strong><?= (int) $clients ?></strong></span>
      <span class="count-chip">Freelancers <strong><?= (int) $freelance ?></strong></span>
    <?php endif; ?>
  </div>
  <div style="overflow-x:auto;">
    <table class="data-table">
      <thead><tr><?php foreach ($headers as $h): ?><th><?= e($h) ?></th><?php endforeach; ?></tr></thead>
      <tbody>
        <?php if (!$rows): ?><tr><td colspan="<?= count($headers) ?>" class="muted" style="text-align:center; padding:1rem;">No rows in this range.</td></tr><?php endif; ?>
        <?php foreach (array_slice($rows, 0, 10) as $row): ?>
          <tr><?php foreach ($row as $cell): ?><td><?= e($cell) ?></td><?php endforeach; ?></tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php if (count($rows) > 10): ?><p class="fee-note">Showing the first 10 rows. The download includes all <?= count($rows) ?> rows.</p><?php endif; ?>
</section>

</main>

<?php include '../includes/footer.php'; ?>