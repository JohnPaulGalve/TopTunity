<?php
$page_title = "Project Moderation";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>Project Moderation</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Global directory of all platform project listings with administrative override capabilities[cite: 10, 11, 81].</p>

  <div class="card">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
      <thead>
        <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
          <th style="padding: 0.75rem;">ID</th>
          <th style="padding: 0.75rem;">Project Title</th>
          <th style="padding: 0.75rem;">Client</th>
          <th style="padding: 0.75rem;">Billing</th>
          <th style="padding: 0.75rem;">Budget</th>
          <th style="padding: 0.75rem;">Status</th>
          <th style="padding: 0.75rem;">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr style="border-bottom: 1px solid var(--color-border-gray);">
          <td style="padding: 0.75rem;">101</td>
          <td style="padding: 0.75rem;"><strong>Online Ordering Website for a Coffee Shop</strong></td>
          <td style="padding: 0.75rem;">Andrea Santos[cite: 92]</td>
          <td style="padding: 0.75rem;">Fixed</td>
          <td style="padding: 0.75rem;">₱45,000[cite: 93]</td>
          <td style="padding: 0.75rem;"><span class="badge badge-info">Open</span></td>
          <td style="padding: 0.75rem;">
            <button class="btn-outline" style="padding: 0.2rem 0.4rem; font-size: 0.75rem; color: var(--color-error-base);">Remove Listing</button>[cite: 10, 81]
          </td>
        </tr>
        <tr style="border-bottom: 1px solid var(--color-border-gray);">
          <td style="padding: 0.75rem;">102</td>
          <td style="padding: 0.75rem;"><strong>Student Enrollment System for Tutorial Center</strong></td>
          <td style="padding: 0.75rem;">Ramon Villanueva[cite: 94]</td>
          <td style="padding: 0.75rem;">Hourly</td>
          <td style="padding: 0.75rem;">₱500/hr (80 hrs)[cite: 94]</td>
          <td style="padding: 0.75rem;"><span class="badge badge-success">Ongoing</span></td>
          <td style="padding: 0.75rem;">
            <button class="btn-outline" style="padding: 0.2rem 0.4rem; font-size: 0.75rem; color: var(--color-error-base);">Cancel Contract</button>[cite: 10, 81]
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php include '../includes/footer.php'; ?>