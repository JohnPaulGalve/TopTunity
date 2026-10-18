<?php
/**
 * pages/project-details.php - Public project view
 * Reads ?id= from the URL. Sample data below stands in for a database query.
 */
$user_role = "public";
$base_url  = "/TopTunity/";

require_once __DIR__ . '/../includes/data.php';

$id      = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$project = toptunity_project($id);

$page_title = $project ? $project['title'] : 'Project not found';
include '../includes/header.php';
include '../includes/nav.php';

function fmt_date($ymd)
{
    return date('M d, Y', strtotime($ymd));
}
?>

<main class="page-detail">
  <div class="container">

<?php if (!$project): ?>
    <!-- ===================== NOT FOUND ===================== -->
    <div class="not-found">
      <div class="empty-art"><?= icon('alert', 40) ?></div>
      <h1>Project not found</h1>
      <p>This project is not available.</p>
      <a href="browse-projects.php" class="btn btn--dark">Browse Projects</a>
    </div>

<?php else: ?>
    <?php
      $is_hourly = $project['type'] === 'hourly';
      $client    = $project['client'];
    ?>

    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="browse-projects.php">Browse Projects</a>
      <span>/</span>
      <a href="browse-projects.php?category=<?= urlencode($project['category']) ?>"><?= e($project['category']) ?></a>
      <span>/</span>
      <span aria-current="page"><?= e($project['title']) ?></span>
    </nav>

    <div class="detail-layout">

      <!-- ===================== MAIN COLUMN ===================== -->
      <div class="detail-main">

        <div class="detail-title-row">
          <h1><?= e($project['title']) ?></h1>
          <span class="pill pill--open"><?= e($project['status']) ?></span>
        </div>

        <div class="detail-meta">
          <span class="pill pill--teal"><?= e($project['category']) ?></span>
          <span class="chip chip--type"><?= $is_hourly ? 'Hourly' : 'Fixed Price' ?></span>
          <span class="dot-inline" aria-hidden="true">·</span>
          <span><?= icon('clock', 13) ?> Posted <?= e(fmt_date($project['posted'])) ?></span>
          <span class="dot-inline" aria-hidden="true">·</span>
          <span>Project ID <?= e($project['ref']) ?></span>
        </div>

        <section class="detail-card">
          <h2>Description</h2>
          <p><?= e($project['intro']) ?></p>
          <ul class="bullet-list">
            <?php foreach ($project['features'] as $item): ?>
              <li><?= e($item) ?></li>
            <?php endforeach; ?>
          </ul>
          <p><?= e($project['closing']) ?></p>
        </section>

        <section class="detail-card">
          <h2>Required Skills</h2>
          <div class="skill-chips">
            <?php foreach ($project['skills'] as $skill): ?>
              <span class="chip"><?= e($skill) ?></span>
            <?php endforeach; ?>
          </div>
        </section>

        <?php if (!empty($project['files'])): ?>
        <section class="detail-card">
          <h2>Attachments</h2>
          <div class="file-list">
            <?php foreach ($project['files'] as $file): ?>
              <?php if (!empty($file['id'])): ?>
              <a href="../download.php?file=<?= (int) $file['id'] ?>" class="file-card">
              <?php else: ?>
              <div class="file-card" aria-label="Sample attachment">
              <?php endif; ?>
                <span class="file-card__icon file-card__icon--<?= e($file['type']) ?>"><?= icon('file', 16) ?></span>
                <span>
                  <span class="file-card__name"><?= e($file['name']) ?></span>
                  <span class="file-card__size"><?= e($file['size']) ?></span>
                </span>
                <?php if (!empty($file['id'])): ?><span class="file-card__dl"><?= icon('download', 15) ?></span><?php endif; ?>
              <?= !empty($file['id']) ? '</a>' : '</div>' ?>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endif; ?>
      </div>

      <!-- ===================== SIDEBAR ===================== -->
      <aside class="detail-side" aria-label="Project summary">

        <div class="side-card">
          <div class="fact-list">
            <div class="fact-row">Billing Type <strong><?= $is_hourly ? 'Hourly' : 'Fixed Price' ?></strong></div>
            <?php if ($is_hourly): ?>
              <div class="fact-row">Hourly Rate <strong>₱<?= number_format($project['rate']) ?>/hr</strong></div>
              <div class="fact-row">Maximum Hours <strong><?= (int) $project['max_hours'] ?> hrs</strong></div>
            <?php endif; ?>
            <div class="fact-row">Project Budget <strong>₱<?= number_format($project['budget']) ?></strong></div>
            <div class="fact-row">Deadline <strong><?= e(fmt_date($project['deadline'])) ?></strong></div>
            <div class="fact-row">Proposals <strong><?= (int) $project['proposals'] ?></strong></div>
          </div>

          <a href="login.php?next=<?= urlencode('project-details.php?id=' . $id) ?>" class="btn btn--primary btn--submit">
            <?= icon('send', 16) ?> Submit a Proposal
          </a>
          <p class="submit-note">You'll be asked to log in or register as a freelancer first.</p>
        </div>

        <div class="side-card">
          <h2 class="side-card__title">About the Client</h2>
          <div class="client-head">
            <?= avatar($client['bg'], $client['hair'], $client['style'], 44) ?>
            <div>
              <strong><?= e($client['name']) ?></strong>
              <small><?= e($client['company']) ?></small>
              <div class="client-rating">
                <?= stars($client['rating']) ?> <strong><?= e($client['rating']) ?></strong> (<?= (int) $client['reviews'] ?> reviews)
              </div>
            </div>
          </div>
          <div class="fact-list">
            <div class="fact-row"><span><?= icon('map-pin', 13) ?> Location</span> <strong><?= e($client['location']) ?></strong></div>
            <div class="fact-row">Projects posted <strong><?= (int) $client['projects'] ?></strong></div>
            <div class="fact-row">Member since <strong><?= e($client['since']) ?></strong></div>
          </div>
        </div>

      </aside>
    </div>
<?php endif; ?>

  </div>
</main>

<?php include '../includes/footer.php'; ?>