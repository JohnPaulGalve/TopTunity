<?php
/**
 * client/find-freelancers.php - Search and filter freelancers as a client.
 * Same search, skill filter and sort as Browse Freelancers, with Save buttons.
 */
$user_role     = "client";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "freelancers";

require_once __DIR__ . '/../includes/data.php';
tt_handle_favourite();

$all   = toptunity_freelancers();
$saved = toptunity_saved_freelancer_ids();

$sort_options = ['top_rated' => 'Top Rated', 'rate_low' => 'Rate: low to high', 'rate_high' => 'Rate: high to low', 'projects' => 'Most projects'];

$q        = isset($_GET['q']) ? trim($_GET['q']) : '';
$skill    = isset($_GET['skill']) ? $_GET['skill'] : '';
$sort     = isset($_GET['sort']) && isset($sort_options[$_GET['sort']]) ? $_GET['sort'] : 'top_rated';
$page     = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$per_page = 5;

$skill_counts = [];
foreach ($all as $f) { foreach ($f['skills'] as $s) { $skill_counts[$s] = ($skill_counts[$s] ?? 0) + 1; } }
ksort($skill_counts);
if ($skill !== '' && !isset($skill_counts[$skill])) { $skill = ''; }

$results = array_values(array_filter($all, function ($f) use ($q, $skill) {
    if ($skill !== '' && !in_array($skill, $f['skills'], true)) { return false; }
    if ($q !== '') {
        $hay = $f['name'] . ' ' . $f['title'] . ' ' . $f['bio'] . ' ' . implode(' ', $f['skills']);
        if (stripos($hay, $q) === false) { return false; }
    }
    return true;
}));

usort($results, function ($a, $b) use ($sort) {
    switch ($sort) {
        case 'rate_low':  return $a['rate'] <=> $b['rate'];
        case 'rate_high': return $b['rate'] <=> $a['rate'];
        case 'projects':  return $b['completed'] <=> $a['completed'];
        default:          return $b['rating'] <=> $a['rating'];
    }
});

$total       = count($results);
$total_pages = max(1, (int) ceil($total / $per_page));
$page        = min($page, $total_pages);
$visible     = array_slice($results, ($page - 1) * $per_page, $per_page);
$from        = $total ? ($page - 1) * $per_page + 1 : 0;
$to          = ($page - 1) * $per_page + count($visible);

$state = ['q' => $q, 'skill' => $skill, 'sort' => $sort, 'page' => $page];
function ff_url($state, $override = [])
{
    $p = array_merge($state, $override);
    if ($p['q'] === '')            { unset($p['q']); }
    if ($p['skill'] === '')        { unset($p['skill']); }
    if ($p['sort'] === 'top_rated'){ unset($p['sort']); }
    if ((int) $p['page'] <= 1)     { unset($p['page']); }
    $qs = http_build_query($p);
    return 'find-freelancers.php' . ($qs ? '?' . $qs : '');
}

$page_title = "Find Freelancers";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Find Freelancers</h1>
    <p class="subtle">Search skilled freelancers and filter them by skill.</p>
  </div>
</div>

<form class="search-bar" method="get" action="find-freelancers.php" role="search" style="margin-top:1.25rem;">
  <div class="search-field">
    <?= icon('search', 16) ?>
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search freelancers by name, title or skill…" aria-label="Search freelancers">
  </div>
  <?php if ($skill !== ''): ?><input type="hidden" name="skill" value="<?= e($skill) ?>"><?php endif; ?>
  <button type="submit" class="btn btn--dark">Search</button>
</form>

