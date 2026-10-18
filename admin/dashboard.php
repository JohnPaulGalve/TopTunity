<?php
/**
 * admin/dashboard.php - Platform statistics (matches the Admin Dashboard design).
 * Demo admins see presentation data; real admins see figures derived from live records.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "dashboard";

require_once __DIR__ . '/../includes/data.php';

$users   = toptunity_admin_users();
$clients = count(array_filter($users, function ($u) { return $u['role'] === 'client'; }));
$freel   = count(array_filter($users, function ($u) { return $u['role'] === 'freelancer'; }));
$total   = max(1, $clients + $freel);

$fee = tt_service_fee();
$money = toptunity_admin_money_totals();
$notes = array_slice(toptunity_admin_notifications(), 0, 5);
if (tt_is_demo_admin()) {
    $status_bars = [['Open', 118], ['Past Deadline', 14], ['Ongoing', 86], ['Overdue', 9], ['Completed', 203], ['Closed', 21], ['Cancelled', 12]];
    $months  = ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'];
    $held    = [215, 250, 275, 305, 345, 487];
    $release = [150, 180, 200, 230, 260, 285];
    $fees    = [15, 18, 20, 23, 25, 29];
    $user_growth = '+124 this month';
} else {
    $status_labels = ['open' => 'Open', 'past' => 'Past Deadline', 'ongoing' => 'Ongoing', 'overdue' => 'Overdue',
                      'completed' => 'Completed', 'closed' => 'Closed', 'suspended' => 'Suspended', 'cancelled' => 'Cancelled'];
    $status_counts = array_fill_keys(array_keys($status_labels), 0);
    foreach (toptunity_admin_projects() as $project) {
        if (isset($status_counts[$project['status']])) { $status_counts[$project['status']]++; }
    }
    $status_bars = [];
    foreach ($status_labels as $status => $label) { $status_bars[] = [$label, $status_counts[$status]]; }

    $user_growth_stmt = db()->prepare('SELECT COUNT(*) FROM users WHERE created_at >= ? AND email NOT IN (?, ?, ?)');
    $user_growth_stmt->execute([date('Y-m-01'), 'andrea.santos@kapelokal.ph', 'miguel.reyes@example.com', 'demo.admin@toptunity.ph']);
    $user_growth = '+' . number_format((int) $user_growth_stmt->fetchColumn()) . ' this month';

    $months = $month_keys = [];
    for ($offset = 5; $offset >= 0; $offset--) {
        $month = strtotime(date('Y-m-01') . ' -' . $offset . ' months');
        $month_keys[] = date('Y-m', $month);
        $months[] = date('M', $month);
    }
    $held = $release = $fees = array_fill(0, 6, 0);
    [$payment_rows] = tt_admin_payments_db();
    foreach ($payment_rows as $payment) {
        $index = array_search(date('Y-m', strtotime($payment['created_at'])), $month_keys, true);
        if ($index === false) { continue; }
        if ($payment['status'] === 'held') { $held[$index] += (int) $payment['amount']; }
        if ($payment['status'] === 'released') {
            $release[$index] += (int) $payment['amount'];
            $fees[$index] += (int) $payment['service_fee'];
        }
    }
    $held = array_map(function ($amount) { return (int) round($amount / 1000); }, $held);
    $release = array_map(function ($amount) { return (int) round($amount / 1000); }, $release);
    $fees = array_map(function ($amount) { return (int) round($amount / 1000); }, $fees);
}
$max_status = max(1, max(array_column($status_bars, 1)));
$max_money = max(1, max(array_merge($held, $release)));
$max_fees = max(1, max($fees));
$client_percent = (int) round($clients / $total * 100);
$freelancer_percent = 100 - $client_percent;

$page_title = "Admin Dashboard";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Admin Dashboard</h1>
    <p class="subtle">Platform statistics as of <?= e(date('l, F j, Y')) ?>.</p>
  </div>
  <a href="<?= e($base_url) ?>admin/reports-generation.php" class="btn btn--primary btn--sm-block"><?= icon('clipboard', 16) ?> Generate Reports</a>
</div>

<div class="stat-grid" style="margin-top:1.25rem;">
  <div class="stat-card stat-card--admin">
    <div class="stat-card__top"><span class="stat-card__label">Number of Users</span><span class="icon-box icon-box--teal"><?= icon('users', 16) ?></span></div>
    <span class="stat-card__value"><?= number_format(count($users)) ?></span>
    <span class="muted"><?= e($user_growth) ?></span>
  </div>
  <div class="stat-card stat-card--admin">
    <div class="stat-card__top"><span class="stat-card__label">Payments Held</span><span class="icon-box icon-box--blue"><?= icon('lock', 16) ?></span></div>
    <span class="stat-card__value">₱<?= number_format($money['held']) ?></span>
    <span class="muted"><?= (int) $money['held_projects'] ?> projects in escrow</span>
  </div>
  <div class="stat-card stat-card--admin">
    <div class="stat-card__top"><span class="stat-card__label">Payments Released</span><span class="icon-box icon-box--teal"><?= icon('check-circle', 16) ?></span></div>
    <span class="stat-card__value">₱<?= number_format($money['released']) ?></span>
    <span class="muted">All time</span>
  </div>
  <div class="stat-card stat-card--admin">
    <div class="stat-card__top"><span class="stat-card__label">Service Fees Earned</span><span class="icon-box icon-box--orange"><?= icon('dollar', 16) ?></span></div>
    <span class="stat-card__value">₱<?= number_format($money['fees']) ?></span>
    <span class="muted">At <?= (int) $fee ?>% service fee</span>
  </div>
</div>

<div class="chart-grid">
  <section class="chart-card">
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
      <div><h2>Projects by Status</h2><p class="sub"><?= number_format(array_sum(array_column($status_bars, 1))) ?> projects</p></div>
      <span class="count-chip">This month</span>
    </div>
    <div class="bars" style="margin-top:1.2rem;">
      <?php foreach ($status_bars as $b): $h = round($b[1] / $max_status * 100); ?>
        <div class="bars__col">
          <span class="bars__val"><?= (int) $b[1] ?></span>
          <div class="bars__bar" style="height:<?= (int) $h ?>%;"></div>
          <span class="bars__label"><?= e($b[0]) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="chart-card">
    <h2>Number of Users</h2>
    <p class="sub">By role</p>
    <div class="donut-wrap">
      <div class="donut" style="background: conic-gradient(var(--color-deep-slate) 0 <?= $client_percent ?>%, var(--color-vibrant-teal) <?= $client_percent ?>% 100%);">
        <div class="donut__center"><strong><?= number_format($clients + $freel) ?></strong><small>total users</small></div>
      </div>
      <div class="donut-legend">
        <div><i style="background:#1E293B;"></i> Clients<strong><?= number_format($clients) ?></strong><?= $client_percent ?>%</div>
        <div><i style="background:var(--color-vibrant-teal);"></i> Freelancers<strong><?= number_format($freel) ?></strong><?= $freelancer_percent ?>%</div>
      </div>
    </div>
  </section>
</div>

<div class="chart-grid chart-grid--2">
  <section class="chart-card">
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
      <div><h2>Payments Held vs Released</h2><p class="sub">Monthly, <?= e($months[0]) ?>–<?= e($months[5]) ?></p></div>
      <div><span class="legend"><i></i> Held</span><span class="legend"><i class="alt"></i> Released</span></div>
    </div>
    <div class="bars" style="margin-top:1.2rem;">
      <?php foreach ($months as $i => $m): ?>
        <div class="bars__col" style="flex-direction:row; gap:0.2rem; align-items:flex-end; justify-content:center;">
          <div class="bars__bar" style="height:<?= round($held[$i] / $max_money * 100) ?>%; max-width:24px;"></div>
          <div class="bars__bar bars__bar--alt" style="height:<?= round($release[$i] / $max_money * 100) ?>%; max-width:24px;"></div>
          <span class="bars__label"><?= e($m) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="chart-card">
    <h2>Service Fees Earned</h2>
    <p class="sub">Monthly, <?= e($months[0]) ?>–<?= e($months[5]) ?></p>
    <div class="bars" style="margin-top:1.2rem;">
      <?php foreach ($months as $i => $m): ?>
        <div class="bars__col">
          <span class="bars__val">₱<?= (int) $fees[$i] ?>k</span>
          <div class="bars__bar" style="height:<?= round($fees[$i] / $max_fees * 100) ?>%;"></div>
          <span class="bars__label"><?= e($m) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</div>

<section class="chart-card dashboard-notifications">
  <div class="panel__head">
    <h2>Recent Notifications</h2>
    <a href="notifications.php" class="panel__link">All</a>
  </div>
  <?php if (!$notes): ?><p class="muted">No notifications yet.</p><?php endif; ?>
  <?php foreach ($notes as $n): ?>
    <a class="notif-item notif-item--link" href="notifications.php?open=<?= e(tt_notification_key($n)) ?>">
      <span class="icon-box icon-box--<?= e($n['tint']) ?>"><?= icon($n['icon'], 15) ?></span>
      <span class="notif-item__body">
        <strong><?= e($n['title']) ?><?php if ($n['new']): ?><span class="dot-new" aria-label="New"></span><?php endif; ?></strong>
        <span class="notif-item__text"><?= e($n['text']) ?></span>
      </span>
      <time><?= e($n['time']) ?></time>
    </a>
  <?php endforeach; ?>
</section>

</main>

<?php include '../includes/footer.php'; ?>
