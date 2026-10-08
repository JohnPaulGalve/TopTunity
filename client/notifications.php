<?php
$page_title = "Notifications";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h2>Notifications</h2>
    <a href="#" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">Mark all as read</a>
  </div>

  <!-- Notification Category Tabs -->
  <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
    <button class="tab-btn active" style="padding: 0.3rem 0.7rem; font-size: 0.8rem;">All</button>
    <button class="tab-btn" style="padding: 0.3rem 0.7rem; font-size: 0.8rem;">New Proposals</button>
    <button class="tab-btn" style="padding: 0.3rem 0.7rem; font-size: 0.8rem;">Work Submissions</button>
    <button class="tab-btn" style="padding: 0.3rem 0.7rem; font-size: 0.8rem;">Payments</button>
  </div>

  <!-- Notifications List -->
  <div style="display: flex; flex-direction: column; gap: 0.8rem;">
    <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">
      <div>
        <p style="font-size: 0.9rem;"><strong>New Proposal:</strong> Miguel Reyes submitted a proposal for "Online Ordering Website"[cite: 52, 91].</p>
        <small style="color: var(--color-muted-gray);">2 hours ago</small>
      </div>
      <a href="<?php echo $base_url; ?>client/project-tracking.php?id=101" class="btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">View Proposal</a>
    </div>

    <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">
      <div>
        <p style="font-size: 0.9rem;"><strong>Contract Accepted:</strong> Jerome Castillo accepted the contract for "Clinic Website Redesign"[cite: 52, 91].</p>
        <small style="color: var(--color-muted-gray);">1 day ago</small>
      </div>
      <a href="<?php echo $base_url; ?>client/project-tracking.php?id=102" class="btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">Deposit Escrow</a>
    </div>

    <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: var(--color-off-white);">
      <div>
        <p style="font-size: 0.9rem;"><strong>Work Submitted:</strong> Work files uploaded for "Clinic Website Redesign"[cite: 52].</p>
        <small style="color: var(--color-muted-gray);">3 days ago</small>
      </div>
      <a href="<?php echo $base_url; ?>client/project-tracking.php?id=102" class="btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">Review Work</a>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>