<?php
$page_title = "Billing & Payments";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Billing & Payments</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Simulated escrow deposits, payments, and transaction records[cite: 6, 7, 50].</p>

  <!-- Financial Summary -->
  <div class="grid-3" style="margin-bottom: 2rem;">
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Held in Escrow</p>
      <h3 style="font-size: 2rem; color: var(--color-vibrant-teal);">₱45,000</h3>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Total Paid</p>
      <h3 style="font-size: 2rem; color: var(--color-deep-slate);">₱18,000</h3>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Refunds Received</p>
      <h3 style="font-size: 2rem; color: var(--color-coral-orange);">₱0</h3>
    </div>
  </div>

  <!-- Transaction History Table -->
  <div class="card">
    <h3 style="margin-bottom: 1rem;">Transaction Receipts</h3>
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
      <thead>
        <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
          <th style="padding: 0.75rem;">Date</th>
          <th style="padding: 0.75rem;">Project</th>
          <th style="padding: 0.75rem;">Type</th>
          <th style="padding: 0.75rem;">Amount</th>
          <th style="padding: 0.75rem;">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr style="border-bottom: 1px solid var(--color-border-gray);">
          <td style="padding: 0.75rem;">Oct 01, 2026</td>
          <td style="padding: 0.75rem;">Coffee Shop Ordering Site</td>
          <td style="padding: 0.75rem;">Deposit (Escrow)</td>
          <td style="padding: 0.75rem;">₱45,000</td>
          <td style="padding: 0.75rem;"><span class="badge badge-warning">Held</span>[cite: 50]</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php include '../includes/footer.php'; ?>