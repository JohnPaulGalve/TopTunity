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
$form    = ['amount' => '', 'method' => 'gcash', 'account' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['amount']  = isset($_POST['amount']) ? $_POST['amount'] : '';
    $form['method']  = isset($_POST['method']) && isset($methods[$_POST['method']]) ? $_POST['method'] : 'gcash';
    $form['account'] = trim(isset($_POST['account']) ? $_POST['account'] : '');
    $bank = isset($_POST['bank']) ? trim($_POST['bank']) : '';
    $composed = $form['method'] === 'bank' ? $bank . ' · ' . preg_replace('/\s+/', '', $form['account']) : preg_replace('/\s+/', '', $form['account']);
    $err = tt_check_withdrawal_account($form['method'], $composed) ?: tt_db_withdraw((int) $form['amount'], $form['method'], $composed);
    if ($err) { $errors[] = $err; }
    else {
        tt_flash('Withdrawal of ₱' . number_format((int) $form['amount']) . ' was requested. It is held until it is processed.');
        header('Location: ' . $base_url . 'freelancer/earnings.php');
        exit;
    }
}

$money = toptunity_freelancer_earnings();   // demo figures plus real balances and records
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

<div class="stat-grid" style="grid-template-columns: repeat(3, 1fr); margin-top:1.25rem;">
  <div class="stat-card"><div class="stat-card__top"><span class="stat-card__label">Available balance</span><span class="icon-box icon-box--teal"><?= icon('wallet', 16) ?></span></div><span class="stat-card__value">₱<?= number_format($money['available']) ?></span><span class="muted">Ready to withdraw</span></div>
  <div class="stat-card"><div class="stat-card__top"><span class="stat-card__label">Total earned</span><span class="icon-box icon-box--blue"><?= icon('check-circle', 16) ?></span></div><span class="stat-card__value">₱<?= number_format($money['earned']) ?></span><span class="muted">After the service fee</span></div>
  <div class="stat-card"><div class="stat-card__top"><span class="stat-card__label">Held by clients</span><span class="icon-box icon-box--orange"><?= icon('lock', 16) ?></span></div><span class="stat-card__value">₱<?= number_format($money['on_hold']) ?></span><span class="muted">Released when work is approved</span></div>
</div>

<div class="two-col" style="grid-template-columns: 1fr 1fr; margin-top:1.25rem;">
  <section class="panel" style="margin-top:0;">
    <div class="panel__head"><h2>Request a Withdrawal</h2></div>
    <?php if ($errors): ?><div class="form-alert" role="alert"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div><?php endif; ?>
    <form method="post" action="earnings.php">
      <div class="field" style="margin-top:0;">
        <label for="wd-amount">Amount (₱)</label>
        <input class="input" id="wd-amount" name="amount" type="number" min="500" max="<?= (int) $real['available'] ?>" value="<?= e($form['amount']) ?>">
        <p class="hint">Minimum ₱500. You can withdraw up to ₱<?= number_format($real['available']) ?> from your real earnings. Sample balances cannot be withdrawn.</p>
      </div>
      <div class="field">
        <label for="wd-method">Method</label>
        <select class="input" id="wd-method" name="method"><?php foreach ($methods as $k => $l): ?><option value="<?= e($k) ?>" <?= $form['method'] === $k ? 'selected' : '' ?>><?= e($l) ?></option><?php endforeach; ?></select>
      </div>
      <div class="field">
        <div id="wd-bank-wrap">
          <label for="wd-bank">Bank</label>
          <select class="input" id="wd-bank" name="bank"><?php foreach (['BDO', 'BPI', 'Metrobank', 'Landbank', 'UnionBank', 'Security Bank', 'RCBC', 'PNB'] as $bk): ?><option value="<?= e($bk) ?>"><?= e($bk) ?></option><?php endforeach; ?></select>
        </div>
        <label for="wd-account" id="wd-account-label">GCash number</label>
        <input class="input" id="wd-account" name="account" value="<?= e($form['account']) ?>" placeholder="09XX XXX XXXX" inputmode="numeric">
        <p class="hint" id="wd-hint">GCash: 11 digits starting with 09.</p>
        <script>
        (function () {
          var m = document.getElementById('wd-method'), a = document.getElementById('wd-account'), b = document.getElementById('wd-bank-wrap'),
              l = document.getElementById('wd-account-label'), h = document.getElementById('wd-hint');
          function sync() {
            var bank = m.value === 'bank';
            b.style.display = bank ? '' : 'none';
            l.textContent = bank ? 'Bank account number' : 'GCash number';
            a.placeholder = bank ? 'Account number (10 to 16 digits)' : '09XX XXX XXXX';
            h.textContent = bank ? 'Bank account: 10 to 16 digits.' : 'GCash: 11 digits starting with 09.';
          }
          m.addEventListener('change', sync); sync();
        })();
        </script>
      </div>
      <button type="submit" class="btn btn--primary" style="margin-top:1rem;" <?= $real['available'] < 500 ? 'disabled' : '' ?>>Request Withdrawal</button>
    </form>
  </section>

  <section class="panel" style="margin-top:0;">
    <div class="panel__head"><h2>Withdrawal Requests</h2></div>
    <?php if (!$money['withdrawals']): ?><p class="muted">No withdrawal requests yet.</p><?php endif; ?>
    <?php foreach ($money['withdrawals'] as $w): ?>
      <div class="pay-item">
        <div class="pay-item__top">
          <div><strong>₱<?= number_format($w['amount']) ?> · <?= e($w['method']) ?></strong><small><?= e($w['date']) ?><?= !empty($w['sample']) ? ' · Sample' : '' ?></small></div>
          <span class="status status--<?= $w['status'] === 'processed' ? 'released' : ($w['status'] === 'rejected' ? 'past' : 'pending') ?>"><?= e(ucfirst($w['status'])) ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
</div>

<section class="admin-list" style="margin-top:1.25rem;">
  <p class="section-tag" style="padding:0.9rem 1rem 0;">Payments on your projects</p>
  <div style="overflow-x:auto;">
    <table class="data-table">
      <thead><tr><th>Date</th><th>Project</th><th>Billing</th><th class="num">Payment</th><th class="num">Service fee</th><th class="num">You receive</th></tr></thead>
      <tbody>
        <?php if (!$money['completed']): ?><tr><td colspan="6" class="muted" style="text-align:center; padding:1.2rem;">No payments yet.</td></tr><?php endif; ?>
        <?php foreach ($money['completed'] as $e): ?>
          <tr>
            <td><?= e($e['date']) ?></td>
            <td><strong><?= e($e['project']) ?></strong><?= !empty($e['sample']) ? '<small>Sample</small>' : '' ?></td>
            <td><?= e($e['billing']) ?></td>
            <td class="num">₱<?= number_format($e['payment']) ?></td>
            <td class="num">₱<?= number_format($e['fee']) ?></td>
            <td class="num">₱<?= number_format($e['net']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

</main>

<?php include '../includes/footer.php'; ?>