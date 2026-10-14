<?php
/**
 * pages/pricing.php - Platform fee breakdown
 * The fee percentage is hard-coded here; move it to platform settings later.
 */
$user_role = "public";
$base_url  = "/TopTunity/";
$fee_pct   = 10;

$page_title = "Pricing";
include '../includes/header.php';
include '../includes/nav.php';

// Worked examples
$fixed_amount  = 10000;
$hourly_hours  = 25;
$hourly_rate   = 400;
$hourly_amount = $hourly_hours * $hourly_rate;
$fixed_fee     = $fixed_amount * $fee_pct / 100;
$hourly_fee    = $hourly_amount * $fee_pct / 100;
?>

<main class="page-browse">
  <div class="container">

    <header class="center-head">
      <h1>Pricing</h1>
      <p>No subscription. One simple service fee on every paid project.</p>
    </header>

    <div class="pricing-hero" style="margin-top: 1.75rem;">
      <p class="section-tag">Service fee</p>
      <span class="pricing-hero__pct"><?= $fee_pct ?>%</span>
      <p>Deducted from the amount released to the freelancer, on approval (Fixed Price) or on the End Date (Hourly).</p>
    </div>

    <div class="fee-title">
      <p class="section-tag">Fee calculation</p>
      <h2>How the fee is calculated</h2>
    </div>

    <div class="fee-grid">
      <!-- Fixed price example -->
      <div class="fee-card">
        <div class="fee-card__head">
          <span class="pill--type">Fixed Price</span>
          <h3>Example: Logo and Brand Kit</h3>
        </div>
        <div class="fee-row"><span>Project amount (paid by client)</span> <strong>₱<?= number_format($fixed_amount) ?></strong></div>
        <div class="fee-row"><span>Platform service fee (<?= $fee_pct ?>%)</span> <strong>– ₱<?= number_format($fixed_fee) ?></strong></div>
        <div class="fee-row"><span>Held until the client approves the work</span> <?= icon('check', 16) ?></div>
        <div class="fee-total"><span>Freelancer receives</span> <strong>₱<?= number_format($fixed_amount - $fixed_fee) ?></strong></div>
      </div>

      <!-- Hourly example -->
      <div class="fee-card">
        <div class="fee-card__head">
          <span class="pill--type">Hourly</span>
          <h3>Example: Data Encoding</h3>
        </div>
        <div class="fee-row"><span>Approved hours × hourly rate (<?= $hourly_hours ?> h × ₱<?= $hourly_rate ?>)</span> <strong>₱<?= number_format($hourly_amount) ?></strong></div>
        <div class="fee-row"><span>Platform service fee (<?= $fee_pct ?>%)</span> <strong>– ₱<?= number_format($hourly_fee) ?></strong></div>
        <div class="fee-row"><span>Billed on the End Date (deadline)</span> <?= icon('check', 16) ?></div>
        <div class="fee-total"><span>Freelancer receives</span> <strong>₱<?= number_format($hourly_amount - $hourly_fee) ?></strong></div>
      </div>
    </div>

    <div class="role-benefits">
      <div class="benefit-card">
        <div class="benefit-card__head">
          <span class="icon-box icon-box--orange"><?= icon('briefcase', 18) ?></span>
          <h3>For Clients</h3>
        </div>
        <ul class="check-list">
          <li><?= icon('check-circle', 16) ?> Post Fixed Price or Hourly projects for free</li>
          <li><?= icon('check-circle', 16) ?> Pay only after the freelancer accepts the contract</li>
          <li><?= icon('check-circle', 16) ?> Payment is held until you approve the work (Fixed Price)</li>
          <li><?= icon('check-circle', 16) ?> Hourly: pay only for approved hours; unused deposit is refunded</li>
          <li><?= icon('check-circle', 16) ?> Refunds for cancelled or disputed projects</li>
        </ul>
      </div>

      <div class="benefit-card">
        <div class="benefit-card__head">
          <span class="icon-box icon-box--teal"><?= icon('laptop', 18) ?></span>
          <h3>For Freelancers</h3>
        </div>
        <ul class="check-list">
          <li><?= icon('check-circle', 16) ?> Create a profile and submit proposals for free</li>
          <li><?= icon('check-circle', 16) ?> The service fee is deducted only from paid projects</li>
          <li><?= icon('check-circle', 16) ?> See your net earnings for every project</li>
          <li><?= icon('check-circle', 16) ?> Withdraw to GCash or a bank account</li>
        </ul>
      </div>
    </div>

    <div class="info-callout" style="margin-top: 1.25rem;">
      <?= icon('info', 15) ?>
      <span><strong>All payments on TopTunity are simulated.</strong> No real money is used. Paying, releasing and refunding only update the records in the database.</span>
    </div>

  </div>
</main>

<?php include '../includes/footer.php'; ?>