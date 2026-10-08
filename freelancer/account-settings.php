<?php
$page_title = "Account Settings";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <div class="card">
      <h3>Email Preferences</h3>
      <form action="#" method="POST" style="margin-top: 1rem;">
        <div style="margin-bottom: 1.5rem;">
          <label style="display: block; font-weight: 600; font-size: 0.9rem;">Email Address</label>
          <input type="email" value="miguel.reyes@example.com" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <button type="submit" class="btn-primary">Update Email</button>
      </form>
    </div>

    <div class="card">
      <h3>Security & Password</h3>
      <form action="#" method="POST" style="margin-top: 1rem;">
        <div style="margin-bottom: 1rem;">
          <label style="display: block; font-weight: 600; font-size: 0.9rem;">Current Password</label>
          <input type="password" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 1.5rem;">
          <label style="display: block; font-weight: 600; font-size: 0.9rem;">New Password</label>
          <input type="password" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
        <button type="submit" class="btn-outline">Change Password</button>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>