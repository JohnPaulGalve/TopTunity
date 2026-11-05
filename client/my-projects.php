<?php
/**
 * client/my-projects.php - Every project the client has posted.
 * Filter with ?status=all|open|ongoing|overdue|past|completed|closed|cancelled, search with ?q=.
 * Shows 6 per page. Buttons depend on each project's status.
 */
$user_role     = "client";
$base_url      = "/TopTunity/";
$active_client = "projects";

require_once __DIR__ . '/../includes/data.php';
tt_refresh_project_statuses();   // keeps Overdue in step with the deadline

$projects = toptunity_client_projects();

$tabs = [
    'all'       => 'All',
    'open'      => 'Open',
    'past'      => 'Past Deadline',
    'ongoing'   => 'Ongoing',
    'overdue'   => 'Overdue',
    'completed' => 'Completed',
    'closed'    => 'Closed',
    'cancelled' => 'Cancelled', 'removed' => 'Removed',
];

$status = isset($_GET['status']) ? $_GET['status'] : 'all';
if (!isset($tabs[$status])) { $status = 'all'; }
$q        = isset($_GET['q']) ? trim($_GET['q']) : '';
$page     = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$per_page = 6;

// Count per tab
$counts = ['all' => count($projects), 'closed' => 0];
foreach ($projects as $p) {
    $counts[$p['status']] = ($counts[$p['status']] ?? 0) + 1;
    if ($p['status'] === 'closed') { $counts['closed']++; }
}

$rows = array_values(array_filter($projects, function ($p) use ($status, $q) {
    if ($status !== 'all' && $p['status'] !== $status) { return false; }
    if ($q !== '' && stripos($p['title'] . ' ' . $p['category'], $q) === false) { return false; }
    return true;
}));

$total       = count($rows);
$total_pages = max(1, (int) ceil($total / $per_page));
$page        = min($page, $total_pages);
$visible     = array_slice($rows, ($page - 1) * $per_page, $per_page);

$cat_icons = [
    'Web Development'        => ['code', 'teal'],
    'Digital Marketing'      => ['megaphone', 'orange'],
    'Graphic Design'         => ['pen-tool', 'slate'],
    'Video and Animation'    => ['video', 'blue'],
    'UI/UX Design'           => ['frame', 'teal'],
    'Mobile App Development' => ['smartphone', 'orange'],
];

function mp_url($status, $q, $page = 1)
{
    $params = [];
    if ($status !== 'all') { $params['status'] = $status; }
    if ($q !== '')         { $params['q'] = $q; }
    if ($page > 1)         { $params['page'] = $page; }
    $qs = http_build_query($params);
    return 'my-projects.php' . ($qs ? '?' . $qs : '');
}

$page_title = "My Projects";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>My Projects</h1>
    <p class="subtle">Manage all your posted projects.</p>
  </div>
  <a href="<?= e($base_url) ?>client/post-project.php" class="btn btn--primary btn--sm-block"><?= icon('plus', 16) ?> Post a Project</a>
</div>

<div class="filter-row">
  <div>
    <p class="section-tag" style="margin-bottom:0.5rem;">Filter by status</p>
    <nav class="filter-tabs" aria-label="Filter by status">
      <?php foreach ($tabs as $key => $label): ?>
        <a href="<?= e(mp_url($key, $q)) ?>" class="filter-tab <?= $status === $key ? 'is-active' : '' ?>">
          <?= e($label) ?> <small><?= (int) ($counts[$key] ?? 0) ?></small>
        </a>
      <?php endforeach; ?>
    </nav>
  </div>

  <form class="search-compact" method="get" action="my-projects.php" role="search">
    <?= icon('search', 15) ?>
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search my projects…" aria-label="Search my projects">
    <?php if ($status !== 'all'): ?><input type="hidden" name="status" value="<?= e($status) ?>"><?php endif; ?>
  </form>
</div>

<?php if (!$projects): ?>
  <div class="empty-state empty-state--design" style="margin-top:1.5rem;">
    <div class="empty-art"><?= icon('folder', 40) ?></div>
    <h3>You haven't posted a project yet</h3>
    <p>Post your first project and freelancers can start sending proposals.</p>
    <a href="post-project.php" class="btn btn--primary"><?= icon('plus', 14) ?> Post a Project</a>
  </div>
