<?php
/**
 * freelancer/profile-edit.php - Edit your profile (matches the My Profile design).
 * Saving is not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = "/Webdev/";
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
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($form as $k => $v) { $form[$k] = trim(isset($_POST[$k]) ? $_POST[$k] : ''); }
    if ($form['name'] === '')                       { $errors[] = 'Please enter your full name.'; }
    if ($form['title'] === '')                      { $errors[] = 'Please enter your professional title.'; }
    if ((int) $form['rate'] < 100)                  { $errors[] = 'Enter an hourly rate of at least ₱100.'; }
    if (mb_strlen($form['about']) < 50)             { $errors[] = 'Your about section should be at least 50 characters.'; }
    if (!$errors) {
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
      <?= avatar($me['bg'], $me['hair'], $me['style'], 96) ?>
      <h2><?= e($form['name']) ?></h2>
      <p><?= e($form['title']) ?></p>
      <button type="button" class="btn btn--outline btn--sm"><?= icon('upload', 13) ?> Upload Photo</button>
      <div class="rating-box">
        <div><?= stars($rev['avg']) ?></div>
        <strong><?= e($rev['avg']) ?></strong>
        <div><a href="my-reviews.php"><?= (int) $rev['total'] ?> reviews received →</a></div>
      </div>
      <a href="#" class="btn btn--row-outline" style="width:100%; margin-top:0.9rem;"><?= icon('eye', 13) ?> Preview Profile</a>
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
      <div class="form-actions--plain" style="align-items:center;">
        <button type="submit" class="btn btn--primary">Save Profile</button>
        <a href="profile-edit.php" class="btn btn--outline">Cancel</a>
        <span class="muted" style="margin-left:auto;">Manage <a href="skills.php" class="link-teal">Skills</a> · <a href="portfolio.php" class="link-teal">Portfolio</a></span>
      </div>
    </form>
  </section>
</div>

</main>

<?php include '../includes/footer.php'; ?>