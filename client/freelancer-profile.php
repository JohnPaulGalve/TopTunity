<?php
/**
 * client/freelancer-profile.php - Freelancer profile as the client sees it.
 * NEW file (not in the original plan): the public version lives in pages/freelancer-profile.php.
 * Accepts ?id=N. Falls back to the first freelancer if the ID is unknown.
 */
$user_role     = "client";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "freelancers";

require_once __DIR__ . '/../includes/data.php';
tt_handle_favourite();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$f  = toptunity_freelancer($id);
if (!$f) {
    $ids = array_keys(toptunity_freelancers());
    $id  = $ids[0];
    $f   = toptunity_freelancer($id);
}
$saved = in_array($id, toptunity_saved_freelancer_ids(), true);

$page_title = $f['name'];
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="find-freelancers.php">Find Freelancers</a><span>/</span><span aria-current="page"><?= e($f['name']) ?></span>
</nav>

<div class="profile-banner" aria-hidden="true"></div>
<div class="profile-head profile-head--actions">
  <div class="profile-id">
    <?= tt_freelancer_avatar_html($f, 96, $base_url) ?>
    <div class="profile-id__text">
      <h1>
        <?= e($f['name']) ?>
        <?php if ($f['available']): ?><span class="pill pill--open">Available</span><?php endif; ?>
      </h1>
      <p class="profile-id__role"><?= e($f['title']) ?> · <?= icon('map-pin', 12) ?> <?= e($f['location']) ?></p>
      <div class="profile-id__meta"><?= stars($f['rating']) ?> <strong><?= e($f['rating']) ?></strong> (<?= (int) $f['reviews'] ?> reviews)</div>
    </div>
  </div>
</div>
<div class="profile-actionbar">
  <div class="profile-actions">
    <a href="hire-freelancer.php?freelancer=<?= (int) $id ?>" class="btn btn--hire"><?= icon('user-plus', 15) ?> Hire</a>
    <a href="messages.php" class="btn btn--row-outline"><?= icon('message', 13) ?> Message Freelancer</a>
    <form method="post" action="freelancer-profile.php?id=<?= (int) $id ?>" style="display:inline;">
      <input type="hidden" name="favourite" value="freelancer"><input type="hidden" name="item" value="<?= (int) $id ?>">
      <button type="submit" class="btn btn--row-outline" style="<?= $saved ? 'color:var(--color-error-base);' : '' ?>"><?= icon('heart', 13) ?> <?= $saved ? 'Saved' : 'Save Freelancer' ?></button>
    </form>
  </div>
  <a href="report-dispute.php?user=<?= (int) $id ?>" class="btn btn--row-outline profile-report"><?= icon('flag', 13) ?> Report User</a>
</div>

<div class="detail-layout" style="margin-top:1rem;">
  <div class="detail-main">
    <section class="detail-card">
      <h2>About</h2>
      <?php foreach ($f['about'] as $para): ?><p><?= e($para) ?></p><?php endforeach; ?>
    </section>

    <section class="detail-card">
      <div class="reviews-summary" style="margin-bottom:0;">
        <h2 style="margin:0;">Portfolio</h2>
        <small><?= count($f['portfolio']) ?> work samples</small>
      </div>
      <div class="portfolio-grid" style="margin-top:1rem; grid-template-columns:repeat(3, minmax(0, 1fr));">
        <?php foreach ($f['portfolio'] as $item): ?>
          <div class="portfolio-item">
            <?php if (!empty($item['image']) && !empty($item['id'])): ?>
              <div class="portfolio-thumb" style="padding:0; overflow:hidden;"><img src="<?= e($base_url) ?>download.php?file=<?= (int) $item['id'] ?>" alt="<?= e($item['title']) ?>" loading="lazy" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
            <?php else: ?>
              <div class="portfolio-thumb" style="--thumb: <?= e($item['tint']) ?>"><span></span><span></span><span></span></div>
            <?php endif; ?>
            <h4><?= e($item['title']) ?></h4>
            <p><?= e($item['category']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

  </div>

  <aside class="detail-side">
    <div class="side-card">
      <h2 class="side-card__title">Skills</h2>
      <div class="skill-chips">
        <?php foreach ($f['skills'] as $s): ?><span class="chip"><?= e($s) ?></span><?php endforeach; ?>
      </div>
    </div>
    <div class="side-card">
      <h2 class="side-card__title">Details</h2>
      <div class="fact-list">
        <div class="fact-row">Hourly rate <strong>₱<?= number_format($f['rate']) ?>/hr</strong></div>
        <div class="fact-row">Projects completed <strong><?= (int) $f['completed'] ?></strong></div>
        <div class="fact-row">On-time delivery <strong><?= e($f['ontime']) ?></strong></div>
        <div class="fact-row">Languages <strong><?= e($f['languages'] ?? '') ?></strong></div>
        <div class="fact-row">Member since <strong><?= e($f['since']) ?></strong></div>
      </div>
    </div>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>