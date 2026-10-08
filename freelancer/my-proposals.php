<?php
$page_title = "My Proposals";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>My Proposals</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Track submitted project proposals and contract offers[cite: 8, 60].</p>

  <!-- Filter Status Tabs -->
  <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem;">
    <button class="tab-btn active" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">All</button>
    <button class="tab-btn" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Pending</button>
    <button class="tab-btn" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Selected</button>
    <button class="tab-btn" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Not Selected</button>
    <button class="tab-btn" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Withdrawn</button>
  </div>

  <!-- Proposal List Feed -->
  <div style="display: flex; flex-direction: column; gap: 1rem;">
    <div class="card">
      <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
          <span class="badge badge-warning">Pending</span>[cite: 60]
          <h3 style="margin: 0.5rem 0;">Online Ordering Website for a Coffee Shop</h3>
          <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Offer: ₱45,000 • Estimated Time: 14 days • Submitted Oct 02, 2026[cite: 60, 93]</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
          <a href="<?php echo $base_url; ?>freelancer/messages.php" class="btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.85rem;">Message Client</a>
          <button class="btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.85rem; color: var(--color-error-base);">Withdraw</button>
        </div>
      </div>
    </div>

    <div class="card">
      <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
          <span class="badge badge-success">Selected</span>[cite: 60]
          <h3 style="margin: 0.5rem 0;">Student Enrollment System for Tutorial Center</h3>
          <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Offer: ₱500/hr • Max 80 hrs • Submitted Oct 01, 2026[cite: 60, 94]</p>
        </div>
        <a href="<?php echo $base_url; ?>freelancer/my-projects.php" class="btn-primary" style="padding: 0.3rem 0.6rem; font-size: 0.85rem;">Review & Accept Contract Offer</a>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>