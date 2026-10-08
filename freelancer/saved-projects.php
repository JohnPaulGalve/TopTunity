<?php
$page_title = "Saved Projects";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Saved Projects</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Bookmarked open project listings you plan to apply for[cite: 9, 71].</p>

  <div style="display: flex; flex-direction: column; gap: 1rem;">
    <!-- Saved Item Card 1 -->
    <div class="card">
      <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
          <span class="badge badge-info">Web Development</span>
          <h3 style="margin: 0.5rem 0;"><a href="<?php echo $base_url; ?>freelancer/project-details.php?id=101">Online Ordering Website for a Coffee Shop</a></h3>
          <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Budget: ₱45,000 • Fixed Price • Posted by Andrea Santos[cite: 91, 92, 93]</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
          <a href="<?php echo $base_url; ?>freelancer/project-details.php?id=101" class="btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Submit Proposal</a>
          <button class="btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; color: var(--color-error-base);">Remove</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>