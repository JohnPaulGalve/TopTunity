<?php
/**
 * pages/browse-projects.php - Public project listing
 * Search + category filter + sort + pagination (all via GET parameters).
 * Sample data below stands in for a database query.
 */
$page_title = "Browse Projects";
$user_role  = "public";
$base_url   = "/TopTunity/";

include '../includes/header.php';
include '../includes/nav.php';

require_once __DIR__ . '/../includes/data.php';
$all_projects = toptunity_listing();

$categories = [
    'Web Development', 'Mobile App Development', 'Graphic Design', 'UI/UX Design',
    'Writing and Content', 'Digital Marketing', 'Video and Animation', 'Data Entry and Admin',
];

/* ---------- Read & validate query string ---------- */
$q        = isset($_GET['q']) ? trim($_GET['q']) : '';
$cat      = isset($_GET['category']) ? $_GET['category'] : '';
$sort     = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$page     = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$per_page = 5;

$sort_options = [
    'newest'      => 'Newest',
    'budget_high' => 'Highest budget',
    'deadline'    => 'Nearest deadline',
];
if (!in_array($cat, $categories, true))   { $cat = ''; }
if (!isset($sort_options[$sort]))         { $sort = 'newest'; }

/* ---------- Helpers local to this page ---------- */
function project_total($p)
{
    return $p['type'] === 'hourly' ? $p['amount'] * $p['max_hours'] : $p['amount'];
}

function posted_text($hours)
{
    if ($hours < 24)  { return 'Posted ' . max(1, $hours) . 'h ago'; }
    if ($hours < 48)  { return 'Posted yesterday'; }
    return 'Posted ' . floor($hours / 24) . ' days ago';
}

/** Build a link to this page, keeping the current search/filter/sort. */
function browse_url($state, $override = [])
{
    $params = array_merge($state, $override);
    if ($params['q'] === '')           { unset($params['q']); }
    if ($params['category'] === '')    { unset($params['category']); }
    if ($params['sort'] === 'newest')  { unset($params['sort']); }
    if ((int) $params['page'] <= 1)    { unset($params['page']); }
    $qs = http_build_query($params);
    return 'browse-projects.php' . ($qs ? '?' . $qs : '');
}

/* ---------- Category counts (always across all projects) ---------- */
$counts = array_fill_keys($categories, 0);
foreach ($all_projects as $p) {
    $counts[$p['category']]++;
}

/* ---------- Filter ---------- */
$results = array_values(array_filter($all_projects, function ($p) use ($q, $cat) {
    if ($cat !== '' && $p['category'] !== $cat) {
        return false;
    }
    if ($q !== '') {
        $haystack = $p['title'] . ' ' . $p['desc'] . ' ' . $p['category'] . ' ' . implode(' ', $p['skills']);
        if (stripos($haystack, $q) === false) {
            return false;
        }
    }
    return true;
}));

/* ---------- Sort ---------- */
usort($results, function ($a, $b) use ($sort) {
    if ($sort === 'budget_high') { return project_total($b) <=> project_total($a); }
    if ($sort === 'deadline')    { return strtotime($a['deadline']) <=> strtotime($b['deadline']); }
    return $a['age_h'] <=> $b['age_h']; // newest first
});

/* ---------- Paginate ---------- */
$total       = count($results);
$total_pages = max(1, (int) ceil($total / $per_page));
$page        = min($page, $total_pages);
$offset      = ($page - 1) * $per_page;
$visible     = array_slice($results, $offset, $per_page);
$from        = $total ? $offset + 1 : 0;
$to          = $offset + count($visible);

$state = ['q' => $q, 'category' => $cat, 'sort' => $sort, 'page' => $page];
?>

