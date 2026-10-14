<?php
/**
 * freelancer/find-projects.php - Matches the Find Projects design: recommended projects, filters, listing.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "find";

require_once __DIR__ . '/../includes/data.php';
tt_handle_favourite();

$categories = ['Web Development', 'Mobile App Development', 'Graphic Design', 'UI/UX Design',
               'Writing and Content', 'Digital Marketing', 'Video and Animation', 'Data Entry and Admin'];
$skills     = tt_is_demo_freelancer() ? toptunity_freelancer(1)['skills'] : [];

$q    = isset($_GET['q']) ? trim($_GET['q']) : '';
$cat  = isset($_GET['category']) && in_array($_GET['category'], $categories, true) ? $_GET['category'] : '';
$type = isset($_GET['type']) && in_array($_GET['type'], ['fixed', 'hourly'], true) ? $_GET['type'] : '';
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$per_page = 5;

$rows = [];
foreach (toptunity_listing() as $row) {
    $full = toptunity_project($row['id']);
    $req  = $full ? $full['skills'] : [];
    $rows[] = $row + ['match' => tt_skill_match($req, $skills), 'skills' => $req ?: $row['skills'],
                      'desc' => $full ? $full['desc'] : $row['desc']];
}

foreach (tt_load_saved_projects() as $sp) {
    if ($sp['status'] !== 'open') { continue; }
    $rows[] = ['id' => $sp['id'], 'title' => $sp['title'], 'category' => $sp['category'], 'client' => 'Client',
               'type' => $sp['type'], 'amount' => $sp['type'] === 'hourly' ? $sp['rate'] : $sp['budget'],
               'deadline' => $sp['deadline'], 'proposals' => $sp['proposals'], 'status' => 'open', 'age_h' => 0,
               'match' => tt_skill_match($sp['skills'], $skills), 'skills' => $sp['skills'], 'desc' => $sp['intro']];
}

$counts = array_fill_keys($categories, 0);
foreach ($rows as $r) { $counts[$r['category']] = ($counts[$r['category']] ?? 0) + 1; }

$results = array_values(array_filter($rows, function ($r) use ($q, $cat, $type) {
    if ($cat !== '' && $r['category'] !== $cat) { return false; }
    if ($type !== '' && $r['type'] !== $type) { return false; }
    if ($q !== '' && stripos($r['title'] . ' ' . $r['desc'] . ' ' . implode(' ', $r['skills']), $q) === false) { return false; }
    return true;
}));
usort($results, function ($a, $b) { return $b['match'] <=> $a['match']; });

$recommended = array_slice($rows, 0, 0);
$sorted = $rows; usort($sorted, function ($a, $b) { return $b['match'] <=> $a['match']; });
$recommended = array_slice($sorted, 0, 2);

$total       = count($results);
$total_pages = max(1, (int) ceil($total / $per_page));
$page        = min($page, $total_pages);
$visible     = array_slice($results, ($page - 1) * $per_page, $per_page);

function fp_url($q, $cat, $type, $page = 1)
{
    $p = [];
    if ($q !== '')    { $p['q'] = $q; }
    if ($cat !== '')  { $p['category'] = $cat; }
    if ($type !== '') { $p['type'] = $type; }
    if ($page > 1)    { $p['page'] = $page; }
    $qs = http_build_query($p);
    return 'find-projects.php' . ($qs ? '?' . $qs : '');
}

$page_title = "Find Projects";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Find Projects</h1>
    <p class="subtle">Open projects that have not passed their deadline.</p>
  </div>
</div>

<form class="search-bar" method="get" action="find-projects.php" role="search" style="margin-top:1.25rem;">
  <div class="search-field">
    <?= icon('search', 16) ?>
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search projects by title or skill…" aria-label="Search projects">
  </div>
  <button type="submit" class="btn btn--dark">Search</button>
</form>

<div class="browse-layout" style="margin-top:1.25rem;">
  <aside class="filter-card">
    <h2>Filter Projects</h2>
    <p class="section-tag" style="margin:0.4rem 0 0.3rem;">Category</p>
    <nav class="filter-list">
      <a href="<?= e(fp_url($q, '', $type)) ?>" class="filter-option <?= $cat === '' ? 'is-active' : '' ?>"><span class="check"><?= icon('check') ?></span> All Categories</a>
      <?php foreach ($categories as $c): if (!$counts[$c]) { continue; } ?>
        <a href="<?= e(fp_url($q, $c, $type)) ?>" class="filter-option <?= $cat === $c ? 'is-active' : '' ?>"><span class="check"><?= icon('check') ?></span> <?= e($c) ?> <span class="filter-option__count"><?= (int) $counts[$c] ?></span></a>
      <?php endforeach; ?>
    </nav>
    <p class="section-tag" style="margin:0.9rem 0 0.3rem;">Billing type</p>
    <nav class="filter-list">
      <a href="<?= e(fp_url($q, $cat, '')) ?>" class="filter-option <?= $type === '' ? 'is-active' : '' ?>"><span class="check"><?= icon('check') ?></span> Any</a>
      <a href="<?= e(fp_url($q, $cat, 'fixed')) ?>" class="filter-option <?= $type === 'fixed' ? 'is-active' : '' ?>"><span class="check"><?= icon('check') ?></span> Fixed Price</a>
      <a href="<?= e(fp_url($q, $cat, 'hourly')) ?>" class="filter-option <?= $type === 'hourly' ? 'is-active' : '' ?>"><span class="check"><?= icon('check') ?></span> Hourly</a>
    </nav>
    <a href="find-projects.php" class="btn btn--outline btn--sm btn--block" style="margin-top:0.6rem;">Clear Filter</a>
  </aside>

  <section>
    <?php if ($recommended && $q === '' && $cat === '' && $type === ''): ?>
      <div class="recommend-band">
        <div class="recommend-band__head">
          <h2><?= icon('zap', 16) ?> Recommended Projects</h2>
          <small>Based on your skills: <?= e(implode(' · ', array_slice($skills, 0, 4))) ?></small>
        </div>
        <div class="rec-grid">
          <?php foreach ($recommended as $r): ?>
            <div class="rec-card">
              <div style="display:flex; justify-content:space-between; gap:0.6rem; align-items:flex-start;">
                <h3><?= e($r['title']) ?></h3>
                <span class="rec-card__price"><?= $r['type'] === 'hourly' ? '₱' . number_format($r['amount']) . '/hr' : '₱' . number_format($r['amount']) ?></span>
              </div>
              <div style="margin:0.5rem 0;"><span class="match-chip"><?= icon('zap', 11) ?> <?= (int) $r['match'] ?>% match</span></div>
              <p class="muted"><?= e($r['client']) ?> · <?= e($r['category']) ?></p>
              <div class="chips" style="margin-top:0.5rem;"><?php foreach ($r['skills'] as $s): ?><span class="chip"><?= e($s) ?></span><?php endforeach; ?></div>
              <div class="rec-card__actions">
                <form method="post" action="find-projects.php" style="display:inline;">
                  <input type="hidden" name="favourite" value="project"><input type="hidden" name="item" value="<?= (int) $r['id'] ?>">
                  <button type="submit" class="btn btn--row-outline"><?= icon('bookmark', 13) ?> <?= in_array((int) $r['id'], toptunity_freelancer_saved_ids(), true) ? 'Saved' : 'Save Project' ?></button>
                </form>
                <a href="<?= e($base_url) ?>pages/project-details.php?id=<?= (int) $r['id'] ?>" class="btn--row-dark">View Details</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="listing-meta" style="margin-top:1.25rem;">
      <p class="section-tag">Project listing</p>
      <span class="muted"><?= $total ? 'Showing ' . (($page - 1) * $per_page + 1) . '–' . (($page - 1) * $per_page + count($visible)) . ' of ' . $total . ' open projects' : 'No open projects found' ?></span>
    </div>

    <?php if (!$visible): ?>
      <div class="empty-state empty-state--design">
        <div class="empty-art"><?= icon('search', 40) ?></div>
        <h3>No projects found</h3>
        <p>Try another keyword or category.</p>
        <a href="find-projects.php" class="btn btn--dark">Clear Filter</a>
      </div>
    <?php else: ?>
      <div class="project-list" style="margin-top:0;">
        <?php foreach ($visible as $r): ?>
          <article class="project-row" style="grid-template-columns: 1fr auto;">
            <div>
              <div class="project-row__title">
                <h3><?= e($r['title']) ?></h3>
                <span class="pill pill--cat"><?= e($r['category']) ?></span>
                <span class="pill pill--blue"><?= $r['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span>
              </div>
              <div class="project-row__meta">
                <span>Client <strong><?= e($r['client']) ?></strong></span>
                <span>Deadline <strong><?= e(date('M d, Y', strtotime($r['deadline']))) ?></strong></span>
                <span>Proposals <strong><?= (int) $r['proposals'] ?></strong></span>
                <span>Match <strong><?= (int) $r['match'] ?>%</strong></span>
              </div>
              <p class="listing-card__desc" style="margin:0.5rem 0;"><?= e($r['desc']) ?></p>
              <div class="chips"><?php foreach ($r['skills'] as $s): ?><span class="chip"><?= e($s) ?></span><?php endforeach; ?></div>
            </div>
            <div class="project-row__actions" style="flex-direction:column; align-items:flex-end;">
              <div style="font-family:var(--font-heading); font-weight:700; font-size:1.05rem;"><?= $r['type'] === 'hourly' ? '₱' . number_format($r['amount']) . '/hr' : '₱' . number_format($r['amount']) ?></div>
              <div style="display:flex; gap:0.45rem;">
                <form method="post" action="find-projects.php" style="display:inline;">
                  <input type="hidden" name="favourite" value="project"><input type="hidden" name="item" value="<?= (int) $r['id'] ?>">
                  <button type="submit" class="btn btn--row-outline" aria-label="Save"><?= icon('bookmark', 13) ?></button>
                </form>
                <a href="<?= e($base_url) ?>pages/project-details.php?id=<?= (int) $r['id'] ?>" class="btn--row-dark">View Details</a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <?php if ($total_pages > 1): ?>
        <nav class="pagination" aria-label="Pagination">
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a class="page-btn <?= $i === $page ? 'is-active' : '' ?>" href="<?= e(fp_url($q, $cat, $type, $i)) ?>"><?= $i ?></a>
          <?php endfor; ?>
        </nav>
      <?php endif; ?>
    <?php endif; ?>
  </section>
</div>

</main>

<?php include '../includes/footer.php'; ?>