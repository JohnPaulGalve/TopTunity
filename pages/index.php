<?php
/**
 * pages/index.php - Public homepage
 * Sections: Hero, Guide, Categories, New projects, Top talent,
 *           Testimonials, Pricing preview.
 */
$page_title = "Home";
$user_role  = "public";
$base_url   = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');

require_once __DIR__ . '/../includes/auth.php';
$__u = tt_current_user();
if ($__u && in_array($__u['role'], ['client', 'freelancer'], true)) {
    header('Location: ' . $base_url . tt_home_for($__u['role']));
    exit;
}

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

$categories = [
    ['Web Development',        'code',       'teal',   '2 open projects'],
    ['Mobile App Development', 'smartphone', 'orange', '1 open project'],
    ['Graphic Design',         'pen-tool',   'slate',  '1 open project'],
    ['UI/UX Design',           'frame',      'teal',   '1 open project'],
];

$projects = [
    [
        'category' => 'UI/UX Design', 'pill' => 'teal', 'posted' => 'Posted 15h ago',
        'title'    => 'Clinic Website Redesign in Figma',
        'desc'     => 'Redesign our clinic website (6 pages) in Figma with a mobile version and a clickable prototype.',
        'tags'     => ['Figma', 'UI Design'],
        'pay_type' => 'Budget', 'pay' => '₱18,000', 'deadline' => 'Nov 15, 2026',
    ],
    [
        'category' => 'Data Entry and Admin', 'pill' => 'green', 'posted' => 'Posted yesterday',
        'title'    => 'Inventory Spreadsheet Cleanup',
        'desc'     => 'Clean up and merge our 6 inventory spreadsheets (about 4,000 items) into one organized file.',
        'tags'     => ['Data Entry', 'Microsoft Excel'],
        'pay_type' => 'Hourly', 'pay' => '₱300/hr', 'deadline' => 'Oct 30, 2026',
    ],
    [
        'category' => 'Web Development', 'pill' => 'blue', 'posted' => 'Posted 2 days ago',
        'title'    => 'Online Ordering Website for a Coffee Shop',
        'desc'     => 'We need a simple online ordering website for Kapé Lokal where customers can browse our menu, place pick-u…',
        'tags'     => ['JavaScript', 'MySQL', 'PHP'],
        'pay_type' => 'Budget', 'pay' => '₱45,000', 'deadline' => 'Nov 20, 2026',
    ],
];

$freelancers = [
    ['Jerome Castillo', 'Backend Developer',             4.7, 10, ['PHP', 'REST API'],         '#CCFBF1', '#1E293B', 'glasses'],
    ['Miguel Reyes',    'Full-Stack PHP Developer',      4.8, 5,  ['HTML/CSS', 'JavaScript'],  '#DBEAFE', '#1E293B', 'short'],
    ['Rhea Mendoza',    'Content Writer and SEO Specialist', 4.8, 4, ['Copywriting', 'SEO'],   '#CCFBF1', '#1E293B', 'long'],
    ['Janelle Cruz',    'Web and Database Developer',    4.7, 3,  ['HTML/CSS', 'JavaScript'],  '#FFEDD5', '#1E293B', 'bun'],
];

