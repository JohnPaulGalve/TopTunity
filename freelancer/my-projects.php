<?php
$page_title = "My Projects";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>My Projects & Offers</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Review project offers, perform contract acceptance, and manage ongoing work[cite: 8, 61].</p>

  <!-- Contract Offer Modal Trigger Preview -->
  <div class="card" style="border: 2px solid var(--color-vibrant-teal); background: var(--color-off-white); margin-bottom: 2rem;">
    <span class="badge badge-info">New Contract Offer</span>
    <h3 style="margin: 0.5rem 0;">Student Enrollment System for Tutorial Center</h3>
    <p style="font-size: 0.9rem; color: var(--color-deep-slate); margin-bottom: 1rem;">Client Ramon Villanueva sent you a contract agreement (₱500/hr, Max 80 hrs)[cite: 8, 94].</p>
    <div style="display: flex; gap: 1rem;">
      <a href="<?php echo $base_url; ?>freelancer/project-details.php?id=102" class="btn-primary">Accept Project Contract</a>
      <button class="btn-outline" style="color: var(--color-error-base);">Decline Offer</button>
    </div>
  </div>

  <!-- Active Projects Table -->
  <div class="card">
    <h3 style="margin-bottom: 1rem;">Ongoing Contracts</h3>
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
      <thead>
        <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
          <th style="padding: 0.75rem;">Project Title</th>
          <th style="padding: 0.75rem;">Client</th>
          <th style="padding: 0.75rem;">Type</th>
          <th style="padding: 0.75rem;">Start Date</th>
          <th style="padding: 0.75rem;">Deadline</th>
          <th style="padding: 0.75rem;">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr style="border-bottom: 1px solid var(--color-border-gray);">
          <td style="padding: 0.75rem;"><strong>Clinic Inventory Dashboard</strong></td>
          <td style="padding: 0.75rem;">Grace Aquino[cite: 96]</td>
          <td style="padding: 0.75rem;">Fixed Price</td>
          <td style="padding: 0.75rem;">Sep 10, 2026</td>
          <td style="padding: 0.75rem;">Sep 25, 2026</td>
          <td style="padding: 0.75rem;"><a href="<?php echo $base_url; ?>freelancer/project-details.php?id=103" class="btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">Open Project View</a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php include '../includes/footer.php'; ?>