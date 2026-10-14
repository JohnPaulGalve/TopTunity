<?php
/**
 * freelancer/dashboard.php - Matches the Freelancer Dashboard design.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "dashboard";

require_once __DIR__ . '/../includes/data.php';

$me        = toptunity_current_freelancer();
$proposals = toptunity_freelancer_proposals();
$projects  = toptunity_freelancer_projects();
$earn      = toptunity_freelancer_earnings();
$notes     = array_slice(toptunity_freelancer_notifications(), 0, 4);
$threads   = array_slice(toptunity_freelancer_threads(), 0, 3);
$skills    = tt_is_demo_freelancer() ? toptunity_freelancer(1)['skills'] : [];

$real_statuses = tt_freelancer_db_proposal_statuses();   // real proposals sent by this freelancer
$pending  = count(array_filter($proposals, function ($p) { return $p['status'] === 'pending'; }))
          + count(array_filter($real_statuses, function ($st) { return $st === 'pending'; }));
$selected = count(array_filter($proposals, function ($p) { return $p['status'] === 'selected'; }))
          + count(array_filter($real_statuses, function ($st) { return $st === 'selected'; }));
$proposal_total = count($proposals) + count($real_statuses);
$ongoing  = array_values(array_filter($projects, function ($p) { return in_array($p['status'], ['ongoing', 'overdue'], true); }));
$overdue  = count(array_filter($ongoing, function ($p) { return $p['status'] === 'overdue'; }));
$ongoing_total  = count($ongoing) + tt_freelancer_db_ongoing_count();

$page_title = "Freelancer Dashboard";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Welcome back, <?= e(explode(' ', $me['name'])[0] ?: 'there') ?>!</h1>
    <p class="subtle">Overview of your proposals, projects and earnings.</p>
  </div>
  <a href="<?= e($base_url) ?>freelancer/find-projects.php" class="btn btn--primary btn--sm-block"><?= icon('search', 16) ?> Find Projects</a>
</div>

<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-card__top"><span class="stat-card__label">Proposals</span><span class="icon-box icon-box--teal"><?= icon('file', 16) ?></span></div>
    <span class="stat-card__value"><?= (int) $proposal_total ?></span>
    <span class="muted"><?= (int) $pending ?> pending · <?= (int) $selected ?> selected</span>
    <a href="my-proposals.php" class="stat-card__link">My Proposals →</a>
  </div>
  <div class="stat-card">
    <div class="stat-card__top"><span class="stat-card__label">Ongoing Projects</span><span class="icon-box icon-box--blue"><?= icon('clock', 16) ?></span></div>
    <span class="stat-card__value"><?= (int) $ongoing_total ?></span>
    <span class="muted"><?= (int) $overdue ?> overdue</span>
    <a href="my-projects.php" class="stat-card__link">My Projects →</a>
  </div>
  <div class="stat-card">
    <div class="stat-card__top"><span class="stat-card__label">Earnings Balance</span><span class="icon-box icon-box--orange"><?= icon('wallet', 16) ?></span></div>
    <span class="stat-card__value">₱<?= number_format($earn['available']) ?></span>
    <span class="muted">₱<?= number_format($earn['on_hold']) ?> on hold for a pending withdrawal</span>
    <a href="earnings.php" class="stat-card__link">Earnings and Withdrawals →</a>
  </div>
</div>

<?php if ($skills): ?>
<div class="rec-band" style="margin-top:1rem; display:flex; align-items:center; gap:0.7rem; padding:0.8rem 1.1rem; background:var(--color-teal-tint); border:1px solid #99F6E4; border-radius:var(--radius-sm); font-size:0.78rem; color:var(--color-teal-dark);">
  <?= icon('zap', 15) ?>
  <span><strong>3 new projects match your skills</strong> — <?= e(implode(' · ', array_slice($skills, 0, 3))) ?>.</span>
  <a href="find-projects.php" class="link-teal" style="margin-left:auto;">See Recommended →</a>
</div>
<?php endif; ?>

<div class="dash-grid" style="grid-template-columns: 1fr 340px;">
  <div class="dash-col">
    <section class="panel">
      <div class="panel__head"><h2>Proposals</h2><a href="my-proposals.php" class="panel__link">View all in My Proposals →</a></div>
      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead><tr><th>Project</th><th>Status</th><th class="num">Offer</th><th class="num">Submitted</th><th></th></tr></thead>
          <tbody>
            <?php foreach (array_slice($proposals, 0, 4) as $p): ?>
              <tr>
                <td><strong><?= e($p['title']) ?></strong><small><?= e($p['client']) ?> · <?= $p['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></small></td>
                <td><span class="status status--<?= $p['status'] === 'pending' ? 'pending' : ($p['status'] === 'selected' ? 'released' : 'cancelled') ?>"><?= e(str_replace('_', ' ', ucfirst($p['status']))) ?></span></td>
                <td class="num">₱<?= number_format($p['offer']) ?><?= $p['type'] === 'hourly' ? '/hr' : '' ?></td>
                <td class="num"><?= e(date('M d', strtotime($p['sent']))) ?></td>
                <td class="num"><a href="my-proposals.php" class="view">View</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section class="panel">
      <div class="panel__head"><h2>Ongoing Projects</h2><a href="my-projects.php" class="panel__link">My Projects →</a></div>
      <?php foreach ($ongoing as $p): ?>
        <div class="stat-line" style="padding:0.75rem 0; border-bottom:1px solid var(--color-border-gray);">
          <div style="flex:1; min-width:0;">
            <strong style="font-size:0.8rem;"><?= e($p['title']) ?></strong>
            <small class="muted" style="display:block;"><?= e($p['client']) ?> · End <?= e(date('M d, Y', strtotime($p['deadline']))) ?></small>
            <div class="dist-bar" style="height:6px; margin-top:0.4rem;"><span style="width:<?= (int) $p['progress'] ?>%; background:<?= $p['status'] === 'overdue' ? 'var(--color-warning-base)' : 'var(--color-vibrant-teal)' ?>;"></span></div>
          </div>
          <span class="status status--<?= $p['status'] === 'overdue' ? 'overdue' : 'ongoing' ?>"><?= $p['status'] === 'overdue' ? 'Overdue' : 'Ongoing' ?></span>
        </div>
      <?php endforeach; ?>
    </section>
  </div>

  <div class="dash-col">
    <section class="panel">
      <div class="panel__head"><h2>Recent Notifications</h2><a href="notifications.php" class="panel__link">All</a></div>
      <?php foreach ($notes as $n): ?>
        <div class="notif-item">
          <span class="icon-box icon-box--<?= e($n['tint']) ?>"><?= icon($n['icon'] === 'bank' ? 'wallet' : $n['icon'], 15) ?></span>
          <div class="notif-item__body"><strong><?= e($n['title']) ?><?php if ($n['new']): ?><span class="dot-new"></span><?php endif; ?></strong><p><?= e($n['text']) ?></p></div>
          <time><?= e($n['time']) ?></time>
        </div>
      <?php endforeach; ?>
    </section>

    <section class="panel">
      <div class="panel__head"><h2>Recent Messages</h2><a href="messages.php" class="panel__link">All</a></div>
      <?php foreach ($threads as $t): ?>
        <div class="msg-item">
          <?= avatar($t['bg'], $t['hair'], $t['style'], 34) ?>
          <div class="msg-item__body"><strong><?= e($t['name']) ?></strong><p><?= e($t['preview']) ?></p></div>
          <div class="msg-item__meta"><time><?= e($t['time']) ?></time><?php if ($t['unread']): ?><span class="unread-dot"></span><?php endif; ?></div>
        </div>
      <?php endforeach; ?>
    </section>
  </div>
</div>

</main>

<?php include '../includes/footer.php'; ?>