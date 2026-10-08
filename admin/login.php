<?php
$page_title = "Administrator Login";
$user_role = "public";
include '../includes/header.php';
?>

<div class="container" style="padding-top: 5rem; padding-bottom: 5rem; max-width: 420px;">
  <div class="card" style="border: 2px solid var(--color-deep-slate);">
    <div style="text-align: center; margin-bottom: 1.5rem;">
      <span class="badge badge-error" style="margin-bottom: 0.5rem;">Restricted Portal</span>
      <h2 style="font-family: var(--font-logo); color: var(--color-midnight-black);">TopTunity Admin</h2>
      <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Administrator Authentication</p>
    </div>

    <form action="/admin/dashboard.php" method="GET">
      <div style="margin-bottom: 1rem;">
        <label for="admin_user" style="display: block; font-weight: 600; font-size: 0.85rem;">Admin Username / Email</label>
        <input type="text" id="admin_user" required placeholder="admin@toptunity.ph" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label for="admin_pass" style="display: block; font-weight: 600; font-size: 0.85rem;">Password</label>
        <input type="password" id="admin_pass" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
      </div>

      <button type="submit" class="btn-primary" style="width: 100%; background: var(--color-midnight-black);">Login to Admin Console</button>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>