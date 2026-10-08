<?php
$page_title = "Account Settings";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <!-- Account Information Form -->
    <div class="card">
      <h3>Update Email</h3>
      <form action="#" method="POST" style="margin-top: 1rem;">
        <div style="margin-bottom: 1.5rem;">
          <label for="account_email" style="display: block; font-weight: 600; font-size: 0.9rem;">Email Address</label>
          <input type="email" name="account_email" id="account_email" value="andrea.santos@kapelokal.ph" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <button type="submit" class="btn-primary">Save Changes</button>
      </form>
    </div>

    <!-- Password Change Form -->
    <div class="card">
      <h3>Change Password</h3>
      <form action="#" method="POST" style="margin-top: 1rem;">
        <div style="margin-bottom: 1rem;">
          <label for="current_password" style="display: block; font-weight: 600; font-size: 0.9rem;">Current Password</label>
          <input type="password" name="current_password" id="current_password" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 1.5rem;">
          <label for="new_password" style="display: block; font-weight: 600; font-size: 0.9rem;">New Password</label>
          <input type="password" name="new_password" id="new_password" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <button type="submit" class="btn-outline">Update Password</button>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>