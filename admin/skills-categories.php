<?php
/**
 * admin/skills-categories.php - Manage the skills freelancers can add and the project categories (matches the design).
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "skills";

require_once __DIR__ . '/../includes/data.php';

$catalog = toptunity_skill_catalog();
if (tt_is_demo_admin()) {
    $demo_catalog = tt_demo_admin_catalog_state();
    $skill_rows = array_map(static function ($name) {
        return ['name' => $name, 'count' => 0];
    }, array_keys($demo_catalog['skills']));
    $categories = array_map(static function ($name) {
        return ['name' => $name, 'count' => 0];
    }, $demo_catalog['categories']);
} else {
    $skill_rows = db()->query('SELECT s.name, COUNT(DISTINCT fs.freelancer_id) AS count
                               FROM skills s LEFT JOIN freelancer_skills fs ON fs.skill_id = s.id
                               GROUP BY s.id, s.name ORDER BY s.name')->fetchAll();
    $categories = db()->query('SELECT c.name, COUNT(DISTINCT p.id) AS count
                               FROM categories c LEFT JOIN projects p ON p.category_id = c.id
                               GROUP BY c.id, c.name ORDER BY c.name')->fetchAll();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['catalog_action'] ?? 'add');
    $kind = (string) ($_POST['kind'] ?? 'skill');
    $name = trim((string) ($_POST['name'] ?? ''));
    $error = tt_admin_catalog_change($action, $kind, $name, (string) ($_POST['new_name'] ?? ''));
    if ($error) { $errors[] = $error; }
    else {
        tt_flash(ucfirst($kind) . ' ' . ($action === 'remove' ? 'removed.' : ($action === 'rename' ? 'renamed.' : 'added.')));
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

<div class="catalog-grid">
  <section class="box catalog-panel">
    <div class="box-head"><h2>Skills</h2><span class="muted"><?= count($skill_rows) ?> shown</span></div>
    <form method="post" action="skills-categories.php" class="catalog-add">
      <input type="hidden" name="catalog_action" value="add">
      <input type="hidden" name="kind" value="skill">
      <div class="field catalog-add__field">
        <input class="input" name="name" minlength="2" maxlength="80" placeholder="New skill name" aria-label="New skill name">
      </div>
      <button type="submit" class="btn btn--primary"><?= icon('plus', 14) ?> Add Skill</button>
    </form>
    <div class="catalog-list">
      <?php foreach ($skill_rows as $s): ?>
        <div class="catalog-row">
          <div class="catalog-row__main">
            <span class="chip catalog-skill-chip"><?= e($s['name']) ?></span>
            <small class="muted"><?= (int) $s['count'] ?> freelancers</small>
          </div>
          <div class="catalog-row__actions">
            <details class="catalog-edit">
              <summary><?= icon('edit', 12) ?> Edit</summary>
              <form method="post" action="skills-categories.php" class="catalog-edit__form">
                <input type="hidden" name="catalog_action" value="rename">
                <input type="hidden" name="kind" value="skill">
                <input type="hidden" name="name" value="<?= e($s['name']) ?>">
                <div class="field">
                  <input class="input" name="new_name" value="<?= e($s['name']) ?>" minlength="2" maxlength="80" aria-label="Rename skill <?= e($s['name']) ?>">
                </div>
                <button type="submit" class="catalog-save">Save</button>
              </form>
            </details>
            <form method="post" action="skills-categories.php" onsubmit="return confirm('Remove this skill and its freelancer/project associations?');">
              <input type="hidden" name="catalog_action" value="remove">
              <input type="hidden" name="kind" value="skill">
              <input type="hidden" name="name" value="<?= e($s['name']) ?>">
              <button type="submit" class="catalog-remove"><?= icon('x-circle', 12) ?> Remove</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="box catalog-panel">
    <div class="box-head"><h2>Categories</h2><span class="muted"><?= count($categories) ?> shown</span></div>
    <form method="post" action="skills-categories.php" class="catalog-add">
      <input type="hidden" name="catalog_action" value="add">
      <input type="hidden" name="kind" value="category">
      <div class="field catalog-add__field">
        <input class="input" name="name" minlength="2" maxlength="120" placeholder="New category name" aria-label="New category name">
      </div>
      <button type="submit" class="btn btn--primary"><?= icon('plus', 14) ?> Add Category</button>
    </form>
    <div class="catalog-list">
      <?php foreach ($categories as $c): $category_icons = ['Web Development' => 'code', 'Mobile App Development' => 'smartphone', 'Graphic Design' => 'pen-tool', 'UI/UX Design' => 'frame', 'Writing and Content' => 'clipboard', 'Digital Marketing' => 'megaphone', 'Video and Animation' => 'video']; $category_icon = $category_icons[$c['name']] ?? 'code'; ?>
        <div class="catalog-row">
          <div class="catalog-row__main catalog-row__main--category">
            <span class="icon-box icon-box--teal catalog-category-icon"><?= icon($category_icon, 14) ?></span>
            <strong><?= e($c['name']) ?></strong>
            <small class="muted"><?= (int) $c['count'] ?> projects</small>
          </div>
          <div class="catalog-row__actions">
            <details class="catalog-edit">
              <summary><?= icon('edit', 12) ?> Edit</summary>
              <form method="post" action="skills-categories.php" class="catalog-edit__form">
                <input type="hidden" name="catalog_action" value="rename">
                <input type="hidden" name="kind" value="category">
                <input type="hidden" name="name" value="<?= e($c['name']) ?>">
                <div class="field">
                  <input class="input" name="new_name" value="<?= e($c['name']) ?>" minlength="2" maxlength="120" aria-label="Rename category <?= e($c['name']) ?>">
                </div>
                <button type="submit" class="catalog-save">Save</button>
              </form>
            </details>
            <form method="post" action="skills-categories.php" onsubmit="return confirm('Remove this category? Projects and skills using it will become uncategorized.');">
              <input type="hidden" name="catalog_action" value="remove">
              <input type="hidden" name="kind" value="category">
              <input type="hidden" name="name" value="<?= e($c['name']) ?>">
              <button type="submit" class="catalog-remove"><?= icon('x-circle', 12) ?> Remove</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</div>

</main>

<?php include '../includes/footer.php'; ?>