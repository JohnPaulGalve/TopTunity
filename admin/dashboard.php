<?php
$page_title = "Admin Dashboard";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';

// Mock Platform System Stats
$total_users = 148;
$total_projects = 52;
$escrow_volume = "₱340,000";
$revenue_collected = "₱34,000"; // 10% Platform fee total
?>

<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
      <h2>Platform Administrator Dashboard</h2>
      <p style="color: var(--color-muted-gray);">Monitor system analytics, user activity, escrow volume, and platform revenue[cite: 10, 77].</p>
    </div>
    <a href="<?php echo $base_url; ?>admin/reports-generation.php" class="btn-primary">Generate Reports</a>
  </div>

  <!-- Metric Cards -->
  <div class="grid-4" style="margin-bottom: 2rem;">
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Total Registered Users</p>
      <h3 style="font-size: 2rem; color: var(--color-deep-slate);"><?php echo $total_users; ?></h3>
      <a href="<?php echo $base_url; ?>admin/user-management.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">Manage accounts &rarr;</a>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Platform Projects</p>
      <h3 style="font-size: 2rem; color: var(--color-deep-slate);"><?php echo $total_projects; ?></h3>
      <a href="<?php echo $base_url; ?>admin/project-moderation.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">Moderate listings &rarr;</a>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Active Escrow Volume</p>
      <h3 style="font-size: 2rem; color: var(--color-vibrant-teal);"><?php echo $escrow_volume; ?></h3>
      <a href="<?php echo $base_url; ?>admin/payments.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">View payments &rarr;</a>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">10% Fee Commission Collected</p>
      <h3 style="font-size: 2rem; color: var(--color-coral-orange);"><?php echo $revenue_collected; ?></h3>
      <a href="<?php echo $base_url; ?>admin/payments.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">Fee logs &rarr;</a>
    </div>
  </div>

  <!-- Overview Grid -->
  <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem;">
    <main>
      <div class="card" style="margin-bottom: 2rem;">
        <h3>Platform Activity Overview</h3>
        <p style="color: var(--color-muted-gray); font-size: 0.85rem; margin-bottom: 1rem;">Recent contract updates and financial logs[cite: 10, 77].</p>
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
          <thead>
            <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
              <th style="padding: 0.6rem;">Event</th>
              <th style="padding: 0.6rem;">User Account</th>
              <th style="padding: 0.6rem;">Amount</th>
              <th style="padding: 0.6rem;">Date</th>
            </tr>
          </thead>
          <tbody>
            <tr style="border-bottom: 1px solid var(--color-border-gray);">
              <td style="padding: 0.6rem;">Escrow Deposit</td>
              <td style="padding: 0.6rem;">Andrea Santos (Client)[cite: 92]</td>
              <td style="padding: 0.6rem;">₱45,000[cite: 93]</td>
              <td style="padding: 0.6rem;">Oct 01, 2026</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--color-border-gray);">
              <td style="padding: 0.6rem;">10% Fee Commission Recorded</td>
              <td style="padding: 0.6rem;">Miguel Reyes (Freelancer)[cite: 95]</td>
              <td style="padding: 0.6rem; color: var(--color-success-base);">+₱2,500[cite: 92]</td>
              <td style="padding: 0.6rem;">Sep 18, 2026</td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <!-- Admin Action Quick Links -->
    <aside style="display: flex; flex-direction: column; gap: 1rem;">
      <div class="card">
        <h3 style="font-size: 1rem; margin-bottom: 1rem;">Pending Admin Actions</h3>
        <div style="display: flex; flex-direction: column; gap: 0.6rem; font-size: 0.85rem;">
          <a href="<?php echo $base_url; ?>admin/withdrawal-requests.php" style="display: flex; justify-content: space-between; padding: 0.5rem; background: var(--color-off-white); border-radius: 4px;">
            <span>Withdrawal Requests</span>
            <span class="badge badge-warning">2 Pending</span>[cite: 11]
          </a>
          <a href="<?php echo $base_url; ?>admin/dispute-management.php" style="display: flex; justify-content: space-between; padding: 0.5rem; background: var(--color-off-white); border-radius: 4px;">
            <span>Open Disputes</span>
            <span class="badge badge-error">1 Open</span>[cite: 11]
          </a>
          <a href="<?php echo $base_url; ?>admin/reported-content.php" style="display: flex; justify-content: space-between; padding: 0.5rem; background: var(--color-off-white); border-radius: 4px;">
            <span>Flagged Content</span>
            <span class="badge badge-info">3 Reports</span>[cite: 10]
          </a>
        </div>
      </div>
    </aside>
  </div>
</div>

<?php include '../includes/footer.php'; ?>