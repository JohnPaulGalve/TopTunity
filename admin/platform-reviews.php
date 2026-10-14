<?php
/**
 * admin/platform-reviews.php - Platform reviews, published as testimonials or hidden (matches the design).
 * Publishing and hiding are not saved to a database yet.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "reviews";

require_once __DIR__ . '/../includes/data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = isset($_POST['action']) ? $_POST['action'] : '';
    header('Location: ' . $base_url . 'admin/platform-reviews.php' . (isset($_GET['id']) ? '?id=' . urlencode($_GET['id']) : ''));
    exit;
}

$all  = toptunity_admin_reviews();
$want = isset($_GET['id']) ? $_GET['id'] : '';
$sel  = null;
foreach ($all as $r) { if ($r['id'] === $want) { $sel = $r; } }
if (!$sel) { $sel = $all[0]; }
$cls = ['new' => 'pending', 'published' => 'released', 'hidden' => 'cancelled'];

$page_title = "Platform Reviews";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Platform Reviews and Testimonials</h1>
    <p class="subtle">Publish platform reviews as testimonials or hide them.</p>
  </div>
</div>

<div class="admin-layout">
  <section class="admin-list">
    <p class="section-tag" style="padding:0.9rem 1rem 0;">Platform review list</p>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead><tr><th>Date</th><th>User</th><th>Role</th><th>Rating</th><th>Status</th></tr></thead>
        <tbody>
          <?php foreach ($all as $r): ?>
            <tr class="<?= $r['id'] === $sel['id'] ? 'is-selected' : '' ?>">
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
    <h2>Review Details</h2>
    <div style="display:flex; align-items:center; gap:0.6rem;">
      <?= avatar('#CCFBF1', '#1E293B', 'short', 34) ?>
      <div><strong style="font-size:0.85rem;"><?= e($sel['user']) ?></strong><small style="display:block; color:var(--color-muted-gray); font-size:0.7rem;"><?= e($sel['role']) ?> · <?= e($sel['date']) ?></small></div>
    </div>
    <div style="margin:0.6rem 0;"><?= stars($sel['rating']) ?></div>
    <div class="quote-box">“<?= e($sel['text']) ?>”</div>
    <form method="post" action="platform-reviews.php?id=<?= e($sel['id']) ?>" style="margin-top:0.9rem;">
      <button type="submit" name="action" value="publish" class="btn btn--primary btn--block">📢 Publish as Testimonial</button>
      <button type="submit" name="action" value="hide" class="btn btn--row-outline btn--block" style="margin-top:0.5rem;">⊘ Hide</button>
    </form>
    <p class="note-line" style="margin-top:0.7rem;">Published reviews appear on the Testimonials page.</p>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>