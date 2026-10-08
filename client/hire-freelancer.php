<?php
$page_title = "Hire Freelancer";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 700px;">
  <div class="card">
    <h2>Hire Freelancer</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 1.5rem;">Select an open project to invite Miguel Reyes[cite: 6, 49].</p>

    <form action="/client/project-tracking.php" method="GET">
      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.5rem;">Select Open Project</label>
        <div style="display: flex; flex-direction: column; gap: 0.8rem;">
          <label style="border: 1px solid var(--color-border-gray); padding: 0.8rem; border-radius: 4px; display: block; cursor: pointer;">
            <input type="radio" name="project_id" value="101" checked>
            <strong>Online Ordering Website for a Coffee Shop</strong>
            <p style="font-size: 0.8rem; color: var(--color-muted-gray);">Fixed Price • Budget: ₱45,000[cite: 91, 93]</p>
          </label>
        </div>
      </div>

      <button type="submit" class="btn-primary" style="width: 100%;">Continue to Contract &rarr;</button>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>