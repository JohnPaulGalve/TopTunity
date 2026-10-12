<?php
/**
 * client/billing.php - Deposits, held funds, refunds, hourly billing and payment history.
 * All payments are simulated. Buttons do not move money yet.
 */
$user_role     = "client";
$base_url      = "/Webdev/";
$active_client = "billing";

require_once __DIR__ . '/../includes/data.php';

$projects = toptunity_client_projects();
$payments = toptunity_client_payments();
$hourly   = toptunity_client_hourly_billing();

$sum = function ($statuses) use ($payments) {
    return array_sum(array_map(function ($x) use ($statuses) {
        return in_array($x['status'], $statuses, true) ? $x['amount'] : 0;
    }, $payments));
};
$held_total     = $sum(['held']);
$paid_total     = $sum(['paid', 'released']);
$refund_total   = $sum(['refunded']);
$refund_count   = count(array_filter($payments, function ($x) { return $x['status'] === 'refunded'; }));

/* Pending deposit: Monthly Social Media Content Calendar (hourly) */
$pending_pid = 3;
$pending     = isset($projects[$pending_pid]) ? $projects[$pending_pid] : null;
$pending_amt = $pending ? $pending['budget'] : 0;

$filter = isset($_GET['type']) ? $_GET['type'] : 'all';
$types  = ['all' => 'All types', 'Deposit' => 'Deposit', 'Refund' => 'Refund', 'Hourly Billing' => 'Hourly Billing'];
if (!isset($types[$filter])) { $filter = 'all'; }
$history = array_values(array_filter($payments, function ($x) use ($filter) {
    return $filter === 'all' || $x['type'] === $filter;
}));

$page_title = "Billing and Payments";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Billing and Payments</h1>
    <p class="subtle">Pay for your projects and manage your billing records.</p>
  </div>
</div>

<div class="notice-bar">
  <?= icon('info', 15) ?> All payments are simulated (dummy). No real money is used. Each action only updates the records in the database.
</div>

<!-- Totals -->
<div class="stat-grid" style="grid-template-columns: repeat(3, 1fr);">
  <div class="stat-card">
    <div class="stat-card__top"><span class="stat-card__label">Held (deposited)</span><span class="icon-box icon-box--blue"><?= icon('lock', 16) ?></span></div>
    <span class="stat-card__value">₱<?= number_format($held_total) ?></span>
    <span class="muted"><?= count(array_filter($payments, function ($x) { return $x['status'] === 'held'; })) ?> ongoing projects</span>
  </div>
  <div class="stat-card">
    <div class="stat-card__top"><span class="stat-card__label">Total Paid</span><span class="icon-box icon-box--teal"><?= icon('check-circle', 16) ?></span></div>
    <span class="stat-card__value">₱<?= number_format($paid_total) ?></span>
    <span class="muted">Since Feb 2025</span>
  </div>
  <div class="stat-card">
    <div class="stat-card__top"><span class="stat-card__label">Refunds</span><span class="icon-box icon-box--orange"><?= icon('refresh', 16) ?></span></div>
    <span class="stat-card__value">₱<?= number_format($refund_total) ?></span>
    <span class="muted"><?= (int) $refund_count ?> refund<?= $refund_count === 1 ? '' : 's' ?></span>
  </div>
</div>

