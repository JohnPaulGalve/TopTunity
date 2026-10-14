<?php
/**
 * admin/dashboard.php - Platform statistics (matches the Admin Dashboard design).
 * Money and chart figures are sample values from the design; the user count is live.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "dashboard";

require_once __DIR__ . '/../includes/data.php';

$users   = toptunity_admin_users();
$clients = count(array_filter($users, function ($u) { return $u['role'] === 'client'; }));
$freel   = count(array_filter($users, function ($u) { return $u['role'] === 'freelancer'; }));
$total   = max(1, count($users));

$fee = tt_service_fee();
$money = toptunity_admin_money_totals();
$status_bars = [['Open', 118], ['Past Deadline', 14], ['Ongoing', 86], ['Overdue', 9], ['Completed', 203], ['Closed', 21], ['Cancelled', 12]];
$max_status = max(array_column($status_bars, 1));
$months  = ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'];
$held    = [215, 250, 275, 305, 345, 487];
$release = [150, 180, 200, 230, 260, 285];
$fees    = [15, 18, 20, 23, 25, 29];
$max_money = 600;

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
    <span class="muted">+124 this month</span>
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
      <div><h2>Projects by Status</h2><p class="sub">463 projects</p></div>
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
      <div class="donut" style="background: conic-gradient(#1E293B 0 37%, #009488 37% 100%);">
        <div class="donut__center"><strong><?= number_format(742 + 1244) ?></strong><small>total users</small></div>
      </div>
      <div class="donut-legend">
        <div><i style="background:#1E293B;"></i> Clients<strong>742</strong>37%</div>
        <div><i style="background:#009488;"></i> Freelancers<strong>1,244</strong>63%</div>
      </div>
    </div>
  </section>
</div>

<div class="chart-grid chart-grid--2">
  <section class="chart-card">
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
      <div><h2>Payments Held vs Released</h2><p class="sub">Monthly, May–Oct 2026</p></div>
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
    <p class="sub">Monthly, May–Oct 2026</p>
    <div class="bars" style="margin-top:1.2rem;">
      <?php foreach ($months as $i => $m): ?>
        <div class="bars__col">
          <span class="bars__val">₱<?= (int) $fees[$i] ?>k</span>
          <div class="bars__bar" style="height:<?= round($fees[$i] / 40 * 100) ?>%;"></div>
          <span class="bars__label"><?= e($m) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</div>

</main>

<?php include '../includes/footer.php'; ?>
