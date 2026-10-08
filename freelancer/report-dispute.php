<?php
$page_title = "Report & Dispute";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 700px;">
  <div class="card">
    <h2>Report & File Dispute</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 1.5rem;">Submit client reports or log contract disputes for admin review[cite: 10, 76].</p>

    <form action="#" method="POST">
      <div style="margin-bottom: 1rem;">
        <label style="display: block; font-weight: 600; font-size: 0.9rem;">Select Contract</label>
        <select name="dispute_project" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
          <option value="103">Clinic Inventory Dashboard (Grace Aquino)[cite: 96]</option>
        </select>
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-weight: 600; font-size: 0.9rem;">Reason & Dispute Details</label>
        <textarea name="dispute_details" rows="5" required placeholder="Describe the issue regarding work log approvals or escrow releases..." style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;"></textarea>
      </div>

      <button type="submit" class="btn-primary" style="background: var(--color-error-base);">Submit Dispute to Administrator</button>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>