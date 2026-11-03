<?php
/**
 * pages/index.php - Public homepage
 * Sections: Hero, Guide, Categories, New projects, Top talent,
 *           Testimonials, Pricing preview.
 */
$page_title = "Home";
$user_role  = "public";
$base_url   = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');

require_once __DIR__ . '/../includes/data.php';

include '../includes/header.php';
include '../includes/nav.php';

/* ---------- Page data (swap for database queries later) ---------- */

$client_steps = [
    ['Post a project',      'Describe the work, skills, budget and deadline'],
    ['Review proposals',    'Compare offers and match percentages'],
    ['Select a freelancer', 'Send the contract and deposit the amount'],
    ['Track the project',   'Follow every stage and status update'],
    ['Review the work',     'Approve, release payment and leave a review'],
];

$freelancer_steps = [
    ['Find projects',     'Search or see projects that match your skills'],
    ['Submit a proposal', 'Send your offer and estimated time'],
    ['Accept the project','Agree to the contract terms'],
    ['Submit the work',   'Upload deliverables or log your hours'],
    ['Get reviewed',      'Get paid and build your rating'],
];

$category_icons = [
    'Web Development' => ['code', 'teal'],
    'Mobile App Development' => ['smartphone', 'orange'],
    'Graphic Design' => ['pen-tool', 'slate'],
    'UI/UX Design' => ['frame', 'teal'],
    'Writing and Content' => ['file', 'orange'],
    'Digital Marketing' => ['megaphone', 'blue'],
    'Video and Animation' => ['video', 'slate'],
    'Data Entry and Admin' => ['clipboard', 'teal'],
];
$category_counts = [];
foreach (toptunity_listing() as $listed_project) {
    $category_counts[$listed_project['category']] = ($category_counts[$listed_project['category']] ?? 0) + 1;
}
$categories = [];
foreach (toptunity_category_catalog() as $category) {
    $style = $category_icons[$category] ?? ['briefcase', 'teal'];
    $count = $category_counts[$category] ?? 0;
    $categories[] = [$category, $style[0], $style[1], $count . ' open ' . ($count === 1 ? 'project' : 'projects')];
}


/* ---------- Projects shown on the home page: real open projects ranked by tt_project_score ---------- */
function home_posted_text($hours)
{
    if ($hours < 24) { return 'Posted ' . max(1, $hours) . 'h ago'; }
    if ($hours < 48) { return 'Posted yesterday'; }
    return 'Posted ' . floor($hours / 24) . ' days ago';
}

$real_projects = [];
foreach (tt_real_listing() as $rp) {
    $rp['score'] = tt_project_score($rp, '');
    $hourly = $rp['type'] === 'hourly';
    $desc   = (string) $rp['desc'];
    $real_projects[] = [
        'category' => $rp['category'],
        'pill'     => 'teal',
        'posted'   => home_posted_text((int) $rp['age_h']),
        'title'    => $rp['title'],
        'desc'     => mb_strlen($desc) > 140 ? mb_substr($desc, 0, 137) . '...' : $desc,
        'tags'     => array_slice((array) $rp['skills'], 0, 3),
        'pay_type' => $hourly ? 'Hourly' : 'Budget',
        'pay'      => '₱' . number_format((int) $rp['amount']) . ($hourly ? '/hr' : ''),
        'deadline' => $rp['deadline'] ? date('M j, Y', strtotime($rp['deadline'])) : '—',
        'score'    => $rp['score'],
    ];
}
usort($real_projects, function ($a, $b) { return $b['score'] <=> $a['score']; });

// Show the top 3 real projects, best score first
$projects = array_slice($real_projects, 0, 3);

$freelancers = [];
$top_freelancers = tt_real_freelancers();
uasort($top_freelancers, function ($a, $b) { return [$b['reviews'], $b['user_id']] <=> [$a['reviews'], $a['user_id']]; });
foreach (array_slice($top_freelancers, 0, 4) as $rf) {
    $freelancers[] = [$rf['name'], $rf['title'], (float) $rf['rating'], (int) $rf['reviews'], array_slice((array) $rf['skills'], 0, 2), $rf['bg'], $rf['hair'], $rf['style'], (int) $rf['id']];
}

$testimonials = [];
$tpal = [['#FFEDD5', '#1E293B', 'long'], ['#CCFBF1', '#1E293B', 'short'], ['#DBEAFE', '#1E293B', 'bun']];
$published = db()->query("SELECT pr.rating, pr.body, u.name, u.role FROM platform_reviews pr JOIN users u ON u.id = pr.user_id WHERE pr.status = 'published' ORDER BY pr.created_at DESC LIMIT 3")->fetchAll();
foreach ($published as $k => $t) {
    $testimonials[] = ['quote' => $t['body'], 'name' => $t['name'], 'role' => ucfirst($t['role']) . ' · TopTunity', 'rating' => (int) $t['rating'],
                       'bg' => $tpal[$k % 3][0], 'hair' => $tpal[$k % 3][1], 'style' => $tpal[$k % 3][2]];
}
?>

