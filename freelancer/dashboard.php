<?php
$page_title = "Freelancer Dashboard";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';

// Mock Freelancer Data
$freelancer_name = "Miguel Reyes";
$active_proposals = 3;
$ongoing_projects = 2;
$available_balance = "₱22,500";
?>

<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
      <h2>Welcome back, <?php echo htmlspecialchars($freelancer_name); ?>!</h2>
      <p style="color: var(--color-muted-gray);">Overview of your active proposals, ongoing contracts, and net earnings balance[cite: 8, 57].</p>
    </div>
    <a href="<?php echo $base_url; ?>freelancer/find-projects.php" class="btn-primary">Find Projects</a>
  </div>

  <!-- Metric Cards Grid -->
  <div class="grid-3" style="margin-bottom: 2rem;">
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Active Proposals</p>
      <h3 style="font-size: 2rem; color: var(--color-deep-slate);"><?php echo $active_proposals; ?></h3>
      <a href="<?php echo $base_url; ?>freelancer/my-proposals.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">Track proposals &rarr;</a>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Ongoing Projects</p>
      <h3 style="font-size: 2rem; color: var(--color-deep-slate);"><?php echo $ongoing_projects; ?></h3>
      <a href="<?php echo $base_url; ?>freelancer/my-projects.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">Manage work &rarr;</a>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Available Balance</p>
      <h3 style="font-size: 2rem; color: var(--color-vibrant-teal);"><?php echo $available_balance; ?></h3>
      <a href="<?php echo $base_url; ?>freelancer/earnings.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">Request withdrawal &rarr;</a>
    </div>
  </div>

  <!-- Dashboard Tables & Feed -->
  <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem;">
    <main>
      <div class="card" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
          <h3>Active Proposal Status</h3>
          <a href="<?php echo $base_url; ?>freelancer/my-proposals.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">View All</a>
        </div>
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
          <thead>
            <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
              <th style="padding: 0.75rem;">Project Title</th>
              <th style="padding: 0.75rem;">Offer</th>
              <th style="padding: 0.75rem;">Status</th>
              <th style="padding: 0.75rem;">Submitted</th>
              <th style="padding: 0.75rem;">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr style="border-bottom: 1px solid var(--color-border-gray);">
              <td style="padding: 0.75rem;"><strong>Coffee Shop Ordering Site</strong></td>
              <td style="padding: 0.75rem;">₱45,000</td>
              <td style="padding: 0.75rem;"><span class="badge badge-warning">Pending</span>[cite: 57]</td>
              <td style="padding: 0.75rem;">Oct 02, 2026</td>
              <td style="padding: 0.75rem;"><a href="<?php echo $base_url; ?>freelancer/my-proposals.php" class="btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">View Offer</a></td>
            </tr>
            <tr style="border-bottom: 1px solid var(--color-border-gray);">
              <td style="padding: 0.75rem;"><strong>Student Enrollment System</strong></td>
              <td style="padding: 0.75rem;">₱500/hr</td>
              <td style="padding: 0.75rem;"><span class="badge badge-success">Selected</span>[cite: 57]</td>
              <td style="padding: 0.75rem;">Oct 01, 2026</td>
              <td style="padding: 0.75rem;"><a href="<?php echo $base_url; ?>freelancer/my-projects.php" class="btn-primary" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">Accept Contract</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <!-- Side Alerts -->
    <aside style="display: flex; flex-direction: column; gap: 1.5rem;">
      <div class="card">
        <h3 style="font-size: 1rem; margin-bottom: 1rem;">Project Alerts</h3>
        <div style="display: flex; flex-direction: column; gap: 0.8rem; font-size: 0.85rem;">
          <div style="border-bottom: 1px solid var(--color-border-gray); padding-bottom: 0.5rem;">
            <p><strong>Contract Offer:</strong> Andrea Santos sent you a contract offer for "Online Ordering Site"[cite: 8, 57].</p>
            <small style="color: var(--color-muted-gray);">1h ago</small>
          </div>
          <div>
            <p><strong>Work Approved:</strong> "Clinic Inventory Dashboard" payment released to balance[cite: 8, 57].</p>
            <small style="color: var(--color-muted-gray);">Yesterday</small>
          </div>
        </div>
      </div>
    </aside>
  </div>
</div>

<?php include '../includes/footer.php'; ?>