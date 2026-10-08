<?php
/**
 * pages/testimonials.php - Published user reviews
 * Filter with ?role=client|freelancer. Paginates 9 per page.
 */
$user_role = "public";
$base_url  = "/Webdev/";

require_once __DIR__ . '/../includes/data.php';

$page_title = "Testimonials";
include '../includes/header.php';
include '../includes/nav.php';

$all  = toptunity_testimonials();
$role = isset($_GET['role']) ? $_GET['role'] : 'all';
if (!in_array($role, ['all', 'client', 'freelancer'], true)) { $role = 'all'; }
$page     = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$per_page = 9;

$shown = array_values(array_filter($all, function ($t) use ($role) {
    return $role === 'all' || $t['role'] === $role;
}));

$total       = count($shown);
$total_pages = max(1, (int) ceil($total / $per_page));
$page        = min($page, $total_pages);
$visible     = array_slice($shown, ($page - 1) * $per_page, $per_page);

// Average across every review (not just the filtered view)
$avg = count($all) ? round(array_sum(array_column($all, 'stars')) / count($all), 1) : 0;

function tt_url($role, $page)
{
    $params = [];
    if ($role !== 'all') { $params['role'] = $role; }
    if ($page > 1)       { $params['page'] = $page; }
    $qs = http_build_query($params);
    return 'testimonials.php' . ($qs ? '?' . $qs : '');
}
?>

<main class="page-browse">
  <div class="container">

    <header class="center-block">
      <h1 class="section-title-xl" style="font-size:2rem; font-weight:700;">Testimonials</h1>
      <p style="margin-top:0.35rem; font-size:0.85rem; color:var(--color-muted-gray);">Reviews of TopTunity from our clients and freelancers.</p>

      <nav class="seg" aria-label="Filter testimonials">
        <a href="<?= e(tt_url('all', 1)) ?>"        class="<?= $role === 'all' ? 'is-active' : '' ?>">All</a>
        <a href="<?= e(tt_url('client', 1)) ?>"     class="<?= $role === 'client' ? 'is-active' : '' ?>">Clients</a>
        <a href="<?= e(tt_url('freelancer', 1)) ?>" class="<?= $role === 'freelancer' ? 'is-active' : '' ?>">Freelancers</a>
      </nav>

      <p class="reviews-total">
        <?= stars($avg) ?> <strong><?= e($avg) ?></strong> average from <?= count($all) ?> platform reviews
      </p>
    </header>

    <?php if (!$visible): ?>
      <div class="empty-state empty-state--design" style="margin-top:2rem;">
        <h3>No testimonials here yet</h3>
        <p>Try another filter.</p>
        <a href="testimonials.php" class="btn btn--dark">View all</a>
      </div>
    <?php else: ?>
      <div class="testimonial-grid">
        <?php foreach ($visible as $t): ?>
          <figure class="testimonial-card--page">
            <?= stars($t['stars']) ?>
            <span class="quote-mark"><?= icon('quote', 22) ?></span>
            <blockquote>“<?= e($t['quote']) ?>”</blockquote>
            <figcaption class="who">
              <?= avatar($t['bg'], $t['hair'], $t['style'], 32) ?>
              <div>
                <strong><?= e($t['name']) ?></strong>
                <small><?= e(ucfirst($t['role'])) ?> · <?= e($t['context']) ?></small>
              </div>
            </figcaption>
          </figure>
        <?php endforeach; ?>
      </div>

      <?php if ($total_pages > 1): ?>
        <nav class="pagination" aria-label="Pagination">
          <a class="page-btn <?= $page <= 1 ? 'is-disabled' : '' ?>" href="<?= e(tt_url($role, $page - 1)) ?>" aria-label="Previous page"><?= icon('chevron-left', 14) ?></a>
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a class="page-btn <?= $i === $page ? 'is-active' : '' ?>" href="<?= e(tt_url($role, $i)) ?>" <?= $i === $page ? 'aria-current="page"' : '' ?>><?= $i ?></a>
          <?php endfor; ?>
          <a class="page-btn <?= $page >= $total_pages ? 'is-disabled' : '' ?>" href="<?= e(tt_url($role, $page + 1)) ?>" aria-label="Next page"><?= icon('chevron-right', 14) ?></a>
        </nav>
      <?php endif; ?>
    <?php endif; ?>

  </div>
</main>

<?php include '../includes/footer.php'; ?>