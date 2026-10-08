<?php
/**
 * client/platform-review.php - Rate and review TopTunity (matches the Platform Review design).
 * Submitting is not connected to a database yet.
 */
$user_role     = "client";
$base_url      = "/Webdev/";
$active_client = "";

$labels = [5 => 'Excellent', 4 => 'Very good', 3 => 'Good', 2 => 'Fair', 1 => 'Poor'];
$rating = isset($_POST['rating']) ? max(1, min(5, (int) $_POST['rating'])) : 5;
$text   = "I posted our ordering website project on a Monday and had twelve solid proposals by Wednesday. The match percentage helped me shortlist fast, and holding the payment until I approved the work gave me peace of mind.";
$max    = 1000;

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

<div class="two-col" style="margin-top:1.25rem;">
  <section class="box" style="margin-top:0;">
    <form method="post" action="">
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
        <textarea id="review" name="review" class="input" rows="5" maxlength="<?= $max ?>" style="height:auto; padding:0.8rem; line-height:1.6; font-size:0.82rem;"><?= e($text) ?></textarea>
        <span class="char-count"><?= strlen($text) ?> / <?= number_format($max) ?> characters</span>
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
        <li style="font-size:0.74rem; color:var(--color-info-text);">One platform review per client.</li>
        <li style="font-size:0.74rem; color:var(--color-info-text);">The administrator decides if it is published on Testimonials.</li>
      </ul>
    </div>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>