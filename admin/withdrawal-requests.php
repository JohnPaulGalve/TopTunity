<?php
$page_title = "Freelancer Withdrawal Requests";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Withdrawal Requests Approval Panel</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Review and process simulated GCash or Bank payout requests submitted by freelancers[cite: 11, 85].</p>

  <div class="card">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
      <thead>
        <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
          <th style="padding: 0.75rem;">Request ID</th>
          <th style="padding: 0.75rem;">Freelancer Name</th>
          <th style="padding: 0.75rem;">Method</th>
          <th style="padding: 0.75rem;">Account / Mobile</th>
          <th style="padding: 0.75rem;">Requested Amount</th>
          <th style="padding: 0.75rem;">Date</th>
          <th style="padding: 0.75rem;">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr style="border-bottom: 1px solid var(--color-border-gray);">
          <td style="padding: 0.75rem;">#WDR-102</td>
          <td style="padding: 0.75rem;"><strong>Miguel Reyes</strong>[cite: 95]</td>
          <td style="padding: 0.75rem;">GCash</td>
          <td style="padding: 0.75rem;">0917 888 1234</td>
          <td style="padding: 0.75rem; font-weight: bold; color: var(--color-vibrant-teal);">₱10,000</td>
          <td style="padding: 0.75rem;">Oct 07, 2026</td>
          <td style="padding: 0.75rem; display: flex; gap: 0.5rem;">
            <button class="btn-primary" style="padding: 0.2rem 0.5rem; font-size: 0.75rem; background: var(--color-success-base);">Mark Processed</button>[cite: 11, 85]
            <button class="btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.75rem; color: var(--color-error-base);">Reject</button>[cite: 11, 85]
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php include '../includes/footer.php'; ?>