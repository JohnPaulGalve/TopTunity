<?php
/**
 * Direct hiring workflow: select an open project, review its contract, and send
 * the offer without entering the proposal-based project-tracking flow.
 */
$user_role     = "client";
$base_url      = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/';
$active_client = "freelancers";

require_once __DIR__ . '/../includes/data.php';

$fid = isset($_GET['freelancer']) ? (int) $_GET['freelancer'] : 1;
$f   = toptunity_freelancer($fid);
if (!$f) {
    $fid = 1;
    $f = toptunity_freelancer(1);
}
$f = array_merge(['name' => 'Freelancer', 'title' => '', 'rating' => '', 'skills' => [], 'languages' => ''], $f ?: []);

$projects = toptunity_client_projects();
foreach ($projects as $id => &$project_data) {
    if ((int) $id < 1000) {
        $sample_state = tt_sample_state((int) $id);
        $project_data['freelancer_id'] = $sample_state['freelancer_id'];
        $project_data['contract_status'] = $sample_state['contract_status'];
        $project_data['agreed_amount'] = $sample_state['agreed'];
    }
}
unset($project_data);
$open = array_filter($projects, function ($p) {
    return $p['status'] === 'open'
        && empty($p['freelancer_id'])
        && ($p['contract_status'] ?? 'none') === 'none';
});
$project_id = (int) ($_GET['project'] ?? $_POST['project'] ?? 0);
$project = $project_id && isset($projects[$project_id]) ? $projects[$project_id] : null;
$step = $_GET['step'] ?? 'select';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'continue') {
        if (!isset($open[$project_id])) {
            tt_flash('Choose one of your open projects that has no selected freelancer.');
            header('Location: ' . $base_url . 'client/hire-freelancer.php?freelancer=' . $fid);
            exit;
        }
        header('Location: ' . $base_url . 'client/hire-freelancer.php?freelancer=' . $fid . '&project=' . $project_id . '&step=contract');
        exit;
    }

    if ($action === 'send') {
        if (empty($_POST['agree'])) {
            header('Location: ' . $base_url . 'client/hire-freelancer.php?freelancer=' . $fid . '&project=' . $project_id . '&step=contract');
            exit;
        }
        if (!$project || $step !== 'contract') {
            tt_flash('Choose a project before sending a contract.');
        } else {
            $amount = filter_var($_POST['agreed'] ?? null, FILTER_VALIDATE_INT);
            if ($amount === false || $amount < 1) {
                tt_flash('Enter a valid agreed amount.');
            } elseif (($project['type'] ?? '') === 'hourly'
                && $amount !== (int) ($project['rate'] ?? 0) * (int) ($project['max_hours'] ?? 0)) {
                tt_flash('For hourly projects, the agreed amount must match the hourly rate multiplied by maximum hours.');
            } elseif ($project_id < 1000) {
                if (empty($f['real'])) {
                    $state = tt_sample_state($project_id);
                    if ($state['contract_status'] !== 'none' || $state['freelancer_id']) {
                        tt_flash('This project is no longer available for direct hiring.');
                    } else {
                        tt_save_sample_state($project_id, [
                            'freelancer_id' => $fid,
                            'contract_status' => 'pending',
                            'agreed' => $amount,
                            'sent_at' => date('Y-m-d'),
                        ]);
                        tt_flash('Contract sent. The freelancer must accept it before the project starts.');
                    }
                } else {
                    tt_flash('Choose one of your posted projects to hire this freelancer.');
                }
            } else {
                $error = tt_db_hire_freelancer($project_id, $fid, $amount);
                if ($error) {
                    tt_flash($error);
                } else {
                    tt_flash('Contract sent. The freelancer must accept it before the project starts.');
                    header('Location: ' . $base_url . 'client/project-tracking.php?id=' . $project_id . '&tab=contract');
                    exit;
                }
            }
        }

        header('Location: ' . $base_url . 'client/hire-freelancer.php?freelancer=' . $fid . '&project=' . $project_id . '&step=contract');
        exit;
    }
}

$is_sent = $project
    && (int) ($project['freelancer_id'] ?? 0) > 0
    && (int) ($project['freelancer_id'] ?? 0) === (int) ($f['user_id'] ?? $fid)
    && ($project['contract_status'] ?? 'none') !== 'none';
$can_contract = $project
    && $project['status'] === 'open'
    && empty($project['freelancer_id'])
    && ($project['contract_status'] ?? 'none') === 'none';
