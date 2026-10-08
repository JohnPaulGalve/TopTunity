<?php
/**
 * includes/client-nav.php
 * Client area shell: dark sidebar + white top bar.
 * Pages set before including:
 *   $active_client   'dashboard' | 'post' | 'projects' | 'freelancers' | 'billing'
 *   $page_title, $base_url  (as usual)
 * Pages must set $app_shell = true (footer.php closes the shell using it).
 */
$base_url      = isset($base_url) ? $base_url : '/Webdev/';
$active_client = isset($active_client) ? $active_client : '';
$app_shell     = true;
$me            = toptunity_current_client();

$side_links = [
    'dashboard'   => ['client/dashboard.php',    'Client Dashboard',    'home'],
    'post'        => ['client/post-project.php',  'Post a Project',      'plus-circle'],
    'projects'    => ['client/my-projects.php',   'My Projects',         'folder'],
    'freelancers' => ['client/find-freelancers.php', 'Find Freelancers', 'users'],
    'billing'     => ['client/billing.php',       'Billing and Payments', 'wallet'],
];
?>
<div class="app-shell">

  <aside class="app-sidebar" aria-label="Client navigation">
    <a href="<?= e($base_url) ?>client/dashboard.php" class="brand-logo brand-logo--light app-brand">TopTunity<span class="logo-star" aria-hidden="true">&#10022;</span></a>

    <nav class="side-nav">
      <?php foreach ($side_links as $key => $link): ?>
        <a href="<?= e($base_url . $link[0]) ?>" class="<?= $active_client === $key ? 'is-active' : '' ?>"
           <?= $active_client === $key ? 'aria-current="page"' : '' ?>>
          <?= icon($link[2], 17) ?> <?= e($link[1]) ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="side-user">
      <?= avatar($me['bg'], $me['hair'], $me['style'], 34) ?>
      <div>
        <strong><?= e($me['name']) ?></strong>
        <small>Signed in as Client</small>
      </div>
    </div>
  </aside>

  <div class="app-main">
    <header class="app-topbar">
      <button class="nav-toggle app-menu-btn" type="button" aria-label="Menu"><?= icon('menu', 22) ?></button>

      <div class="topbar-right">
        <a href="<?= e($base_url) ?>client/messages.php" class="topbar-btn" aria-label="Messages">
          <?= icon('message', 18) ?><span class="badge-count">2</span>
        </a>
        <a href="<?= e($base_url) ?>client/notifications.php" class="topbar-btn" aria-label="Notifications">
          <?= icon('bell', 18) ?><span class="badge-count">3</span>
        </a>

        <details class="profile-menu">
          <summary class="profile-trigger">
            <?= avatar($me['bg'], $me['hair'], $me['style'], 26) ?>
            My Profile <?= icon('chevron-down', 13) ?>
          </summary>
          <div class="profile-dropdown">
            <a href="<?= e($base_url) ?>client/my-profile.php"><?= icon('user', 15) ?> My Profile</a>
            <a href="<?= e($base_url) ?>client/my-profile.php#reviews"><?= icon('star', 15) ?> My Reviews</a>
            <a href="<?= e($base_url) ?>client/saved-freelancers.php"><?= icon('heart', 15) ?> Saved Freelancers</a>
            <a href="<?= e($base_url) ?>client/platform-review.php"><?= icon('message', 15) ?> Platform Review</a>
            <a href="<?= e($base_url) ?>client/report-dispute.php"><?= icon('flag', 15) ?> Report and Dispute</a>
            <a href="<?= e($base_url) ?>client/account-settings.php"><?= icon('lock', 15) ?> Account Settings</a>
            <a href="<?= e($base_url) ?>pages/login.php" class="is-danger"><?= icon('logout', 15) ?> Logout</a>
          </div>
        </details>
      </div>
    </header>

    <main class="app-content">