<?php
/**
 * client/dashboard.php - Client home: stats, posted projects, notifications, messages.
 */
$user_role     = "client";
$base_url      = "/Webdev/";
$active_client = "dashboard";

require_once __DIR__ . '/../includes/data.php';

$me       = toptunity_current_client();
$projects = toptunity_client_projects();
$payments = toptunity_client_payments();
$notes    = toptunity_client_notifications();
$messages = toptunity_client_messages();

$page_title = "Client Dashboard";
include '../includes/header.php';
include '../includes/client-nav.php';

/* ---- Stats, calculated from the data ---- */
$posted_count   = count($projects);
$proposal_total = array_sum(array_column($projects, 'proposals'));
$ongoing_count  = count(array_filter($projects, function ($p) { return $p['status'] === 'ongoing'; }));
$pending_total  = array_sum(array_map(function ($x) {
    return $x['status'] === 'pending' ? $x['amount'] : 0;
}, $payments));

/* Projects shown in the table */
$table_ids = [1, 2, 4, 6];

/* The project with the pending deposit */
$pending_project = null;
foreach ($projects as $p) {
    if ($p['title'] === 'Monthly Social Media Content Calendar') { $pending_project = $p; break; }
}
?>

<div class="welcome-row">
  <div>
    <h1>Welcome back, <?= e(explode(' ', $me['name'])[0]) ?>!</h1>
    <p class="subtle">Here's what's happening with your projects today, <?= e(date('l, F j')) ?>.</p>
  </div>
  <a href="<?= e($base_url) ?>client/post-project.php" class="btn btn--primary btn--sm-block"><?= icon('plus', 16) ?> Post a Project</a>
</div>

<!-- Stat cards -->
<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-card__top">
      <span class="stat-card__label">Posted Projects</span>
      <span class="icon-box icon-box--orange"><?= icon('folder', 16) ?></span>
    </div>
    <span class="stat-card__value"><?= (int) $posted_count ?></span>
    <a href="<?= e($base_url) ?>client/my-projects.php" class="stat-card__link">View →</a>
  </div>

  <div class="stat-card">
    <div class="stat-card__top">
      <span class="stat-card__label">Proposals Received</span>
      <span class="icon-box icon-box--teal"><?= icon('clipboard', 16) ?></span>
    </div>
    <span class="stat-card__value"><?= (int) $proposal_total ?></span>
    <a href="<?= e($base_url) ?>client/my-projects.php" class="stat-card__link">View →</a>
  </div>

  <div class="stat-card">
    <div class="stat-card__top">
      <span class="stat-card__label">Ongoing Projects</span>
      <span class="icon-box icon-box--blue"><?= icon('clock', 16) ?></span>
    </div>
    <span class="stat-card__value"><?= (int) $ongoing_count ?></span>
    <a href="<?= e($base_url) ?>client/my-projects.php?status=ongoing" class="stat-card__link">View →</a>
  </div>

  <div class="stat-card">
    <div class="stat-card__top">
      <span class="stat-card__label">Pending Payments</span>
      <span class="icon-box icon-box--orange"><?= icon('wallet', 16) ?></span>
    </div>
    <span class="stat-card__value">₱<?= number_format($pending_total) ?></span>
    <a href="<?= e($base_url) ?>client/billing.php" class="stat-card__link">View →</a>
  </div>
</div>

<div class="dash-grid">

  <div class="dash-col">
    <!-- Posted projects -->
    <section class="panel">
      <div class="panel__head">
        <h2>Posted Projects</h2>
        <a href="<?= e($base_url) ?>client/my-projects.php" class="panel__link">View all in My Projects →</a>
      </div>
      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead>
            <tr>
              <th>Project</th>
              <th>Status</th>
              <th class="num">Proposals</th>
              <th class="num">Deadline</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($table_ids as $id): $p = $projects[$id]; ?>
              <tr>
                <td>
                  <strong><?= e($p['title']) ?></strong>
                  <small><?= $p['type'] === 'hourly' ? 'Hourly · ₱' . number_format($p['rate']) . '/hr' : 'Fixed Price · ₱' . number_format($p['budget']) ?></small>
                </td>
                <td><span class="status status--<?= e($p['status']) ?>"><?= e(toptunity_status_label($p['status'])) ?></span></td>
                <td class="num"><?= (int) $p['proposals'] ?></td>
                <td class="num"><?= e(date('M d, Y', strtotime($p['deadline']))) ?></td>
                <td class="num"><a href="<?= e($base_url) ?>client/project-tracking.php?id=<?= (int) $id ?>" class="view">View</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Recent messages -->
    <section class="panel">
      <div class="panel__head">
        <h2>Recent Messages</h2>
        <a href="<?= e($base_url) ?>client/messages.php" class="panel__link">Open Messages →</a>
      </div>
      <?php foreach ($messages as $m): ?>
        <div class="msg-item">
          <?= avatar($m['bg'], $m['hair'], $m['style'], 34) ?>
          <div class="msg-item__body">
            <strong><?= e($m['name']) ?></strong>
            <small> · <?= e($m['project']) ?></small>
            <p><?= e($m['text']) ?></p>
          </div>
          <div class="msg-item__meta">
            <time><?= e($m['time']) ?></time>
            <?php if ($m['unread']): ?><span class="unread-dot" aria-label="Unread"></span><?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </section>
  </div>

  <div class="dash-col">
    <!-- Notifications -->
    <section class="panel">
      <div class="panel__head">
        <h2>Recent Notifications</h2>
        <a href="<?= e($base_url) ?>client/notifications.php" class="panel__link">All</a>
      </div>
      <?php foreach ($notes as $n): ?>
        <div class="notif-item">
          <span class="icon-box icon-box--<?= e($n['tint']) ?>"><?= icon($n['icon'], 15) ?></span>
          <div class="notif-item__body">
            <strong><?= e($n['title']) ?><?php if ($n['new']): ?><span class="dot-new" aria-label="New"></span><?php endif; ?></strong>
            <p><?= e($n['text']) ?></p>
          </div>
          <time><?= e($n['time']) ?></time>
        </div>
      <?php endforeach; ?>
    </section>

    <!-- Pending payment -->
    <?php if ($pending_project): ?>
    <section class="pending-box">
      <h2>Pending Payments</h2>
      <p>
        <?= e($pending_project['title']) ?><br>
        Deposit ₱<?= number_format($pending_project['rate']) ?> × <?= (int) $pending_project['max_hours'] ?> hrs
        <strong>₱<?= number_format($pending_project['budget']) ?></strong>
      </p>
      <a href="<?= e($base_url) ?>client/billing.php" class="btn btn--primary btn--small">Go to Billing and Payments</a>
    </section>
    <?php endif; ?>
  </div>

</div>

</main>

<?php include '../includes/footer.php'; ?>