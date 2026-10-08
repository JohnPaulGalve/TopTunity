<?php
$page_title = "Platform Payments & Escrow Logs";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Payments & Escrow Audit Logs</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Real-time master ledger of simulated escrow deposits, payouts, and platform fee collections[cite: 11, 84].</p>

  <!-- Summary Cards -->
  <div class="grid-3" style="margin-bottom: 2rem;">
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Escrow Funds Currently Held</p>
      <h3 style="font-size: 2rem; color: var(--color-vibrant-teal);">₱340,000</h3>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Total Released Payouts</p>
      <h3 style="font-size: 2rem; color: var(--color-deep-slate);">₱1,280,000</h3>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">10% Platform Revenue Earned</p>
      <h3 style="font-size: 2rem; color: var(--color-coral-orange);">₱128,000</h3>[cite: 12, 92]
    </div>
  </div>

  <!-- Master Payments Table -->
  <div class="card">
    <h3 style="margin-bottom: 1rem;">Transaction Master Ledger</h3>
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
      <thead>
        <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
          <th style="padding: 0.75rem;">TX ID</th>
          <th style="padding: 0.75rem;">Date</th>
          <th style="padding: 0.75rem;">Type</th>
          <th style="padding: 0.75rem;">Client / Freelancer</th>
          <th style="padding: 0.75rem;">Gross</th>
          <th style="padding: 0.75rem;">10% Fee</th>
          <th style="padding: 0.75rem;">Net Amount</th>
          <th style="padding: 0.75rem;">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr style="border-bottom: 1px solid var(--color-border-gray);">
          <td style="padding: 0.75rem;">#TX-9041</td>
          <td style="padding: 0.75rem;">Oct 01, 2026</td>
          <td style="padding: 0.75rem;">Escrow Deposit</td>
          <td style="padding: 0.75rem;">Andrea Santos[cite: 92]</td>
          <td style="padding: 0.75rem;">₱45,000[cite: 93]</td>
          <td style="padding: 0.75rem;">--</td>
          <td style="padding: 0.75rem;">₱45,000</td>
          <td style="padding: 0.75rem;"><span class="badge badge-warning">Held in Escrow</span>[cite: 50]</td>
        </tr>
        <tr style="border-bottom: 1px solid var(--color-border-gray);">
          <td style="padding: 0.75rem;">#TX-8820</td>
          <td style="padding: 0.75rem;">Sep 18, 2026</td>
          <td style="padding: 0.75rem;">Project Payout</td>
          <td style="padding: 0.75rem;">Miguel Reyes[cite: 95]</td>
          <td style="padding: 0.75rem;">₱25,000</td>
          <td style="padding: 0.75rem; color: var(--color-error-base);">-₱2,500[cite: 92]</td>
          <td style="padding: 0.75rem; font-weight: bold; color: var(--color-success-base);">₱22,500</td>
          <td style="padding: 0.75rem;"><span class="badge badge-success">Completed</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php include '../includes/footer.php'; ?>