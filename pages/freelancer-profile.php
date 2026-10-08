<?php
/**
 * pages/freelancer-profile.php - Public freelancer profile
 * Accepts ?id=N, or ?name=Full Name (used by homepage links).
 */
$user_role = "public";
$base_url  = "/Webdev/";

require_once __DIR__ . '/../includes/data.php';

$freelancer = null;
$id = 0;
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $freelancer = toptunity_freelancer($id);
} elseif (isset($_GET['name'])) {
    $found = toptunity_freelancer_by_name($_GET['name']);
    if ($found) { $freelancer = $found; $id = $found['id']; }
}

// If the ID or name doesn't match anyone, show the first freelancer instead
// of an error page, so the profile always has details to display.
if (!$freelancer) {
    $all_ids    = array_keys(toptunity_freelancers());
    $id         = $all_ids[0];
    $freelancer = toptunity_freelancer($id);
}

$page_title = $freelancer ? $freelancer['name'] : 'Freelancer not found';
include '../includes/header.php';
include '../includes/nav.php';
?>

<main class="page-detail">
  <div class="container">

<?php if (!$freelancer): ?>
    <div class="not-found">
      <?= icon('alert', 36) ?>
      <h1>We couldn't find that freelancer</h1>
      <p>The profile may have moved, or the link is incorrect.</p>
      <a href="browse-freelancers.php" class="btn btn--teal-outline">Back to Browse Freelancers</a>
    </div>

<?php else: ?>
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="browse-freelancers.php">Browse Freelancers</a>
      <span>/</span>
      <span aria-current="page"><?= e($freelancer['name']) ?></span>
    </nav>

    <!-- Profile header -->
    <div class="profile-banner" aria-hidden="true"></div>
    <div class="profile-head">
      <div class="profile-id">
        <?= avatar($freelancer['bg'], $freelancer['hair'], $freelancer['style'], 96) ?>
        <div class="profile-id__text">
          <h1>
            <?= e($freelancer['name']) ?>
            <?php if ($freelancer['available']): ?>
              <span class="pill pill--open">Available</span>
            <?php endif; ?>
          </h1>
          <p class="profile-id__role"><?= e($freelancer['title']) ?> · <?= icon('map-pin', 12) ?> <?= e($freelancer['location']) ?></p>
          <div class="profile-id__meta">
            <?= stars($freelancer['rating']) ?> <strong><?= e($freelancer['rating']) ?></strong> (<?= (int) $freelancer['reviews'] ?> reviews)
          </div>
        </div>
      </div>
      <div class="profile-actions">
        <a href="login.php?next=<?= urlencode('freelancer-profile.php?id=' . $id) ?>" class="btn btn--hire">
          <?= icon('user-plus', 16) ?> Hire
        </a>
      </div>
    </div>

    <div class="detail-layout" style="margin-top: 1rem;">

      <!-- Main column -->
      <div class="detail-main">

        <section class="detail-card">
          <h2>About</h2>
          <div class="profile-about">
            <?php foreach ($freelancer['about'] as $para): ?>
              <p><?= e($para) ?></p>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="detail-card">
          <div class="reviews-summary" style="margin-bottom:0;">
            <h2 style="margin:0;">Portfolio</h2>
            <small><?= count($freelancer['portfolio']) ?> work samples</small>
          </div>
          <div class="portfolio-grid" style="margin-top:1rem;">
            <?php foreach ($freelancer['portfolio'] as $item): ?>
              <div class="portfolio-item">
                <div class="portfolio-thumb" style="--thumb: <?= e($item['tint']) ?>">
                  <span></span><span></span><span></span>
                </div>
                <h4><?= e($item['title']) ?></h4>
                <p><?= e($item['category']) ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="detail-card">
          <div class="reviews-summary">
            <h2 style="margin:0;">Reviews</h2>
            <span><?= stars($freelancer['rating']) ?> <strong><?= e($freelancer['rating']) ?></strong> · <small><?= (int) $freelancer['reviews'] ?> reviews</small></span>
          </div>
          <?php if (empty($freelancer['feedback'])): ?>
            <p>No reviews yet.</p>
          <?php else: ?>
            <?php foreach ($freelancer['feedback'] as $r): ?>
              <div class="review-item">
                <div class="review-head">
                  <div class="review-by">
                    <?= avatar($r['bg'], '#1E293B', $r['style'], 32) ?>
                    <div>
                      <strong><?= e($r['by']) ?></strong>
                      <small><?= e($r['project']) ?></small>
                    </div>
                  </div>
                  <div class="review-meta">
                    <?= stars($r['stars']) ?>
                    <?= e(date('M d, Y', strtotime($r['date']))) ?>
                  </div>
                </div>
                <p><?= e($r['text']) ?></p>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </section>
      </div>

      <!-- Sidebar -->
      <aside class="detail-side" aria-label="Freelancer summary">
        <div class="side-card">
          <h2 class="side-card__title">Skills</h2>
          <div class="skill-chips">
            <?php foreach ($freelancer['skills'] as $s): ?>
              <span class="chip"><?= e($s) ?></span>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="side-card">
          <h2 class="side-card__title">Details</h2>
          <div class="fact-list">
            <div class="fact-row">Hourly rate <strong>₱<?= number_format($freelancer['rate']) ?>/hr</strong></div>
            <div class="fact-row">Projects completed <strong><?= (int) $freelancer['completed'] ?></strong></div>
            <div class="fact-row">On-time delivery <strong><?= e($freelancer['ontime']) ?></strong></div>
            <div class="fact-row">Languages <strong><?= e($freelancer['languages']) ?></strong></div>
            <div class="fact-row">Member since <strong><?= e($freelancer['since']) ?></strong></div>
          </div>
        </div>

        <div class="info-callout">
          <?= icon('info', 15) ?>
          <span>Log in or register as a client to hire or message <?= e(explode(' ', $freelancer['name'])[0]) ?>.</span>
        </div>
      </aside>
    </div>
<?php endif; ?>

  </div>
</main>

<?php include '../includes/footer.php'; ?>