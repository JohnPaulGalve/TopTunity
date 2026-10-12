<?php
/**
 * client/post-project.php - Post a new project, or edit one of your own projects (?id=N).
 * Saves to storage/projects.json, so the project appears on the dashboard and My Projects.
 */
$user_role     = "client";
$base_url      = "/Webdev/";
$active_client = "post";

require_once __DIR__ . '/../includes/data.php';

$categories = [
    'Web Development', 'Mobile App Development', 'Graphic Design', 'UI/UX Design',
    'Writing and Content', 'Digital Marketing', 'Video and Animation', 'Data Entry and Admin',
];

/* Edit mode: only projects this client posted (saved ones) can be edited */
$edit_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$saved   = tt_saved_projects_for_current_user();
$editing = ($edit_id && isset($saved[$edit_id])) ? $saved[$edit_id] : null;
if ($edit_id && !$editing) {
    tt_flash('That project can\'t be edited here.');
    header('Location: ' . $base_url . 'client/my-projects.php');
    exit;
}

$form = $editing ? [
    'title'       => $editing['title'],
    'description' => $editing['intro'],
    'category'    => $editing['category'],
    'skills'      => $editing['skills'],
    'type'        => $editing['type'],
    'budget'      => $editing['type'] === 'fixed' ? $editing['budget'] : '',
    'rate'        => $editing['type'] === 'hourly' ? $editing['rate'] : '',
    'max_hours'   => $editing['type'] === 'hourly' ? $editing['max_hours'] : '',
    'deadline'    => $editing['deadline'],
    'files'       => $editing['files'],
] : [
    'title' => '', 'description' => '', 'category' => '', 'skills' => [], 'type' => 'fixed',
    'budget' => '', 'rate' => '', 'max_hours' => '', 'deadline' => '', 'files' => [],
];

/* Submitted form */
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $in = [
        'title'       => trim(isset($_POST['title']) ? $_POST['title'] : ''),
        'description' => trim(isset($_POST['description']) ? $_POST['description'] : ''),
        'category'    => isset($_POST['category']) ? $_POST['category'] : '',
        'skills'      => array_values(array_unique(array_filter(array_map('trim', (array) (isset($_POST['skills']) ? $_POST['skills'] : [])), 'strlen'))),
        'type'        => (isset($_POST['billing_type']) && $_POST['billing_type'] === 'hourly') ? 'hourly' : 'fixed',
        'budget'      => (int) (isset($_POST['budget']) ? $_POST['budget'] : 0),
        'rate'        => (int) (isset($_POST['rate']) ? $_POST['rate'] : 0),
        'max_hours'   => (int) (isset($_POST['max_hours']) ? $_POST['max_hours'] : 0),
        'deadline'    => isset($_POST['deadline']) ? $_POST['deadline'] : '',
    ];

    if (mb_strlen($in['title']) < 5)                       { $errors[] = 'Please enter a project title (at least 5 characters).'; }
    if (mb_strlen($in['title']) > 120)                     { $errors[] = 'The project title can be at most 120 characters.'; }
    if ($in['description'] === '')                         { $errors[] = 'Please describe the project.'; }
    if (mb_strlen($in['description']) > 3000)              { $errors[] = 'The description can be at most 3,000 characters.'; }
    if (!in_array($in['category'], $categories, true))     { $errors[] = 'Please choose a category.'; }
    if (!$in['skills'])                                    { $errors[] = 'Add at least one required skill.'; }
    if ($in['type'] === 'fixed') {
        if ($in['budget'] < 1)                             { $errors[] = 'Enter a budget for the Fixed Price project.'; }
    } else {
        if ($in['rate'] < 1)                               { $errors[] = 'Enter an hourly rate.'; }
        if ($in['max_hours'] < 1)                          { $errors[] = 'Enter the maximum hours.'; }
    }
    $d = DateTime::createFromFormat('Y-m-d', $in['deadline']);
    if (!$d || $d->format('Y-m-d') !== $in['deadline']) {
        $errors[] = 'Please choose a deadline.';
    } elseif (!$editing && $in['deadline'] < date('Y-m-d')) {
        $errors[] = 'The deadline must be today or later.';
    }

    $uploads = tt_handle_uploads('attachments');
    $errors  = array_merge($errors, $uploads['errors']);

    $form = $in + ['files' => $editing ? $editing['files'] : []];

    if (!$errors) {
        $record = [
            'title'     => $in['title'],
            'category'  => $in['category'],
            'type'      => $in['type'],
            'budget'    => $in['type'] === 'hourly' ? $in['rate'] * $in['max_hours'] : $in['budget'],
            'rate'      => $in['type'] === 'hourly' ? $in['rate'] : 0,
            'max_hours' => $in['type'] === 'hourly' ? $in['max_hours'] : 0,
            'deadline'  => $in['deadline'],
            'intro'     => $in['description'],
            'skills'    => $in['skills'],
            'files'     => array_merge($editing ? $editing['files'] : [], $uploads['files']),
        ];
        if ($editing) {
            tt_update_saved_project($edit_id, $record);
            tt_flash('Your changes were saved.');
        } else {
            tt_add_saved_project($record);
            tt_flash('Your project was posted. It now appears on your dashboard and in My Projects.');
        }
        header('Location: ' . $base_url . 'client/my-projects.php');
        exit;
    }
}

