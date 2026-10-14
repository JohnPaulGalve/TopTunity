<?php
/**
 * pages/terms.php - Terms of Service and Privacy Policy
 * The table of contents jumps to each section by anchor.
 */
$user_role = "public";
$base_url  = "/TopTunity/";

$page_title = "Terms and Privacy Policy";
include '../includes/header.php';
include '../includes/nav.php';

$sections = [
    ['Terms of Use', 'By creating an account on TopTunity, you agree to these terms. TopTunity is a student project that simulates a freelance marketplace; you must provide accurate information and use the platform only for lawful work.'],
    ['User Accounts', 'Each email address can only be used for one account, either as a Client or a Freelancer. You are responsible for keeping your password secure. Suspended users cannot log in or send messages.'],
    ['Projects and Proposals', 'Clients may post Fixed Price or Hourly projects. A freelancer can submit only one proposal per project, and proposals cannot be submitted after the deadline. Clients may select only one freelancer per project.'],
    ['Payments and Fees', 'All payments are simulated and no real money is used. A 10% platform service fee is deducted from the amount released to the freelancer. Unused Hourly deposits are refunded to the client on the End Date.'],
    ['Reviews and Reports', 'Clients and freelancers may review each other once per completed project. Abusive messages, fake reviews or prohibited projects may be reported and are reviewed by the administrator.'],
    ['Privacy Policy', 'We collect only the information needed to run the platform: your name, email, profile details, projects, messages and transaction records. Messages are only viewed by the administrator when they are part of a report or dispute.'],
    ['Data We Collect', 'We collect account details, profile information, project and proposal records, messages, and transaction records needed to operate the platform.'],
    ['How We Use Data', 'We use your data to run your account, match freelancers to projects, process simulated payments and resolve reports. We do not use it for any other purpose.'],
];
?>

<main class="page-browse">
  <div class="container">

    <header class="terms-title">
      <h1>Terms and Privacy Policy</h1>
      <p>Last updated September 15, 2026</p>
    </header>

    <div class="terms-layout">

      <aside class="toc-card">
        <h2>Contents</h2>
        <ol>
          <?php foreach ($sections as $i => $s): ?>
            <li>
              <a href="#section-<?= $i + 1 ?>" class="<?= $i === 0 ? 'is-active' : '' ?>"><?= $i + 1 ?>. <?= e($s[0]) ?></a>
            </li>
          <?php endforeach; ?>
        </ol>
      </aside>

      <article class="terms-body">
        <?php foreach ($sections as $i => $s): ?>
          <section id="section-<?= $i + 1 ?>">
            <h2><?= $i + 1 ?>. <?= e($s[0]) ?></h2>
            <p><?= e($s[1]) ?></p>
          </section>
        <?php endforeach; ?>
      </article>

    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>