$testimonials = [
    [
        'quote'  => 'I posted our ordering website project on a Monday and had twelve solid proposals by Wednesday. The match percentage helped me shortlist fast, and holding the payment until I approved the work gave me peace of mind.',
        'name'   => 'Andrea Santos', 'role' => 'Client · Kapé Lokal Coffee Co.',
        'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'long',
    ],
    [
        'quote'  => 'The proposal process is clear and the 10% fee is shown upfront, so I always know my net earnings before I send an offer. Withdrawing to GCash is simple.',
        'name'   => 'Rhea Mendoza', 'role' => 'Freelancer · Content Writer and SEO Specialist',
        'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'long',
    ],
    [
        'quote'  => 'Tracking the project from contract to completion was easy. I could see the status history and every submitted file in one place.',
        'name'   => 'Grace Aquino', 'role' => 'Client · Aquino Dental Clinic',
        'bg' => '#FFEDD5', 'hair' => '#1E293B', 'style' => 'bun',
    ],
];
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

        <div class="social-proof">
          <div class="avatar-group">
            <?= avatar('#DBEAFE', '#1E293B', 'short', 32) ?>
            <?= avatar('#FFEDD5', '#1E293B', 'glasses', 32) ?>
            <?= avatar('#CCFBF1', '#1E293B', 'bun', 32) ?>
            <?= avatar('#FEF9C3', '#1E293B', 'long', 32) ?>
          </div>
          <div>
            <div class="social-proof__rating"><?= stars(4.8) ?> 4.8/5</div>
            <div class="social-proof__note">from 12 active freelancers</div>
          </div>
        </div>
      </div>

      <div class="hero-art" aria-hidden="true">
        <span class="hero-art__blob hero-art__blob--teal"></span>
        <span class="hero-art__blob hero-art__blob--peach"></span>
        <span class="hero-art__blob hero-art__blob--white"></span>

        <!-- Replace with <img src="<?= e($base_url) ?>images/hero.svg"> if you have final artwork -->
        <svg viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#1E293B" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
          <!-- hair (back) -->
          <path d="M88 120C78 60 115 28 152 30C195 32 222 68 212 122C218 150 208 170 196 176L104 176C92 168 84 146 88 120Z" fill="#1E293B"/>
          <!-- neck -->
          <rect x="134" y="150" width="30" height="40" fill="#fff"/>
          <!-- body -->
          <path d="M50 300C50 235 82 192 148 186C214 192 246 235 246 300Z" fill="#fff"/>
          <path d="M126 188L148 214L170 188"/>
          <!-- face -->
          <ellipse cx="150" cy="118" rx="40" ry="46" fill="#fff"/>
          <!-- hair (front) -->
          <path d="M108 112C110 74 168 66 190 104C170 94 134 94 108 112Z" fill="#1E293B"/>
          <path d="M104 120C100 150 104 164 112 170L116 132Z" fill="#1E293B"/>
          <path d="M196 120C200 150 196 164 188 170L184 132Z" fill="#1E293B"/>
          <!-- face details -->
          <circle cx="134" cy="122" r="2.6" fill="#1E293B" stroke="none"/>
          <circle cx="164" cy="122" r="2.6" fill="#1E293B" stroke="none"/>
          <path d="M138 138Q150 148 162 137"/>
          <!-- laptop -->
          <path d="M150 236L268 208L274 262L158 284Z" fill="#fff"/>
          <path d="M168 246L258 226" stroke="#CBD5E1" stroke-width="2"/>
          <!-- arm + hand -->
          <path d="M62 300C68 262 104 244 150 254" fill="none"/>
          <ellipse cx="154" cy="260" rx="12" ry="7" fill="#fff"/>
        </svg>
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
            <a href="<?= e($base_url) ?>pages/freelancer-profile.php?name=<?= urlencode($f[0]) ?>" class="btn btn--teal-outline">View Profile</a>
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
        <?php foreach ($testimonials as $t): ?>
          <figure class="testimonial-card">
            <?= stars(5) ?>
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

      <!-- 10% pricing preview -->
      <div class="pricing-banner">
        <div class="pricing-banner__content">
          <span class="pricing-banner__percent">10%</span>
          <div>
            <p class="section-tag">Pricing preview</p>
            <h3>Simple, transparent service fee</h3>
            <p>A 10% platform service fee is deducted from each completed project. Posting projects and sending proposals is free.</p>
          </div>
        </div>
        <a href="<?= e($base_url) ?>pages/pricing.php" class="btn btn--primary">See Pricing <?= icon('arrow-right', 16) ?></a>
      </div>
    </div>
  </section>

</main>

<?php include '../includes/footer.php'; ?>