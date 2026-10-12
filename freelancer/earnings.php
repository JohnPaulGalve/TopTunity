<?php
/**
 * freelancer/earnings.php - Matches the Earnings and Withdrawals design.
 * Withdrawals are simulated and not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = "/Webdev/";
$active_client = "earnings";

require_once __DIR__ . '/../includes/data.php';

$money   = toptunity_freelancer_earnings();
$methods = ['gcash' => 'GCash', 'bank' => 'Bank Account'];
$errors  = [];
$form    = ['amount' => 10000, 'method' => 'gcash', 'account' => 'Miguel Reyes · 0917 •••• 4821'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['amount'] = (int) (isset($_POST['amount']) ? $_POST['amount'] : 0);
    $form['method'] = isset($_POST['method']) && isset($methods[$_POST['method']]) ? $_POST['method'] : 'gcash';
    if ($form['amount'] < 500)                         { $errors[] = 'The minimum withdrawal is ₱500.'; }
    elseif ($form['amount'] > $money['available'])     { $errors[] = 'You can withdraw at most ₱' . number_format($money['available']) . '.'; }
    if (!$errors) {
        tt_flash('Withdrawal of ₱' . number_format($form['amount']) . ' was requested (simulated). It is held until processed.');
        header('Location: ' . $base_url . 'freelancer/earnings.php');
        exit;
    }
}

$page_title = "Earnings and Withdrawals";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Earnings and Withdrawals</h1>
    <p class="subtle">Track your payments and withdraw your balance.</p>
  </div>
</div>

<div class="notice-bar" style="margin-top:1.25rem;">
  <?= icon('info', 15) ?> All transactions are simulated (dummy). No real money is sent. Each action only updates your balance and records in the database.
</div>

<div class="stat-grid" style="grid-template-columns: 1.2fr 1fr 1fr; margin-top:1rem;">
  <div class="stat-card" style="background:var(--color-deep-slate); border-color:var(--color-deep-slate);">
    <span class="stat-card__label" style="color:#CBD5E1;">Available Balance</span>
    <span class="stat-card__value" style="color:#FFFFFF; font-size:2rem;">₱<?= number_format($money['available']) ?></span>
    <span class="muted" style="color:#94A3B8;">₱<?= number_format($money['on_hold']) ?> on hold for a pending withdrawal</span>
  </div>
  <div class="stat-card">
    <div class="stat-card__top"><span class="stat-card__label">Net Earnings</span><span class="icon-box icon-box--teal"><?= icon('dollar', 16) ?></span></div>
    <span class="stat-card__value">₱<?= number_format($money['net']) ?></span>
    <span class="muted">From <?= count($money['completed']) ?> completed projects</span>
  </div>
  <div class="stat-card">
    <div class="stat-card__top"><span class="stat-card__label">Platform Service Fee Deducted</span><span class="icon-box icon-box--orange"><?= icon('percent', 16) ?></span></div>
    <span class="stat-card__value">₱<?= number_format($money['fee']) ?></span>
    <span class="muted">10% of ₱<?= number_format($money['fee'] * 10) ?></span>
  </div>
</div>

<div class="billing-grid">
  <div class="stack">
    <section class="panel">
      <div class="panel__head"><h2>Completed Project Payments</h2></div>
      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead><tr><th>Date</th><th>Project · Billing</th><th class="num">Payment</th><th class="num">Service Fee</th><th class="num">Net</th></tr></thead>
          <tbody>
            <?php foreach ($money['completed'] as $c): ?>
              <tr>
                <td><?= e($c['date']) ?></td>
                <td><strong><?= e($c['project']) ?></strong><small><?= e($c['billing']) ?></small></td>
                <td class="num">₱<?= number_format($c['payment']) ?></td>
                <td class="num" style="color:var(--color-error-base);">– ₱<?= number_format($c['fee']) ?></td>
                <td class="num" style="color:var(--color-teal-dark); font-weight:700;">₱<?= number_format($c['net']) ?></td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="2"><strong>Total</strong></td>
              <td class="num"><strong>₱<?= number_format(array_sum(array_column($money['completed'], 'payment'))) ?></strong></td>
              <td class="num" style="color:var(--color-error-base);"><strong>– ₱<?= number_format(array_sum(array_column($money['completed'], 'fee'))) ?></strong></td>
              <td class="num" style="color:var(--color-teal-dark);"><strong>₱<?= number_format(array_sum(array_column($money['completed'], 'net'))) ?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <section class="panel">
      <div class="panel__head"><h2>Withdrawal Request Status</h2></div>
      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead><tr><th>Date</th><th>Method</th><th class="num">Amount</th><th>Status</th></tr></thead>
          <tbody>
            <?php foreach ($money['withdrawals'] as $w): ?>
              <tr>
                <td><?= e($w['date']) ?></td>
                <td><?= e($w['method']) ?></td>
                <td class="num">₱<?= number_format($w['amount']) ?></td>
                <td>
                  <span class="status status--<?= $w['status'] === 'pending' ? 'pending' : ($w['status'] === 'processed' ? 'released' : 'past') ?>"><?= e(ucfirst($w['status'])) ?></span>
                  <?php if ($w['status'] === 'rejected'): ?><small class="muted"> returned to balance</small><?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </div>

  <aside class="panel summary-card">
    <div class="panel__head"><h2>Request Withdrawal</h2></div>
    <?php if ($errors): ?><div class="form-alert" role="alert" style="margin-top:0;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div><?php endif; ?>
    <form method="post" action="earnings.php">
      <div class="field" style="margin-top:0.6rem;">
        <label for="w-amount">Amount (₱)</label>
        <div class="input-prefix"><span>₱</span><input class="input" type="number" id="w-amount" name="amount" min="500" max="<?= (int) $money['available'] ?>" step="1" value="<?= e($form['amount']) ?>" required></div>
        <span class="hint">Available: ₱<?= number_format($money['available']) ?></span>
      </div>
      <div class="field">
        <label>Withdraw to</label>
        <div class="role-options" style="grid-template-columns:1fr 1fr;">
          <?php foreach ($methods as $key => $label): ?>
            <label class="role-card"><input type="radio" name="method" value="<?= e($key) ?>" <?= $form['method'] === $key ? 'checked' : '' ?>>
              <span class="role-card__body"><span><strong><?= e($label) ?></strong></span><span class="role-card__dot"></span></span></label>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="field">
        <label>Account name / number</label>
        <div class="input-wrap"><?= icon('user', 16) ?><input value="<?= e($form['account']) ?>" readonly></div>
      </div>
      <button type="submit" class="btn btn--primary btn--full">Request Withdrawal</button>
      <p class="fine-print">Simulated · No real money. The amount is held from your balance until the administrator marks it as processed (or returned if rejected).</p>
    </form>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>