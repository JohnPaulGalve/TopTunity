<?php
$page_title = "Platform Settings";
$user_role = "admin";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 650px;">
  <div class="card">
    <h2>Platform Settings & Commission Controller</h2>
    <p style="color: var(--color-muted-gray); font-size: 0.9rem; margin-bottom: 2rem;">Adjust platform-wide rules and the global service fee percentage[cite: 12, 87].</p>

    <form action="#" method="POST">
      <div style="margin-bottom: 1.5rem;">
        <label for="platform_fee_percent" style="display: block; font-weight: 600; font-size: 0.9rem;">Platform Service Fee (%)</label>
        <input type="number" step="0.1" name="platform_fee_percent" id="platform_fee_percent" value="10.0" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        <p style="font-size: 0.8rem; color: var(--color-muted-gray); margin-top: 0.3rem;">
          Default is 10%. This percentage is dynamically computed across all payout calculations and pricing pages[cite: 2, 4, 12, 92].
        </p>
      </div>

      <div style="margin-bottom: 1.5rem;">
        <label for="platform_status" style="display: block; font-weight: 600; font-size: 0.9rem;">Platform Operating Mode</label>
        <select name="platform_status" id="platform_status" style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
          <option value="active" selected>Active / Live Prototype</option>
          <option value="maintenance">Maintenance Mode</option>
        </select>
      </div>

      <button type="submit" class="btn-primary">Save Platform Settings</button>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>