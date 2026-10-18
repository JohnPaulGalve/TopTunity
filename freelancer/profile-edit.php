<?php
/**
 * freelancer/profile-edit.php - Edit your profile (matches the My Profile design).
 * Saves profile details and photos to the database.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

$me   = toptunity_current_freelancer();
$demo = tt_is_demo_freelancer();
$f    = $demo ? toptunity_freelancer(1) : null;
$rev  = toptunity_freelancer_reviews();

$form = [
    'name'      => $me['name'],
    'title'     => $demo ? $f['title'] : '',
    'location'  => $demo ? $f['location'] : '',
    'contact'   => $demo ? '+63 917 555 0199' : '',
    'rate'      => $demo ? $f['rate'] : '',
    'languages' => $demo ? $f['languages'] : '',
    'about'     => $demo ? $f['about'][0] : '',
];
$form = tt_apply_profile_form($form);
$errors = [];

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
    foreach ($form as $k => $v) { $form[$k] = trim(isset($_POST[$k]) ? $_POST[$k] : ''); }
    if ($form['name'] === '')                       { $errors[] = 'Please enter your full name.'; }
    if ($form['title'] === '')                      { $errors[] = 'Please enter your professional title.'; }
    if ((int) $form['rate'] < 100)                  { $errors[] = 'Enter an hourly rate of at least ₱100.'; }
    if (mb_strlen($form['about']) < 50)             { $errors[] = 'Your about section should be at least 50 characters.'; }
    if (!$errors) {
        tt_save_freelancer_profile($form);
        tt_flash('Your profile was saved.');
        header('Location: ' . $base_url . 'freelancer/profile-edit.php');
        exit;
    }
}

$page_title = "My Profile";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>My Profile</h1>
    <p class="subtle">Create or edit your profile so clients know who they are working with.</p>
  </div>
</div>

<?php if ($errors): ?>
  <div class="form-alert" role="alert" style="margin-top:1.25rem;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
<?php endif; ?>

<div class="two-col" style="margin-top:1.25rem;">
  <div class="stack">
    <section class="profile-card">
      <?php $my_photo = tt_user_photo((int) tt_current_user()['id'], 'freelancer'); ?><?= tt_avatar_html($me, 96, $base_url) ?>
      <h2><?= e($form['name']) ?></h2>
      <p><?= e($form['title']) ?></p>
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
        <div><?= stars($rev['avg']) ?></div>
        <strong><?= e($rev['avg']) ?></strong>
        <div><a href="my-reviews.php"><?= (int) $rev['total'] ?> reviews received →</a></div>
      </div>
      <a href="<?= e($base_url) ?>pages/freelancer-profile.php?id=<?= 5000 + (int) tt_current_user()['id'] ?>" target="_blank" rel="noopener" class="btn btn--row-outline" style="width:100%; margin-top:0.9rem;"><?= icon('eye', 13) ?> Preview Profile</a>
      <p class="muted" style="margin-top:0.6rem;">How clients and visitors see your profile.</p>
    </section>
  </div>

  <section class="box" style="margin-top:0;">
    <form method="post" action="profile-edit.php">
      <div class="form-grid-2">
        <div class="field"><label for="p-name">Full Name</label><input class="input" id="p-name" name="name" value="<?= e($form['name']) ?>" required></div>
        <div class="field"><label for="p-title">Professional Title</label><input class="input" id="p-title" name="title" value="<?= e($form['title']) ?>" required></div>
        <div class="field"><label for="p-location">Location</label>
          <div class="input-wrap"><?= icon('map-pin', 16) ?><input id="p-location" name="location" value="<?= e($form['location']) ?>"></div>
        </div>
        <div class="field"><label for="p-contact">Contact Number</label>
          <div class="input-wrap"><?= icon('phone', 16) ?><input id="p-contact" name="contact" value="<?= e($form['contact']) ?>"></div>
        </div>
        <div class="field"><label for="p-rate">Hourly Rate (₱/hr)</label>
          <div class="input-prefix"><span>₱</span><input class="input" id="p-rate" name="rate" type="number" min="100" step="1" value="<?= e($form['rate']) ?>"></div>
        </div>
        <div class="field"><label for="p-langs">Languages</label><input class="input" id="p-langs" name="languages" value="<?= e($form['languages']) ?>"></div>
        <div class="field full"><label for="p-about">About</label>
          <textarea id="p-about" name="about" class="input" rows="5" minlength="50" style="height:auto; padding:0.7rem; font-size:0.82rem; line-height:1.6;"><?= e($form['about']) ?></textarea>
        </div>
      </div>
      <div class="form-actions--plain" style="align-items:center; flex-wrap:wrap;">
        <button type="submit" class="btn btn--primary">Save Profile</button>
        <a href="profile-edit.php" class="btn btn--outline">Cancel</a>
        <span class="muted" style="flex-basis:100%; margin-top:0.6rem;">Manage <a href="skills.php" class="link-teal">Skills</a> · <a href="portfolio.php" class="link-teal">Portfolio</a></span>
      </div>
    </form>
  </section>
</div>

</main>

<?php include '../includes/footer.php'; ?>