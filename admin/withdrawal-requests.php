<?php
/**
 * admin/withdrawal-requests.php - Freelancer withdrawal requests (database).
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "withdraw";

require_once __DIR__ . '/../includes/data.php';

$all  = toptunity_admin_withdrawals();
$want = isset($_GET['id']) ? (string) $_GET['id'] : '';
$sel  = null;
foreach ($all as $w) {
    if ((string) (string) $w['id'] === (string) $want) { $sel = $w; break; }
}
if (!$sel) {
    foreach ($all as $w) {
        $sel = $w; break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $sel) {
    $action = $_POST['action'] ?? '';
    $reason = trim($_POST['reason'] ?? '');
    $reference = trim($_POST['reference'] ?? '');
    $err = tt_db_process_withdrawal((int) preg_replace('/\D/', '', (string) $sel['id']), (string) $action, $reason, $reference);
    tt_flash($err ? 'Could not continue: ' . $err : ($action === 'process' ? 'Marked as processed.' : 'Rejected. The amount returns to the freelancer\'s balance.'));
    header('Location: ' . $base_url . 'admin/withdrawal-requests.php?id=' . urlencode((string) $sel['id']));
    exit;
}

$cls = ['pending' => 'pending', 'processed' => 'released', 'rejected' => 'past'];
$money_label = function ($m) { return $m; };
$page_title = "Withdrawal Requests";
$flash = tt_flash();
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Withdrawal Requests</h1>
    <p class="subtle">Review freelancers' withdrawal requests.</p>
  </div>
</div>

<?php if ($flash): ?><div class="note-soft" role="status" style="margin-top:1rem;"><?= e($flash) ?></div><?php endif; ?>

<div class="admin-layout" style="margin-top:1.25rem;">
  <section class="admin-list">
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead><tr><th>Date</th><th>Freelancer</th><th>Method</th><th class="num">Amount</th><th>Status</th></tr></thead>
        <tbody>
          <?php if (!$all): ?><tr><td colspan="5" class="muted" style="text-align:center; padding:1.2rem;">No withdrawal requests yet.</td></tr><?php endif; ?>
          <?php foreach ($all as $w): ?>
            <tr class="<?= $sel && (string) $w['id'] === (string) $sel['id'] ? 'is-selected' : '' ?>">
              <td><?= e($w['date']) ?></td>
              <td><a href="withdrawal-requests.php?id=<?= urlencode((string) $w['id']) ?>"><strong><?= e($w['freelancer']) ?></strong></a><?php if (!empty($w['sample'])): ?><small>Sample</small><?php endif; ?></td>
              <td><?= e($w['method']) ?></td>
              <td class="num">₱<?= number_format($w['amount']) ?></td>
              <td><span class="status status--<?= e($cls[$w['status']]) ?>"><?= e(ucfirst($w['status'])) ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <aside class="admin-side">
    <h2>Request Details</h2>
    <?php if (!$sel): ?>
      <p class="muted">No request selected.</p>
    <?php else: ?>
      <div class="kv"><span>Freelancer</span><strong><?= e($sel['freelancer']) ?></strong></div>
      <div class="kv"><span>Method</span><strong><?= e($sel['method']) ?></strong></div>
      <div class="kv"><span>Account</span><strong><?= e($sel['account']) ?></strong></div>
      <div class="kv"><span>Amount</span><strong>₱<?= number_format($sel['amount']) ?></strong></div>
      <div class="kv"><span>Status</span><span class="status status--<?= e($cls[$sel['status']]) ?>"><?= e(ucfirst($sel['status'])) ?></span></div>
      <?php if ($sel['status'] === 'processed'): ?>
        <div class="kv"><span>Processed on</span><strong><?= e($sel['processed']) ?></strong></div>
        <div class="kv"><span>Reference</span><strong><?= e($sel['reference']) ?></strong></div>
      <?php endif; ?>

      <?php if ($sel['status'] === 'pending'): ?>
        <form method="post" action="withdrawal-requests.php?id=<?= (int) $sel['id'] ?>" style="margin-top:0.9rem;">
          <input class="input" name="reference" minlength="4" maxlength="30" placeholder="Transfer reference (from GCash or bank)" style="height:38px;">
          <button type="submit" name="action" value="process" class="btn btn--green btn--block" style="margin-top:0.6rem;">✓ Mark as Processed</button>
          <input class="input" name="reason" minlength="10" placeholder="Reason, if rejecting (10+ characters)" style="margin-top:0.6rem; height:38px;">
          <button type="submit" name="action" value="reject" class="btn btn--block" style="margin-top:0.5rem; background:#FFFFFF; border:1px solid var(--color-error-base); color:var(--color-error-base);">Mark as Rejected</button>
        </form>
        <p class="note-line" style="margin-top:0.7rem;">The freelancer is notified. Rejected amounts return to their balance.</p>
      <?php endif; ?>
    <?php endif; ?>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>