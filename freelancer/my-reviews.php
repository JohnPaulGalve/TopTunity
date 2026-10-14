<?php
/**
 * freelancer/my-reviews.php - Reviews and ratings you received from clients (matches the My Reviews design).
 * NEW file (not in the original plan) because the design shows it as its own page.
 */
$user_role     = "freelancer";
$base_url      = "/TopTunity/";
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

$rev = toptunity_freelancer_reviews();

$page_title = "My Reviews";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>My Reviews</h1>
    <p class="subtle">Reviews and ratings you received from clients.</p>
  </div>
</div>

<div class="review-summary" style="margin-top:1.25rem;">
  <section class="box" style="margin-top:0;">
    <div class="review-big">
      <strong><?= e($rev['avg']) ?></strong>
      <div style="margin-top:0.5rem;"><?= stars($rev['avg']) ?></div>
      <small><?= (int) $rev['total'] ?> reviews</small>
    </div>
    <div style="margin-top:1rem;">
      <?php foreach ($rev['dist'] as $star => $n): ?>
        <div class="dist-row">
          <span><?= $star ?>★</span>
          <div class="dist-bar"><span style="width: <?= $rev['total'] ? round($n / $rev['total'] * 100) : 0 ?>%"></span></div>
          <span><?= (int) $n ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <div class="stack">
    <?php if (!$rev['items']): ?>
      <div class="empty-state empty-state--design">
        <div class="empty-art"><?= icon('star', 40) ?></div>
        <h3>No reviews yet</h3>
        <p>Reviews from clients appear here after a project is completed.</p>
      </div>
    <?php endif; ?>
    <?php foreach ($rev['items'] as $r): ?>
      <article class="review-card">
        <div class="review-card__head">
          <div class="review-by">
            <?= avatar($r['bg'], '#1E293B', $r['style'], 34) ?>
            <div><strong><?= e($r['by']) ?></strong><small><?= e($r['project']) ?></small></div>
          </div>
          <div style="text-align:right;">
            <?= stars($r['stars']) ?>
            <div class="review-card__date"><?= e(date('M d, Y', strtotime($r['date']))) ?></div>
          </div>
        </div>
        <p>“<?= e($r['text']) ?>”</p>
      </article>
    <?php endforeach; ?>
  </div>
</div>

</main>

<?php include '../includes/footer.php'; ?>