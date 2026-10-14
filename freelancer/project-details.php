<?php
/**
 * freelancer/project-details.php - Matches the Project Details design (freelancer view).
 * Log hours, request-revision banner, submit completed work, status history, review client.
 * Saving is not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "projects";

require_once __DIR__ . '/../includes/data.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$p  = toptunity_freelancer_project($id);

$steps   = ['Project Posted', 'Proposals Submitted', 'Freelancer Selected', 'Contract Accepted', 'Project Started', 'Work Submitted', 'Client Review', 'Completed'];
$current = $p ? ($p['status'] === 'completed' ? 8 : ($p['status'] === 'offer' ? 3 : 5)) : 0;

$errors = [];
$log    = ['date' => date('Y-m-d'), 'hours' => '', 'task' => ''];
if ($p && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log_hours'])) {
    $log['date']  = isset($_POST['date']) ? $_POST['date'] : '';
    $log['hours'] = isset($_POST['hours']) ? $_POST['hours'] : '';
    $log['task']  = trim(isset($_POST['task']) ? $_POST['task'] : '');
    $d = DateTime::createFromFormat('Y-m-d', $log['date']);
    if (!$d || $d->format('Y-m-d') !== $log['date'])                          { $errors[] = 'Choose the date you worked.'; }
    if ($log['hours'] === '' || (float) $log['hours'] < 0.5 || (float) $log['hours'] > 12) { $errors[] = 'Enter between 0.5 and 12 hours.'; }
    if (mb_strlen($log['task']) < 5)                                          { $errors[] = 'Describe the task (at least 5 characters).'; }
    if (!$errors) {
        tt_flash('Hours logged. The client will review them.');
        header('Location: ' . $base_url . 'freelancer/project-details.php?id=' . $id);
        exit;
    }
}

if ($p && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_work'])) {
    $up = tt_handle_uploads('deliverables');
    if ($up['errors']) { tt_flash('Could not submit: ' . implode(' ', $up['errors'])); }
    else {
        tt_save_attachments('deliverable', $id, $up['files']);
        tt_flash(count($up['files']) ? 'Your work was submitted to the client.' : 'Add at least one file to submit your work.');
    }
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

$page_title = $p ? $p['title'] : 'Project not found';
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="my-projects.php">My Projects</a><span>/</span><span aria-current="page">Project Details</span>
</nav>

<?php if (!$p): ?>
  <div class="not-found"><div class="empty-art"><?= icon('alert', 40) ?></div><h1>Project not found</h1><p>This project is not available.</p><a href="my-projects.php" class="btn btn--dark">Back to My Projects</a></div>
<?php else:
  $is_hourly = $p['type'] === 'hourly';
  $days_left = max(0, (int) ceil((strtotime($p['deadline']) - strtotime(date('Y-m-d'))) / 86400));
  $status_label = ['ongoing' => 'Ongoing', 'overdue' => 'Overdue', 'completed' => 'Completed', 'offer' => 'Project Offer'][$p['status']];
?>

<div class="head-row">
  <div>
    <div style="display:flex; align-items:center; gap:0.6rem; flex-wrap:wrap;">
      <h1><?= e($p['title']) ?></h1>
      <span class="status status--<?= $p['status'] === 'completed' ? 'completed' : ($p['status'] === 'overdue' ? 'overdue' : 'ongoing') ?>"><?= e($status_label) ?></span>
      <span class="pill pill--blue"><?= $is_hourly ? 'Hourly' : 'Fixed Price' ?></span>
    </div>
    <div class="head-meta">
      <span>Client <strong><?= e($p['client']) ?></strong></span>
      <?php if ($is_hourly): ?><span>Hourly rate <strong>₱<?= number_format($p['rate']) ?>/hr</strong></span><span>Maximum hours <strong><?= (int) $p['max_hours'] ?> h</strong></span><?php endif; ?>
      <span>Start date <strong><?= e(date('M d, Y', strtotime($p['start']))) ?></strong></span>
      <span>End date <strong><?= e(date('M d, Y', strtotime($p['deadline']))) ?></strong></span>
    </div>
  </div>
  <div class="head-actions">
    <a href="messages.php" class="btn btn--row-outline"><?= icon('message', 13) ?> Message Client</a>
    <a href="report-dispute.php?tab=dispute" class="btn btn--danger-outline"><?= icon('flag', 13) ?> File a Dispute</a>
  </div>
</div>

<section class="box" style="margin-top:1.25rem;">
  <div class="status-banner">Current Status: <strong><?= $p['status'] === 'completed' ? 'Completed' : ($p['status'] === 'overdue' ? 'Overdue' : 'Project Started') ?></strong>
    <span style="margin-left:auto; font-size:0.74rem;"><?= (int) $p['progress'] ?>% complete</span></div>
  <ol class="tracking-steps">
    <?php foreach ($steps as $i => $label): $n = $i + 1;
      $cls = $n < $current ? 'is-done' : ($n === $current ? 'is-current' : ''); ?>
      <li class="<?= $cls ?>"><span class="dot"><?= $n < $current ? icon('check', 12) : $n ?></span><small><?= e($label) ?></small></li>
    <?php endforeach; ?>
  </ol>
  <?php if ($p['revision']): ?>
  <div class="revision-banner">
    <div>
      <strong><?= icon('refresh', 13) ?> Revision requested by client · <?= e($p['revision']['date']) ?></strong>
      <p>“<?= e($p['revision']['message']) ?>”</p>
    </div>
    <a href="#submit-work" class="btn btn--primary">Resubmit Revised Work</a>
  </div>
  <?php endif; ?>
</section>

<div class="two-col" style="margin-top:1rem;">
  <div class="stack">
    <?php if ($is_hourly): ?>
    <section class="box">
      <div class="box-head">
        <h2>Work Log</h2>
        <span class="status status--pending">Hourly project</span>
      </div>
      <?php if ($errors): ?><div class="form-alert" role="alert"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div><?php endif; ?>

      <form method="post" action="project-details.php?id=<?= (int) $id ?>" style="margin-top:0.6rem;">
        <input type="hidden" name="log_hours" value="1">
        <div class="field-row" style="grid-template-columns: 1fr 110px 2fr auto; align-items:end;">
          <div class="field" style="margin-top:0;"><label for="log-date">Date</label><input class="input" type="date" id="log-date" name="date" value="<?= e($log['date']) ?>" required></div>
          <div class="field" style="margin-top:0;"><label for="log-hours">Hours</label><input class="input" type="number" id="log-hours" name="hours" min="0.5" max="12" step="0.5" value="<?= e($log['hours']) ?>" required></div>
          <div class="field" style="margin-top:0;"><label for="log-task">Task</label><input class="input" type="text" id="log-task" name="task" value="<?= e($log['task']) ?>" placeholder="What did you work on?" required></div>
          <button type="submit" class="btn btn--primary" style="height:42px;"><?= icon('plus', 14) ?> Log Hours</button>
        </div>
      </form>

      <div style="overflow-x:auto; margin-top:0.8rem;">
        <table class="data-table">
          <thead><tr><th>Date</th><th>Hours</th><th>Task</th><th>Status</th></tr></thead>
          <tbody>
            <?php foreach ($p['worklog'] as $w): ?>
              <tr>
                <td><?= e(date('M d, Y', strtotime($w['date']))) ?></td>
                <td><?= number_format($w['hours'], 1) ?></td>
                <td><?= e($w['task']) ?><?php if (!empty($w['note'])): ?><small style="display:block; color:var(--color-error-text);">Reason: <?= e($w['note']) ?></small><?php endif; ?></td>
                <td><span class="status status--<?= $w['status'] === 'approved' ? 'released' : ($w['status'] === 'pending' ? 'pending' : 'past') ?>"><?= e(ucfirst($w['status'])) ?></span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="hours-foot">
        <span>Logged <strong><?= number_format($p['hours_logged'], 1) ?> / <?= (int) $p['max_hours'] ?> h</strong></span>
        <span>Approved <strong><?= number_format($p['hours_approved'], 1) ?> h</strong></span>
        <span>Estimated pay <strong>₱<?= number_format($p['hours_approved'] * $p['rate']) ?></strong></span>
      </div>
      <p class="note-line">Hours cannot go over the Maximum Hours and can only be logged between the Start Date and the End Date.</p>
    </section>
    <?php endif; ?>

    <section class="box" id="submit-work">
      <h2>Submit Completed Work</h2>
      <?php if ($p['status'] === 'completed'): ?>
        <p class="muted">The work was approved and the payment was released.</p>
      <?php else: ?>
        <form method="post" action="project-details.php?id=<?= (int) $id ?>" style="margin-top:0.6rem;" enctype="multipart/form-data">
          <div class="field" style="margin-top:0;">
            <label for="msg-client">Message to client</label>
            <textarea id="msg-client" name="message" class="input" rows="3" style="height:auto; padding:0.7rem; font-size:0.8rem;" placeholder="Explain what you delivered and what to check."><?= $p['submitted'] ? e($p['submitted']['message']) : '' ?></textarea>
          </div>
          <label class="dropzone" style="margin-top:0.8rem;">
            <?= icon('upload', 20) ?>
            <strong>Upload files or add links</strong>
            <small>PDF, DOCX, PNG, ZIP up to 20 MB</small>
            <input type="file" name="deliverables[]" multiple>
          </label>
          <?php foreach (tt_attachments('deliverable', $id) as $f): ?>
            <div class="file-row" style="margin-top:0.6rem;"><?= icon('file', 15) ?><?= tt_file_name_html($f, $base_url) ?><span class="file-row__size"><?= e($f['size']) ?></span></div>
          <?php endforeach; ?>
          <?php foreach (($p['submitted']['files'] ?? []) as $f): ?>
            <div class="file-row" style="margin-top:0.6rem;"><?= icon('file', 15) ?><span><?= e($f['name']) ?></span><span class="file-row__size"><?= e($f['size']) ?></span></div>
          <?php endforeach; ?>
          <div class="form-actions--plain"><button type="submit" name="submit_work" value="1" class="btn btn--primary"><?= icon('upload', 14) ?> Submit Completed Work</button></div>
        </form>
      <?php endif; ?>
    </section>

    <section class="box">
      <h2>Status History</h2>
      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead><tr><th>Date</th><th>Status</th><th>Note</th></tr></thead>
          <tbody>
            <?php foreach ($p['history'] as $h): ?>
              <tr><td><?= e($h['date']) ?></td><td><?= e($h['status']) ?></td><td><?= e($h['note']) ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </div>

  <aside class="stack">
    <section class="box">
      <h2>Project Dates</h2>
      <div class="kv"><span>Start Date</span><strong><?= e(date('M d, Y', strtotime($p['start']))) ?></strong></div>
      <div class="kv"><span>End Date</span><strong><?= e(date('M d, Y', strtotime($p['deadline']))) ?></strong></div>
      <div class="kv"><span>Days left</span><strong style="color:var(--color-vibrant-teal);"><?= $days_left ?> days</strong></div>
    </section>
    <section class="box">
      <h2>Contract</h2>
      <div class="kv"><span>Status</span><span class="status status--ongoing">Active</span></div>
      <div class="kv"><span>Agreed on</span><strong><?= e(date('M d, Y', strtotime($p['start']))) ?></strong></div>
      <a href="#" class="btn btn--row-outline" style="width:100%; margin-top:0.7rem;">View Contract →</a>
    </section>
    <?php if ($is_hourly): ?>
    <section class="box">
      <h2>Hourly Billing</h2>
      <p class="muted">On the End Date, approved hours × your hourly rate, minus the 10% platform fee, goes to your Earnings balance.</p>
    </section>
    <?php endif; ?>
    <?php if ($p['status'] === 'completed'): ?>
    <section class="box">
      <h2>Work Approved</h2>
      <p class="muted">The project is completed and the payment was released (minus the service fee).</p>
      <a href="#review-client" class="btn btn--review" style="width:100%; margin-top:0.7rem;"><?= icon('star', 13) ?> Review Client</a>
    </section>
    <?php endif; ?>
    <section class="warn-box">
      <h3>Having a problem?</h3>
      <p>You can file a dispute on any ongoing project.</p>
      <a href="report-dispute.php?tab=dispute" class="btn btn--danger-outline" style="width:100%; margin-top:0.6rem;"><?= icon('flag', 13) ?> File a Dispute</a>
    </section>
  </aside>
</div>

<div class="modal-overlay" id="review-client" role="dialog" aria-modal="true" aria-labelledby="rc2-title">
  <div class="modal">
    <div class="modal__head"><h2 id="rc2-title">Review Client</h2><a href="#" class="modal__close" aria-label="Close"><?= icon('x', 18) ?></a></div>
    <div class="modal__who"><?= avatar('#FFEDD5', '#1E293B', 'bun', 36) ?><div><strong><?= e($p['client']) ?></strong><small><?= e($p['client_company']) ?> · <?= e($p['title']) ?></small></div></div>
    <form method="post" action="project-details.php?id=<?= (int) $id ?>">
      <p style="margin-top:1rem; font-size:0.78rem; font-weight:600;">Rating</p>
      <div class="star-pick">
        <?php for ($s = 5; $s >= 1; $s--): ?>
          <input type="radio" id="rc2-<?= $s ?>" name="rating" value="<?= $s ?>" <?= $s === 5 ? 'checked' : '' ?>>
          <label for="rc2-<?= $s ?>" aria-label="<?= $s ?> stars">★</label>
        <?php endfor; ?>
      </div>
      <div class="field"><label for="rc2-text" style="font-size:0.78rem; font-weight:600;">Review</label>
        <textarea id="rc2-text" name="review" class="input" rows="4" style="height:auto; padding:0.7rem; font-size:0.8rem;" placeholder="How did the client work with you?"></textarea></div>
      <p class="hint"><?= icon('info', 13) ?> Available once the client approves the work · once per project.</p>
      <div class="modal__foot"><a href="#" class="btn btn--outline">Cancel</a><button type="submit" class="btn btn--primary">Submit Review</button></div>
    </form>
  </div>
</div>

<?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>