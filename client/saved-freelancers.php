<?php
/**
 * client/saved-freelancers.php - Freelancers the client has bookmarked.
 * Removing is not connected to a database yet.
 */
$user_role     = "client";
$base_url      = "/Webdev/";
$active_client = "freelancers";

require_once __DIR__ . '/../includes/data.php';

$saved = array_filter(array_map('toptunity_freelancer', toptunity_saved_freelancer_ids()));

$page_title = "Saved Freelancers";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Saved Freelancers</h1>
    <p class="subtle">Freelancers you are interested in.</p>
  </div>
</div>

<?php if (!$saved): ?>
  <div class="empty-state empty-state--design" style="margin-top:1.5rem;">
    <div class="empty-art"><?= icon('heart', 40) ?></div>
    <h3>No saved freelancers yet</h3>
    <p>Save freelancers from Find Freelancers to keep them here.</p>
    <a href="find-freelancers.php" class="btn btn--dark">Find Freelancers</a>
  </div>
<?php else: ?>
  <div class="saved-grid">
    <?php foreach ($saved as $fid => $f): ?>
      <article class="saved-card">
        <?= avatar($f['bg'], $f['hair'], $f['style'], 60) ?>
        <h3><?= e($f['name']) ?></h3>
        <p class="saved-card__role"><?= e($f['title']) ?></p>
        <div class="stars"><?= stars($f['rating']) ?> <strong><?= e($f['rating']) ?></strong></div>
        <a href="freelancer-profile.php?id=<?= (int) $fid ?>" class="btn btn--teal-outline">View Profile</a>
        <a href="#" class="saved-card__remove"><?= icon('heart', 13) ?> Remove from Saved</a>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>