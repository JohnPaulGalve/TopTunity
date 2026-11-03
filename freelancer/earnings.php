<?php
/**
 * freelancer/earnings.php - Earnings, held payments and withdrawals (database).
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "earnings";

require_once __DIR__ . '/../includes/data.php';

$methods = ['gcash' => 'GCash', 'bank' => 'Bank Account'];
$errors  = [];
$real    = tt_freelancer_money();   // real balance only (the limit for withdrawals)
$field_errors = [];
$form    = ['amount' => '', 'method' => 'gcash', 'account' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['amount']  = isset($_POST['amount']) ? $_POST['amount'] : '';
    $form['method']  = isset($_POST['method']) && isset($methods[$_POST['method']]) ? $_POST['method'] : 'gcash';
    $form['account'] = trim(isset($_POST['account']) ? $_POST['account'] : '');
    $bank = isset($_POST['bank']) ? trim($_POST['bank']) : '';
    $composed = $form['method'] === 'bank' ? $bank . ' · ' . preg_replace('/\s+/', '', $form['account']) : preg_replace('/\s+/', '', $form['account']);
    // Check each field on its own, so every message appears under the field it is about
    $amount_value = is_numeric($form['amount']) ? (int) $form['amount'] : 0;
    if ($amount_value < 500)                    { $field_errors['amount'] = 'Minimum withdrawal is ₱500.'; }
    elseif ($amount_value > (int) $real['available']) { $field_errors['amount'] = 'You can withdraw up to ₱' . number_format($real['available']) . '.'; }
    $account_error = tt_check_withdrawal_account($form['method'], $composed);
    if ($account_error) { $field_errors['account'] = $account_error; }
    if (!$field_errors) {
        $err = tt_db_withdraw($amount_value, $form['method'], $composed);
        if ($err) { $field_errors['amount'] = $err; }
    }
    if (!$field_errors) {
        tt_flash('Withdrawal of ₱' . number_format($amount_value) . ' was requested. It is held until it is processed.');
        header('Location: ' . $base_url . 'freelancer/earnings.php');
        exit;
    }
}

$money = toptunity_freelancer_earnings();
$real  = tt_freelancer_money();              // real balance only (the limit for withdrawals)

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

<?php
$completed_total = array_sum(array_column($money['completed'], 'payment'));
$completed_fee   = array_sum(array_column($money['completed'], 'fee'));
$pending_total   = array_sum(array_map(function ($w) { return $w['status'] === 'pending' ? (int) $w['amount'] : 0; }, $money['withdrawals']));
$fee_percent     = (int) tt_service_fee();
?>
<div class="notice-bar" style="margin-top:1.25rem;"><?= icon('info', 15) ?> All transactions are simulated — no real money is sent. Each action only updates your balance and records in the database.</div>

<div class="stat-grid" style="grid-template-columns: repeat(3, 1fr); margin-top:1.25rem;">
  <div class="stat-card" style="background:#1E293B; color:#fff; border-color:#1E293B;">
    <span class="stat-card__label" style="color:#CBD5E1;">Available Balance</span>
    <span class="stat-card__value" style="color:#fff;">₱<?= number_format($money['available'] ?? 0) ?></span>
    <span class="stat-card__sub" style="color:#CBD5E1;"><?= $pending_total > 0 ? '₱' . number_format($pending_total) . ' on hold for a pending withdrawal' : 'Ready to withdraw' ?></span>
  </div>
  <div class="stat-card" style="display:flex; flex-direction:row; align-items:center; gap:0.9rem;">
    <span class="icon-box icon-box--teal" style="flex-shrink:0;"><?= icon('dollar', 18) ?></span>
    <div>
      <span class="stat-card__label" style="display:block;">Net Earnings</span>
      <span class="stat-card__value" style="display:block;">₱<?= number_format($money['net'] ?? 0) ?></span>
      <span class="stat-card__sub" style="display:block;">From <?= (int) count($money['completed']) ?> completed project<?= count($money['completed']) === 1 ? '' : 's' ?></span>
    </div>
  </div>
  <div class="stat-card" style="display:flex; flex-direction:row; align-items:center; gap:0.9rem;">
    <span class="icon-box icon-box--orange" style="flex-shrink:0;"><?= icon('percent', 18) ?></span>
    <div>
      <span class="stat-card__label" style="display:block;">Platform Service Fee Deducted</span>
      <span class="stat-card__value" style="display:block;">₱<?= number_format($completed_fee) ?></span>
      <span class="stat-card__sub" style="display:block;"><?= $fee_percent ?>% of ₱<?= number_format($completed_total) ?></span>
    </div>
  </div>
</div>

<div style="display:grid; grid-template-columns: minmax(0,1fr) 340px; gap:1.25rem; margin-top:1.25rem; align-items:start;">
  <div>
    <section class="admin-list">
      <div class="panel__head" style="padding:1rem 1.1rem 0;"><h2>Completed Project Payments</h2></div>
      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead><tr><th>Date</th><th>Project · Billing</th><th class="num">Payment</th><th class="num">Service Fee</th><th class="num">Net</th></tr></thead>
          <tbody>
            <?php if (!$money['completed']): ?><tr><td colspan="5" class="muted" style="text-align:center; padding:1.2rem;">No payments yet.</td></tr><?php endif; ?>
            <?php foreach ($money['completed'] as $e): ?>
              <tr>
                <td><?= e($e['date']) ?></td>
                <td><strong><?= e($e['project']) ?></strong><small style="display:block;" class="muted"><?= e($e['billing']) ?></small></td>
                <td class="num">₱<?= number_format($e['payment']) ?></td>
                <td class="num" style="color:var(--color-error-base);">− ₱<?= number_format($e['fee']) ?></td>
                <td class="num" style="color:var(--color-vibrant-teal); font-weight:700;">₱<?= number_format($e['net']) ?></td>
              </tr>
            <?php endforeach; ?>
            <?php if ($money['completed']): ?>
              <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td class="num"><strong>₱<?= number_format($completed_total) ?></strong></td>
                <td class="num" style="color:var(--color-error-base);"><strong>− ₱<?= number_format($completed_fee) ?></strong></td>
                <td class="num" style="color:var(--color-vibrant-teal);"><strong>₱<?= number_format($money['net'] ?? 0) ?></strong></td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section class="admin-list" style="margin-top:1.25rem;">
      <div class="panel__head" style="padding:1rem 1.1rem 0;"><h2>Withdrawal Request Status</h2></div>
      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead><tr><th>Date</th><th>Method</th><th class="num">Amount</th><th>Status</th></tr></thead>
          <tbody>
            <?php if (!$money['withdrawals']): ?><tr><td colspan="4" class="muted" style="text-align:center; padding:1.2rem;">No withdrawal requests yet.</td></tr><?php endif; ?>
            <?php foreach ($money['withdrawals'] as $w): ?>
              <tr>
                <td><?= e($w['date']) ?></td>
                <td><?= e($w['method'] === 'gcash' ? 'GCash' : 'Bank') ?><?= !empty($w['account']) ? ' ···· ' . e(substr($w['account'], -4)) : '' ?></td>
                <td class="num">₱<?= number_format($w['amount']) ?></td>
                <td>
                  <span class="status status--<?= $w['status'] === 'processed' ? 'released' : ($w['status'] === 'rejected' ? 'past' : 'pending') ?>"><?= e(ucfirst($w['status'])) ?></span>
                  <?php if ($w['status'] === 'rejected'): ?><small class="muted">returned to balance</small><?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </div>

  <section class="panel" style="margin-top:0;">
    <div class="panel__head"><h2>Request Withdrawal</h2></div>
    <?php if ($errors): ?><div class="form-alert" role="alert"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div><?php endif; ?>
    <form method="post" action="earnings.php" novalidate>
      <div class="field" style="margin-top:0;">
        <label for="wd-amount">Amount (₱)</label>
        <input class="input<?= isset($field_errors['amount']) ? ' is-invalid' : '' ?>" id="wd-amount" name="amount" type="number" value="<?= e($form['amount']) ?>">
        <p class="hint">Available: ₱<?= number_format($real['available']) ?>. Minimum ₱500.</p>
        <?php if (isset($field_errors['amount'])): ?><p class="field-error"><?= e($field_errors['amount']) ?></p><?php endif; ?>
      </div>
      <div class="field">
        <label>Withdraw to</label>
        <div style="display:flex; gap:0.5rem;">
          <?php foreach ($methods as $k => $l): ?>
            <label style="flex:1; display:flex; align-items:center; justify-content:center; gap:0.4rem; border:1px solid var(--color-border-gray); border-radius:10px; padding:0.6rem; cursor:pointer; font-weight:600; <?= $form['method'] === $k ? 'border-color:var(--color-vibrant-teal); background:#F0FDFA;' : '' ?>">
              <input type="radio" name="method" value="<?= e($k) ?>" <?= $form['method'] === $k ? 'checked' : '' ?> style="accent-color:var(--color-vibrant-teal);">
              <?= e($l) ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="field">
        <div id="wd-bank-wrap">
          <label for="wd-bank">Bank</label>
          <select class="input" id="wd-bank" name="bank"><?php foreach (['BDO', 'BPI', 'Metrobank', 'Landbank', 'UnionBank', 'Security Bank', 'RCBC', 'PNB'] as $bk): ?><option value="<?= e($bk) ?>"><?= e($bk) ?></option><?php endforeach; ?></select>
        </div>
        <label for="wd-account" id="wd-account-label">GCash number</label>
        <input class="input<?= isset($field_errors['account']) ? ' is-invalid' : '' ?>" id="wd-account" name="account" value="<?= e($form['account']) ?>" placeholder="09XX XXX XXXX" inputmode="numeric">
        <p class="hint" id="wd-hint">GCash: 11 digits starting with 09.</p>
        <?php if (isset($field_errors['account'])): ?><p class="field-error"><?= e($field_errors['account']) ?></p><?php endif; ?>
      </div>
      <button type="submit" class="btn btn--primary" style="width:100%; margin-top:0.8rem;" <?= $real['available'] < 500 ? 'disabled' : '' ?>>Request Withdrawal</button>
      <p class="fee-note" style="text-align:center; margin-top:0.6rem;">SIMULATED · NO REAL MONEY</p>
      <p class="fee-note" style="margin-top:0.4rem;">The amount is held from your balance, then deducted when the administrator marks it as processed (or returned if rejected).</p>
    </form>
  </section>
</div>

<script>
(function () {
  var radios = document.querySelectorAll('input[name="method"]'), a = document.getElementById('wd-account'),
      b = document.getElementById('wd-bank-wrap'), l = document.getElementById('wd-account-label'), h = document.getElementById('wd-hint');
  function sync() {
    var bank = document.querySelector('input[name="method"]:checked').value === 'bank';
    b.style.display = bank ? '' : 'none';
    l.textContent = bank ? 'Bank account number' : 'GCash number';
    a.placeholder = bank ? 'Account number (10 to 16 digits)' : '09XX XXX XXXX';
    h.textContent = bank ? 'Bank account: 10 to 16 digits.' : 'GCash: 11 digits starting with 09.';
  }
  radios.forEach(function (r) { r.addEventListener('change', sync); });
  sync();
})();
</script>

</main>

<?php include '../includes/footer.php'; ?>