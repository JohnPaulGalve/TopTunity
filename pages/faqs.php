<?php
$page_title = "Frequently Asked Questions";
$user_role = "public";
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <h2>Frequently Asked Questions</h2>
  <p style="color: var(--color-muted-gray); margin-bottom: 2rem;">Answers to common questions about using TopTunity[cite: 4, 35].</p>

  <div style="display: flex; flex-direction: column; gap: 1rem;">
    <div class="card">
      <h3 style="font-size: 1rem; color: var(--color-vibrant-teal);">How does escrow payment work?</h3>
      <p style="font-size: 0.9rem; color: var(--color-deep-slate); margin-top: 0.5rem;">
        When a client accepts a contract, they deposit the project amount into platform escrow[cite: 6]. The payment is held safely until the client approves the completed deliverables or the hourly project deadline completes[cite: 6].
      </p>
    </div>

    <div class="card">
      <h3 style="font-size: 1rem; color: var(--color-vibrant-teal);">Are real monetary payments processed?</h3>
      <p style="font-size: 0.9rem; color: var(--color-deep-slate); margin-top: 0.5rem;">
        No. All payments, billings, and withdrawal requests on TopTunity are entirely simulated for academic demonstration and only update database records[cite: 2, 7, 9, 11].
      </p>
    </div>

    <div class="card">
      <h3 style="font-size: 1rem; color: var(--color-vibrant-teal);">When is the platform service fee deducted?</h3>
      <p style="font-size: 0.9rem; color: var(--color-deep-slate); margin-top: 0.5rem;">
        A transparent 10% platform service fee is automatically computed and deducted from the freelancer's payout upon successful work release[cite: 2, 6, 8, 92].
      </p>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>