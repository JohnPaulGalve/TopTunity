<?php
/**
 * pages/about.php - Platform mission and background
 * Stats are calculated from the site data, not typed in.
 */
$user_role = "public";
$base_url  = "/TopTunity/";

require_once __DIR__ . '/../includes/data.php';

$page_title = "About Us";
include '../includes/header.php';
include '../includes/nav.php';

$freelancers = toptunity_freelancers();
$projects    = toptunity_projects();
$open_count  = count(array_filter($projects, function ($p) { return $p['status'] === 'Open'; }));
$avg_rating  = count($freelancers) ? round(array_sum(array_column($freelancers, 'rating')) / count($freelancers), 1) : 0;
?>

<main class="page-browse">
  <div class="container">

    <section class="about-hero">
      <div>
        <p class="section-tag">About us</p>
        <h1>Connecting work with the right people.</h1>
        <p>TopTunity is a freelance project and service marketplace built by Team KitchClass. We help small businesses, schools and startups find skilled Filipino freelancers, and help freelancers find steady, fairly paid work.</p>

        <div class="stat-row">
          <div><strong><?= count($freelancers) ?>+</strong><span>Active freelancers</span></div>
          <div><strong><?= $open_count ?></strong><span>Open projects</span></div>
          <div><strong><?= e($avg_rating) ?></strong><span>Average rating</span></div>
        </div>
      </div>

      <div class="about-art" aria-hidden="true">
        <?= avatar('#CCFBF1', '#1E293B', 'long', 150) ?>
        <?= avatar('#FFEDD5', '#1E293B', 'short', 150) ?>
      </div>
    </section>

  </div>

  <div class="about-band">
    <div class="container info-grid">
      <div class="info-card">
        <span class="icon-box icon-box--teal"><?= icon('info', 18) ?></span>
        <h2>What is TopTunity?</h2>
        <p>An online platform where clients post Fixed Price or Hourly projects and freelancers submit proposals. Both sides agree on a contract before work starts, communicate through built-in messages, and track every project from posting to completion.</p>
      </div>
      <div class="info-card">
        <span class="icon-box icon-box--orange"><?= icon('check-circle', 18) ?></span>
        <h2>Our Goal</h2>
        <p>To connect clients who need projects done with freelancers who can complete them, through skill-based matching, transparent fees and fair, two-way reviews that build trust on both sides.</p>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="feature-block">
      <p class="section-tag">Why TopTunity</p>
      <h2>Built for fair, simple freelancing</h2>
      <div class="feature-grid">
        <div class="feature-card">
          <span class="icon-box icon-box--teal"><?= icon('search', 18) ?></span>
          <h3>Skill-based matching</h3>
          <p>Projects and freelancers are matched by required skills, with a clear match percentage for each.</p>
        </div>
        <div class="feature-card">
          <span class="icon-box icon-box--orange"><?= icon('check-circle', 18) ?></span>
          <h3>Secure escrow payments</h3>
          <p>The project amount is held until the work is approved, then released minus the service fee.</p>
        </div>
        <div class="feature-card">
          <span class="icon-box icon-box--slate"><?= icon('star', 18) ?></span>
          <h3>Two-way reviews</h3>
          <p>Clients review freelancers and freelancers review clients after every completed project.</p>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include '../includes/footer.php'; ?>