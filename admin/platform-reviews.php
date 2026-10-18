<?php
/**
 * admin/platform-reviews.php - Platform reviews, published as testimonials or hidden (matches the design).
 * Publishing and hiding are saved to live records or isolated demo session state.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "reviews";

require_once __DIR__ . '/../includes/data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = (string) ($_POST['action'] ?? '');
    $review_id = (string) ($_POST['review_id'] ?? '');
    $error = tt_admin_set_review_status($review_id, $act);
    tt_flash($error ? 'Could not update review: ' . $error : 'Review status updated.');
    header('Location: ' . $base_url . 'admin/platform-reviews.php?id=' . urlencode($review_id));
    exit;
}

$all  = toptunity_admin_reviews();
$want = isset($_GET['id']) ? $_GET['id'] : '';
$sel  = null;
foreach ($all as $r) { if ($r['id'] === $want) { $sel = $r; } }
if (!$sel && $all) { $sel = $all[0]; }
$cls = ['new' => 'pending', 'published' => 'released', 'hidden' => 'cancelled'];

$page_title = "Platform Reviews";
$flash = tt_flash();
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Platform Reviews and Testimonials</h1>
    <p class="subtle">Publish platform reviews as testimonials or hide them.</p>
  </div>
</div>

<?php if ($flash): ?><div class="note-soft" role="status" style="margin-top:1rem;"><?= e($flash) ?></div><?php endif; ?>

<div class="admin-layout">
  <section class="admin-list">
    <p class="section-tag" style="padding:0.9rem 1rem 0;">Platform review list</p>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead><tr><th>Date</th><th>User</th><th>Role</th><th>Rating</th><th>Status</th></tr></thead>
        <tbody>
          <?php if (!$all): ?><tr><td colspan="5" class="muted" style="text-align:center; padding:1.2rem;">No reviews are available.</td></tr><?php endif; ?>
          <?php foreach ($all as $r): ?>
            <tr class="<?= $sel && $r['id'] === $sel['id'] ? 'is-selected' : '' ?>">
              <td><?= e($r['date']) ?></td>
              <td><a href="platform-reviews.php?id=<?= e($r['id']) ?>" style="display:flex; align-items:center; gap:0.5rem;"><?= avatar('#CCFBF1', '#1E293B', 'short', 26) ?><strong><?= e($r['user']) ?></strong></a></td>
              <td><?= e($r['role']) ?></td>
              <td><?= stars($r['rating']) ?></td>
              <td><span class="status status--<?= e($cls[$r['status']]) ?>"><?= e(ucfirst($r['status'])) ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <aside class="admin-side">
    <?php if (!$sel): ?>
      <h2>Review Details</h2><p class="muted">No review selected.</p>
    <?php else: ?>
    <h2>Review Details</h2>
    <div style="display:flex; align-items:center; gap:0.6rem;">
      <?= avatar('#CCFBF1', '#1E293B', 'short', 34) ?>
      <div><strong style="font-size:0.85rem;"><?= e($sel['user']) ?></strong><small style="display:block; color:var(--color-muted-gray); font-size:0.7rem;"><?= e($sel['role']) ?> · <?= e($sel['date']) ?></small></div>
    </div>
    <div style="margin:0.6rem 0;"><?= stars($sel['rating']) ?></div>
    <div class="quote-box">“<?= e($sel['text']) ?>”</div>
    <form method="post" action="platform-reviews.php?id=<?= e($sel['id']) ?>" style="margin-top:0.9rem;">
      <input type="hidden" name="review_id" value="<?= e($sel['id']) ?>">
      <button type="submit" name="action" value="publish" class="btn btn--primary btn--block">📢 Publish as Testimonial</button>
      <button type="submit" name="action" value="hide" class="btn btn--row-outline btn--block" style="margin-top:0.5rem;">⊘ Hide</button>
    </form>
    <p class="note-line" style="margin-top:0.7rem;">Published reviews appear on the Testimonials page.</p>
    <?php endif; ?>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>