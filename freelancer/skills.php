<?php
/**
 * freelancer/skills.php - Your skills (matches the Skills design). Skills come from the admin's list.
 * Saving is not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "";

require_once __DIR__ . '/../includes/data.php';

$catalog = toptunity_skill_catalog();
$mine    = tt_is_demo_freelancer() ? toptunity_freelancer(1)['skills'] : [];
if (tt_freelancer_saved_skills() !== null) { $mine = tt_freelancer_saved_skills(); }
$errors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chosen = array_values(array_unique(array_filter(array_map('trim', (array) (isset($_POST['skills']) ? $_POST['skills'] : [])), 'strlen')));
    $bad    = array_filter($chosen, function ($s) use ($catalog) { return !isset($catalog[$s]); });
    if (!$chosen)     { $errors[] = 'Add at least one skill. Skills are required before you can submit proposals.'; }
    if ($bad)         { $errors[] = 'These skills are not in the list: ' . implode(', ', $bad) . '.'; }
    $mine = $chosen;
    if (!$errors) {
        tt_save_freelancer_skills($chosen);
        tt_flash('Your skills were saved.');
        header('Location: ' . $base_url . 'freelancer/skills.php');
        exit;
    }
}

$page_title = "Skills";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>Skills</h1>
    <p class="subtle">Add skills from the list set by the administrator. These are used to match you with projects.</p>
  </div>
</div>

<?php if ($errors): ?>
  <div class="form-alert" role="alert" style="margin-top:1.25rem;"><?= icon('alert', 15) ?><div><?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?></div></div>
<?php endif; ?>

<div class="two-col" style="margin-top:1.25rem;">
  <section class="box" style="margin-top:0;">
    <h2>Add Skills</h2>
    <form method="post" action="skills.php" style="margin-top:0.8rem;">
      <div class="skill-box" id="skill-box">
        <?php foreach ($mine as $s): ?>
          <span class="chip--removable"><?= e($s) ?><input type="hidden" name="skills[]" value="<?= e($s) ?>"><button type="button" class="chip-x" aria-label="Remove <?= e($s) ?>"><?= icon('x', 11) ?></button></span>
        <?php endforeach; ?>
        <input class="skill-input" type="text" id="skill-input" list="skill-list" placeholder="Search a skill, e.g. Laravel…" autocomplete="off">
      </div>
      <datalist id="skill-list">
        <?php foreach ($catalog as $name => $cat): ?><option value="<?= e($name) ?>"><?= e($cat) ?></option><?php endforeach; ?>
      </datalist>
      <span class="hint"><?= icon('info', 13) ?> Press Enter to add a skill. Only skills in the list can be added.</span>

      <div class="form-actions--plain"><button type="submit" class="btn btn--primary">Save Skills</button></div>

      <p class="section-tag" style="margin-top:1.4rem;">My Skills (<?= count($mine) ?>)</p>
    </form>
  </section>

  <aside class="tip-card" style="margin-top:0;">
    <h2><?= icon('info', 16) ?> Note</h2>
    <ul>
      <li>At least one skill is required before submitting proposals.</li>
      <li>Click × to remove a skill.</li>
      <li>Your skills power the match % on Recommended Projects.</li>
    </ul>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>