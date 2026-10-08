<?php
$page_title = "My Posted Projects";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
      <h2>My Projects</h2>
      <p style="color: var(--color-muted-gray);">Manage and track all your posted projects[cite: 5, 41].</p>
    </div>
    <a href="<?php echo $base_url; ?>client/post-project.php" class="btn-primary">+ Post a Project</a>
  </div>

  <!-- Filter Status Tabs -->
  <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
    <button class="tab-btn active" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">All</button>
    <button class="tab-btn" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Open</button>
    <button class="tab-btn" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Ongoing</button>
    <button class="tab-btn" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Overdue</button>
    <button class="tab-btn" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Completed</button>
  </div>

  <!-- Projects List Cards -->
  <div style="display: flex; flex-direction: column; gap: 1rem;">
    <!-- Project Card 1: Open -->
    <div class="card">
      <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
          <span class="badge badge-info">Open</span>
          <h3 style="margin: 0.5rem 0;">Online Ordering Website for a Coffee Shop</h3>
          <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Budget: ₱45,000 • Fixed Price • Deadline: Nov 20, 2026 • 12 Proposals[cite: 91, 93]</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
          <a href="#" class="btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.85rem;">Edit</a>
          <a href="<?php echo $base_url; ?>client/project-tracking.php?id=101" class="btn-primary" style="padding: 0.3rem 0.6rem; font-size: 0.85rem;">View Proposals</a>
        </div>
      </div>
    </div>

    <!-- Project Card 2: Ongoing -->
    <div class="card">
      <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
          <span class="badge badge-success">Ongoing</span>
          <h3 style="margin: 0.5rem 0;">Clinic Website Redesign in Figma</h3>
          <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Budget: ₱18,000 • Fixed Price • Deadline: Nov 15, 2026 • Freelancer: Jerome Castillo[cite: 91]</p>
        </div>
        <a href="<?php echo $base_url; ?>client/project-tracking.php?id=102" class="btn-primary" style="padding: 0.3rem 0.6rem; font-size: 0.85rem;">Project Tracking</a>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>