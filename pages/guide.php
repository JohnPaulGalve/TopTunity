<?php
/**
 * pages/guide.php - How TopTunity works, for clients and freelancers
 */
$user_role = "public";
$base_url  = "/TopTunity/";

$page_title = "Guide";
include '../includes/header.php';
include '../includes/nav.php';

$client_steps = [
    ['Register as a Client', 'Create your account with your name and email, then choose the Client role.'],
    ['Post a Project', 'Add the title, description, category, required skills, billing type (Fixed Price or Hourly), budget and deadline.'],
    ['Review Proposals', 'Compare offers, estimated time and the match percentage of each freelancer.'],
    ['Select a Freelancer', 'Choose one freelancer and send the contract. Other proposals are marked Not Selected.'],
    ['Deposit the Project Amount', 'Once the freelancer accepts, deposit the amount. TopTunity holds it until the work is approved.'],
    ['Track the Project', 'Follow the status history, approve logged hours and message your freelancer.'],
    ['Approve the Work', 'Approve the submitted work or request a revision. Approval releases the payment.'],
    ['Review the Freelancer', 'Rate and review the freelancer to help other clients.'],
];

$freelancer_steps = [
    ['Register as a Freelancer', 'Create your account and choose the Freelancer role.'],
    ['Complete Profile and Skills', 'Add your title, bio, portfolio and at least one skill so we can match you.'],
    ['Find Projects', 'Search, filter or check Recommended Projects that match your skills.'],
    ['Submit a Proposal', 'Send your offer and estimated completion time. One proposal per project.'],
    ['Accept the Project', 'Review the contract terms and accept the project offer to start.'],
    ['Submit Completed Work', 'Upload your deliverables (Fixed Price) or log your hours (Hourly).'],
    ['Get Paid (minus service fee)', 'Payment, minus the 10% service fee, goes to your Earnings balance.'],
    ['Review the Client', 'Rate and review the client after the project is completed.'],
];
?>

<main class="page-browse">
  <div class="container">

    <header class="guide-hero">
      <div class="guide-hero__art" aria-hidden="true"><img src="<?= e(tt_image_url($base_url, 'images/Illustrations/Guide/guide.svg')) ?>" alt=""></div>
      <h1>Guide</h1>
      <p>How to use TopTunity, from posting a project to completing it.</p>
      <nav class="seg" aria-label="Jump to section">
        <a href="#clients" class="is-active">For Clients</a>
        <a href="#freelancers">For Freelancers</a>
      </nav>
    </header>

    <div class="guide-cols">
      <!-- Clients -->
      <section class="detail-card" id="clients" style="margin-top:0;">
        <div class="guide-card__header" style="font-family:var(--font-heading); font-size:1rem; font-weight:600; display:flex; align-items:center; gap:0.6rem;">
          <span class="icon-box icon-box--orange"><?= icon('briefcase', 18) ?></span> For Clients
        </div>
        <ol class="guide-steps">
          <?php foreach ($client_steps as $i => $step): ?>
            <li class="g-step">
              <span class="g-num g-num--orange"><?= $i + 1 ?></span>
              <div>
                <h4><?= e($step[0]) ?></h4>
                <p><?= e($step[1]) ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
      </section>

      <!-- Freelancers -->
      <section class="detail-card" id="freelancers" style="margin-top:0;">
        <div style="font-family:var(--font-heading); font-size:1rem; font-weight:600; display:flex; align-items:center; gap:0.6rem;">
          <span class="icon-box icon-box--teal"><?= icon('laptop', 18) ?></span> For Freelancers
        </div>
        <ol class="guide-steps">
          <?php foreach ($freelancer_steps as $i => $step): ?>
            <li class="g-step">
              <span class="g-num g-num--teal"><?= $i + 1 ?></span>
              <div>
                <h4><?= e($step[0]) ?></h4>
                <p><?= e($step[1]) ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
      </section>
    </div>

  </div>
</main>

<?php include '../includes/footer.php'; ?>