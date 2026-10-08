<?php
$page_title = "Admin Notifications";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <h2>System Notifications</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 1.5rem;">Critical platform alerts regarding dispute filings, flag reports, and pending withdrawals[cite: 11, 87].</p>

  <div style="display: flex; flex-direction: column; gap: 0.8rem;">
    <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">
      <div>
        <p style="font-size: 0.9rem;"><strong>New Dispute Filed:</strong> Dispute #DSP-2026-08 was filed on "Clinic Inventory Dashboard"[cite: 83, 87, 96].</p>
        <small style="color: var(--color-muted-gray);">Yesterday</small>
      </div>
      <a href="<?php echo $base_url; ?>admin/dispute-management.php" class="btn-primary" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">Arbitrate</a>
    </div>

    <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">
      <div>
        <p style="font-size: 0.9rem;"><strong>Pending Withdrawal:</strong> Miguel Reyes requested a ₱10,000 withdrawal to GCash[cite: 85, 87, 95].</p>
        <small style="color: var(--color-muted-gray);">Yesterday</small>
      </div>
      <a href="<?php echo $base_url; ?>admin/withdrawal-requests.php" class="btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">Review Request</a>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>