<?php elseif (!$visible): ?>
  <div class="empty-state empty-state--design" style="margin-top:1.5rem;">
    <div class="empty-art"><?= icon('folder', 40) ?></div>
    <h3>No projects found</h3>
    <p>Try another keyword or status.</p>
    <a href="my-projects.php" class="btn btn--dark">Clear Filter</a>
  </div>
<?php else: ?>
  <div class="project-list">
    <?php foreach ($visible as $p):
      $id   = array_search($p, $projects, true);
      $cat  = isset($cat_icons[$p['category']]) ? $cat_icons[$p['category']] : ['folder', 'slate'];
    ?>
      <article class="project-row">
        <span class="icon-box icon-box--<?= e($cat[1]) ?> project-row__icon"><?= icon($cat[0], 18) ?></span>

        <div>
          <div class="project-row__title">
            <h3><?= e($p['title']) ?></h3>
            <?php [$sl, $sc] = tt_project_status_view($p['status'], $p['contract_status'] ?? 'none', !empty($p['freelancer_id'])); ?><span class="status status--<?= e($sc) ?>"><?= e($sl) ?></span>
            <span class="pill pill--cat"><?= e($p['category']) ?></span>
          </div>
          <div class="project-row__meta">
            <?php if ($p['type'] === 'hourly'): ?>
              <span>Hourly <strong>₱<?= number_format($p['rate']) ?>/hr</strong></span>
            <?php else: ?>
              <span>Budget <strong>₱<?= number_format($p['budget']) ?></strong></span>
            <?php endif; ?>
            <span>Deadline <strong><?= e(date('M d, Y', strtotime($p['deadline']))) ?></strong></span>
            <span>Proposals <strong><?= (int) $p['proposals'] ?></strong></span>
            <?php if ($p['freelancer']): ?>
              <span>Freelancer <strong><?= e($p['freelancer']) ?></strong></span>
            <?php endif; ?>
            <?php if (!empty($p['note'])): ?>
              <span class="note"><?= e($p['note']) ?></span>
            <?php endif; ?>
          </div>
        </div>

        <div class="project-row__actions">
          <?php if (in_array($p['status'], ['open', 'past'], true)): ?>
            <a href="<?= e($base_url) ?>client/post-project.php?id=<?= (int) $id ?>" class="btn--row-outline"><?= icon('edit', 13) ?> Edit Project</a>
            <form method="post" action="<?= e($base_url) ?>client/project-tracking.php?id=<?= (int) $id ?>" style="display:inline;" data-confirm="Cancel this project? Any held deposit is refunded to you. This cannot be undone.">
              <input type="hidden" name="action" value="cancel_project">
              <button type="submit" class="btn btn--danger-outline"><?= icon('x-circle', 13) ?> Cancel Project</button>
            </form>
          <?php elseif ($p['status'] === 'completed' && !tt_review_done($id, tt_current_user()['id'])): ?>
            <a href="<?= e($base_url) ?>client/project-tracking.php?id=<?= (int) $id ?>#review" class="btn btn--review"><?= icon('star', 13) ?> Review Freelancer</a>
          <?php endif; ?>
          <a href="<?= e($base_url) ?>client/project-tracking.php?id=<?= (int) $id ?>" class="btn--row-dark">View Details</a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <?php if ($total_pages > 1): ?>
    <nav class="pagination pagination--tight" aria-label="Pagination">
      <a class="page-btn <?= $page <= 1 ? 'is-disabled' : '' ?>" href="<?= e(mp_url($status, $q, $page - 1)) ?>" aria-label="Previous page"><?= icon('chevron-left', 14) ?></a>
      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a class="page-btn <?= $i === $page ? 'is-active' : '' ?>" href="<?= e(mp_url($status, $q, $i)) ?>" <?= $i === $page ? 'aria-current="page"' : '' ?>><?= $i ?></a>
      <?php endfor; ?>
      <a class="page-btn <?= $page >= $total_pages ? 'is-disabled' : '' ?>" href="<?= e(mp_url($status, $q, $page + 1)) ?>" aria-label="Next page"><?= icon('chevron-right', 14) ?></a>
    </nav>
  <?php endif; ?>
<?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>