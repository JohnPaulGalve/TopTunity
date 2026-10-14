<?php
/**
 * admin/skills-categories.php - Manage the skills freelancers can add and the project categories (matches the design).
 * Adding, editing and removing are not saved to a database yet.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "skills";

require_once __DIR__ . '/../includes/data.php';

$catalog = toptunity_skill_catalog();
$freelancers = toptunity_freelancers();
$design_counts = ['PHP' => 214, 'MySQL' => 198, 'JavaScript' => 305, 'Laravel' => 96, 'Figma' => 122, 'Flutter' => 87, 'Copywriting' => 173];
$skill_rows = [];
foreach ($catalog as $name => $cat) {
    $n = 0;
    foreach ($freelancers as $f) { if (in_array($name, $f['skills'], true)) { $n++; } }
    $skill_rows[] = ['name' => $name, 'count' => isset($design_counts[$name]) ? $design_counts[$name] : $n];
}
$skill_rows = array_slice($skill_rows, 0, 7);

$categories = [
    ['Web Development', 'code', 'teal'], ['Mobile App Development', 'smartphone', 'teal'], ['Graphic Design', 'pen-tool', 'teal'],
    ['UI/UX Design', 'frame', 'teal'], ['Writing and Content', 'clipboard', 'teal'], ['Digital Marketing', 'megaphone', 'teal'],
    ['Video and Animation', 'video', 'teal'],
];
$public = toptunity_listing();
$cat_counts = [];
foreach ($public as $p) { $cat_counts[$p['category']] = ($cat_counts[$p['category']] ?? 0) + 1; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $what = isset($_POST['what']) && $_POST['what'] === 'category' ? 'category' : 'skill';
    $name = trim(isset($_POST['name']) ? $_POST['name'] : '');
    if (mb_strlen($name) < 2 || mb_strlen($name) > 40) { $errors[] = 'Enter a ' . $what . ' name between 2 and 40 characters.'; }
    if (!$errors) {
        tt_flash(ucfirst($what) . ' "' . $name . '" was added (simulated).');
        header('Location: ' . $base_url . 'admin/skills-categories.php');
        exit;
    }
}

$page_title = "Skills and Categories";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Skills and Categories Management</h1>
    <p class="subtle">Skills are the basis of the freelancer matching feature.</p>
  </div>
</div>

<?php if ($errors): ?>
  <div class="form-alert" role="alert" style="margin-top:1.25rem;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
<?php endif; ?>

<div class="two-col" style="margin-top:1.25rem; grid-template-columns:1fr 1fr;">
  <section class="box" style="margin-top:0;">
    <div class="box-head"><h2>Skills</h2><span class="muted"><?= count($skill_rows) ?> shown</span></div>
    <form method="post" action="skills-categories.php" style="display:flex; gap:0.5rem; margin-bottom:0.8rem;">
      <input type="hidden" name="what" value="skill">
      <input class="input" name="name" placeholder="New skill name" style="flex:1; height:40px;">
      <button type="submit" class="btn btn--primary" style="height:40px;"><?= icon('plus', 14) ?> Add Skill</button>
    </form>
    <?php foreach ($skill_rows as $s): ?>
      <div class="kv" style="align-items:center;">
        <span><span class="chip" style="background:var(--color-teal-tint); color:var(--color-teal-dark); border-color:#CDEBE7;"><?= e($s['name']) ?></span></span>
        <span style="display:flex; gap:0.7rem; align-items:center;">
          <small class="muted"><?= (int) $s['count'] ?> freelancers</small>
          <a href="#" class="view" style="font-size:0.72rem;"><?= icon('edit', 12) ?> Edit</a>
          <a href="#" style="color:var(--color-error-base); font-size:0.72rem; font-weight:600;"><?= icon('x-circle', 12) ?> Remove</a>
        </span>
      </div>
    <?php endforeach; ?>
  </section>

  <section class="box" style="margin-top:0;">
    <div class="box-head"><h2>Categories</h2><span class="muted"><?= count($categories) ?> shown</span></div>
    <form method="post" action="skills-categories.php" style="display:flex; gap:0.5rem; margin-bottom:0.8rem;">
      <input type="hidden" name="what" value="category">
      <input class="input" name="name" placeholder="New category name" style="flex:1; height:40px;">
      <button type="submit" class="btn btn--primary" style="height:40px;"><?= icon('plus', 14) ?> Add Category</button>
    </form>
    <?php foreach ($categories as $c): $n = $cat_counts[$c[0]] ?? 0; ?>
      <div class="kv" style="align-items:center;">
        <span style="display:flex; align-items:center; gap:0.6rem;"><span class="icon-box icon-box--teal" style="width:28px; height:28px;"><?= icon($c[1], 14) ?></span><strong style="font-size:0.8rem; color:var(--color-deep-slate);"><?= e($c[0]) ?></strong></span>
        <span style="display:flex; gap:0.7rem; align-items:center;">
          <small class="muted"><?= (int) $n ?> projects</small>
          <a href="#" class="view" style="font-size:0.72rem;"><?= icon('edit', 12) ?> Edit</a>
          <a href="#" style="color:var(--color-error-base); font-size:0.72rem; font-weight:600;"><?= icon('x-circle', 12) ?> Remove</a>
        </span>
      </div>
    <?php endforeach; ?>
  </section>
</div>

</main>

<?php include '../includes/footer.php'; ?>