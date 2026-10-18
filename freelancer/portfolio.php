<?php
/**
 * freelancer/portfolio.php - Samples of your previous work (matches the Portfolio design).
 * Uploading, editing and removing are not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

$cats = ['Web Development', 'Mobile App Development', 'Graphic Design', 'UI/UX Design', 'Writing and Content', 'Digital Marketing', 'Video and Animation', 'Data Entry and Admin'];
$tints = ['#CCFBF1', '#FFEDD5', '#E0E7FF', '#FEF9C3'];
$uid = (int) tt_current_user()['id'];
$pf = $_SESSION[tt_demo_session_key()]['portfolio'] ?? ['hidden' => [], 'edit' => []];

// Samples saved in the database (real freelancers, and demo uploads for this session)
$real_items = [];
foreach (tt_attachments('portfolio', $uid) as $i => $f) {
    $real_items[] = ['key' => 'r' . $f['id'], 'id' => (int) $f['id'], 'title' => $f['label'] ?: $f['name'],
                     'category' => $f['category'] ?: 'Web Development', 'tint' => $tints[$i % 4], 'real' => true,
                     'img' => $f['type'] === 'image'];
}
// The demo samples stay as they are; Remove and Edit only change them for this session
$sample_items = [];
if (tt_is_demo_freelancer()) {
    foreach (toptunity_freelancer(1)['portfolio'] as $sm) {
        $key = 'd' . md5($sm['title']);
        if (!empty($pf['hidden'][$key])) { continue; }
        $sample_items[] = ['key' => $key, 'title' => $pf['edit'][$key]['title'] ?? $sm['title'],
                           'category' => $pf['edit'][$key]['category'] ?? $sm['category'], 'tint' => $sm['tint'], 'real' => false];
    }
}
$items = array_merge($real_items, $sample_items);

$errors  = [];
$form    = ['title' => '', 'category' => ''];
$editing = null;
$edit_key = isset($_GET['edit']) ? (string) $_GET['edit'] : '';
foreach ($items as $it) { if ($edit_key !== '' && $it['key'] === $edit_key) { $editing = $it; } }
if ($editing) { $form = ['title' => $editing['title'], 'category' => $editing['category']]; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'upload';
    $key    = (string) ($_POST['key'] ?? '');
    if ($action === 'remove') {
        if ($key !== '' && $key[0] === 'r') { tt_portfolio_remove_real((int) substr($key, 1)); }
        elseif ($key !== '') { $_SESSION[tt_demo_session_key()]['portfolio']['hidden'][$key] = true; }
        header('Location: ' . $base_url . 'freelancer/portfolio.php');
        exit;
    }
    $form['title']    = trim(isset($_POST['title']) ? $_POST['title'] : '');
    $form['category'] = isset($_POST['category']) ? $_POST['category'] : '';
    if (mb_strlen($form['title']) < 3)             { $errors[] = 'Enter a title for this sample.'; }
    if (!in_array($form['category'], $cats, true)) { $errors[] = 'Choose a category.'; }
    if ($action === 'update') {
        if (!$errors) {
            if ($key !== '' && $key[0] === 'r') { tt_portfolio_update_real((int) substr($key, 1), $form['title'], $form['category']); }
            elseif ($key !== '') { $_SESSION[tt_demo_session_key()]['portfolio']['edit'][$key] = ['title' => $form['title'], 'category' => $form['category']]; }
            header('Location: ' . $base_url . 'freelancer/portfolio.php');
            exit;
        }
    } else {
        if (empty($_FILES['sample']['name'][0])) { $errors[] = 'Choose an image or PDF to upload.'; }
        $up = tt_handle_uploads('sample');
        $errors = array_merge($errors, $up['errors']);
        if (!$errors) {
            tt_save_attachments('portfolio', $uid, $up['files'], $form['title'], $form['category']);
            header('Location: ' . $base_url . 'freelancer/portfolio.php');
            exit;
        }
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
  <div class="portfolio-grid" style="grid-template-columns: repeat(4, 1fr); margin-top:1.25rem;">
    <?php foreach ($items as $item): ?>
      <div class="portfolio-item">
        <?php if (!empty($item['img'])): ?>
          <div class="portfolio-thumb" style="padding:0; overflow:hidden;"><img src="<?= e($base_url) ?>download.php?file=<?= (int) $item['id'] ?>" alt="<?= e($item['title']) ?>" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <?php else: ?>
          <div class="portfolio-thumb" style="--thumb: <?= e($item['tint']) ?>"><span></span><span></span><span></span></div>
        <?php endif; ?>
        <h4><?= e($item['title']) ?></h4>
        <p><?= e($item['category']) ?></p>
        <div style="display:flex; gap:0.9rem; align-items:center; margin-top:0.6rem; font-size:0.72rem; font-weight:600;">
          <a href="portfolio.php?edit=<?= e($item['key']) ?>#upload" style="color:var(--color-vibrant-teal);"><?= icon('edit', 12) ?> Edit</a>
          <form method="post" action="portfolio.php" style="display:inline;">
            <input type="hidden" name="action" value="remove"><input type="hidden" name="key" value="<?= e($item['key']) ?>">
            <button type="submit" style="background:none; border:0; padding:0; cursor:pointer; font:inherit; font-size:0.72rem; font-weight:600; color:var(--color-error-base);"><?= icon('x-circle', 12) ?> Remove</button>
          </form>
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
    <input type="hidden" name="action" value="<?= $editing ? 'update' : 'upload' ?>"><input type="hidden" name="key" value="<?= e($editing['key'] ?? '') ?>">
    <div class="field-row">
      <div class="field" style="margin-top:0;"><label for="pf-title">Title <span class="req">*</span></label><input class="input" id="pf-title" name="title" value="<?= e($form['title']) ?>" minlength="3" required></div>
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

<script>
/* Choosing or dropping a file shows its name in the box */
(function () {
  var zone = document.querySelector('label.dropzone');
  if (!zone) { return; }
  var input = zone.querySelector('input[type="file"]');
  var title = zone.querySelector('strong');
  var hint = zone.querySelector('small');
  function show() {
    if (!input.files || !input.files.length) { return; }
    var names = [].map.call(input.files, function (f) { return f.name; }).join(', ');
    if (title) { title.textContent = names; }
    if (hint) { hint.textContent = input.files.length + (input.files.length === 1 ? ' file' : ' files') + ' selected'; }
  }
  input.addEventListener('change', show);
  ['dragenter', 'dragover'].forEach(function (ev) {
    zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.add('is-drag'); });
  });
  ['dragleave', 'drop'].forEach(function (ev) {
    zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.remove('is-drag'); });
  });
  zone.addEventListener('drop', function (e) {
    if (e.dataTransfer && e.dataTransfer.files.length) { input.files = e.dataTransfer.files; show(); }
  });
})();
</script>
<?php include '../includes/footer.php'; ?>