<?php
$page_title = "Dispute Management";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Dispute Resolution Engine</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Arbitrate open project disputes and determine escrow fund allocation[cite: 11, 83].</p>

  <div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <!-- Active Dispute Case Card -->
    <div class="card" style="border-left: 4px solid var(--color-warning-base);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
        <div>
          <span class="badge badge-warning">Under Review</span>[cite: 83]
          <h3 style="margin: 0.5rem 0;">Dispute Case #DSP-2026-08</h3>
          <p style="font-size: 0.85rem; color: var(--color-muted-gray);">
            Project: <strong>Clinic Inventory Dashboard</strong> • Escrow Funds: <strong>₱25,000</strong>[cite: 83, 96]
          </p>
          <p style="font-size: 0.85rem; color: var(--color-muted-gray);">
            Client: Andrea Santos • Freelancer: Miguel Reyes[cite: 92, 95]
          </p>
        </div>
        <small style="color: var(--color-muted-gray);">Filed Oct 06, 2026</small>
      </div>

      <div style="background: var(--color-off-white); padding: 1rem; border-radius: 4px; border: 1px solid var(--color-border-gray); margin-bottom: 1.5rem; font-size: 0.9rem;">
        <strong>Dispute Summary from Client:</strong>
        <p style="margin-top: 0.3rem; color: var(--color-deep-slate);">
          "The exported CSV inventory feature was missing two required columns mentioned in our initial message thread."[cite: 83]
        </p>
      </div>

      <!-- Resolution Action Engine -->
      <div style="border-top: 1px solid var(--color-border-gray); padding-top: 1rem;">
        <h4 style="font-size: 0.95rem; margin-bottom: 0.8rem;">Administrator Resolution Action:</h4>
        <form action="#" method="POST" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
          <select name="resolution_decision" style="padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px; font-size: 0.85rem;">
            <option value="release_freelancer">Release 100% Escrow to Freelancer (₱22,500 Net)</option>[cite: 11, 83]
            <option value="refund_client">Full Refund to Client (₱25,000)</option>[cite: 11, 83]
            <option value="split_5050">50 / 50 Split Resolution</option>[cite: 11, 83]
          </select>
          <button type="submit" class="btn-primary" style="padding: 0.6rem 1.2rem; font-size: 0.85rem;">Execute Settlement</button>[cite: 11, 83]
        </form>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>