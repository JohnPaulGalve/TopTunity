<?php
$page_title = "Manage Skills & Categories";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Skills & Project Categories CRUD</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Manage category names and active skill tags available across the platform[cite: 11, 82].</p>

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <!-- Manage Categories -->
    <div class="card">
      <h3>Project Categories</h3>
      <form action="#" method="POST" style="display: flex; gap: 0.5rem; margin: 1rem 0;">
        <input type="text" placeholder="New Category Name" required style="flex: 1; padding: 0.5rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        <button type="submit" class="btn-primary">Add Category</button>
      </form>

      <ul style="list-style: none; line-height: 2; font-size: 0.9rem;">
        <li style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--color-border-gray); padding: 0.4rem 0;">
          <span>Web Development</span>
          <button style="color: var(--color-error-base); border: none; background: none; cursor: pointer;">Delete</button>
        </li>
        <li style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--color-border-gray); padding: 0.4rem 0;">
          <span>Mobile App Development</span>
          <button style="color: var(--color-error-base); border: none; background: none; cursor: pointer;">Delete</button>
        </li>
      </ul>
    </div>

    <!-- Manage Skills -->
    <div class="card">
      <h3>Platform Skill Master Tags</h3>
      <form action="#" method="POST" style="display: flex; gap: 0.5rem; margin: 1rem 0;">
        <input type="text" placeholder="New Skill Tag (e.g. React)" required style="flex: 1; padding: 0.5rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        <button type="submit" class="btn-primary">Add Skill Tag</button>
      </form>

      <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
        <span class="badge" style="background: var(--color-off-white); border: 1px solid var(--color-border-gray);">PHP ×</span>
        <span class="badge" style="background: var(--color-off-white); border: 1px solid var(--color-border-gray);">MySQL ×</span>
        <span class="badge" style="background: var(--color-off-white); border: 1px solid var(--color-border-gray);">JavaScript ×</span>
        <span class="badge" style="background: var(--color-off-white); border: 1px solid var(--color-border-gray);">Figma ×</span>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>