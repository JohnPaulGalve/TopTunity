<?php
$page_title = "Earnings & Withdrawals";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';

// Mock Financial Balances
$available_balance = "₱22,500";
$net_earnings = "₱40,500";
$fee_deductions = "₱4,500";
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Earnings & Withdrawals</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">View net earnings breakdown and submit simulated payout requests[cite: 9, 65].</p>

  <!-- Financial Cards -->
  <div class="grid-3" style="margin-bottom: 2rem;">
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Available Balance</p>
      <h3 style="font-size: 2rem; color: var(--color-vibrant-teal);"><?php echo $available_balance; ?></h3>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Net Lifetime Earnings</p>
      <h3 style="font-size: 2rem; color: var(--color-deep-slate);"><?php echo $net_earnings; ?></h3>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">10% Platform Service Fee Deducted</p>
      <h3 style="font-size: 2rem; color: var(--color-error-base);"><?php echo $fee_deductions; ?></h3>
    </div>
  </div>

  <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem;">
    <main>
      <!-- Payments Table -->
      <div class="card" style="margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1rem;">Completed Project Payments</h3>
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
          <thead>
            <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
              <th style="padding: 0.6rem;">Date</th>
              <th style="padding: 0.6rem;">Project</th>
              <th style="padding: 0.6rem;">Gross Payment</th>
              <th style="padding: 0.6rem;">10% Service Fee</th>
              <th style="padding: 0.6rem;">Net Payout</th>
            </tr>
          </thead>
          <tbody>
            <tr style="border-bottom: 1px solid var(--color-border-gray);">
              <td style="padding: 0.6rem;">Sep 18, 2026</td>
              <td style="padding: 0.6rem;">Clinic Inventory Dashboard[cite: 96]</td>
              <td style="padding: 0.6rem;">₱25,000</td>
              <td style="padding: 0.6rem; color: var(--color-error-base);">-₱2,500</td>
              <td style="padding: 0.6rem; font-weight: bold; color: var(--color-success-base);">₱22,500</td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <!-- Withdrawal Request Form -->
    <aside class="card">
      <h3>Request Withdrawal</h3>
      <p style="font-size: 0.8rem; color: var(--color-muted-gray); margin-bottom: 1rem;">Simulated withdrawal to GCash or Bank account[cite: 9, 65].</p>

      <form action="#" method="POST">
        <div style="margin-bottom: 1rem;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600;">Amount (₱)</label>
          <input type="number" name="withdrawal_amount" max="22500" placeholder="10000" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>

        <div style="margin-bottom: 1rem;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600;">Method</label>
          <select name="payout_method" style="width: 100%; padding: 0.5rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
            <option value="gcash">GCash Digital Wallet</option>
            <option value="bank">Bank Transfer (BDO/BPI)</option>
          </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
          <label style="display: block; font-size: 0.85rem; font-weight: 600;">Account Number / Mobile</label>
          <input type="text" name="account_details" placeholder="0917XXXXXXX" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>

        <button type="submit" class="btn-primary" style="width: 100%;">Request Withdrawal</button>
      </form>
    </aside>
  </div>
</div>

<?php include '../includes/footer.php'; ?>