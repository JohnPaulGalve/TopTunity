<?php
/**
 * client/post-project.php - Post a new project, or edit an open one (?id=N).
 * Form is not wired to a database yet. Submitted projects are reviewed by the administrator.
 */
$user_role     = "client";
$base_url      = "/Webdev/";
$active_client = "post";

require_once __DIR__ . '/../includes/data.php';

$categories = [
    'Web Development', 'Mobile App Development', 'Graphic Design', 'UI/UX Design',
    'Writing and Content', 'Digital Marketing', 'Video and Animation', 'Data Entry and Admin',
];

/* Edit mode: prefill from an existing project */
$edit_id  = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$editing  = $edit_id ? (toptunity_client_projects()[$edit_id] ?? null) : null;
$public   = $editing ? toptunity_client_detail($edit_id) : null;

$form = [
    'title'       => $editing ? $editing['title'] : '',
    'description' => $public  ? $public['intro'] : '',
    'category'    => $public  ? $public['category'] : '',
    'skills'      => $public  ? $public['skills'] : [],
    'type'        => $editing ? $editing['type'] : 'fixed',
    'budget'      => $editing && $editing['type'] === 'fixed' ? $editing['budget'] : '',
    'rate'        => $editing && $editing['type'] === 'hourly' ? $editing['rate'] : '',
    'max_hours'   => $editing && $editing['type'] === 'hourly' ? $editing['max_hours'] : '',
    'deadline'    => $editing ? $editing['deadline'] : '',
    'files'       => $public  ? $public['files'] : [],
];
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

<div class="post-layout">

  <!-- ===================== FORM ===================== -->
  <form class="form-card" method="post" action="" enctype="multipart/form-data">
    <?php if ($editing): ?><input type="hidden" name="project_id" value="<?= (int) $edit_id ?>"><?php endif; ?>

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
      <input class="input" type="date" id="deadline" name="deadline" value="<?= e($form['deadline']) ?>" required>
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
      <small>Published after administrator moderation.</small>
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