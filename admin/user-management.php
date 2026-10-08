<?php
$page_title = "User Management";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <h2>User Management</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">View, manage, suspend, or reactivate client and freelancer accounts[cite: 10, 79].</p>

  <!-- Filter & Search Controls -->
  <div class="card" style="margin-bottom: 1.5rem;">
    <div style="display: flex; gap: 1rem; align-items: center;">
      <input type="text" placeholder="Search users by name, email, or ID..." style="flex: 1; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
      <select style="padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        <option value="all">All Roles</option>
        <option value="client">Clients</option>
        <option value="freelancer">Freelancers</option>
      </select>
      <button class="btn-primary">Filter Users</button>
    </div>
  </div>

  <!-- Users Data Table -->
  <div class="card">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
      <thead>
        <tr style="border-bottom: 2px solid var(--color-border-gray); background: var(--color-off-white);">
          <th style="padding: 0.75rem;">User Name</th>
          <th style="padding: 0.75rem;">Email</th>
          <th style="padding: 0.75rem;">Role</th>
          <th style="padding: 0.75rem;">Status</th>
          <th style="padding: 0.75rem;">Registered</th>
          <th style="padding: 0.75rem;">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr style="border-bottom: 1px solid var(--color-border-gray);">
          <td style="padding: 0.75rem;"><strong>Andrea Santos</strong></td>
          <td style="padding: 0.75rem;">andrea.santos@kapelokal.ph</td>
          <td style="padding: 0.75rem;"><span class="badge badge-info">Client</span></td>
          <td style="padding: 0.75rem;"><span class="badge badge-success">Active</span></td>
          <td style="padding: 0.75rem;">May 12, 2026</td>
          <td style="padding: 0.75rem;">
            <button class="btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.8rem; color: var(--color-error-base);">Suspend</button>[cite: 10, 79]
          </td>
        </tr>
        <tr style="border-bottom: 1px solid var(--color-border-gray);">
          <td style="padding: 0.75rem;"><strong>Miguel Reyes</strong></td>
          <td style="padding: 0.75rem;">miguel.reyes@example.com</td>
          <td style="padding: 0.75rem;"><span class="badge badge-secondary" style="background: var(--color-vibrant-teal); color: #fff;">Freelancer</span></td>
          <td style="padding: 0.75rem;"><span class="badge badge-success">Active</span></td>
          <td style="padding: 0.75rem;">Mar 04, 2024</td>
          <td style="padding: 0.75rem;">
            <button class="btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.8rem; color: var(--color-error-base);">Suspend</button>[cite: 10, 79]
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php include '../includes/footer.php'; ?>