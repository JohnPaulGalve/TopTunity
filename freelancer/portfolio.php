<?php
/**
 * freelancer/portfolio.php - Samples of your previous work (matches the Portfolio design).
 * Uploading, editing and removing are not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

$items  = tt_is_demo_freelancer() ? toptunity_freelancer(1)['portfolio'] : [];
$errors = [];
$form   = ['title' => '', 'category' => ''];
$cats   = ['Web Development', 'Mobile App Development', 'Graphic Design', 'UI/UX Design', 'Writing and Content', 'Digital Marketing', 'Video and Animation', 'Data Entry and Admin'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['title']    = trim(isset($_POST['title']) ? $_POST['title'] : '');
    $form['category'] = isset($_POST['category']) ? $_POST['category'] : '';
    if (mb_strlen($form['title']) < 3)                 { $errors[] = 'Enter a title for this sample.'; }
    if (!in_array($form['category'], $cats, true))     { $errors[] = 'Choose a category.'; }
    if (empty($_FILES['sample']['name'][0]))           { $errors[] = 'Choose an image or PDF to upload.'; }
    $up = tt_handle_uploads('sample');
    $errors = array_merge($errors, $up['errors']);
    if (!$errors) {
        tt_save_attachments('portfolio', (int) tt_current_user()['id'], $up['files'], $form['title']);
        tt_flash('Your portfolio sample was uploaded.');
        header('Location: ' . $base_url . 'freelancer/portfolio.php');
        exit;
    }
}

$page_title = "Portfolio";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Portfolio</h1>
    <p class="subtle">Samples of your previous work.</p>
  </div>
  <a href="#upload" class="btn btn--primary btn--sm-block"><?= icon('upload', 14) ?> Upload Portfolio</a>
</div>

<?php if (!$items): ?>
  <div class="empty-state empty-state--design" style="margin-top:1.5rem;">
    <div class="empty-art"><?= icon('folder', 40) ?></div>
    <h3>Your portfolio is empty</h3>
    <p>Upload samples of your work so clients can see what you can do.</p>
    <a href="#upload" class="btn btn--dark">Upload Portfolio</a>
  </div>
<?php else: ?>
  <?php $my_samples = tt_attachments('portfolio', (int) tt_current_user()['id']); if ($my_samples): ?>
  <section class="box" style="margin-bottom:1rem;">
    <h2 style="margin-bottom:0.6rem;">Uploaded samples</h2>
    <?php foreach ($my_samples as $ms): ?>
      <div class="file-row" style="margin-top:0.5rem;"><?= icon('file', 15) ?><?= tt_file_name_html($ms, $base_url) ?><?php if (!empty($ms['label'])): ?><span class="muted"><?= e($ms['label']) ?></span><?php endif; ?><span class="file-row__size"><?= e($ms['size']) ?></span></div>
    <?php endforeach; ?>
  </section>
  <?php endif; ?>

  <div class="portfolio-grid" style="grid-template-columns: repeat(4, 1fr); margin-top:1.25rem;">
    <?php foreach ($items as $item): ?>
      <div class="portfolio-item">
        <div class="portfolio-thumb" style="--thumb: <?= e($item['tint']) ?>"><span></span><span></span><span></span></div>
        <h4><?= e($item['title']) ?></h4>
        <p><?= e($item['category']) ?></p>
        <div style="display:flex; gap:0.9rem; margin-top:0.6rem; font-size:0.72rem; font-weight:600;">
          <a href="#" style="color:var(--color-vibrant-teal);"><?= icon('edit', 12) ?> Edit</a>
          <a href="#" style="color:var(--color-error-base);"><?= icon('x-circle', 12) ?> Remove</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<section class="box" id="upload" style="margin-top:1.5rem;">
  <h2>Upload a sample</h2>
  <?php if ($errors): ?>
    <div class="form-alert" role="alert"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
  <?php endif; ?>
  <form method="post" action="portfolio.php" enctype="multipart/form-data" style="margin-top:0.8rem;">
    <div class="field-row">
      <div class="field" style="margin-top:0;"><label for="pf-title">Title <span class="req">*</span></label><input class="input" id="pf-title" name="title" value="<?= e($form['title']) ?>" required></div>
      <div class="field" style="margin-top:0;"><label for="pf-cat">Category <span class="req">*</span></label>
        <select class="input" id="pf-cat" name="category" required>
          <option value="" disabled <?= $form['category'] === '' ? 'selected' : '' ?>>Choose a category</option>
          <?php foreach ($cats as $c): ?><option <?= $form['category'] === $c ? 'selected' : '' ?>><?= e($c) ?></option><?php endforeach; ?>
        </select>
      </div>
    </div>
    <label class="dropzone" style="margin-top:0.9rem;">
      <?= icon('upload', 22) ?>
      <strong>Drag files here or <a>browse</a></strong>
      <small>PNG, JPG or PDF up to 10 MB</small>
      <input type="file" name="sample[]" accept=".pdf,.jpg,.jpeg,.png">
    </label>
    <div class="form-actions--plain"><button type="submit" class="btn btn--primary">Upload</button></div>
  </form>
</section>

</main>

<?php include '../includes/footer.php'; ?>