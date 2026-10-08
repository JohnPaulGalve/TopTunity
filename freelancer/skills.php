<?php
$page_title = "Manage Skills";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 700px;">
  <div class="card">
    <h2>Skills Manager</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 1.5rem;">Select active skills from the platform list. At least one skill is required to submit project proposals[cite: 8, 9, 70].</p>

    <!-- Add Skill Box -->
    <form action="#" method="POST" style="display: flex; gap: 0.5rem; margin-bottom: 2rem;">
      <select name="new_skill" style="flex: 1; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        <option value="PHP">PHP</option>
        <option value="MySQL">MySQL</option>
        <option value="JavaScript">JavaScript</option>
        <option value="Laravel">Laravel</option>
        <option value="Bootstrap">Bootstrap</option>
        <option value="REST API">REST API</option>
      </select>
      <button type="submit" class="btn-primary">Add Skill</button>
    </form>

    <!-- Interactive Active Skill Tags -->
    <h3>My Active Skills</h3>
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 1rem;">
      <span class="badge" style="background: var(--color-info-bg); color: var(--color-info-text); padding: 0.4rem 0.8rem; font-size: 0.9rem;">
        PHP <a href="#" style="color: var(--color-error-base); font-weight: bold; margin-left: 0.4rem;">×</a>[cite: 9, 70]
      </span>
      <span class="badge" style="background: var(--color-info-bg); color: var(--color-info-text); padding: 0.4rem 0.8rem; font-size: 0.9rem;">
        MySQL <a href="#" style="color: var(--color-error-base); font-weight: bold; margin-left: 0.4rem;">×</a>[cite: 9, 70]
      </span>
      <span class="badge" style="background: var(--color-info-bg); color: var(--color-info-text); padding: 0.4rem 0.8rem; font-size: 0.9rem;">
        JavaScript <a href="#" style="color: var(--color-error-base); font-weight: bold; margin-left: 0.4rem;">×</a>[cite: 9, 70]
      </span>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>