<main>

  <!-- ===================== HERO ===================== -->
  <section class="hero">
    <div class="container hero__grid">
      <div class="hero__copy">
        <span class="badge-pill"><?= icon('star', 12) ?> Top Talents. Best Opportunities.</span>

        <h1 class="hero__title">
          Find the right<br>
          <span class="text-teal">freelancer.</span><br>
          Find the right <span class="text-orange">project.</span>
        </h1>

        <p class="hero__subtitle">
          TopTunity connects clients who need projects done with skilled Filipino freelancers who can complete them — from the first proposal to the final payment.
        </p>

        <div class="hero__actions">
          <a href="<?= e($base_url) ?>pages/register.php?role=client" class="btn btn--primary"><?= icon('plus', 16) ?> Post a Project</a>
          <a href="<?= e($base_url) ?>pages/register.php?role=freelancer" class="btn btn--outline">Become a Freelancer</a>
        </div>

        <?php
          $fl_count   = (int) db()->query("SELECT COUNT(*) FROM users WHERE role = 'freelancer' AND status = 'active'")->fetchColumn();
          $avg_raw    = db()->query("SELECT AVG(rating) FROM platform_reviews WHERE status = 'published'")->fetchColumn();
          $avg_rating = $avg_raw ? round((float) $avg_raw, 1) : 0;
          $proof_fls  = array_slice(array_values(tt_real_freelancers()), 0, 4);
        ?>
        <div class="social-proof">
          <div class="avatar-group">
            <?php foreach ($proof_fls as $pf): ?>
              <?= tt_freelancer_avatar_html($pf, 32, $base_url) ?>
            <?php endforeach; ?>
          </div>
          <div>
            <div class="social-proof__rating"><?= stars($avg_rating) ?> <?= $avg_rating ? number_format($avg_rating, 1) . '/5' : 'No ratings yet' ?></div>
            <div class="social-proof__note">from <?= $fl_count ?> active freelancer<?= $fl_count === 1 ? '' : 's' ?></div>
          </div>
        </div>
      </div>

      <div class="hero-art" aria-hidden="true">
        <span class="hero-art__blob hero-art__blob--teal"></span>
        <span class="hero-art__blob hero-art__blob--peach"></span>
        <span class="hero-art__blob hero-art__blob--white"></span>

        <img src="<?= e(tt_image_url($base_url, 'images/Illustrations/Homepage/hero-freelancer.svg')) ?>" alt="" class="hero-illustration">
      </div>
    </div>
  </section>

  <!-- ===================== HOW IT WORKS ===================== -->
  <section class="section">
    <div class="container">
      <div class="section-header">
        <div>
          <p class="section-tag">Guide</p>
          <h2>How TopTunity works</h2>
        </div>
        <a href="<?= e($base_url) ?>pages/guide.php" class="section-link">Read the Full Guide <?= icon('arrow-right', 15) ?></a>
      </div>

      <div class="guide-grid">
        <!-- For Clients -->
        <article class="guide-card">
          <div class="guide-card__header">
            <span class="icon-box icon-box--orange"><?= icon('briefcase', 18) ?></span>
            For Clients
          </div>
          <ol class="step-list">
            <?php foreach ($client_steps as $i => $step): ?>
              <li class="step-item">
                <span class="step-num step-num--orange"><?= $i + 1 ?></span>
                <div>
                  <h4><?= e($step[0]) ?></h4>
                  <p><?= e($step[1]) ?></p>
                </div>
              </li>
            <?php endforeach; ?>
          </ol>
        </article>

        <!-- For Freelancers -->
        <article class="guide-card">
          <div class="guide-card__header">
            <span class="icon-box icon-box--teal"><?= icon('laptop', 18) ?></span>
            For Freelancers
          </div>
          <ol class="step-list">
            <?php foreach ($freelancer_steps as $i => $step): ?>
              <li class="step-item">
                <span class="step-num step-num--teal"><?= $i + 1 ?></span>
                <div>
                  <h4><?= e($step[0]) ?></h4>
                  <p><?= e($step[1]) ?></p>
                </div>
              </li>
            <?php endforeach; ?>
          </ol>
        </article>
      </div>
    </div>
  </section>

  <!-- ===================== CATEGORIES + NEW PROJECTS ===================== -->
  <section class="section section--tint">
    <div class="container">

      <div class="section-header">
        <div>
          <p class="section-tag">Browse by category</p>
          <h2>Explore categories</h2>
        </div>
        <a href="<?= e($base_url) ?>pages/browse-projects.php" class="section-link">View All Projects <?= icon('arrow-right', 15) ?></a>
      </div>

      <div class="categories-grid">
        <?php foreach ($categories as $cat): ?>
          <a href="<?= e($base_url) ?>pages/browse-projects.php?category=<?= urlencode($cat[0]) ?>" class="category-card">
            <span class="icon-box icon-box--<?= e($cat[2]) ?>"><?= icon($cat[1], 15) ?></span>
            <span class="category-card__name"><?= e($cat[0]) ?></span>
            <span class="category-card__meta"><?= e($cat[3]) ?> <?= icon('arrow-right', 15) ?></span>
          </a>
        <?php endforeach; ?>
      </div>

      <div class="section-header block-gap">
        <div>
          <p class="section-tag">Latest open projects</p>
          <h2>New projects</h2>
        </div>
        <a href="<?= e($base_url) ?>pages/browse-projects.php" class="section-link">View All Projects <?= icon('arrow-right', 15) ?></a>
      </div>

      <div class="projects-grid">
        <?php if (!$projects): ?><p class="muted">No projects have been posted yet.</p><?php endif; ?>
        <?php foreach ($projects as $p): ?>
          <article class="project-card">
            <div class="project-card__body">
              <div class="project-card__top">
                <span class="pill pill--<?= e($p['pill']) ?>"><?= e($p['category']) ?></span>
                <span class="project-card__posted"><?= e($p['posted']) ?></span>
              </div>
              <h3><?= e($p['title']) ?></h3>
              <p class="project-card__desc"><?= e($p['desc']) ?></p>
              <div class="chips">
                <?php foreach ($p['tags'] as $tag): ?>
                  <span class="chip"><?= e($tag) ?></span>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="project-card__footer">
              <span><?= e($p['pay_type']) ?> <strong><?= e($p['pay']) ?></strong></span>
              <span class="project-card__date"><?= icon('calendar', 14) ?> <?= e($p['deadline']) ?></span>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===================== TOP TALENT ===================== -->
  <section class="section">
    <div class="container">
      <div class="section-header">
        <div>
          <p class="section-tag">Featured freelancers</p>
          <h2>Top talent</h2>
        </div>
        <a href="<?= e($base_url) ?>pages/browse-freelancers.php" class="section-link">View All Freelancers <?= icon('arrow-right', 15) ?></a>
      </div>

      <div class="freelancers-grid">
        <?php if (!$freelancers): ?><p class="muted">No freelancers have joined yet.</p><?php endif; ?>
        <?php foreach ($freelancers as $f): ?>
          <article class="freelancer-card">
            <?= avatar($f[5], $f[6], $f[7], 52) ?>
            <h3><?= e($f[0]) ?></h3>
            <p class="freelancer-card__role"><?= e($f[1]) ?></p>
            <div class="freelancer-card__rating">
              <?= stars($f[2]) ?> <strong><?= e($f[2]) ?></strong> (<?= e($f[3]) ?>)
            </div>
            <div class="chips">
              <?php foreach ($f[4] as $skill): ?>
                <span class="chip"><?= e($skill) ?></span>
              <?php endforeach; ?>
            </div>
            <a href="<?= e($base_url) ?>pages/freelancer-profile.php?id=<?= (int) $f[8] ?>" class="btn btn--teal-outline">View Profile</a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===================== TESTIMONIALS + PRICING ===================== -->
  <section class="section section--tint">
    <div class="container">
      <div class="section-header">
        <div>
          <p class="section-tag">Testimonials</p>
          <h2>What our users say</h2>
        </div>
        <a href="<?= e($base_url) ?>pages/testimonials.php" class="section-link">View All Testimonials <?= icon('arrow-right', 15) ?></a>
      </div>

      <div class="testimonials-grid">
        <?php if (!$testimonials): ?><p class="muted">No reviews have been published yet.</p><?php endif; ?>
        <?php foreach ($testimonials as $t): ?>
          <figure class="testimonial-card">
            <?= stars($t['rating']) ?>
            <span class="testimonial-card__quote-icon"><?= icon('quote', 22) ?></span>
            <blockquote>“<?= e($t['quote']) ?>”</blockquote>
            <figcaption class="testimonial-card__author">
              <?= avatar($t['bg'], $t['hair'], $t['style'], 32) ?>
              <div>
                <strong><?= e($t['name']) ?></strong>
                <small><?= e($t['role']) ?></small>
              </div>
            </figcaption>
          </figure>
        <?php endforeach; ?>
      </div>

      <!-- <?= (int) tt_service_fee() ?>% pricing preview -->
      <div class="pricing-banner">
        <div class="pricing-banner__content">
          <span class="pricing-banner__percent"><?= (int) tt_service_fee() ?>%</span>
          <div>
            <p class="section-tag">Pricing preview</p>
            <h3>Simple, transparent service fee</h3>
            <p>A <?= (int) tt_service_fee() ?>% platform service fee is deducted from each completed project. Posting projects and sending proposals is free.</p>
          </div>
        </div>
        <a href="<?= e($base_url) ?>pages/pricing.php" class="btn btn--primary">See Pricing <?= icon('arrow-right', 16) ?></a>
      </div>
    </div>
  </section>

</main>

<button type="button" class="back-to-top" id="back-to-top" aria-label="Back to top" title="Back to top"><?= icon('arrow-up', 20) ?></button>
<?php include '../includes/footer.php'; ?>