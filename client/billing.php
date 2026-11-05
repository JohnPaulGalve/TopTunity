<?php
/**
 * client/billing.php - Pending payments, hourly billing, payment history and breakdown.
 * Demo rows (for demo accounts) are shown as sample data. Real deposits and releases
 * come from the database and have working buttons.
 */
$user_role     = "client";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "billing";

require_once __DIR__ . '/../includes/data.php';
tt_settle_due_hourly_projects();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site = (int) ($_POST['project'] ?? 0);
    $act  = $_POST['action'] ?? '';
    if ($act === 'sample') {
        // demo deposit: kept for this session only, not saved
        $_SESSION[tt_demo_session_key()]['billing']['deposited'] = true;
        header('Location: ' . $base_url . 'client/billing.php');
        exit;
    }
    $err  = $act === 'deposit' ? tt_db_deposit($site, $_POST['method'] ?? '', $_POST['transfer_ref'] ?? '') : ($act === 'release' ? tt_db_release($site) : 'Unknown action.');
    tt_flash($err ? 'Could not continue: ' . $err : ($act === 'deposit' ? 'Deposit recorded. The money is held until you release it.' : 'Payment released. The freelancer has been notified.'));
    header('Location: ' . $base_url . 'client/billing.php');
    exit;
}

$projects = toptunity_client_projects();           // demo projects plus real ones
$payments = toptunity_client_payments();           // demo rows plus real deposits and releases
$demo = false;
$hourly   = toptunity_client_hourly_billing();     // demo hourly table (empty for real accounts)
$real_projects = tt_client_billing_projects();

$sum = function ($statuses) use ($payments) {
    return array_sum(array_map(function ($x) use ($statuses) {
        return in_array($x['status'], $statuses, true) ? $x['amount'] : 0;
    }, $payments));
};
$demo = false;
$held_total   = $sum(['held']);
$real_paid = 0; $real_refunds = 0; $real_refund_count = 0;
foreach (tt_client_payment_history() as $h) {
    if ($h['status'] === 'released') { $real_paid += (int) $h['amount']; }
    if ($h['type'] === 'refund' && $h['status'] === 'refunded') { $real_refunds += (int) $h['amount']; $real_refund_count++; }
}
$paid_total   = $real_paid;
$refund_total = $real_refunds;
$refund_count = $real_refund_count;

/* Demo pending deposit: Monthly Social Media Content Calendar (hourly), sample only */

$filter = isset($_GET['type']) ? $_GET['type'] : 'all';
$types  = ['all' => 'All types', 'Deposit' => 'Deposit', 'Release' => 'Release', 'Refund' => 'Refund'];
if (!isset($types[$filter])) { $filter = 'all'; }
$history = array_values(array_filter($payments, function ($x) use ($filter) {
    return $filter === 'all' || $x['type'] === $filter;
}));

$sample_held = array_filter($payments, function ($x) { return $x['status'] === 'held' && !empty($x['sample']); });

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
  <?= icon('info', 15) ?> All payments are simulated — no real money is used. Each action only updates the records in the database.
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
    <span class="muted"><?= !empty($payments) ? 'Since ' . e(date('M Y', strtotime(end($payments)['created_at'] ?? 'now'))) : 'Released to freelancers' ?></span>
  </div>
  <div class="stat-card">
    <div class="stat-card__top"><span class="stat-card__label">Refunds</span><span class="icon-box icon-box--orange"><?= icon('refresh', 16) ?></span></div>
    <span class="stat-card__value">₱<?= number_format($refund_total) ?></span>
    <span class="muted"><?= (int) $refund_count ?> refund<?= $refund_count === 1 ? '' : 's' ?></span>
  </div>
</div>

