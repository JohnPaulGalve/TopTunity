<?php
/**
 * freelancer/my-proposals.php - Matches the My Proposals design.
 */
$user_role     = "freelancer";
$base_url      = "/Webdev/";
$active_client = "proposals";

require_once __DIR__ . '/../includes/data.php';

$all  = toptunity_freelancer_proposals();
$tabs = ['all' => 'All', 'pending' => 'Pending', 'selected' => 'Selected', 'not_selected' => 'Not Selected', 'withdrawn' => 'Withdrawn'];
$status = isset($_GET['status']) && isset($tabs[$_GET['status']]) ? $_GET['status'] : 'all';
$counts = ['all' => count($all)];
foreach ($all as $p) { $counts[$p['status']] = ($counts[$p['status']] ?? 0) + 1; }
$rows = array_values(array_filter($all, function ($p) use ($status) { return $status === 'all' || $p['status'] === $status; }));

$label = ['pending' => 'Pending', 'selected' => 'Selected', 'not_selected' => 'Not Selected', 'withdrawn' => 'Withdrawn'];
$cls   = ['pending' => 'pending', 'selected' => 'released', 'not_selected' => 'cancelled', 'withdrawn' => 'cancelled'];

$page_title = "My Proposals";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>My Proposals</h1>
    <p class="subtle">Track your applications.</p>
  </div>
</div>

<div class="filter-row" style="margin-top:1.25rem;">
  <p class="section-tag" style="margin:0;">Filter by status</p>
  <nav class="filter-tabs" aria-label="Filter by status">
    <?php foreach ($tabs as $key => $t): ?>
      <a href="my-proposals.php<?= $key === 'all' ? '' : '?status=' . e($key) ?>" class="filter-tab <?= $status === $key ? 'is-active' : '' ?>">
        <?= e($t) ?><?= $key === 'all' ? '' : ' · ' ?><?= $key === 'all' ? ' <small>' . (int) $counts['all'] . '</small>' : (isset($counts[$key]) ? (int) $counts[$key] : 0) ?>
      </a>
    <?php endforeach; ?>
  </nav>
</div>

<?php if (!$rows): ?>
  <div class="empty-state empty-state--design" style="margin-top:1.5rem;">
    <div class="empty-art"><?= icon('clipboard', 40) ?></div>
    <h3><?= $all ? 'No proposals in this group' : "You haven't sent any proposals yet" ?></h3>
    <p>Find a project that matches your skills and send your first proposal.</p>
    <a href="find-projects.php" class="btn btn--dark">Find Projects</a>
  </div>
<?php else: ?>
  <div class="project-list" style="margin-top:1.25rem;">
    <?php foreach ($rows as $p): $selected = $p['status'] === 'selected'; ?>
      <article class="project-row" style="grid-template-columns: 1fr auto; <?= $selected ? 'border-color:#99F6E4; background:#F4FBFA;' : '' ?>">
        <div>
          <div class="project-row__title">
            <h3><?= e($p['title']) ?></h3>
            <span class="status status--<?= e($cls[$p['status']]) ?>"><?= e($label[$p['status']]) ?></span>
            <span class="pill pill--blue"><?= $p['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span>
          </div>
          <div class="project-row__meta">
            <span>Client <strong><?= e($p['client']) ?></strong></span>
            <span>Offer <strong>₱<?= number_format($p['offer']) ?><?= $p['type'] === 'hourly' ? '/hr' : '' ?></strong></span>
            <span>Estimated <strong><?= (int) $p['days'] ?> days</strong></span>
            <span>Submitted <strong><?= e(date('M d, Y', strtotime($p['sent']))) ?></strong></span>
          </div>
        </div>
        <div class="project-row__actions">
          <?php if ($selected): ?>
            <a href="my-projects.php#offer" class="btn btn--primary"><?= icon('arrow-right', 13) ?> Go to Project Offer</a>
          <?php elseif ($p['status'] === 'pending'): ?>
            <a href="#" class="btn btn--row-outline"><?= icon('message', 13) ?> Message Client</a>
            <a href="#" class="btn btn--danger-outline">Withdraw Proposal</a>
          <?php endif; ?>
          <a href="<?= e($base_url) ?>pages/project-details.php?id=<?= (int) $p['project_id'] ?>" class="btn--row-dark">View Proposal</a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<div class="note-box" style="margin-top:1.25rem;">
  <?= icon('info', 14) ?> When a client selects another freelancer, your proposal is automatically marked as Not Selected. You can withdraw a proposal only before the client decides.
</div>

</main>

<?php include '../includes/footer.php'; ?>