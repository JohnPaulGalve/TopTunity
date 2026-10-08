<?php
/**
 * pages/browse-freelancers.php - Public freelancer directory
 * Search + skill filter + sort + pagination (GET parameters).
 */
$page_title = "Browse Freelancers";
$user_role  = "public";
$base_url   = "/Webdev/";

include '../includes/header.php';
include '../includes/nav.php';
require_once __DIR__ . '/../includes/data.php';

$all = toptunity_freelancers();

$sort_options = [
    'top_rated'  => 'Top Rated',
    'rate_low'   => 'Rate: low to high',
    'rate_high'  => 'Rate: high to low',
    'projects'   => 'Most projects',
];

$q        = isset($_GET['q']) ? trim($_GET['q']) : '';
$skill    = isset($_GET['skill']) ? $_GET['skill'] : '';
$sort     = isset($_GET['sort']) ? $_GET['sort'] : 'top_rated';
$page     = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$per_page = 5;

if (!isset($sort_options[$sort])) { $sort = 'top_rated'; }

/* Skill list and counts, derived from the data */
$skill_counts = [];
foreach ($all as $f) {
    foreach ($f['skills'] as $s) {
        $skill_counts[$s] = ($skill_counts[$s] ?? 0) + 1;
    }
}
ksort($skill_counts);
if ($skill !== '' && !isset($skill_counts[$skill])) { $skill = ''; }

/* Filter */
$results = array_values(array_filter($all, function ($f) use ($q, $skill) {
    if ($skill !== '' && !in_array($skill, $f['skills'], true)) {
        return false;
    }
    if ($q !== '') {
        $hay = $f['name'] . ' ' . $f['title'] . ' ' . $f['bio'] . ' ' . implode(' ', $f['skills']);
        if (stripos($hay, $q) === false) { return false; }
    }
    return true;
}));

/* Sort */
usort($results, function ($a, $b) use ($sort) {
    switch ($sort) {
        case 'rate_low':  return $a['rate'] <=> $b['rate'];
        case 'rate_high': return $b['rate'] <=> $a['rate'];
        case 'projects':  return $b['completed'] <=> $a['completed'];
        default:          return $b['rating'] <=> $a['rating'];
    }
});

/* Paginate */
$total       = count($results);
$total_pages = max(1, (int) ceil($total / $per_page));
$page        = min($page, $total_pages);
$offset      = ($page - 1) * $per_page;
$visible     = array_slice($results, $offset, $per_page);
$from        = $total ? $offset + 1 : 0;
$to          = $offset + count($visible);

$state = ['q' => $q, 'skill' => $skill, 'sort' => $sort, 'page' => $page];

function fr_url($state, $override = [])
{
    $params = array_merge($state, $override);
    if ($params['q'] === '')          { unset($params['q']); }
    if ($params['skill'] === '')      { unset($params['skill']); }
    if ($params['sort'] === 'top_rated') { unset($params['sort']); }
    if ((int) $params['page'] <= 1)   { unset($params['page']); }
    $qs = http_build_query($params);
    return 'browse-freelancers.php' . ($qs ? '?' . $qs : '');
}
?>