<div class="billing-grid">
  <div class="stack">

    <!-- Pending payments: sample items (demo) and real projects waiting for a deposit -->
    <section class="panel">
      <div class="panel__head"><h2>Pending Payments</h2></div>





      <?php foreach ($real_projects as $p):
        if ($p['contract_status'] !== 'active' || !empty($p['escrow_status'])) { continue; } ?>
        <div class="pending-box" id="deposit-<?= (int) $p['id'] ?>" style="margin-bottom:0.8rem;">
          <div class="pay-item">
            <div class="pay-item__top">
              <div><strong><?= e($p['title']) ?></strong> <span class="muted" style="font-size:0.75rem;"><?= $p['billing_type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span><small><?= $p['billing_type'] === 'hourly' ? '₱' . number_format($p['hourly_rate']) . '/hr × ' . (int) $p['max_hours'] . ' max hours · ' : '' ?>Freelancer: <?= e($p['freelancer_name']) ?> · Contract accepted</small></div>
              <span class="pay-item__amount">₱<?= number_format($p['agreed_amount']) ?></span>
            </div>
            <div class="pay-item__action">
              <form method="post" action="billing.php">
                <input type="hidden" name="action" value="deposit"><input type="hidden" name="project" value="<?= (int) ($p['id'] + 1000) ?>">
                <label for="dep-method-<?= (int) $p['id'] ?>" style="display:block; font-size:0.75rem; font-weight:600; margin:0.4rem 0 0.2rem;">How did you pay?</label>
                <select id="dep-method-<?= (int) $p['id'] ?>" name="method" class="input" required style="height:38px;">
                  <option value="" disabled selected hidden>Choose one</option>
                  <option value="gcash">GCash</option>
                  <option value="bank">Bank transfer</option>
                </select>
                <label for="dep-ref-<?= (int) $p['id'] ?>" style="display:block; font-size:0.75rem; font-weight:600; margin:0.5rem 0 0.2rem;">Payment reference number</label>
                <input id="dep-ref-<?= (int) $p['id'] ?>" class="input" name="transfer_ref" minlength="4" maxlength="40" placeholder="From your GCash, bank or card receipt" required style="height:38px;">
                <button type="submit" class="btn btn--deposit" style="margin-top:0.6rem;"><?= icon('lock', 13) ?> Deposit Project Amount</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php foreach ($real_projects as $p):
        if ($p['escrow_status'] !== 'held') { continue; } ?>
        <div class="pending-box" style="margin-bottom:0.8rem; background:#FFFFFF; border-color:var(--color-border-gray);">
          <div class="pay-item">
            <div class="pay-item__top">
              <div><strong><?= e($p['title']) ?></strong><small>Held until you approve the work · Freelancer: <?= e($p['freelancer_name']) ?></small></div>
              <span class="pay-item__amount">₱<?= number_format($p['escrow_amount']) ?></span>
            </div>
            <div class="pay-item__action">
              <?php if ($p['billing_type'] === 'hourly'): ?>
                <small class="muted">Hourly billing is settled on the End Date using approved hours; unused funds are refunded.</small>
              <?php else: ?>
                <form method="post" action="billing.php" data-confirm="Release this payment? This cannot be undone.">
                  <input type="hidden" name="action" value="release"><input type="hidden" name="project" value="<?= (int) ($p['id'] + 1000) ?>">
                  <button type="submit" class="btn btn--primary"><?= icon('check-circle', 13) ?> Approve and Release</button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php foreach ($sample_held as $h): ?>
        <div class="pending-box" style="margin-bottom:0.8rem; background:#FFFFFF; border-color:var(--color-border-gray);">
          <div class="pay-item">
            <div class="pay-item__top">
              <div><strong><?= e($h['project']) ?></strong><small>Sample · held until the End Date</small></div>
              <span class="pay-item__amount">₱<?= number_format($h['amount']) ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if (!$sample_held && !array_filter($real_projects, function ($p) { return $p['contract_status'] === 'active'; })): ?>
        <p class="muted">Nothing is pending right now.</p>
      <?php endif; ?>
    </section>

    <!-- Hourly billing (demo) -->
    <?php if ($hourly): ?>
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
    <?php endif; ?>

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
                <td><strong><?= e($x['project']) ?></strong><small><?= e($x['type']) ?><?= !empty($x['reference']) ? ' · ' . e($x['reference']) : '' ?><?= !empty($x['method']) ? ' · ' . e(ucfirst($x['method'] === 'bank' ? 'Bank transfer' : $x['method'])) : '' ?><?= !empty($x['transfer_ref']) ? ' · Ref ' . e($x['transfer_ref']) : '' ?><?= !empty($x['sample']) ? ' · Sample' : '' ?></small></td>
                <td class="num">₱<?= number_format($x['amount']) ?></td>
                <td><span class="status status--<?= e($x['status']) ?>"><?= e(ucfirst($x['status'])) ?></span></td>
                <td>
                  <?php if (empty($x['sample']) && !empty($x['id'])): ?>
                    <a href="receipt.php?id=<?= (int) $x['id'] ?>" class="view" aria-label="Download receipt"><?= icon('file', 15) ?></a>
                  <?php else: ?>
                    <span class="view" aria-label="Sample receipt is not downloadable" title="Sample receipt"><?= icon('file', 15) ?></span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <p class="fee-note">Refunds come from cancelled or disputed projects, and from unused Hourly deposits.</p>
    </section>

  </div>

  <aside class="stack">
    <section class="panel">
      <div class="panel__head"><h2>Payment Breakdown</h2></div>
      <?php
        $waiting_first = null;
        foreach ($real_projects as $wp) { if ($wp['contract_status'] === 'active' && empty($wp['escrow_status'])) { $waiting_first = $wp; break; } }
      ?>
      <?php if ($waiting_first): $wamt = (int) $waiting_first['agreed_amount']; ?>
        <p class="muted" style="margin-bottom:0.8rem;"><?= e($waiting_first['title']) ?> · <?= $waiting_first['billing_type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></p>
        <?php if ($waiting_first['billing_type'] === 'hourly'): ?>
          <div class="kv"><span>Hourly rate</span><strong>₱<?= number_format($waiting_first['hourly_rate']) ?>/hr</strong></div>
          <div class="kv"><span>Maximum hours</span><strong><?= (int) $waiting_first['max_hours'] ?> hrs</strong></div>
        <?php endif; ?>
        <div class="kv"><span>Platform service fee (<?= (int) tt_service_fee() ?>%)</span><strong style="color:var(--color-error-base);">−₱<?= number_format(tt_fee_for($wamt)) ?></strong></div>
        <p class="fee-note" style="margin:0 0 0.6rem;">Taken from the freelancer's payment when you release it.</p>
        <div class="kv" style="border-top:1px solid var(--color-border-gray); margin-top:0.4rem; padding-top:0.8rem;"><span>You pay</span><strong class="big" style="font-size:1rem;">₱<?= number_format($wamt) ?></strong></div>
        <p class="fee-note">Held until the End Date (<?= e(date('M d, Y', strtotime($waiting_first['deadline']))) ?>). Only approved hours are billed; the unused deposit is refunded.</p>
        <a href="#deposit-<?= (int) $waiting_first['id'] ?>" class="btn btn--deposit" style="width:100%; margin-top:0.8rem;"><?= icon('lock', 13) ?> Deposit Project Amount</a>
        <p class="fee-note" style="text-align:center; margin-top:0.6rem;">SIMULATED · NO REAL MONEY</p>
      <?php else: ?>
        <p class="muted">Nothing is waiting for a deposit right now.</p>
      <?php endif; ?>
    </section>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>