<div class="billing-grid">
  <div class="stack">

    <?php if ($pending): ?>
    <!-- Pending payments --><!-- Pending payments -->
    <section class="panel">
      <div class="panel__head"><h2>Pending Payments</h2></div>
      <div class="pending-box" style="margin-bottom:0.8rem;">
        <div class="pay-item">
          <div class="pay-item__top">
            <div>
              <strong><?= e($pending['title']) ?></strong>
              <span class="status status--<?= $pending['type'] === 'hourly' ? 'ongoing' : 'open' ?>" style="margin-top:0.4rem;"><?= $pending['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span>
              <small>₱<?= number_format($pending['rate']) ?>/hr × <?= (int) $pending['max_hours'] ?> hrs max · Contract accepted Oct 02, 2026</small>
            </div>
            <span class="pay-item__amount">₱<?= number_format($pending_amt) ?></span>
          </div>
          <div class="pay-item__action"><a href="#" class="btn btn--deposit">Deposit Project Amount</a></div>
        </div>
      </div>
      <div class="pending-box" style="background:#FFFFFF; border-color:var(--color-border-gray);">
        <div class="pay-item">
          <div class="pay-item__top">
            <div>
              <strong><?= e($projects[1]['title']) ?></strong>
              <span class="status status--pending" style="margin-top:0.4rem;">Fixed Price</span>
              <small>Waiting for Miguel Reyes to accept the contract</small>
            </div>
            <span class="pay-item__amount">₱<?= number_format($projects[1]['budget'] ?? 42000) ?></span>
          </div>
          <div class="pay-item__action"><a href="#" class="btn btn--deposit" aria-disabled="true">Deposit Project Amount</a></div>
        </div>
      </div>
    </section>

    <?php endif; ?>

    <!-- Hourly billing -->
    <section class="panel">
      <div class="panel__head">
        <h2>Hourly Billing</h2>
        <span class="muted">Billed on each Hourly project's End Date</span>
      </div>
      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead>
            <tr><th>End Date</th><th>Project</th><th class="num">Approved Hours</th><th class="num">Hourly Rate</th><th class="num">Amount Billed</th><th class="num">Unused Deposit</th></tr>
          </thead>
          <tbody>
            <?php foreach ($hourly as $h): ?>
              <tr>
                <td><?= e(date('M d, Y', strtotime($h['end']))) ?></td>
                <td><strong><?= e($h['project']) ?></strong></td>
                <td class="num"><?= number_format($h['approved'], 1) ?></td>
                <td class="num">₱<?= number_format($h['rate']) ?></td>
                <td class="num"><?= $h['billed'] !== null ? '₱' . number_format($h['billed']) : '—' ?></td>
                <td class="num">
                  <?php if ($h['unused'] !== null): ?><span style="color:var(--color-warning-text); font-weight:600;">₱<?= number_format($h['unused']) ?> refunded</span>
                  <?php else: ?><span class="status status--pending">Upcoming</span><?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Payment history -->
    <section class="panel">
      <div class="panel__head">
        <h2>Payment History</h2>
        <form method="get" action="billing.php">
          <label class="sort-select">
            <select name="type" data-autosubmit>
              <?php foreach ($types as $value => $label): ?>
                <option value="<?= e($value) ?>" <?= $filter === $value ? 'selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
            <?= icon('chevron-down', 13) ?>
          </label>
          <noscript><button type="submit" class="btn btn--outline btn--sm">Apply</button></noscript>
        </form>
      </div>
      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead><tr><th>Date</th><th>Project · Type</th><th class="num">Amount</th><th>Status</th><th>Receipt</th></tr></thead>
          <tbody>
            <?php if (!$history): ?>
              <tr><td colspan="5" class="muted" style="text-align:center; padding:1.2rem;">No payments of this type yet.</td></tr>
            <?php endif; ?>
            <?php foreach ($history as $x): ?>
              <tr>
                <td><?= e(date('M d, Y', strtotime($x['date']))) ?></td>
                <td><strong><?= e($x['project']) ?></strong><small><?= e($x['type']) ?></small></td>
                <td class="num">₱<?= number_format($x['amount']) ?></td>
                <td><span class="status status--<?= e($x['status']) ?>"><?= e(ucfirst($x['status'])) ?></span></td>
                <td><a href="#" class="view" aria-label="Download receipt"><?= icon('file', 15) ?></a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="fee-note">Refunds come from cancelled or disputed projects, and from unused Hourly deposits.</p>
    </section>

  </div>

  <!-- Payment breakdown -->
  <?php if ($pending): ?>
  <aside class="panel summary-card">
    <div class="panel__head"><h2>Payment Breakdown</h2></div>
    <p class="muted" style="margin-bottom:0.8rem;"><?= e($pending['title']) ?> · Hourly</p>
    <div class="kv"><span>Hourly rate</span><strong>₱<?= number_format($pending['rate']) ?>/hr</strong></div>
    <div class="kv"><span>Maximum hours</span><strong><?= (int) $pending['max_hours'] ?> hrs</strong></div>
    <div class="kv"><span>Platform service fee (10%)</span><strong style="color:var(--color-muted-gray); font-weight:500;">deducted from freelancer</strong></div>
    <div class="kv" style="border-top:1px solid var(--color-border-gray); margin-top:0.4rem; padding-top:0.8rem;"><span>You pay</span><strong class="big" style="font-size:1rem;">₱<?= number_format($pending_amt) ?></strong></div>
    <p class="fee-note">Held until the End Date (<?= e(date('M d, Y', strtotime($pending['deadline']))) ?>). Only approved hours are billed; the unused deposit is refunded.</p>
    <a href="#" class="btn btn--deposit"><?= icon('lock', 13) ?> Deposit Project Amount</a>
    <p class="fine-print">Simulated · No real money</p>
  </aside>
<?php endif; ?>
</div>

</main>

<?php include '../includes/footer.php'; ?>