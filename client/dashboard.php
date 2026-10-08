<?php
$page_title = "Client Dashboard";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';

// Mock Client Data
$client_name = "Andrea Santos";
$posted_count = 4;
$proposals_count = 12;
$ongoing_count = 2;
$pending_payments = "₱18,000";
?>

<div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
      <h2>Welcome back, <?php echo htmlspecialchars($client_name); ?>!</h2>
      <p style="color: var(--color-muted-gray);">Overview of your posted projects, received proposals, and account activity[cite: 5, 39].</p>
    </div>
    <a href="<?php echo $base_url; ?>client/post-project.php" class="btn-primary">+ Post a Project</a>
  </div>

  <!-- Metric Cards Grid -->
  <div class="grid-4" style="margin-bottom: 2rem;">
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Posted Projects</p>
      <h3 style="font-size: 2rem; color: var(--color-deep-slate);"><?php echo $posted_count; ?></h3>
      <a href="<?php echo $base_url; ?>client/my-projects.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">View all &rarr;</a>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Proposals Received</p>
      <h3 style="font-size: 2rem; color: var(--color-deep-slate);"><?php echo $proposals_count; ?></h3>
      <a href="<?php echo $base_url; ?>client/my-projects.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">Review proposals &rarr;</a>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Ongoing Projects</p>
      <h3 style="font-size: 2rem; color: var(--color-deep-slate);"><?php echo $ongoing_count; ?></h3>
      <a href="<?php echo $base_url; ?>client/my-projects.php?status=ongoing" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">Track progress &rarr;</a>
    </div>
    <div class="card">
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Pending Payments</p>
      <h3 style="font-size: 2rem; color: var(--color-coral-orange);"><?php echo $pending_payments; ?></h3>
      <a href="<?php echo $base_url; ?>client/billing.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">Go to Billing &rarr;</a>
    </div>
  </div>

  <!-- Dashboard Tables & Feed Layout -->
  <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem;">
    <main>
      <div class="card" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
          <h3>Posted Projects Overview</h3>
          <a href="<?php echo $base_url; ?>client/my-projects.php" style="font-size: 0.85rem; color: var(--color-vibrant-teal);">View All</a>
        </div>
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
          <thead>
            <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
              <th style="padding: 0.75rem;">Project Title</th>
              <th style="padding: 0.75rem;">Billing</th>
              <th style="padding: 0.75rem;">Status</th>
              <th style="padding: 0.75rem;">Deadline</th>
              <th style="padding: 0.75rem;">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr style="border-bottom: 1px solid var(--color-border-gray);">
              <td style="padding: 0.75rem;"><strong>Coffee Shop Ordering Site</strong></td>
              <td style="padding: 0.75rem;">Fixed</td>
              <td style="padding: 0.75rem;"><span class="badge badge-info">Open</span></td>
              <td style="padding: 0.75rem;">Nov 20, 2026[cite: 91]</td>
              <td style="padding: 0.75rem;"><a href="<?php echo $base_url; ?>client/project-tracking.php?id=1" class="btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">Manage</a></td>
            </tr>
            <tr style="border-bottom: 1px solid var(--color-border-gray);">
              <td style="padding: 0.75rem;"><strong>Clinic Website Redesign</strong></td>
              <td style="padding: 0.75rem;">Fixed</td>
              <td style="padding: 0.75rem;"><span class="badge badge-success">Ongoing</span></td>
              <td style="padding: 0.75rem;">Nov 15, 2026[cite: 91]</td>
              <td style="padding: 0.75rem;"><a href="<?php echo $base_url; ?>client/project-tracking.php?id=2" class="btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">Track</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <!-- Side Panel -->
    <aside style="display: flex; flex-direction: column; gap: 1.5rem;">
      <div class="card">
        <h3 style="font-size: 1rem; margin-bottom: 1rem;">Recent Notifications</h3>
        <div style="display: flex; flex-direction: column; gap: 0.8rem; font-size: 0.85rem;">
          <div style="border-bottom: 1px solid var(--color-border-gray); padding-bottom: 0.5rem;">
            <p><strong>New Proposal:</strong> Miguel Reyes submitted an offer on Coffee Shop Ordering Site[cite: 39].</p>
            <small style="color: var(--color-muted-gray);">2h ago</small>
          </div>
          <div>
            <p><strong>Hours Logged:</strong> Work log updated for Student Enrollment System[cite: 39].</p>
            <small style="color: var(--color-muted-gray);">5h ago</small>
          </div>
        </div>
      </div>
    </aside>
  </div>
</div>

<?php include '../includes/footer.php'; ?>