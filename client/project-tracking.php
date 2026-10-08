<?php
$page_title = "Project Details & Tracking";
$user_role = "client";
include '../includes/header.php';
include '../includes/nav.php';
?>

<div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
  <!-- Header Overview -->
  <div class="card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
      <div>
        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
          <span class="badge badge-info">Web Development</span>
          <span class="badge badge-success">Ongoing</span>
        </div>
        <h2>Online Ordering Website for a Coffee Shop</h2>
        <p style="color: var(--color-muted-gray); font-size: 0.85rem; margin-top: 0.2rem;">Budget: ₱45,000 • Fixed Price • Deadline: Nov 20, 2026[cite: 91, 93]</p>
      </div>
      <a href="<?php echo $base_url; ?>client/messages.php" class="btn-outline">Message Freelancer</a>
    </div>
  </div>

  <!-- Navigation Tabs for Tracking View -->
  <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--color-border-gray); padding-bottom: 0.5rem;">
    <button class="tab-btn active" data-tab="proposals" data-group="tracking">Proposals & Recommended</button>
    <button class="tab-btn" data-tab="contract" data-group="tracking">Contract</button>
    <button class="tab-btn" data-tab="tracking" data-group="tracking">Tracking & Work Log</button>
  </div>

  <!-- Tab 1: Proposals -->
  <div id="proposals" class="tab-content" data-group="tracking" style="display: block;">
    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem;">
      <div>
        <h3>Submitted Proposals (12)[cite: 93]</h3>
        <div class="card" style="margin-top: 1rem;">
          <div style="display: flex; justify-content: space-between;">
            <strong>Miguel Reyes</strong>
            <span style="color: var(--color-vibrant-teal); font-weight: bold;">₱45,000</span>
          </div>
          <p style="font-size: 0.85rem; color: var(--color-muted-gray); margin: 0.5rem 0;">Estimated completion: 14 days • Match Score: 95%[cite: 42]</p>
          <p style="font-size: 0.9rem; margin-bottom: 1rem;">"Hi! I can build this online ordering platform using PHP and MySQL. I have built similar systems before."[cite: 96]</p>
          <a href="<?php echo $base_url; ?>client/hire-freelancer.php?freelancer=1" class="btn-primary" style="font-size: 0.85rem;">Select Freelancer</a>
        </div>
      </div>

      <!-- Recommended Freelancers Box -->
      <aside class="card">
        <h3>Recommended</h3>
        <p style="font-size: 0.8rem; color: var(--color-muted-gray); margin-bottom: 1rem;">Matched based on required skills[cite: 5, 42]:</p>
        <div style="border-bottom: 1px solid var(--color-border-gray); padding-bottom: 0.5rem; margin-bottom: 0.5rem;">
          <p style="font-weight: 600; font-size: 0.9rem;">Miguel Reyes</p>
          <span class="badge badge-success">95% Match</span>[cite: 42]
        </div>
      </aside>
    </div>
  </div>

  <!-- Tab 2: Contract Viewer -->
  <div id="contract" class="tab-content" data-group="tracking" style="display: none;">
    <div class="card">
      <h3>Contract Terms</h3>
      <p style="font-size: 0.9rem; color: var(--color-muted-gray); margin-bottom: 1.5rem;">Agreement between Andrea Santos (Client) and Miguel Reyes (Freelancer)[cite: 5, 44].</p>
      <p style="font-size: 0.9rem; margin-bottom: 0.5rem;"><strong>Billing:</strong> Fixed Price (₱45,000 held in escrow)[cite: 5, 6, 44]</p>
      <p style="font-size: 0.9rem; margin-bottom: 0.5rem;"><strong>Platform Service Fee:</strong> 10% deducted upon payout release[cite: 2, 44, 92]</p>
      <p style="font-size: 0.9rem; margin-bottom: 1.5rem;"><strong>Contract Status:</strong> <span class="badge badge-success">Active</span>[cite: 6, 44]</p>
    </div>
  </div>

  <!-- Tab 3: Tracking & Work Log -->
  <div id="tracking" class="tab-content" data-group="tracking" style="display: none;">
    <div class="card">
      <h3>Submitted Work & Progress</h3>
      <p style="font-size: 0.9rem; color: var(--color-muted-gray); margin-bottom: 1.5rem;">Review deliverables uploaded by the freelancer[cite: 6, 46].</p>
      <div style="border: 1px border var(--color-border-gray); padding: 1rem; border-radius: 4px; background: var(--color-off-white); margin-bottom: 1.5rem;">
        <p><strong>Submitted File:</strong> ordering-system-v1.zip (12.4 MB)</p>
        <p style="font-size: 0.85rem; color: var(--color-muted-gray);">Submitted on Oct 08, 2026</p>
      </div>
      <div style="display: flex; gap: 1rem;">
        <button class="btn-primary">Approve Work & Release Funds</button>
        <button class="btn-outline">Request Revision</button>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>