if ($step === 'contract' && !$can_contract && !$is_sent) {
    $project = null;
    $step = 'select';
    tt_flash('That project is no longer available for direct hiring.');
}

$default_amount = $project
    ? ($project['type'] === 'hourly'
        ? (int) ($project['rate'] ?? 0) * (int) ($project['max_hours'] ?? 0)
        : (int) ($project['budget'] ?? 0))
    : 0;
$page_title = "Hire Freelancer";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="find-freelancers.php">Find Freelancers</a><span>/</span>
  <a href="freelancer-profile.php?id=<?= (int) $fid ?>"><?= e($f['name']) ?></a><span>/</span>
  <span aria-current="page">Hire Freelancer</span>
</nav>

<div class="welcome-row">
  <div>
    <h1>Hire Freelancer</h1>
    <p class="subtle">Send a direct offer without using the project proposal-selection process.</p>
  </div>
</div>

<ol class="hire-steps" aria-label="Progress">
  <li class="<?= $step === 'select' ? 'is-current' : 'is-done' ?>"><span class="dot"><?= $step === 'select' ? '1' : icon('check', 12) ?></span> Select Project</li>
  <li class="bar" aria-hidden="true"></li>
  <li class="<?= $step === 'contract' && !$is_sent ? 'is-current' : ($is_sent ? 'is-done' : '') ?>"><span class="dot">2</span> Contract</li>
  <li class="bar" aria-hidden="true"></li>
  <li class="<?= $is_sent ? 'is-current' : '' ?>"><span class="dot">3</span> Freelancer accepts</li>
</ol>