$is_hourly = $form['type'] === 'hourly';
$max_desc  = 3000;

$page_title = $editing ? 'Edit Project' : 'Post a Project';
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1><?= $editing ? 'Edit Project' : 'Post a Project' ?></h1>
    <p class="subtle">Set your project requirements, billing type, budget and deadline.</p>
  </div>
</div>

<?php if ($errors): ?>
  <div class="form-alert" role="alert" style="margin-top:1.25rem;">
    <?= icon('alert', 15) ?>
    <div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div>
  </div>
<?php endif; ?>

<div class="post-layout">

  <!-- ===================== FORM ===================== -->
  <form class="form-card" method="post" action="post-project.php<?= $editing ? '?id=' . (int) $edit_id : '' ?>" enctype="multipart/form-data">

    <div class="field">
      <label for="title">Project Title <span class="req">*</span></label>
      <input class="input" type="text" id="title" name="title" value="<?= e($form['title']) ?>" placeholder="e.g. Online ordering website for my café" required>
    </div>

    <div class="field">
      <label for="description">Description <span class="req">*</span></label>
      <textarea id="description" name="description" maxlength="<?= $max_desc ?>" rows="5" placeholder="Describe the work, the goals and what you need delivered" required><?= e($form['description']) ?></textarea>
      <span class="char-count" id="desc-count"></span>
    </div>

    <div class="field-row">
      <div class="field">
        <label for="category">Category <span class="req">*</span></label>
        <select class="input" id="category" name="category" required>
          <option value="" disabled <?= $form['category'] === '' ? 'selected' : '' ?>>Choose a category</option>
          <?php foreach ($categories as $c): ?>
            <option value="<?= e($c) ?>" <?= $form['category'] === $c ? 'selected' : '' ?>><?= e($c) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="field">
        <label for="skill-input">Required Skills <span class="req">*</span></label>
        <div class="skill-box" id="skill-box">
          <?php foreach ($form['skills'] as $skill): ?>
            <span class="chip--removable"><?= e($skill) ?><input type="hidden" name="skills[]" value="<?= e($skill) ?>"><button type="button" class="chip-x" aria-label="Remove <?= e($skill) ?>"><?= icon('x', 11) ?></button></span>
          <?php endforeach; ?>
          <input class="skill-input" type="text" id="skill-input" placeholder="Add skill…" autocomplete="off">
        </div>
        <span class="hint"><?= icon('info', 13) ?> Press Enter to add a skill. Skills power the match percentage.</span>
      </div>
    </div>

    <!-- Billing type -->
    <div class="field">
      <label>Billing Type</label>
      <div class="billing-wrap">
        <input type="radio" id="bt-fixed"  name="billing_type" value="fixed"  class="sr-only" <?= !$is_hourly ? 'checked' : '' ?>>
        <input type="radio" id="bt-hourly" name="billing_type" value="hourly" class="sr-only" <?= $is_hourly ? 'checked' : '' ?>>

        <div class="billing-cards">
          <label for="bt-fixed" class="billing-card billing-card--fixed">
            <span class="radio-dot"></span>
            <span>
              <strong>Fixed Price</strong>
              <small>One budget for the whole project. Paid when you approve the work.</small>
            </span>
          </label>
          <label for="bt-hourly" class="billing-card billing-card--hourly">
            <span class="radio-dot"></span>
            <span>
              <strong>Hourly</strong>
              <small>Pay for approved hours. Billed on the deadline (End Date).</small>
            </span>
          </label>
        </div>

        <div class="billing-fields">
          <div class="field f-fixed">
            <label for="budget">Budget (₱) <span class="req">*</span></label>
            <div class="input-prefix">
              <span>₱</span>
              <input class="input" type="number" id="budget" name="budget" min="1" step="1" value="<?= e($form['budget']) ?>" placeholder="0">
            </div>
          </div>

          <div class="f-hourly">
            <div class="field-row">
              <div class="field">
                <label for="hourly-rate">Hourly Rate (₱/hr) <span class="req">*</span></label>
                <div class="input-prefix">
                  <span>₱</span>
                  <input class="input" type="number" id="hourly-rate" name="rate" min="1" step="1" value="<?= e($form['rate']) ?>" placeholder="0">
                </div>
              </div>
              <div class="field">
                <label for="max-hours">Maximum Hours <span class="req">*</span></label>
                <input class="input" type="number" id="max-hours" name="max_hours" min="1" step="1" value="<?= e($form['max_hours']) ?>" placeholder="0">
              </div>
            </div>
            <p class="computed-total" id="hourly-total"></p>
          </div>
        </div>
      </div>
    </div>

    <div class="field">
      <label for="deadline">Deadline <span class="req">*</span></label>
      <input class="input" type="date" id="deadline" name="deadline" value="<?= e($form['deadline']) ?>" min="<?= e(date('Y-m-d')) ?>" required>
    </div>

    <!-- Attachments -->
    <div class="field">
      <label>Attachments <span style="font-weight:500; color:var(--color-muted-gray);">(optional)</span></label>
      <label class="dropzone">
        <?= icon('upload', 22) ?>
        <strong>Drag files here or <a>browse</a></strong>
        <small>PDF, JPG, PNG, DOCX up to 10 MB</small>
        <input type="file" id="attachments" name="attachments[]" multiple accept=".pdf,.jpg,.jpeg,.png,.docx">
      </label>

      <div class="file-list" id="new-files"></div>
      <?php foreach ($form['files'] as $f): ?>
        <div class="file-row">
          <?= icon('file', 15) ?>
          <span><?= e($f['name']) ?></span>
          <span class="file-row__size"><?= e($f['size']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="form-actions">
      <div class="form-actions__buttons">
        <button type="submit" class="btn btn--primary"><?= icon('send', 15) ?> <?= $editing ? 'Save Changes' : 'Post' ?></button>
        <a href="<?= e($base_url) ?>client/my-projects.php" class="btn btn--outline">Cancel</a>
      </div>
      <small>Your project appears in My Projects straight away.</small>
    </div>
  </form>

  <!-- ===================== SIDE ===================== -->
  <aside class="side-stack">
    <div class="tip-card">
      <h2><?= icon('info', 16) ?> Tips</h2>
      <ul>
        <li>Use a clear title freelancers can search for.</li>
        <li>List every required skill. They power the match %.</li>
        <li>Attach samples or references if you have them.</li>
      </ul>
    </div>

    <div class="fee-mini">
      <h2>Service Fee</h2>
      <p>A 10% platform service fee is deducted from the amount released to the freelancer. Fixed Price: on approval. Hourly: on the End Date.</p>
      <a href="<?= e($base_url) ?>pages/pricing.php" class="section-link">See Pricing <?= icon('arrow-right', 14) ?></a>
    </div>

    <div class="info-callout">
      <?= icon('info', 15) ?>
      <span><strong>Simulated payments.</strong> No real money is used. Payments only update the records in the database.</span>
    </div>
  </aside>

</div>

</main>

<?php include '../includes/footer.php'; ?>