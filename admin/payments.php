<?php
/**
 * admin/payments.php - Payments and transactions (database).
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "payments";

require_once __DIR__ . '/../includes/data.php';

$rows   = toptunity_admin_payments();   // demo rows plus real records
$totals = toptunity_admin_money_totals();
$cls    = ['held' => 'held', 'released' => 'released', 'paid' => 'released', 'refunded' => 'refunded'];

$page_title = "Payments and Transactions";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Payments and Transactions</h1>
    <p class="subtle">All transactions are simulated (dummy). No real money is used.</p>
  </div>
</div>

<div class="stat-grid" style="grid-template-columns: repeat(3, 1fr); margin-top:1.25rem;">
  <div class="stat-card"><div class="stat-card__top"><span class="stat-card__label">Escrow payments held</span><span class="icon-box icon-box--blue"><?= icon('lock', 16) ?></span></div><span class="stat-card__value">₱<?= number_format($totals['held']) ?></span><span class="muted"><?= (int) $totals['held_projects'] ?> projects in escrow</span></div>
  <div class="stat-card"><div class="stat-card__top"><span class="stat-card__label">Payments released</span><span class="icon-box icon-box--teal"><?= icon('check-circle', 16) ?></span></div><span class="stat-card__value">₱<?= number_format($totals['released']) ?></span><span class="muted">All time</span></div>
  <div class="stat-card"><div class="stat-card__top"><span class="stat-card__label">Service fees</span><span class="icon-box icon-box--orange"><?= icon('dollar', 16) ?></span></div><span class="stat-card__value">₱<?= number_format($totals['fees']) ?></span><span class="muted">Platform fee earned</span></div>
</div>

<section class="admin-list" style="margin-top:1.25rem;">
  <div style="overflow-x:auto;">
    <table class="data-table">
      <thead><tr><th>Date</th><th>Project · Billing</th><th>Type</th><th class="num">Amount</th><th class="num">Service fee</th><th>Status</th></tr></thead>
      <tbody>
        <?php if (!$rows): ?><tr><td colspan="6" class="muted" style="text-align:center; padding:1.2rem;">No payments yet.</td></tr><?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= e($r['date']) ?></td>
            <td><strong><?= e($r['project']) ?></strong><small><?= e($r['billing']) ?><?= !empty($r['sample']) ? ' · Sample' : '' ?></small></td>
            <td><?= e($r['type']) ?></td>
            <td class="num">₱<?= number_format($r['amount']) ?></td>
            <td class="num"><?= !empty($r['fee']) ? '₱' . number_format($r['fee']) : '—' ?></td>
            <td><span class="status status--<?= e($cls[$r['status']] ?? 'cancelled') ?>"><?= e(ucfirst($r['status'])) ?></span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

</main>

<?php include '../includes/footer.php'; ?>