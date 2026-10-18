<?php
/**
 * client/my-profile.php - Edit the client profile, and see reviews received (#reviews).
 * ?tab=personal|business. Saving is not connected to a database yet.
 */
$user_role     = "client";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_photo'])) {
    tt_remove_photo();
    tt_flash('Your profile photo was removed.');
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['choose_avatar'])) {
    $err = tt_set_user_avatar((string) ($_POST['avatar'] ?? ''));
    tt_flash($err ? 'Could not update avatar: ' . $err : 'Your avatar was updated.');
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $err = tt_save_photo();
    tt_flash($err ? 'Could not save: ' . $err : 'Your profile photo was updated.');
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cur = tt_client_profile() ?: [];
    $data = [
        'full_name' => $_POST['full_name'] ?? '',
        'company'   => $_POST['company'] ?? ($_POST['business_name'] ?? ($cur['company'] ?? '')),
        'location'  => $_POST['location'] ?? ($cur['location'] ?? ''),
        'contact'   => $_POST['contact'] ?? ($cur['phone'] ?? ''),
        'about'     => $_POST['about'] ?? ($cur['about'] ?? ''),
        'address'   => $_POST['address'] ?? ($cur['address'] ?? ''),
        'tin'       => $_POST['tin'] ?? ($cur['tin'] ?? ''),
    ];
    $err = tt_save_client_profile($data);
    tt_flash($err ? 'Could not save: ' . $err : 'Your profile was saved.');
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

$me      = toptunity_current_client();
$demo    = tt_is_demo_account();
$reviews = toptunity_client_reviews();
$tab     = isset($_GET['tab']) && $_GET['tab'] === 'business' ? 'business' : 'personal';

$avg   = $reviews ? round(array_sum(array_column($reviews, 'stars')) / count($reviews), 1) : 0;
$dist  = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
foreach ($reviews as $r) { $dist[$r['stars']]++; }

$page_title = "My Profile";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>My Profile</h1>
    <p class="subtle">Create or edit your profile so freelancers know who they are working with.</p>
  </div>
</div>

<div class="two-col" style="margin-top:1.25rem;">
  <div class="stack">
    <section class="profile-card">
      <?php $my_photo = tt_user_photo((int) tt_current_user()['id'], 'client'); ?><?= tt_avatar_html($me, 96, $base_url) ?>
      <h2><?= e($me['name']) ?></h2>
      <p>Owner, <?= e($me['company']) ?></p>
      <form method="post" enctype="multipart/form-data" style="display:inline;">
        <label class="btn btn--outline btn--sm" style="cursor:pointer;"><?= icon('upload', 13) ?> Upload Photo<input type="file" name="photo" accept="image/png,image/jpeg" onchange="this.form.submit()" style="display:none;"></label>
      </form>
      <?php if (!empty($my_photo)): ?>
      <form method="post" style="margin-top:0.5rem;"><button type="submit" name="remove_photo" value="1" class="btn btn--row-outline btn--sm">Remove Photo</button></form>
      <?php endif; ?>
      <details class="avatar-picker-details">
        <summary>Choose an illustrated avatar</summary>
        <form method="post" class="avatar-picker-form">
          <div class="avatar-picker">
            <?php foreach (tt_avatar_assets() as $asset): ?>
              <label class="avatar-choice">
                <input type="radio" name="avatar" value="<?= e($asset) ?>" aria-label="<?= e(ucwords(str_replace('-', ' ', pathinfo($asset, PATHINFO_FILENAME)))) ?>" <?= $asset === ($me['avatar'] ?? '') ? 'checked' : '' ?> required>
                <?= tt_avatar_image_html($asset, 48, $base_url) ?>
              </label>
            <?php endforeach; ?>
          </div>
          <button type="submit" name="choose_avatar" value="1" class="btn btn--primary btn--sm">Use Selected Avatar</button>
          <?php if ($my_photo): ?><small class="muted">Choosing an avatar will replace your uploaded profile photo.</small><?php endif; ?>
        </form>
      </details>
      <div class="rating-box">
        <div><?= stars($avg) ?></div>
        <strong><?= e($avg) ?></strong>
        <div><a href="#reviews"><?= count($reviews) ?> reviews received →</a></div>
      </div>
    </section>
  </div>

  <section class="box" style="margin-top:0;">
    <div class="profile-tabs" role="tablist" aria-label="Profile type">
      <a href="my-profile.php?tab=personal" class="<?= $tab === 'personal' ? 'is-active' : '' ?>"><?= icon('user', 13) ?> Personal</a>
      <a href="my-profile.php?tab=business" class="<?= $tab === 'business' ? 'is-active' : '' ?>"><?= icon('briefcase', 13) ?> Business</a>
    </div>

    <form method="post" action="" style="margin-top:1rem;">
      <?php if ($tab === 'personal'): ?>
        <div class="form-grid-2">
          <div class="field"><label for="full-name">Full Name</label><input class="input" id="full-name" name="full_name" value="<?= e($me['name']) ?>"></div>
          <div class="field"><label for="company">Company (optional)</label><input class="input" id="company" name="company" value="<?= e(tt_pv('company', $me['company'])) ?>"></div>
          <div class="field"><label for="location">Location</label>
            <div class="input-wrap"><?= icon('map-pin', 16) ?><input id="location" name="location" value="<?= e(tt_pv('location', $demo ? 'Quezon City, Philippines' : '')) ?>"></div>
          </div>
          <div class="field"><label for="contact">Contact Number</label>
            <div class="input-wrap"><?= icon('phone', 16) ?><input id="contact" name="contact" value="<?= e(tt_pv('phone', $demo ? '+63 917 555 0142' : '')) ?>"></div>
          </div>
          <div class="field full"><label for="about">About</label>
            <textarea id="about" name="about" class="input" rows="4" style="height:auto; padding:0.7rem; font-size:0.82rem;"><?= e(tt_pv('about', $demo ? 'Kapé Lokal is a small specialty coffee shop in Maginhawa, Quezon City serving locally sourced Batangas and Benguet beans. I usually hire freelancers for web, design and social media work.' : '')) ?></textarea>
          </div>
        </div>
      <?php else: ?>
        <div class="form-grid-2">
          <div class="field"><label for="biz-name">Business Name</label><input class="input" id="biz-name" name="business_name" value="<?= e(tt_pv('company', $me['company'])) ?>"></div>
          <div class="field"><label for="biz-type">Business Type</label>
            <select class="input" id="biz-type" name="business_type"><option selected>Food and beverage</option><option>Retail</option><option>Clinic or health</option><option>Education</option><option>Other</option></select>
          </div>
          <div class="field full"><label for="biz-address">Business Address</label><input class="input" id="biz-address" name="address" value="<?= e(tt_pv('address', $demo ? 'Maginhawa Street, Quezon City' : '')) ?>"></div>
          <div class="field"><label for="biz-tin">Business ID or TIN (optional)</label><input class="input" id="biz-tin" name="tin" placeholder="e.g. 123-456-789-000"></div>
        </div>
      <?php endif; ?>

      <div class="form-actions--plain">
        <button type="submit" class="btn btn--primary">Save Profile</button>
        <a href="my-profile.php?tab=<?= e($tab) ?>" class="btn btn--outline">Cancel</a>
      </div>
    </form>
  </section>
</div>

<!-- My Reviews -->
<section id="reviews" class="box" style="margin-top:1.25rem; scroll-margin-top: calc(var(--nav-height) + 1rem);">
  <div class="box-head">
    <h2>My Reviews</h2>
    <span class="muted">Reviews and ratings you received from freelancers.</span>
  </div>
  <div class="review-summary">
    <div>
      <div class="review-big">
        <strong><?= e($avg) ?></strong>
        <div style="margin-top:0.5rem;"><?= stars($avg) ?></div>
        <small><?= count($reviews) ?> reviews</small>
      </div>
      <div style="margin-top:1rem;">
        <?php foreach ($dist as $star => $n): ?>
          <div class="dist-row">
            <span><?= $star ?>★</span>
            <div class="dist-bar"><span style="width: <?= count($reviews) ? round($n / count($reviews) * 100) : 0 ?>%"></span></div>
            <span><?= $n ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="review-list">
      <?php foreach ($reviews as $r): ?>
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
</section>

</main>

<?php include '../includes/footer.php'; ?>