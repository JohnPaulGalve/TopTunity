<?php
/**
 * freelancer/report-dispute.php - Report a client, or file a dispute (matches the Report and Dispute design).
 * ?tab=report|dispute|submissions. Submitting is not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

$tabs = [
    'report'      => ['Report Content or User', 'flag'],
    'dispute'     => ['File a Dispute', 'alert'],
    'submissions' => ['My Submissions', 'clipboard'],
];
$tab = isset($_GET['tab']) && isset($tabs[$_GET['tab']]) ? $_GET['tab'] : 'report';

$people = [
    'Rico Manalastas · Client', 'Andrea Santos · Client', 'Grace Aquino · Client',
    'Mark Francisco · Client', 'Ramon Villanueva · Client', 'Joy Bautista · Client',
];
$reasons_report  = ['Fake or misleading project posting', 'Abusive or inappropriate messages', 'Asked for payment outside TopTunity', 'Other'];
$reasons_dispute = ['Client did not approve or pay for work', 'Scope changed without agreement', 'Payment or release problem', 'Client stopped responding', 'Other'];
$projects = array_filter(toptunity_freelancer_projects(), function ($p) { return $p['status'] === 'ongoing'; });

// Real projects this freelancer is working on (added to the sample list)
$me_id = (int) tt_current_user()['id'];
foreach (db()->query("SELECT id, title FROM projects WHERE freelancer_id = $me_id AND status IN ('ongoing','overdue')")->fetchAll() as $rp) {
    $projects[] = ['id' => 1000 + (int) $rp['id'], 'title' => $rp['title'], 'status' => 'ongoing'];
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $details = trim(isset($_POST['details']) ? $_POST['details'] : '');
    if (mb_strlen($details) < 20) { $errors[] = 'Describe what happened (at least 20 characters).'; }
    $up = tt_handle_uploads('attachments');
    $errors = array_merge($errors, $up['errors']);
    if (!$errors) {
        if ($tab === 'dispute') {
            $pid   = (int) ($_POST['project'] ?? 0);
            $title = 'Project';
            foreach ($projects as $pp) { if ((int) $pp['id'] === $pid) { $title = $pp['title']; } }
            $e2 = tt_db_dispute($pid, $title, $_POST['reason'] ?? '', $details);
        } else {
            $e2 = tt_db_report($_POST['type'] ?? 'User', $_POST['reason'] ?? '', $details);
        }
        if ($e2) { $errors[] = $e2; }
    }
    if (!$errors) {
        tt_save_attachments($GLOBALS['tt_last']['type'], $GLOBALS['tt_last']['id'], $up['files']);
        tt_flash('Your ' . ($tab === 'dispute' ? 'dispute' : 'report') . ' was sent to the administrator for review.');
        header('Location: ' . $base_url . 'freelancer/report-dispute.php?tab=submissions');
        exit;
    }
}

$submissions = [
    ['type' => 'Report', 'about' => 'Rico Manalastas · Client', 'reason' => 'Fake or misleading project posting', 'date' => 'Oct 02, 2026', 'status' => 'pending'],
    ['type' => 'Dispute', 'about' => 'Tuition Payment Tracker', 'reason' => 'Payment or release problem', 'date' => 'Sep 12, 2026', 'status' => 'released'],
];

$page_title = "Report and Dispute";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Report and Dispute</h1>
    <p class="subtle">Send a report or dispute for the administrator to review.</p>
  </div>
</div>

<nav class="tab-nav" aria-label="Report sections" style="margin-top:1.25rem;">
  <?php foreach ($tabs as $key => $t): ?>
    <a href="report-dispute.php?tab=<?= e($key) ?>" class="<?= $tab === $key ? 'is-active' : '' ?>">
      <?= icon($t[1], 13) ?> <?= e($t[0]) ?>
      <?php if ($key === 'submissions'): ?><span class="count"><?= count($submissions) ?></span><?php endif; ?>
    </a>
  <?php endforeach; ?>
</nav>

<?php if ($tab === 'submissions'): ?>
  <section class="box" style="margin-top:1.25rem;">
    <h2>My Submissions</h2>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead><tr><th>Type</th><th>About</th><th>Reason</th><th>Submitted</th><th>Status</th></tr></thead>
        <tbody>
          <?php foreach ($submissions as $s): ?>
            <tr>
              <td><?= e($s['type']) ?></td>
              <td><strong><?= e($s['about']) ?></strong></td>
              <td><?= e($s['reason']) ?></td>
              <td><?= e($s['date']) ?></td>
              <td><span class="status status--<?= $s['status'] === 'pending' ? 'pending' : 'released' ?>"><?= $s['status'] === 'pending' ? 'Under review' : 'Resolved' ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
<?php else: ?>
  <section class="box" style="margin-top:1.25rem;">
    <?php if ($errors): ?>
      <div class="form-alert" role="alert" style="margin-top:0;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
    <?php endif; ?>
    <form method="post" action="report-dispute.php?tab=<?= e($tab) ?>" enctype="multipart/form-data">
      <?php if ($tab === 'report'): ?>
        <div class="two-col" style="margin-top:0; grid-template-columns:1fr 1fr; gap:1rem;">
          <div class="field" style="margin-top:0;">
            <label for="rep-type">What are you reporting?</label>
            <select class="input" id="rep-type" name="type"><option>User</option><option>Project</option><option>Message</option></select>
          </div>
          <div class="field" style="margin-top:0;">
            <label for="rep-reason">Reason</label>
            <select class="input" id="rep-reason" name="reason"><?php foreach ($reasons_report as $r): ?><option><?= e($r) ?></option><?php endforeach; ?></select>
          </div>
        </div>
        <div class="field">
          <label for="rep-user">Reported user</label>
          <select class="input" id="rep-user" name="user"><?php foreach ($people as $p): ?><option><?= e($p) ?></option><?php endforeach; ?></select>
        </div>
      <?php else: ?>
        <div class="two-col" style="margin-top:0; grid-template-columns:1fr 1fr; gap:1rem;">
          <div class="field" style="margin-top:0;">
            <label for="dis-project">Project</label>
            <select class="input" id="dis-project" name="project">
              <?php foreach ($projects as $p): ?><option value="<?= (int) $p['id'] ?>"><?= e($p['title']) ?></option><?php endforeach; ?>
            </select>
          </div>
          <div class="field" style="margin-top:0;">
            <label for="dis-reason">Reason</label>
            <select class="input" id="dis-reason" name="reason"><?php foreach ($reasons_dispute as $r): ?><option><?= e($r) ?></option><?php endforeach; ?></select>
          </div>
        </div>
      <?php endif; ?>

      <div class="field">
        <label for="details">Details <span class="req">*</span></label>
        <textarea id="details" name="details" class="input" rows="4" minlength="20" style="height:auto; padding:0.8rem; line-height:1.6; font-size:0.82rem;" required><?= $tab === 'report' ? 'The client asked me to pay a "registration fee" through GCash before sending the contract. This looks like a scam.' : '' ?></textarea>
      </div>

      <div class="field">
        <label>Attachments</label>
        <label class="dropzone" style="margin-top:0;">
          <?= icon('upload', 20) ?>
          <strong>Drag files here or <a>browse</a></strong>
          <small>PDF, JPG, PNG up to 10 MB</small>
          <input type="file" name="attachments[]" multiple accept=".pdf,.jpg,.jpeg,.png">
        </label>
      </div>

      <div class="form-actions" style="justify-content:space-between;">
        <small><?= icon('info', 12) ?> <?= $tab === 'report' ? 'Report a user or content: type · reason · details · attachments' : 'File a Dispute: project · reason · details · attachments' ?></small>
        <button type="submit" class="btn btn--primary">Submit</button>
      </div>
    </form>
  </section>
<?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>