<?php
$page_title = "Notifications";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <h2>Notifications</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 1.5rem;">Updates regarding proposal acceptances, contract offers, and payout releases[cite: 9, 73].</p>

  <div style="display: flex; flex-direction: column; gap: 0.8rem;">
    <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">
      <div>
        <p style="font-size: 0.9rem;"><strong>Contract Offer:</strong> Ramon Villanueva sent you a contract offer for "Student Enrollment System"[cite: 73, 94].</p>
        <small style="color: var(--color-muted-gray);">1 hour ago</small>
      </div>
      <a href="<?php echo $base_url; ?>freelancer/my-projects.php" class="btn-primary" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">Review Contract</a>
    </div>

    <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: var(--color-off-white);">
      <div>
        <p style="font-size: 0.9rem;"><strong>Payout Released:</strong> ₱22,500 net payment added to your available balance[cite: 73].</p>
        <small style="color: var(--color-muted-gray);">Yesterday</small>
      </div>
      <a href="<?php echo $base_url; ?>freelancer/earnings.php" class="btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">View Earnings</a>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>