<main class="page-browse">
  <div class="container">

    <header class="page-head">
      <h1>Browse Freelancers</h1>
      <p>Discover skilled freelancers ready to work on your next project.</p>
    </header>

    <form class="search-bar" method="get" action="browse-freelancers.php" role="search">
      <div class="search-field">
        <?= icon('search', 16) ?>
        <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search freelancers by name, title or skill…" aria-label="Search freelancers">
      </div>
      <?php if ($skill !== ''): ?><input type="hidden" name="skill" value="<?= e($skill) ?>"><?php endif; ?>
      <?php if ($sort !== 'top_rated'): ?><input type="hidden" name="sort" value="<?= e($sort) ?>"><?php endif; ?>
      <button type="submit" class="btn btn--dark">Search</button>
    </form>

    <div class="browse-layout">

      <aside class="filter-card" aria-label="Filter freelancers">
        <h2>Filter by Skill</h2>
        <nav class="filter-list">
          <a href="<?= e(fr_url($state, ['skill' => '', 'page' => 1])) ?>"
             class="filter-option <?= $skill === '' ? 'is-active' : '' ?>"
             <?= $skill === '' ? 'aria-current="true"' : '' ?>>
            <span class="check"><?= icon('check') ?></span>
            All Skills
            <span class="filter-option__count"><?= count($all) ?></span>
          </a>
          <?php foreach ($skill_counts as $name => $count): ?>
            <a href="<?= e(fr_url($state, ['skill' => $name, 'page' => 1])) ?>"
               class="filter-option <?= $skill === $name ? 'is-active' : '' ?>"
               <?= $skill === $name ? 'aria-current="true"' : '' ?>>
              <span class="check"><?= icon('check') ?></span>
              <?= e($name) ?>
              <span class="filter-option__count"><?= (int) $count ?></span>
            </a>
          <?php endforeach; ?>
        </nav>
        <a href="browse-freelancers.php" class="btn btn--outline btn--sm btn--block">Clear Filter</a>
      </aside>

      <section aria-label="Freelancer listing">
        <div class="listing-meta">
          <p class="section-tag">Freelancer listing</p>
          <form class="listing-meta__right" method="get" action="browse-freelancers.php">
            <?php if ($q !== ''): ?><input type="hidden" name="q" value="<?= e($q) ?>"><?php endif; ?>
            <?php if ($skill !== ''): ?><input type="hidden" name="skill" value="<?= e($skill) ?>"><?php endif; ?>
            <span>
              <?php if ($total): ?>
                Showing <?= $from ?>–<?= $to ?> of <?= $total ?> active freelancers
              <?php else: ?>
                No freelancers found
              <?php endif; ?>
              · Sort by
            </span>
            <label class="sort-select">
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
          <div class="empty-state">
            <h3>No freelancers match your search</h3>
            <p>Try a different keyword or clear the skill filter.</p>
            <a href="browse-freelancers.php" class="btn btn--teal-outline">Clear search and filter</a>
          </div>
        <?php else: ?>
          <div class="listing">
            <?php foreach ($visible as $f): ?>
              <article class="freelancer-row">
                <?= avatar($f['bg'], $f['hair'], $f['style'], 60) ?>

                <div>
                  <h3>
                    <a href="<?= e($base_url) ?>pages/freelancer-profile.php?id=<?= (int) $f['id'] ?>"><?= e($f['name']) ?></a>
                    <span class="freelancer-row__title"><?= e($f['title']) ?></span>
                  </h3>
                  <p class="freelancer-row__loc"><?= icon('map-pin', 13) ?> <?= e($f['location']) ?> · <?= (int) $f['completed'] ?> projects completed</p>
                  <p class="listing-card__desc"><?= e($f['bio']) ?></p>
                  <div class="chips">
                    <?php foreach ($f['skills'] as $s): ?>
                      <span class="chip"><?= e($s) ?></span>
                    <?php endforeach; ?>
                  </div>
                </div>

                <div class="freelancer-row__side">
                  <div class="freelancer-row__rating">
                    <?= stars($f['rating']) ?> <strong><?= e($f['rating']) ?></strong> · <?= (int) $f['reviews'] ?> reviews
                  </div>
                  <div class="price">₱<?= number_format($f['rate']) ?><span class="price__unit">/hr</span></div>
                  <a href="<?= e($base_url) ?>pages/freelancer-profile.php?id=<?= (int) $f['id'] ?>" class="btn btn--teal-outline">View Profile</a>
                </div>
              </article>
            <?php endforeach; ?>
          </div>

          <?php if ($total_pages > 1): ?>
            <nav class="pagination" aria-label="Pagination">
              <a class="page-btn <?= $page <= 1 ? 'is-disabled' : '' ?>" href="<?= e(fr_url($state, ['page' => $page - 1])) ?>" aria-label="Previous page"><?= icon('chevron-left', 14) ?></a>
              <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a class="page-btn <?= $i === $page ? 'is-active' : '' ?>" href="<?= e(fr_url($state, ['page' => $i])) ?>" <?= $i === $page ? 'aria-current="page"' : '' ?>><?= $i ?></a>
              <?php endfor; ?>
              <a class="page-btn <?= $page >= $total_pages ? 'is-disabled' : '' ?>" href="<?= e(fr_url($state, ['page' => $page + 1])) ?>" aria-label="Next page"><?= icon('chevron-right', 14) ?></a>
            </nav>
          <?php endif; ?>
        <?php endif; ?>
      </section>

    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>