<div class="two-col" style="margin-top:1.25rem;">
  <section class="box" style="margin-top:0;">
    <?php if ($step === 'contract' && $project): ?>
      <?php if ($is_sent): ?>
        <h2><?= $project['contract_status'] === 'active' ? 'Direct Contract Accepted' : ($project['contract_status'] === 'completed' ? 'Direct Contract Completed' : 'Direct Contract Sent') ?></h2>
        <p class="muted">
          <?php if ($project['contract_status'] === 'active'): ?>
            <?= e($f['name']) ?> accepted the offer. The project is now in progress.
          <?php elseif ($project['contract_status'] === 'completed'): ?>
            This direct-hire project is complete.
          <?php else: ?>
            The offer is waiting for <?= e($f['name']) ?> to accept it.
          <?php endif; ?>
        </p>
        <div class="kv" style="margin-top:1rem;"><span>Project</span><strong><?= e($project['title']) ?></strong></div>
        <div class="kv"><span>Agreed amount</span><strong>₱<?= number_format((int) ($project['agreed_amount'] ?? 0)) ?></strong></div>
        <div class="kv"><span>End date</span><strong><?= e(date('M d, Y', strtotime($project['deadline']))) ?></strong></div>
        <div class="kv"><span>Status</span><span class="status status--pending"><?= e(ucfirst($project['contract_status'])) ?></span></div>
        <a href="hire-freelancer.php?freelancer=<?= (int) $fid ?>" class="btn btn--outline" style="margin-top:1rem;">Back to project selection</a>
      <?php else: ?>
        <div class="box-head"><h2>Review Direct Contract</h2><span class="muted">This offer is separate from project proposals</span></div>
        <div class="kv"><span>Project</span><strong><?= e($project['title']) ?></strong></div>
        <div class="kv"><span>Billing type</span><strong><?= $project['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></strong></div>
        <div class="kv"><span>End date</span><strong><?= e(date('M d, Y', strtotime($project['deadline']))) ?></strong></div>
        <div class="kv"><span>Freelancer</span><strong><?= e($f['name']) ?></strong></div>

        <form method="post" action="hire-freelancer.php?freelancer=<?= (int) $fid ?>&amp;project=<?= (int) $project_id ?>&amp;step=contract" data-requires-checkbox="agree" style="margin-top:1rem;">
          <input type="hidden" name="action" value="send">
          <input type="hidden" name="project" value="<?= (int) $project_id ?>">
          <div class="field" style="margin-top:0;">
            <label for="agreed">Agreed amount (₱)</label>
            <div class="input-prefix"><span>₱</span><input class="input" id="agreed" name="agreed" type="number" min="1" step="1" value="<?= $default_amount ?>" required></div>
          </div>
          <div class="terms-box">
            <h3>Payment, revision and dispute rules</h3>
            <ul>
              <li>Fixed Price: the agreed amount is held after you deposit it and released when you approve the work.</li>
              <li>A 10% platform service fee is deducted from the freelancer's payment.</li>
              <li>Either side can file a dispute while the project is ongoing.</li>
              <li>All payments are simulated (no real money is used).</li>
            </ul>
          </div>
          <label class="agree"><input type="checkbox" name="agree" value="1"> I agree to the terms of this contract.</label>
          <div class="form-actions--plain" style="margin-top:1rem;">
            <button type="submit" class="btn btn--primary" disabled><?= icon('send', 14) ?> Send Direct Contract</button>
            <a href="hire-freelancer.php?freelancer=<?= (int) $fid ?>" class="btn btn--outline">Back</a>
          </div>
        </form>
      <?php endif; ?>
    <?php else: ?>
      <h2>Select Project</h2>
      <p class="muted" style="margin-bottom:0.9rem;">Only your open projects that have no selected freelancer are listed.</p>

      <?php if (!$open): ?>
        <div class="empty-state empty-state--design">
          <div class="empty-art"><?= icon('folder', 40) ?></div>
          <h3>No open projects</h3>
          <p>Post a project first. Hiring needs an open project to attach the contract to.</p>
          <a href="post-project.php" class="btn btn--primary"><?= icon('plus', 14) ?> Post a Project</a>
        </div>
      <?php else: ?>
        <form method="post" action="hire-freelancer.php?freelancer=<?= (int) $fid ?>">
          <input type="hidden" name="action" value="continue">
          <?php foreach ($open as $id => $p): ?>
            <label class="radio-card">
              <input type="radio" name="project" value="<?= (int) $id ?>" <?= $id === (int) ($project_id ?: array_key_first($open)) ? 'checked' : '' ?> required>
              <span>
                <strong><?= e($p['title']) ?>
                  <span class="status status--open"><?= $p['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span>
                </strong>
                <small>
                  <?= $p['type'] === 'hourly' ? 'Hourly rate ₱' . number_format($p['rate']) . '/hr · Max ' . (int) $p['max_hours'] . ' hrs' : 'Budget ₱' . number_format($p['budget']) ?>
                  · Deadline <?= e(date('M d, Y', strtotime($p['deadline']))) ?> · Proposals <?= (int) $p['proposals'] ?>
                </small>
              </span>
            </label>
          <?php endforeach; ?>

          <div class="form-actions--plain" style="align-items:center; flex-wrap:wrap;">
            <button type="submit" class="btn btn--primary">Continue to Contract <?= icon('arrow-right', 14) ?></button>
            <a href="freelancer-profile.php?id=<?= (int) $fid ?>" class="btn btn--outline">Cancel</a>
            <a href="post-project.php" class="btn-link-teal" style="margin-left:auto;"><?= icon('plus', 13) ?> Post a Project</a>
          </div>
          <p class="hint" style="margin-top:0.9rem;"><?= icon('info', 13) ?> The freelancer does not need to have submitted a proposal.</p>
        </form>
      <?php endif; ?>
    <?php endif; ?>
  </section>

  <aside class="stack">
    <section class="box">
      <h2>Hiring</h2>
      <div class="modal__who" style="margin-bottom:0.8rem;">
        <?= tt_freelancer_avatar_html($f, 40, $base_url) ?>
        <div><strong><?= e($f['name']) ?></strong><small><?= e($f['title']) ?> · <?= $f['rating'] ?></small></div>
      </div>
      <div class="skill-chips">
        <?php foreach (array_slice($f['skills'] ?? [], 0, 3) as $s): ?><span class="chip"><?= e($s) ?></span><?php endforeach; ?>
      </div>
    </section>

    <section class="box" style="background:var(--color-warning-bg); border-color:#FDE68A;">
      <h2 style="color:var(--color-warning-text);">Direct-hire rules</h2>
      <ul class="dots" style="margin:0.4rem 0 0;">
        <li style="color:var(--color-warning-text);">Only one freelancer can be hired per project.</li>
        <li style="color:var(--color-warning-text);">Pending proposals are closed when a direct contract is sent.</li>
        <li style="color:var(--color-warning-text);">The project starts only after the freelancer accepts.</li>
        <li style="color:var(--color-warning-text);">If the freelancer declines, the project reopens.</li>
      </ul>
    </section>

    <section class="box">
      <h2>Not sure yet?</h2>
      <p class="muted">Ask the freelancer first.</p>
      <a href="messages.php" class="btn btn--row-outline" style="margin-top:0.7rem; width:100%;"><?= icon('message', 13) ?> Message Freelancer</a>
    </section>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>