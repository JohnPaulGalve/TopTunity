<?php
/**
 * freelancer/platform-review.php - Rate and review TopTunity (matches the Platform Review design).
 * Sending is not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = "/Webdev/";
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

$labels = [5 => 'Excellent', 4 => 'Very good', 3 => 'Good', 2 => 'Fair', 1 => 'Poor'];
$rating = isset($_POST['rating']) ? max(1, min(5, (int) $_POST['rating'])) : 5;
$text   = tt_is_demo_freelancer() ? 'Recommended Projects shows me jobs that actually match my PHP and MySQL skills. Contracts are clear and the 10% fee is shown upfront. Most of my repeat clients found me through TopTunity.' : '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = trim(isset($_POST['review']) ? $_POST['review'] : '');
    if (mb_strlen($text) < 20)      { $errors[] = 'Please write at least 20 characters.'; }
    if (mb_strlen($text) > 1000)    { $errors[] = 'Your review can be at most 1,000 characters.'; }
    if (!$errors) {
        tt_flash('Thank you! Your platform review was sent.');
        header('Location: ' . $base_url . 'freelancer/platform-review.php');
        exit;
    }
}

$page_title = "Platform Review";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Platform Review</h1>
    <p class="subtle">Rate and review TopTunity. Selected reviews may be published as testimonials.</p>
  </div>
</div>

<?php if ($errors): ?>
  <div class="form-alert" role="alert" style="margin-top:1.25rem;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
<?php endif; ?>

<div class="two-col" style="margin-top:1.25rem;">
  <section class="box" style="margin-top:0;">
    <form method="post" action="platform-review.php">
      <div class="field">
        <label>Rating</label>
        <div style="display:flex; align-items:center; gap:0.8rem; margin-top:0.2rem;">
          <div class="star-pick" style="margin:0; flex-direction:row-reverse; justify-content:flex-start;">
            <?php for ($s = 5; $s >= 1; $s--): ?>
              <input type="radio" id="plat-<?= $s ?>" name="rating" value="<?= $s ?>" <?= $s === $rating ? 'checked' : '' ?>>
              <label for="plat-<?= $s ?>" aria-label="<?= $s ?> stars">★</label>
            <?php endfor; ?>
          </div>
          <span class="muted"><?= (int) $rating ?> out of 5 · <?= e($labels[$rating]) ?></span>
        </div>
      </div>
      <div class="field">
        <label for="review">Review</label>
        <textarea id="review" name="review" class="input" rows="5" minlength="20" maxlength="1000" style="height:auto; padding:0.8rem; line-height:1.6; font-size:0.82rem;"><?= e($text) ?></textarea>
        <span class="char-count"><?= mb_strlen($text) ?> / 1,000 characters</span>
      </div>
      <div class="form-actions" style="justify-content:flex-end; margin-top:0.6rem;">
        <button type="submit" class="btn btn--primary"><?= icon('send', 14) ?> Submit Review</button>
      </div>
    </form>
  </section>

  <aside class="info-callout" style="margin-top:0; align-items:flex-start;">
    <?= icon('info', 15) ?>
    <div>
      <strong style="display:block; margin-bottom:0.4rem;">Before you review</strong>
      <ul class="dots" style="margin:0; gap:0.35rem;">
        <li style="font-size:0.74rem; color:var(--color-info-text);">Available after at least one completed project.</li>
        <li style="font-size:0.74rem; color:var(--color-info-text);">One platform review per freelancer.</li>
        <li style="font-size:0.74rem; color:var(--color-info-text);">The administrator decides if it is published on Testimonials.</li>
      </ul>
    </div>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>