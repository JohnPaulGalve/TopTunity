<?php
/**
 * client/hire-freelancer.php - Hire a freelancer directly, in three steps.
 * Step 1 picks one of your open projects. Continue opens the contract on project-tracking.
 */
$user_role     = "client";
$base_url      = "/TopTunity/";
$active_client = "freelancers";

require_once __DIR__ . '/../includes/data.php';

$fid = isset($_GET['freelancer']) ? (int) $_GET['freelancer'] : 1;
$f   = toptunity_freelancer($fid);
if (!$f) { $fid = 1; $f = toptunity_freelancer(1); }

$open = array_filter(toptunity_client_projects(), function ($p) { return $p['status'] === 'open'; });
$pick = isset($_GET['project']) && isset($open[(int) $_GET['project']]) ? (int) $_GET['project'] : array_key_first($open);

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
    <p class="subtle">Choose one of your open projects, then send the contract.</p>
  </div>
</div>

<ol class="hire-steps" aria-label="Progress">
  <li class="is-current"><span class="dot">1</span> Select Project</li>
  <li class="bar" aria-hidden="true"></li>
  <li><span class="dot">2</span> Contract</li>
  <li class="bar" aria-hidden="true"></li>
  <li><span class="dot">3</span> Freelancer accepts</li>
</ol>

<div class="two-col" style="margin-top:1.25rem;">
  <section class="box" style="margin-top:0;">
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
      <form method="get" action="project-tracking.php">
        <input type="hidden" name="tab" value="contract">
        <input type="hidden" name="freelancer" value="<?= (int) $fid ?>">
        <?php foreach ($open as $id => $p): ?>
          <label class="radio-card">
            <input type="radio" name="id" value="<?= (int) $id ?>" <?= $id === $pick ? 'checked' : '' ?>>
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
          <button type="submit" class="btn btn--primary"><?= icon('arrow-right', 14) ?> Continue to Contract</button>
          <a href="freelancer-profile.php?id=<?= (int) $fid ?>" class="btn btn--outline">Cancel</a>
          <a href="post-project.php" class="btn-link-teal" style="margin-left:auto;"><?= icon('plus', 13) ?> Post a Project</a>
        </div>
        <p class="hint" style="margin-top:0.9rem;"><?= icon('info', 13) ?> No open project yet? Post a project first. The freelancer does not need to have submitted a proposal.</p>
      </form>
    <?php endif; ?>
  </section>

  <aside class="stack">
    <section class="box">
      <h2>Hiring</h2>
      <div class="modal__who" style="margin-bottom:0.8rem;">
        <?= avatar($f['bg'], $f['hair'], $f['style'], 40) ?>
        <div><strong><?= e($f['name']) ?></strong><small><?= e($f['title']) ?> · <?= $f['rating'] ?></small></div>
      </div>
      <div class="skill-chips">
        <?php foreach (array_slice($f['skills'], 0, 3) as $s): ?><span class="chip"><?= e($s) ?></span><?php endforeach; ?>
      </div>
    </section>

    <section class="box" style="background:var(--color-warning-bg); border-color:#FDE68A;">
      <h2 style="color:var(--color-warning-text);">Same rules as Freelancer Selection</h2>
      <ul class="dots" style="margin:0.4rem 0 0;">
        <li style="color:var(--color-warning-text);">Only one freelancer per project.</li>
        <li style="color:var(--color-warning-text);">The project stops accepting proposals.</li>
        <li style="color:var(--color-warning-text);">Other proposals are marked as Not Selected.</li>
        <li style="color:var(--color-warning-text);">If the freelancer declines the contract, the project reopens.</li>
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