<div class="browse-layout" style="margin-top:1.25rem;">
  <aside class="filter-card" aria-label="Filter by skill">
    <h2>Filter by Skill</h2>
    <nav class="filter-list">
      <a href="<?= e(ff_url($state, ['skill' => '', 'page' => 1])) ?>" class="filter-option <?= $skill === '' ? 'is-active' : '' ?>">
        <span class="check"><?= icon('check') ?></span> All Skills <span class="filter-option__count"><?= count($all) ?></span>
      </a>
      <?php foreach ($skill_counts as $name => $count): ?>
        <a href="<?= e(ff_url($state, ['skill' => $name, 'page' => 1])) ?>" class="filter-option <?= $skill === $name ? 'is-active' : '' ?>">
          <span class="check"><?= icon('check') ?></span> <?= e($name) ?> <span class="filter-option__count"><?= (int) $count ?></span>
        </a>
      <?php endforeach; ?>
    </nav>
    <a href="find-freelancers.php" class="btn btn--outline btn--sm btn--block">Clear Filter</a>
  </aside>

  <section>
    <div class="listing-meta">
      <p class="section-tag">Freelancer listing</p>
      <form class="listing-meta__right" method="get" action="find-freelancers.php">
        <?php if ($q !== ''): ?><input type="hidden" name="q" value="<?= e($q) ?>"><?php endif; ?>
        <?php if ($skill !== ''): ?><input type="hidden" name="skill" value="<?= e($skill) ?>"><?php endif; ?>
        <span>
          <?= $total ? "Showing {$from}–{$to} of {$total} freelancers" . ($skill ? " with " . e($skill) : '') : 'No freelancers found' ?> · Sort by
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
      <div class="empty-state empty-state--design">
        <div class="empty-art"><?= icon('users', 40) ?></div>
        <h3>No freelancers found</h3>
        <p>Try another keyword or skill.</p>
        <a href="find-freelancers.php" class="btn btn--dark">Clear Filter</a>
      </div>
    <?php else: ?>
      <div class="listing">
        <?php foreach ($visible as $f):
          $fid = array_search($f, $all, true);
          $is_saved = in_array($fid, $saved, true);
        ?>
          <article class="freelancer-row">
            <?= tt_freelancer_avatar_html($f, 60, $base_url) ?>
            <div>
              <h3>
                <a href="freelancer-profile.php?id=<?= (int) $fid ?>"><?= e($f['name']) ?></a>
                <span class="freelancer-row__title"><?= e($f['title']) ?></span>
              </h3>
              <p class="freelancer-row__loc"><?= icon('map-pin', 13) ?> <?= e($f['location']) ?> · <?= (int) $f['completed'] ?> projects completed</p>
              <p class="listing-card__desc"><?= e($f['bio']) ?></p>
              <div class="chips">
                <?php foreach ($f['skills'] as $s): ?><span class="chip"><?= e($s) ?></span><?php endforeach; ?>
              </div>
            </div>
            <div class="freelancer-row__side">
              <div class="freelancer-row__rating"><?= stars($f['rating']) ?> <strong><?= e($f['rating']) ?></strong> · <?= (int) $f['reviews'] ?> reviews</div>
              <div class="price">₱<?= number_format($f['rate']) ?><span class="price__unit">/hr</span></div>
              <div class="heart-row">
                <form method="post" action="find-freelancers.php" style="display:inline;">
                  <input type="hidden" name="favourite" value="freelancer"><input type="hidden" name="item" value="<?= (int) $fid ?>">
                  <button type="submit" class="heart-btn <?= $is_saved ? 'is-saved' : '' ?>" aria-label="<?= $is_saved ? 'Saved' : 'Save freelancer' ?>"><?= icon('heart', 15) ?></button>
                </form>
                <a href="freelancer-profile.php?id=<?= (int) $fid ?>" class="btn btn--teal-outline">View Profile</a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <?php if ($total_pages > 1): ?>
        <nav class="pagination" aria-label="Pagination">
          <a class="page-btn <?= $page <= 1 ? 'is-disabled' : '' ?>" href="<?= e(ff_url($state, ['page' => $page - 1])) ?>" aria-label="Previous page"><?= icon('chevron-left', 14) ?></a>
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a class="page-btn <?= $i === $page ? 'is-active' : '' ?>" href="<?= e(ff_url($state, ['page' => $i])) ?>" <?= $i === $page ? 'aria-current="page"' : '' ?>><?= $i ?></a>
          <?php endfor; ?>
          <a class="page-btn <?= $page >= $total_pages ? 'is-disabled' : '' ?>" href="<?= e(ff_url($state, ['page' => $page + 1])) ?>" aria-label="Next page"><?= icon('chevron-right', 14) ?></a>
        </nav>
      <?php endif; ?>
    <?php endif; ?>
  </section>
</div>

</main>

<?php include '../includes/footer.php'; ?>