<main class="page-browse">
  <div class="container">

    <header class="page-head">
      <h1>Browse Projects</h1>
      <p>Find open projects from clients across the Philippines.</p>
    </header>

    <!-- Search -->
    <form class="search-bar" method="get" action="browse-projects.php" role="search">
      <div class="search-field">
        <?= icon('search', 16) ?>
        <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search projects by title or skill…" aria-label="Search projects">
      </div>
      <?php if ($cat !== ''): ?><input type="hidden" name="category" value="<?= e($cat) ?>"><?php endif; ?>
      <?php if ($sort !== 'newest'): ?><input type="hidden" name="sort" value="<?= e($sort) ?>"><?php endif; ?>
      <button type="submit" class="btn btn--dark">Search</button>
    </form>

    <div class="browse-layout">

      <!-- Filter sidebar -->
      <aside class="filter-card" aria-label="Filter projects">
        <h2>Filter by Category</h2>
        <nav class="filter-list">
          <a href="<?= e(browse_url($state, ['category' => '', 'page' => 1])) ?>"
             class="filter-option <?= $cat === '' ? 'is-active' : '' ?>"
             <?= $cat === '' ? 'aria-current="true"' : '' ?>>
            <span class="check"><?= icon('check') ?></span>
            All Categories
            <span class="filter-option__count"><?= count($all_projects) ?></span>
          </a>
          <?php foreach ($categories as $name): ?>
            <a href="<?= e(browse_url($state, ['category' => $name, 'page' => 1])) ?>"
               class="filter-option <?= $cat === $name ? 'is-active' : '' ?>"
               <?= $cat === $name ? 'aria-current="true"' : '' ?>>
              <span class="check"><?= icon('check') ?></span>
              <?= e($name) ?>
              <span class="filter-option__count"><?= (int) $counts[$name] ?></span>
            </a>
          <?php endforeach; ?>
        </nav>
        <a href="browse-projects.php" class="btn btn--outline btn--sm btn--block">Clear Filter</a>
      </aside>

      <!-- Project listing -->
      <section aria-label="Project listing">
        <div class="listing-meta">
          <p class="section-tag">Project listing</p>

          <form class="listing-meta__right" method="get" action="browse-projects.php">
            <?php if ($q !== ''): ?><input type="hidden" name="q" value="<?= e($q) ?>"><?php endif; ?>
            <?php if ($cat !== ''): ?><input type="hidden" name="category" value="<?= e($cat) ?>"><?php endif; ?>
            <span>
              <?php if ($total): ?>
                Showing <?= $from ?>–<?= $to ?> of <?= $total ?> open projects
              <?php else: ?>
                Showing 0–0 of 0 open projects
              <?php endif; ?>
              · Sort by
            </span>
            <label class="sort-select">
              <span class="sr-only" hidden>Sort projects</span>
              <select name="sort" data-autosubmit>
                <?php foreach ($sort_options as $value => $label): ?>
                  <option value="<?= e($value) ?>" <?= $sort === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
              </select>
              <?= icon('chevron-down', 13) ?>
            </label>
            <noscript><button type="submit" class="btn btn--outline btn--sm">Apply</button></noscript>
          </form>
        </div>

        <?php if (!$visible): ?>
          <div class="empty-state empty-state--design">
            <div class="empty-art"><?= icon('search', 40) ?></div>
            <h3>No projects found</h3>
            <p>Try another keyword or category.</p>
            <a href="browse-projects.php" class="btn btn--dark">Clear Filter</a>
          </div>
        <?php else: ?>
          <div class="listing">
            <?php foreach ($visible as $p): ?>
              <article class="listing-card">
                <div class="listing-card__main">
                  <h3><?= e($p['title']) ?></h3>
                  <div class="listing-card__meta">
                    <span class="pill pill--teal"><?= e($p['category']) ?></span>
                    <span class="chip chip--type"><?= $p['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span>
                    <span><?= e(posted_text($p['age_h'])) ?> · <?= e($p['client']) ?></span>
                  </div>
                  <p class="listing-card__desc"><?= e($p['desc']) ?></p>
                  <div class="chips">
                    <?php foreach ($p['skills'] as $skill): ?>
                      <span class="chip"><?= e($skill) ?></span>
                    <?php endforeach; ?>
                  </div>
                </div>

                <div class="listing-card__side">
                  <?php if ($p['type'] === 'hourly'): ?>
                    <div class="price">₱<?= number_format($p['amount']) ?><span class="price__unit">/hr</span></div>
                    <div class="price-note">Max <?= (int) $p['max_hours'] ?> hrs · up to ₱<?= number_format(project_total($p)) ?></div>
                  <?php else: ?>
                    <div class="price">₱<?= number_format($p['amount']) ?></div>
                    <div class="price-note">Fixed Price budget</div>
                  <?php endif; ?>

                  <div class="deadline">
                    <?= icon('calendar', 14) ?> Deadline <strong><?= e(date('M d, Y', strtotime($p['deadline']))) ?></strong>
                  </div>
                  <div class="proposal-count"><?= (int) $p['proposals'] ?> proposals</div>

                  <a href="<?= e($base_url) ?>pages/project-details.php?id=<?= (int) $p['id'] ?>" class="btn btn--teal-outline">View Details</a>
                </div>
              </article>
            <?php endforeach; ?>
          </div>

          <?php if ($total_pages > 1): ?>
            <nav class="pagination" aria-label="Pagination">
              <a class="page-btn <?= $page <= 1 ? 'is-disabled' : '' ?>"
                 href="<?= e(browse_url($state, ['page' => $page - 1])) ?>" aria-label="Previous page"><?= icon('chevron-left', 14) ?></a>

              <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a class="page-btn <?= $i === $page ? 'is-active' : '' ?>"
                   href="<?= e(browse_url($state, ['page' => $i])) ?>"
                   <?= $i === $page ? 'aria-current="page"' : '' ?>><?= $i ?></a>
              <?php endfor; ?>

              <a class="page-btn <?= $page >= $total_pages ? 'is-disabled' : '' ?>"
                 href="<?= e(browse_url($state, ['page' => $page + 1])) ?>" aria-label="Next page"><?= icon('chevron-right', 14) ?></a>
            </nav>
          <?php endif; ?>
        <?php endif; ?>
      </section>

    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>