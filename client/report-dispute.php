<?php
/**
 * client/report-dispute.php - Report a user or content, file a dispute, or see your submissions.
 * Matches the Report and Dispute design. ?tab=report|dispute|submissions, ?user=N, ?id=N (project).
 * Submitting is not connected to a database yet.
 */
$user_role     = "client";
$base_url      = "/Webdev/";
$active_client = "projects";

require_once __DIR__ . '/../includes/data.php';

$tabs = [
    'report'      => ['Report Content or User', 'flag'],
    'dispute'     => ['File a Dispute', 'alert'],
    'submissions' => ['My Submissions', 'clipboard'],
];
$tab = isset($_GET['tab']) && isset($tabs[$_GET['tab']]) ? $_GET['tab'] : 'report';

/* Users you can report (freelancers, plus the one in the design) */
$people = [];
foreach (toptunity_freelancers() as $fid => $f) { $people[$fid] = $f['name'] . ' · Freelancer'; }
$people[100] = 'Daniel Ocampo · Freelancer';
$pre_user = isset($_GET['user']) && isset($people[(int) $_GET['user']]) ? (int) $_GET['user'] : 100;

$reported_types = ['User', 'Project', 'Message'];
$reasons_report = ['Abusive or inappropriate messages', 'Fake or misleading profile', 'Spam or off-platform payment request', 'Other'];
$reasons_dispute = ['Work not delivered', 'Work does not match the requirements', 'Hours logged but not real', 'Freelancer stopped responding', 'Payment or refund problem', 'Other'];

$open_projects = array_filter(toptunity_client_projects(), function ($p) {
    return in_array($p['status'], ['ongoing', 'overdue'], true);
});
$pre_project = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$submissions = [
    ['type' => 'Report', 'about' => 'Daniel Ocampo · Freelancer', 'reason' => 'Abusive or inappropriate messages', 'date' => 'Sep 28, 2026', 'status' => 'pending'],
    ['type' => 'Dispute', 'about' => 'Menu Board and Cup Sleeve Design', 'reason' => 'Freelancer stopped responding', 'date' => 'Sep 12, 2026', 'status' => 'released'],
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
    <form method="post" action="">
      <?php if ($tab === 'report'): ?>
        <div class="two-col" style="margin-top:0; grid-template-columns:1fr 1fr; gap:1rem;">
          <div class="field" style="margin-top:0;">
            <label for="rep-type">What are you reporting?</label>
            <select class="input" id="rep-type" name="type"><?php foreach ($reported_types as $t): ?><option><?= e($t) ?></option><?php endforeach; ?></select>
          </div>
          <div class="field" style="margin-top:0;">
            <label for="rep-reason">Reason</label>
            <select class="input" id="rep-reason" name="reason"><?php foreach ($reasons_report as $r): ?><option><?= e($r) ?></option><?php endforeach; ?></select>
          </div>
        </div>
        <div class="field">
          <label for="rep-user">Reported user</label>
          <select class="input" id="rep-user" name="user_id">
            <?php foreach ($people as $pid => $label): ?>
              <option value="<?= (int) $pid ?>" <?= $pid === $pre_user ? 'selected' : '' ?>><?= e($label) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php else: ?>
        <div class="two-col" style="margin-top:0; grid-template-columns:1fr 1fr; gap:1rem;">
          <div class="field" style="margin-top:0;">
            <label for="dis-project">Project</label>
            <select class="input" id="dis-project" name="project_id" required>
              <?php foreach ($open_projects as $id => $p): ?>
                <option value="<?= (int) $id ?>" <?= $pre_project === $id ? 'selected' : '' ?>><?= e($p['title']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field" style="margin-top:0;">
            <label for="dis-reason">Reason</label>
            <select class="input" id="dis-reason" name="reason"><?php foreach ($reasons_dispute as $r): ?><option><?= e($r) ?></option><?php endforeach; ?></select>
          </div>
        </div>
      <?php endif; ?>

      <div class="field">
        <label for="details">Details</label>
        <textarea id="details" name="details" class="input" rows="4" style="height:auto; padding:0.8rem; line-height:1.6; font-size:0.82rem;" required><?= $tab === 'report' ? 'After I chose another freelancer, this user sent me several rude messages and demanded I cancel my project. Screenshots attached.' : '' ?></textarea>
      </div>

      <div class="field">
        <label>Attachments</label>
        <?php if ($tab === 'report'): ?>
          <div class="file-row" style="max-width:340px;">
            <?= icon('file', 15) ?><span>conversation-screenshot.png</span><span class="file-row__size">380 KB</span>
            <button type="button" class="file-row__remove" aria-label="Remove file"><?= icon('x', 13) ?></button>
          </div>
        <?php endif; ?>
        <label class="dropzone" style="margin-top:0.6rem;">
          <?= icon('upload', 20) ?>
          <strong>Drag files here or <a>browse</a></strong>
          <small>PDF, JPG, PNG up to 10 MB</small>
          <input type="file" name="attachments[]" multiple accept=".pdf,.jpg,.jpeg,.png">
        </label>
      </div>

      <div class="form-actions" style="justify-content:space-between;">
        <small><?= icon('info', 12) ?> <?= $tab === 'report' ? 'Report a user or content: choose type · reason · details · attachments' : 'File a Dispute: select project · reason · details · attachments' ?></small>
        <button type="submit" class="btn btn--primary">Submit</button>
      </div>
    </form>
  </section>
<?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>