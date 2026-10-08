<?php
$page_title = "Submit Proposal";
$user_role = "freelancer";
include '../includes/header.php';
include '../includes/nav.php';

// Mock Project Details being applied to
$project_id = isset($_GET['id']) ? $_GET['id'] : 101;
$project_title = "Online Ordering Website for a Coffee Shop";
$client_name = "Andrea Santos";
$billing_type = "fixed"; // 'fixed' or 'hourly'
$client_budget = 45000;
$default_service_fee = 10; // 10% Platform fee
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem; max-width: 800px;">
  <!-- Project Context Header -->
  <div class="card" style="margin-bottom: 2rem; background: var(--color-off-white);">
    <span class="badge badge-info">Applying For</span>
    <h2 style="margin-top: 0.5rem; color: var(--color-deep-slate);"><?php echo htmlspecialchars($project_title); ?></h2>
    <p style="font-size: 0.9rem; color: var(--color-muted-gray); margin-top: 0.2rem;">
      Client: <strong><?php echo htmlspecialchars($client_name); ?></strong> • 
      Billing: <strong>Fixed Price</strong> • 
      Client Budget: <strong>₱<?php echo number_format($client_budget); ?></strong>
    </p>
  </div>

  <!-- Proposal Form -->
  <div class="card">
    <h3 style="margin-bottom: 0.5rem;">Proposal Terms & Offer</h3>
    <p style="color: var(--color-muted-gray); font-size: 0.85rem; margin-bottom: 1.5rem;">
      Set your bid offer and write a detailed cover letter to pitch your skills[cite: 8].
    </p>

    <form action="/freelancer/my-proposals.php" method="GET">
      <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">

      <!-- Terms & Rate Breakdown -->
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
        <div>
          <label for="bid_amount" style="display: block; font-weight: 600; font-size: 0.9rem;">Your Bid Amount (₱)</label>
          <input type="number" name="bid_amount" id="bid_amount" value="<?php echo $client_budget; ?>" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;" oninput="calculateNetPayout()">
        </div>

        <div>
          <label for="estimated_days" style="display: block; font-weight: 600; font-size: 0.9rem;">Estimated Completion (Days)</label>
          <input type="number" name="estimated_days" id="estimated_days" placeholder="14" required style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;">
        </div>
      </div>

      <!-- Live Service Fee Preview Card -->
      <div style="background: var(--color-off-white); padding: 1rem; border-radius: 6px; border: 1px solid var(--color-border-gray); margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.4rem;">
          <span>Gross Bid Amount:</span>
          <strong id="display_gross">₱45,000</strong>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.4rem; color: var(--color-error-base);">
          <span>10% Platform Service Fee Deducted:</span>
          <strong id="display_fee">-₱4,500</strong>
        </div>
        <hr style="border: none; border-top: 1px solid var(--color-border-gray); margin: 0.5rem 0;">
        <div style="display: flex; justify-content: space-between; font-size: 1rem; color: var(--color-success-text);">
          <span>Net Earnings You Will Receive:</span>
          <strong id="display_net" style="font-size: 1.1rem;">₱40,500</strong>
        </div>
        <p style="font-size: 0.75rem; color: var(--color-muted-gray); margin-top: 0.5rem;">
          The 10% platform service fee is automatically deducted from payouts upon successful project completion[cite: 2, 8].
        </p>
      </div>

      <!-- Cover Letter -->
      <div style="margin-bottom: 1.5rem;">
        <label for="cover_letter" style="display: block; font-weight: 600; font-size: 0.9rem;">Cover Letter / Pitch</label>
        <textarea name="cover_letter" id="cover_letter" rows="6" required placeholder="Describe your relevant experience, approach to this project, and why the client should select you..." style="width: 100%; padding: 0.6rem; border: 1px solid var(--color-border-gray); border-radius: 4px;"></textarea>
      </div>

      <!-- Submission Actions -->
      <div style="display: flex; gap: 1rem;">
        <button type="submit" class="btn-primary">Submit Proposal</button>
        <a href="<?php echo $base_url; ?>freelancer/find-projects.php" class="btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>

<script>
function calculateNetPayout() {
  const bidInput = document.getElementById('bid_amount');
  const grossDisplay = document.getElementById('display_gross');
  const feeDisplay = document.getElementById('display_fee');
  const netDisplay = document.getElementById('display_net');

  const gross = parseFloat(bidInput.value) || 0;
  const fee = gross * 0.10;
  const net = gross - fee;

  grossDisplay.textContent = '₱' + gross.toLocaleString('en-PH');
  feeDisplay.textContent = '-₱' + fee.toLocaleString('en-PH');
  netDisplay.textContent = '₱' + net.toLocaleString('en-PH');
}
</script>

<?php include '../includes/footer.php'; ?>