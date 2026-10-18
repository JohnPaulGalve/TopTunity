<?php
/**
 * admin/dispute-management.php - Review disputes and record a decision (matches the Dispute Management design).
 * Decisions are persisted to live dispute records or isolated demo session state.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "disputes";

require_once __DIR__ . '/../includes/data.php';

$all  = toptunity_admin_disputes();
$sel  = null;
$want = isset($_GET['id']) ? $_GET['id'] : '';
foreach ($all as $d) { if ($d['id'] === $want) { $sel = $d; } }
if (!$sel && $all) { $sel = $all[0]; }

$errors = [];
$decision_val = isset($_POST['decision']) ? $_POST['decision'] : '';
$to_fl = isset($_POST['to_freelancer']) ? (int) $_POST['to_freelancer'] : (int) floor(($sel['held'] ?? 0) / 2);
$to_cl = isset($_POST['to_client']) ? (int) $_POST['to_client'] : (int) ceil(($sel['held'] ?? 0) / 2);
$notes = trim(isset($_POST['notes']) ? $_POST['notes'] : '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $sel) {
    $error = tt_admin_resolve_dispute((string) $sel['id'], (string) $decision_val, $to_fl, $to_cl, $notes);
    if ($error) {
        $errors[] = $error;
    } else {
        tt_flash('Decision recorded for ' . $sel['id'] . '.');
        header('Location: ' . $base_url . 'admin/dispute-management.php?id=' . urlencode($sel['id']));
        exit;
    }
}

$page_title = "Dispute Management";
$flash = tt_flash();
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Dispute Management</h1>
    <p class="subtle">Review disputes between clients and freelancers and record a decision.</p>
  </div>
</div>

<?php if ($flash): ?><div class="note-soft" role="status" style="margin-top:1rem;"><?= e($flash) ?></div><?php endif; ?>

<section class="admin-list" style="margin-top:1.25rem;">
  <div style="overflow-x:auto;">
    <table class="data-table">
      <thead><tr><th>Date</th><th>Project</th><th>Billing type</th><th>Filed by</th><th>Reason</th><th>Status</th><th></th></tr></thead>
      <tbody>
        <?php if (!$all): ?><tr><td colspan="7" class="muted" style="text-align:center; padding:1.2rem;">No disputes are available.</td></tr><?php endif; ?>
        <?php foreach ($all as $d): ?>
          <tr class="<?= $sel && $d['id'] === $sel['id'] ? 'is-selected' : '' ?>">
            <td><?= e($d['date']) ?></td>
            <td><strong><?= e($d['project']) ?></strong></td>
            <td><?= e($d['billing']) ?></td>
            <td><?= e($d['filed_by']) ?></td>
            <td><?= e($d['reason']) ?></td>
            <td><span class="status status--<?= $d['status'] === 'open' ? 'pending' : 'released' ?>"><?= e(ucfirst($d['status'])) ?></span></td>
            <td><a class="view" href="dispute-management.php?id=<?= e($d['id']) ?>">View</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<?php if ($sel): ?>
<section class="box" style="margin-top:1rem;">
  <div class="box-head">
    <h2>Dispute Details · <?= e($sel['project']) ?></h2>
    <span class="muted">Filed by <?= e($sel['client']) ?> (Client) vs <?= e($sel['freelancer']) ?> (Freelancer)</span>
  </div>

  <div class="split-grid" style="margin-top:0.6rem;">
    <div class="chart-card" style="box-shadow:none;">
      <p class="section-tag" style="margin-bottom:0.5rem;">Project history</p>
      <div class="timeline">
        <?php foreach ($sel['history'] as $h): ?><div><?= e($h) ?></div><?php endforeach; ?>
      </div>
    </div>
    <div class="chart-card" style="box-shadow:none;">
      <p class="section-tag" style="margin-bottom:0.5rem;">Submitted work</p>
      <?php if (!$sel['files']): ?><p class="muted">No work was submitted.</p><?php endif; ?>
      <?php foreach ($sel['files'] as $f): ?>
        <span class="file-chip"><?= icon('file', 14) ?> <?= e($f['name']) ?> <small><?= e($f['size']) ?></small></span>
      <?php endforeach; ?>
      <p class="note-line" style="margin-top:0.7rem;">Last submission · <?= e($sel['deadline']) ?></p>
    </div>
    <div class="chart-card" style="box-shadow:none;">
      <p class="section-tag" style="margin-bottom:0.5rem;">Payment details</p>
      <div class="kv"><span>Held</span><strong>₱<?= number_format($sel['held']) ?></strong></div>
      <div class="kv"><span>Service fee</span><strong>₱<?= number_format($sel['fee']) ?></strong></div>
      <div class="kv"><span>Deadline</span><strong><?= e($sel['deadline']) ?></strong></div>
    </div>
  </div>

  <div class="split-grid" style="margin-top:1rem; grid-template-columns:1fr 1.4fr;">
    <div class="chart-card" style="box-shadow:none;">
      <p class="section-tag" style="margin-bottom:0.5rem;">Contract</p>
      <div class="kv"><span>Status</span><span class="status status--ongoing">Active</span></div>
      <div class="kv"><span>Billing</span><strong><?= e($sel['contract']) ?></strong></div>
      <div class="kv"><span>Dates</span><strong><?= e($sel['dates']) ?></strong></div>
      <p class="note-line">The available contract summary is shown above.</p>
    </div>
    <div class="chart-card" style="box-shadow:none;">
      <p class="section-tag" style="margin-bottom:0.5rem;">Conversation history <small class="muted">(read-only)</small></p>
      <div class="chat-mini">
        <?php foreach ($sel['chat'] as $m): ?>
          <div class="<?= $m['from'] === $sel['freelancer'] || $m['from'] === explode(' ', $sel['freelancer'])[0] ? 'me' : '' ?>"><strong><?= e($m['from']) ?>:</strong> <?= e($m['text']) ?></div>
        <?php endforeach; ?>
      </div>
      <p class="note-line" style="margin-top:0.5rem;">The available conversation history is shown above.</p>
    </div>
  </div>

  <?php if ($sel['status'] === 'open'): ?>
  <form method="post" action="dispute-management.php?id=<?= e($sel['id']) ?>" style="margin-top:1.2rem;">
    <p class="section-tag">Record decision</p>
    <?php if ($errors): ?><div class="form-alert" role="alert"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div><?php endif; ?>

    <div class="radio-line">
      <label><input type="radio" name="decision" value="release" <?= $decision_val === 'release' ? 'checked' : '' ?>> Release to Freelancer</label>
      <label><input type="radio" name="decision" value="refund" <?= $decision_val === 'refund' ? 'checked' : '' ?>> Refund to Client</label>
      <label><input type="radio" name="decision" value="split" <?= ($decision_val === 'split' || $decision_val === '') ? 'checked' : '' ?>> Split Payment</label>
    </div>

    <div class="split-grid">
      <div class="field" style="margin-top:0;"><label for="tf">To freelancer</label><div class="input-prefix"><span>₱</span><input class="input" id="tf" type="number" name="to_freelancer" value="<?= (int) $to_fl ?>" min="0"></div></div>
      <div class="field" style="margin-top:0;"><label for="tc">To client</label><div class="input-prefix"><span>₱</span><input class="input" id="tc" type="number" name="to_client" value="<?= (int) $to_cl ?>" min="0"></div></div>
      <div class="field" style="margin-top:0;"><label for="nt">Decision notes <span class="req">*</span></label><input class="input" id="nt" name="notes" value="<?= e($notes) ?>" minlength="20" placeholder="Explain the decision"></div>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-top:1rem; flex-wrap:wrap;">
      <p class="note-line" style="max-width:520px;">The decision and notes are saved to the dispute record. This does not initiate a transfer or refund.</p>
      <button type="submit" class="btn btn--primary">Record Decision</button>
    </div>
  </form>
  <?php else: ?>
    <p class="muted" style="margin-top:1rem;">This dispute is resolved. <?= e($sel['history'][count($sel['history']) - 1]) ?></p>
  <?php endif; ?>
</section>
<?php else: ?>
<section class="box" style="margin-top:1rem;"><h2>Dispute Details</h2><p class="muted">There are no disputes to review.</p></section>
<?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>