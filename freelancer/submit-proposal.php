<?php
/**
 * freelancer/submit-proposal.php - Matches the Submit Proposal design.
 * Sending is not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "find";

require_once __DIR__ . '/../includes/data.php';

$id      = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$project = null;
$db_project = $id >= 1000 ? tt_db_project($id) : null;
if ($db_project) {
    $cl = db()->prepare('SELECT name FROM users WHERE id = ?');
    $cl->execute([(int) $db_project['client_id']]);
    $cat = db()->prepare('SELECT name FROM categories WHERE id = ?');
    $cat->execute([(int) $db_project['category_id']]);
    $project = ['id' => $id, 'title' => $db_project['title'], 'category' => $cat->fetchColumn() ?: 'Web Development',
                'client' => $cl->fetchColumn(), 'type' => $db_project['billing_type'],
                'amount' => $db_project['billing_type'] === 'hourly' ? (int) $db_project['hourly_rate'] : (int) $db_project['budget'],
                'max_hours' => (int) $db_project['max_hours'], 'deadline' => $db_project['deadline'],
                'proposals' => count(tt_db_proposals($id)), 'desc' => $db_project['description'], 'skills' => []];
} else {
    foreach (toptunity_listing() as $row) { if ((int) $row['id'] === $id) { $project = $row; } }
}
$full    = ($project && !$db_project) ? toptunity_project($id) : null;
$skills  = tt_is_demo_freelancer() ? toptunity_freelancer(1)['skills'] : [];
$req     = $full ? $full['skills'] : [];
$match   = tt_skill_match($req, $skills);
$have    = count(array_intersect(array_map('strtolower', $req), array_map('strtolower', $skills)));
$sent    = false;
if ($db_project) {
    foreach (tt_db_proposals($id) as $pr) { if ((int) $pr['freelancer_id'] === (int) tt_current_user()['id']) { $sent = true; } }
} else {
    foreach (toptunity_freelancer_proposals() as $pr) { if ($project && (int) $pr['project_id'] === $id) { $sent = true; } }
}
$deadline_passed = $project && $project['deadline'] < date('Y-m-d');

$errors = [];
$form   = ['offer' => '', 'days' => '', 'letter' => ''];

if ($project && !$sent && !$deadline_passed && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['offer']  = isset($_POST['offer']) ? (int) $_POST['offer'] : '';
    $form['days']   = isset($_POST['days']) ? (int) $_POST['days'] : '';
    $form['letter'] = trim(isset($_POST['letter']) ? $_POST['letter'] : '');
    if ($form['offer'] === '' || $form['offer'] < 1)  { $errors[] = $project['type'] === 'hourly' ? 'Enter your hourly rate.' : 'Enter your total price.'; }
    if ($form['days'] === '' || $form['days'] < 1)    { $errors[] = 'Enter how many days you need to finish.'; }
    if (mb_strlen($form['letter']) < 50)              { $errors[] = 'Your cover letter should be at least 50 characters.'; }
    if (empty($_POST['confirm']))                     { $errors[] = 'Please confirm that you can deliver this project.'; }
    if (!$errors && $db_project) {
        $err = tt_db_submit_proposal($id, $form['offer'], $form['days'], $form['letter']);
        if ($err) { $errors[] = $err; }
    }
    if (!$errors) {
        tt_flash('Your proposal was sent. You can track it in My Proposals.');
        header('Location: ' . $base_url . 'freelancer/my-proposals.php');
        exit;
    }
}

$page_title = "Submit Proposal";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="find-projects.php">Find Projects</a><span>/</span><span aria-current="page">Project Details</span>
</nav>

<?php if (!$project): ?>
  <div class="not-found"><div class="empty-art"><?= icon('alert', 40) ?></div><h1>Project not found</h1><p>This project is not available.</p><a href="find-projects.php" class="btn btn--dark">Browse Projects</a></div>
<?php else: ?>

<div class="head-row">
  <div>
    <div style="display:flex; align-items:center; gap:0.6rem; flex-wrap:wrap;">
      <h1><?= e($project['title']) ?></h1>
    </div>
    <div class="head-meta" style="margin-top:0.5rem;">
      <span class="status status--open">Open</span>
      <span class="pill pill--blue"><?= $project['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span>
      <span class="match-chip"><?= icon('zap', 11) ?> <?= (int) $match ?>% match</span>
    </div>
  </div>
  <div class="head-actions">
    <a href="#" class="btn btn--row-outline"><?= icon('bookmark', 13) ?> Save Project</a>
    <a href="#" class="btn btn--row-outline"><?= icon('flag', 13) ?> Report Content</a>
  </div>
</div>

<?php if ($errors): ?>
  <div class="form-alert" role="alert" style="margin-top:1.25rem;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
<?php endif; ?>

<div class="two-col" style="margin-top:1.25rem;">
  <div class="stack">
    <section class="box" style="margin-top:0;">
      <div class="stat-line" style="flex-wrap:wrap; gap:1.2rem; font-size:0.74rem;">
        <div><span class="muted">Category</span><br><strong><?= e($project['category']) ?></strong></div>
        <div><span class="muted">Billing type</span><br><strong><?= $project['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></strong></div>
        <?php if ($project['type'] === 'hourly'): ?>
          <div><span class="muted">Hourly rate</span><br><strong>₱<?= number_format($project['amount']) ?>/hr</strong></div>
          <div><span class="muted">Maximum hours</span><br><strong><?= (int) $project['max_hours'] ?> h</strong></div>
        <?php else: ?>
          <div><span class="muted">Budget</span><br><strong>₱<?= number_format($project['amount']) ?></strong></div>
        <?php endif; ?>
        <div><span class="muted">Deadline</span><br><strong><?= e(date('M d, Y', strtotime($project['deadline']))) ?></strong></div>
        <div><span class="muted">Proposals</span><br><strong><?= (int) $project['proposals'] ?></strong></div>
      </div>
    </section>

    <section class="box">
      <h2>Description</h2>
      <p><?= e($full ? $full['intro'] : $project['desc']) ?></p>
    </section>

    <section class="box">
      <h2>Required Skills</h2>
      <div class="skill-chips" style="margin-top:0.5rem;">
        <?php foreach ($req as $s): $ok = in_array(strtolower($s), array_map('strtolower', $skills), true); ?>
          <span class="chip" style="<?= $ok ? '' : 'opacity:0.6;' ?>"><?= $ok ? icon('check', 11) : '' ?> <?= e($s) ?></span>
        <?php endforeach; ?>
      </div>
      <p class="hint"><?= icon('info', 13) ?> You have <?= (int) $have ?> of <?= count($req) ?> required skills.</p>
    </section>

    <section class="box">
      <h2>Submit a Proposal</h2>
      <?php if ($sent): ?>
        <div class="empty-state empty-state--design" style="margin:0;">
          <div class="empty-art"><?= icon('check-circle', 40) ?></div>
          <h3>You already sent a proposal</h3>
          <p>You can see its status in My Proposals.</p>
          <a href="my-proposals.php" class="btn btn--dark">View My Proposals</a>
        </div>
      <?php elseif ($deadline_passed): ?>
        <p class="muted">The deadline for this project has passed, so proposals are closed.</p>
      <?php else: ?>
        <form method="post" action="submit-proposal.php?id=<?= (int) $id ?>">
          <div class="field-row">
            <div class="field" style="margin-top:0;">
              <label for="offer"><?= $project['type'] === 'hourly' ? 'Offer (₱/hr)' : 'Offer (₱)' ?> <span class="req">*</span></label>
              <div class="input-prefix"><span>₱</span><input class="input" type="number" id="offer" name="offer" min="1" step="1" value="<?= e($form['offer']) ?>" required></div>
              <span class="hint"><?= $project['type'] === 'hourly' ? 'Hourly projects: your hourly rate.' : 'Fixed Price projects: your total price (₱).' ?></span>
            </div>
            <div class="field" style="margin-top:0;">
              <label for="days">Estimated completion time (days) <span class="req">*</span></label>
              <input class="input" type="number" id="days" name="days" min="1" step="1" value="<?= e($form['days']) ?>" required>
            </div>
          </div>
          <div class="field">
            <label for="letter">Cover letter <span class="req">*</span></label>
            <textarea id="letter" name="letter" class="input" rows="6" minlength="50" maxlength="2000" style="height:auto; padding:0.8rem; line-height:1.6; font-size:0.82rem;" placeholder="Tell the client why you are the right freelancer, how you will do the work and when you can start." required><?= e($form['letter']) ?></textarea>
            <span class="char-count"><?= mb_strlen($form['letter']) ?> / 2,000 characters</span>
          </div>
          <?php $est = (int) ($form['offer'] ?: ($project['amount'] ?: 0)); ?>
          <div class="note-box" style="margin-top:0;">
            <?= icon('dollar', 14) ?> At ₱<?= number_format($est ?: $project['amount']) ?><?= $project['type'] === 'hourly' ? '/hr' : '' ?> you receive ₱<?= number_format(round(($est ?: $project['amount']) * 0.9)) ?><?= $project['type'] === 'hourly' ? '/hr' : '' ?> after the 10% platform service fee.
          </div>
          <label class="check-label" style="margin-top:0.9rem;"><input type="checkbox" name="confirm" value="1" required> I confirm that I can deliver this project within the time I offered.</label>
          <div class="form-actions" style="justify-content:space-between;">
            <small>One proposal per project. Not allowed after the deadline.</small>
            <button type="submit" class="btn btn--primary"><?= icon('send', 14) ?> Submit Proposal</button>
          </div>
        </form>
      <?php endif; ?>
    </section>
  </div>

  <aside class="stack">
    <section class="box" style="margin-top:0;">
      <h2>Client Profile</h2>
      <div class="modal__who" style="margin-top:0.6rem;">
        <?= avatar('#CCFBF1', '#1E293B', 'glasses', 40) ?>
        <div><strong><?= e($project['client']) ?></strong><small>BrightPath Tutorial Center</small></div>
      </div>
      <div class="kv"><span>Projects posted</span><strong>7</strong></div>
      <div class="kv"><span>Location</span><strong>Mandaluyong City</strong></div>
      <p class="muted" style="margin-top:0.6rem; font-style:italic;">“Clear requirements and pays on time. Very approachable.” — Bea Lim</p>
      <a href="#" class="btn btn--row-outline" style="width:100%; margin-top:0.7rem;"><?= icon('flag', 13) ?> Report User</a>
    </section>
    <?php if ($project['type'] === 'hourly'): ?>
    <div class="info-callout">
      <?= icon('info', 15) ?>
      <span><strong>Hourly project.</strong> You log your hours in the Work Log. On the End Date, you are paid for approved hours × your rate, minus the platform service fee. Payments are simulated.</span>
    </div>
    <?php endif; ?>
  </aside>
</div>
<?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>