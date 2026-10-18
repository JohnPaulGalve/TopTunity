<?php
/**
 * freelancer/saved-projects.php - Projects you saved while searching (matches the Saved Projects design).
 * Removing is not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';
tt_handle_favourite();

$ids   = toptunity_freelancer_saved_ids();
$open  = [];
foreach (toptunity_listing() as $row) { $open[(int) $row['id']] = $row; }
foreach (tt_load_saved_projects() as $sp) {
    if ($sp['status'] !== 'open') { continue; }
    $open[(int) $sp['id']] = ['id' => $sp['id'], 'title' => $sp['title'],
        'amount' => $sp['type'] === 'hourly' ? $sp['rate'] : $sp['budget'], 'deadline' => $sp['deadline']];
}

$page_title = "Saved Projects";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Saved Projects</h1>
    <p class="subtle">Projects you saved while searching.</p>
  </div>
</div>

<?php if (!$ids): ?>
  <div class="empty-state empty-state--design" style="margin-top:1.5rem;">
    <div class="empty-art empty-art--illustration">
      <img src="<?= e(tt_image_url($base_url, 'images/Illustrations/Empty State and Not found/empty.svg')) ?>" alt="">
    </div>
    <h3>No saved projects yet</h3>
    <p>Save projects from Find Projects to keep them here.</p>
    <a href="find-projects.php" class="btn btn--dark">Find Projects</a>
  </div>
<?php else: ?>
  <div class="project-list" style="margin-top:1.25rem;">
    <?php foreach ($ids as $id):
      $row = isset($open[$id]) ? $open[$id] : null;
    ?>
      <article class="project-row" style="grid-template-columns: 40px 1fr auto;">
        <span class="icon-box icon-box--<?= $row ? 'teal' : 'slate' ?> project-row__icon"><?= icon('heart', 18) ?></span>
        <div>
          <div class="project-row__title">
            <h3><?= e($row ? $row['title'] : 'Project no longer available') ?></h3>
            <?php if ($row): ?><span class="status status--open">Open</span>
            <?php else: ?><span class="status status--cancelled">No longer available</span><?php endif; ?>
          </div>
          <?php if ($row): ?>
            <div class="project-row__meta">
              <span>Budget <strong>₱<?= number_format($row['amount']) ?></strong></span>
              <span>Deadline <strong><?= e(date('M d, Y', strtotime($row['deadline']))) ?></strong></span>
            </div>
          <?php endif; ?>
        </div>
        <div class="project-row__actions">
          <form method="post" action="saved-projects.php" style="display:inline;">
            <input type="hidden" name="favourite" value="project"><input type="hidden" name="item" value="<?= (int) $id ?>">
            <button type="submit" class="btn" style="color:var(--color-error-base); background:transparent; box-shadow:none;">Remove from Saved</button>
          </form>
          <?php if ($row): ?>
            <a href="<?= e($base_url) ?>pages/project-details.php?id=<?= (int) $id ?>" class="btn--row-dark">View Details</a>
          <?php endif; ?>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>